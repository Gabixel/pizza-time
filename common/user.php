<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

class AuthUser
{
	private static $mail_pattern = '/^[^ ]+@[^ ]+\.[a-z]{2,3}$/';
	private $sql_connection;

	function __construct(&$sql_connection)
	{
		$this->sql_connection = $sql_connection;
	}

	public static function is_logged_in()
	{
		// If the session contains the user, he's logged in
		return isset($_SESSION['user']) && !empty($_SESSION['user']);
	}

	public static function is_admin()
	{
		// If the session contains the user AND the user is admin
		return self::is_logged_in()
			? $_SESSION['user']['admin'] == true
			: false;
	}

	public function login(array &$fields)
	{
		// If the SQL connection has failed
		if (!$this->sql_connection->is_db_connected()) {
			$_SESSION['failed_login'] = "failed_db_connection";
			return;
		}

		$username = $fields['username'];
		$password = $fields['password'];

		$query =
			"SELECT id, username, `password`, `admin`
			FROM `users`
			WHERE username = '$username'";

		$user_request = $this->sql_connection->request($query);

		// If the credentials are correct
		if ($user_request->num_rows > 0) {
			$user = $user_request->fetch_array();

			// If the password is correct
			if (password_verify($password, $user['password'])) {
				// Log in!
				$this->store_user($user);
				return;
			} else {
				// Wrong password
				$_SESSION['failed_login'] = 'wrong_password';
				return;
			}
		} else {
			// Wrong username
			$_SESSION['failed_login'] = 'wrong_username';
			return;
		}
	}

	public function register(array &$fields)
	{
		// If the SQL connection has failed
		if (!$this->sql_connection->is_db_connected()) {
			$_SESSION['failed_register'] = 'failed_db_connection';
			return;
		}

		// Store if there are any problems
		$fields_problems = $this->check_register_problems($fields);

		// If there are problems with the fields, return the specific error
		if ($fields_problems) {
			$_SESSION['failed_register'] = $fields_problems;
			return;
		}

		// Add the user to the database
		$request = $this->add_user($fields);

		if (!$request) {
			$_SESSION['failed_register'] = strval($this->sql_connection->get_error());
			return;
		}

		// Success message
		$_SESSION['success_message'] = "success_register";
	}

	public static function logout()
	{
		$_SESSION['user'] = NULL;
	}

	public function change_password($old, $new, $user_id)
	{
		$fields_problems = self::check_change_password_problems($old, $new, $user_id);

		if ($fields_problems) {
			$_SESSION['failed_password_change'] = $fields_problems;
			return;
		}

		// If the SQL connection has failed
		if (!$this->sql_connection->is_db_connected()) {
			$_SESSION['failed_password_change'] = "failed_db_connection";
			return;
		}

		$query =
			"SELECT `password`
			FROM `users`
			WHERE `id` = $user_id LIMIT 1";

		$user_request = $this->sql_connection->request($query);

		// If the user exists in the database (it should be, since he's logged in)
		if ($user_request->num_rows > 0) {
			$user = $user_request->fetch_array();

			// If the password is correct
			if (password_verify($old, $user['password'])) {
				$new = $this->sql_connection->escape_string($this->hash_password($new));

				$psw_query =
					"UPDATE `users`
					SET `password` = '$new'
					WHERE `id` = $user_id";

				// Update the password
				$request = $this->sql_connection->request($psw_query);

				// If the change has been done
				if ($request) {
					self::logout();
					// Success
					$_SESSION['success_message'] = "success_change_password";
					return;
				}

				// Else show error
				$_SESSION['failed_password_change'] = strval($this->sql_connection->get_error());
				return;
			}

			// Wrong username
			$_SESSION['failed_password_change'] = 'wrong_old_password';
			return;
		}

		// Wrong username
		$_SESSION['failed_password_change'] = 'failed_db_connection';
		return;
	}

	// Private stuff

	private static function check_change_password_problems($old, $new, $user_id)
	{
		// Test account is id 2
		if($user_id == 2) {
			return "test_account";
		}

		// If for some reason the user managed to send empty fields
		if (!$old || !$new) {
			return "empty_password_field";
		}

		// If the new password is identical to the current one
		if ($old == $new) {
			return "identical_password";
		}

		return '';
	}

	private function check_register_problems(array &$fields)
	{
		foreach ($fields as $field) {
			if (!$field) return 'empty_string';
		}

		// Check if the database arrived at 100 users
		$countUser = $this->sql_connection->request("SELECT COUNT(`id`) AS 'n_users' FROM `users`");
		if ($countUser->fetch_array()[0] >= 100) {
			return "max_users";
		}

		$date = $fields['birth_date'];

		if (is_string($fields['birth_date'])) {
			$date = strtotime($fields['birth_date']);
		}

		// Minimum age
		$min_age = strtotime('+18 years', $date);
		if (time() < $min_age) return 'minor';

		// If mail pattern matches
		if (!preg_match($this::$mail_pattern, $fields['mail'])) return 'invalid_mail';

		// If the email already exists
		if ($this->email_exists($fields['mail'])) return 'existing_mail';

		// If the username already exists
		if ($this->username_exists($fields['username'])) return 'existing_username';

		// No errors
		return '';
	}

	private function email_exists(string $mail)
	{
		$query =
			"SELECT email
			FROM `users`
			WHERE email = '$mail' LIMIT 1";

		$result = $this->sql_connection->request($query);

		// If there's already a user with this email
		return ($result->num_rows > 0);
	}

	private function username_exists(string $username)
	{
		$query =
			"SELECT username
			FROM `users`
			WHERE username = '$username'";

		$result = $this->sql_connection->request($query);

		// If there's already a user with this username
		if ($result->num_rows > 0) return true;
		else return false;
	}

	private function add_user(array $fields)
	{
		$first_name = $fields['first_name'];
		$last_name = $fields['last_name'];
		$mail = $fields['mail'];
		$username = $fields['username'];
		$password = $this->sql_connection->escape_string($this->hash_password($fields['password']));
		$birth_date = $fields['birth_date'];

		$query =
			"INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `birth_date`, `admin`)
			VALUES (NULL, '$first_name', '$last_name', '$mail', '$username', '$password', '$birth_date', '0')";

		return $this->sql_connection->request($query);
	}

	private function hash_password(string $password)
	{
		// TODO: re-hashing? [hash(password+hash);]
		return password_hash($password, PASSWORD_BCRYPT);
	}

	private function store_user(&$sql_user)
	{
		$_SESSION['user'] = [
			'id' => $sql_user['id'],
			'admin' => $sql_user['admin'],
		];
	}
}

class UserStats
{
	private $sql_connection, $id;

	public function __construct($sql_connection, $user_id)
	{
		$this->sql_connection = $sql_connection;
		$this->id = $user_id;
	}

	public function get_info()
	{
		// If for, some reason, the user isn't logged in but it retrieved infos, return an empty array
		if (!AuthUser::is_logged_in() || !$this->sql_connection->is_db_connected()) return [];

		$query =
			"SELECT	first_name, last_name, birth_date, email, username
			FROM `users`
			WHERE id = $this->id";

		$user_request = $this->sql_connection->request($query);

		// If there's no user with such id, return an empty array
		if ($user_request->num_rows === 0) return [];

		return $user_request->fetch_array();
	}
}
