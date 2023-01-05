<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}

class SQLQuery
{
	private $host_name, $username, $password, $db_name;
	private $connection;

	function __construct()
	{
		$this->host_name = '';
		$this->username = '';
		$this->password = '';
		$this->db_name = '';

		$this->establish_connection();
	}

	function __destruct()
	{
		$this->stop_connection();
	}

	public function is_db_connected() {
		return (!isset($this->connection->connect_error) || empty($this->connection->connect_error));
	}
	
	private function establish_connection()
	{
		// Start SQL connection (suppressed by '@' if it doesn't work)
		@$this->connection = new mysqli($this->host_name, $this->username, $this->password, $this->db_name);
	}

	private function stop_connection()
	{
		// If the connection has no errors, it can be closed
		if (!isset($this->connection->connect_error))
			$this->connection->close();
	}

	public function get_connection()
	{
		return $this->connection;
	}

	public function get_db_name() {
		$db_name = '';

		if($this->is_db_connected())
		$db_name = $this->request("SELECT database() AS 'db_name'")->fetch_array()['db_name'];

		return $db_name;
	}

	public function request(string $query) {
		return $this->connection->query($query);
	}

	public function get_error() {
		return isset($this->connection->error) ? $this->connection->error : false;
	}

	public function escape_string(string $text) {
		return $this->connection->real_escape_string($text);
	}
}
