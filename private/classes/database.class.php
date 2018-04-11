<?php

class Database {

	/** --------------------------------------------------------------------------------
		this attribute will hold database connection
	**/
	private $connection;

	/** --------------------------------------------------------------------------------
		use contructor in order to connect to database
	**/
	public function __construct() {
		$this->db_connect();
		$this->confirm_connection();
		return $this->connection;
	}

	/** --------------------------------------------------------------------------------
		connect to the database
	**/
	private function db_connect() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$this->confirm_connection();
		$this->connection->set_charset("utf8");
		return $this->connection;
	}

	/** --------------------------------------------------------------------------------
		method which return message with error explination and error number
		if there was error while we were trying to connect to the database
	**/
	private function confirm_connection() {
		if(!$this->connection) {
			$msg = 'Database connection error: ';
			$msg .= mysqli_connect_error();
			$msg .= ' (' . mysqli_connect_errno() . ')';
			return $msg;
		}
	}

	/** --------------------------------------------------------------------------------
		close connection (disconnect from database)
	**/
	public function db_disconnect() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	/** --------------------------------------------------------------------------------
		method which is going to query database
	**/
	public function query($sql) {
		// var_dump($sql);
		$result = mysqli_query($this->connection, $sql);
		// var_dump($result);
		$this->confirm_result_set($result);
		return $result;
	}

	/** --------------------------------------------------------------------------------
		checking result from mysqli query and perform exit if it's not set
	**/
	private function confirm_result_set($result_set) {
		if(!$result_set) {
			exit("Database query failed.");
		}
	}

	/** --------------------------------------------------------------------------------
		method which are going escape all potentialy harmful strings
		which can be sql injection from hacker
	**/
	public function db_escape($string) {
		return mysqli_real_escape_string($this->connection, $string);
	}

	public function fetch_assoc($result_set) {
		return mysqli_fetch_assoc($result_set);
	}

	public function fetch_array($result_set) {
		return mysqli_fetch_array($result_set);
	}
	
	public function insert_id() {
		return mysqli_insert_id($this->connection);
	}
}