<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

$has_login_failed = isset($_SESSION['failed_login']);
$login_error = $has_login_failed ? $_SESSION['failed_login'] : '';


$has_register_failed = isset($_SESSION['failed_register']);
$register_error = $has_register_failed ? $_SESSION['failed_register'] : '';


$has_success_message = isset($_SESSION['success_message']);
$success_message = $has_success_message ? $_SESSION['success_message'] : '';


// If the user is trying to login
$is_login = isset($_POST['login']);

// If the user is trying to register
$is_register = isset($_POST['register']);

// If the user has logged out
$is_logout = isset($_SESSION['logOut']) && $_SESSION['logOut'] === true;

// Clear fail/success messages for next refresh
if ($has_success_message || $has_login_failed || $has_register_failed || $is_logout) {
	$_SESSION['logOut'] = $_SESSION['success_message'] = $_SESSION['failed_login'] = $_SESSION['failed_register'] = NULL;
}

// If the user is NOT trying to login/register/logout, stop here
if (!$is_login && !$is_register && !$is_logout) return;

// else, start the checks

require_once DOCUMENT_ROOT . '/common/user.php';
require_once DOCUMENT_ROOT . '/common/sql.php';

$sql_query = new SQLQuery();

$user = new AuthUser($sql_query);

// Login
if ($is_login) {
	$fields = [
		'username' => trim($sql_query->escape_string($_POST['username']), ' '),
		'password' => $sql_query->escape_string($_POST['password']),
	];

	$user->login($fields);
}
// Register
elseif ($is_register) {
	$fields = [
		'first_name' => trim($sql_query->escape_string($_POST['firstName']), ' '),
		'last_name' => trim($sql_query->escape_string($_POST['lastName']), ' '),
		'username' => trim($sql_query->escape_string($_POST['username']), ' '),
		'mail' => trim($sql_query->escape_string($_POST['email']), ' '),
		'password' => $sql_query->escape_string($_POST['password']),
		'birth_date' => $sql_query->escape_string($_POST['birthday']),
	];

	// Register
	$user->register($fields);
}
// Logout (already done, save the success)
else {
	// Logged out
	$_SESSION['success_message'] = "success_logout";
}

// End of credentials check (using destructor)
$user = NULL;

// Re-redirect to the login page (where it checks for success/error messages)
header('Location: ' . $_SERVER['REQUEST_URI']);
