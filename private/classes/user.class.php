<?php
require_once('database.class.php');
require_once('database_object.class.php');

class User extends DatabaseObject {

	protected static $table_name = 'users';

	protected static $db_columns = [
		'id', 'first_name', 'last_name', 'username', 'hash_password', 'status', 'phone', 'email', 'position_id'];

	public $id;
	public $first_name;
	public $last_name;
	public $username;

	public $password;
	public $confirm_password;

	public $hash_password;
	public $password_sent = true;
	public $image_sent = true;
	
	public $status = 1;
	public $phone;
	public $email;

	public $address_id;
	public $address_name;
	public $city_id;
	public $country_name;

	public $position_id;

	public function __construct($args=[]) {
		$this->first_name = isset($args['first_name']) ? $args['first_name'] : '';
		$this->last_name = isset($args['last_name']) ? $args['last_name'] : '';
		$this->username = isset($args['username']) ? $args['username'] : '';
		$this->password = isset($args['password']) ? $args['password'] : '';
		$this->confirm_password = isset($args['confirm_password']) ? $args['confirm_password'] : '';
		$this->status = isset($args['status']) ? $args['status'] : '1';
		$this->phone = isset($args['phone']) ? $args['phone'] : '';
		$this->email = isset($args['email']) ? $args['email'] : '';
		$this->address_id = isset($args['address_id']) ? $args['address_id'] : '';
		$this->address_name = isset($args['address_name']) ? $args['address_name'] : '';
		$this->city_id = isset($args['city_id']) ? $args['city_id'] : '';
		$this->city_name = isset($args['city_name']) ? $args['city_name'] : '';
		$this->country_id = isset($args['country_id']) ? $args['country_id'] : '';
		$this->country_name = isset($args['country_name']) ? $args['country_name'] : '';
		$this->position_id = isset($args['position_id']) ? $args['position_id'] : '';
		$this->position_name = isset($args['position_name']) ? $args['position_name'] : '';

		self::set_city_names();
		self::set_position_names();
	}

	public function full_name() {
		return $this->first_name . " " . $this->last_name;
	}

	protected function set_hash_password() {
		return $this->hash_password = password_hash($this->password, PASSWORD_BCRYPT);
	}

	public function verify_password($password) {
		return password_verify($password, $this->hash_password);
	}

	public function insert() {
		
		$this->validate();

		if(!empty($this->errors)) { 
			return false;
		}

		$this->set_hash_password();
		
		$result = parent::insert();

		if(!$result) { return false; }

		$sql = "INSERT INTO address_". static::$table_name ." ";
		$sql .= "(address_id, address_name, city_id) ";
		$sql .= "VALUES (";
		$sql .= "'". self::$db->db_escape(self::$db->insert_id()) ."', ";
		$sql .= "'". self::$db->db_escape($this->address_name) ."', ";
		$sql .= "'". self::$db->db_escape($this->city_id) ."'";
		$sql .= ");";
		
		$result = self::$db->query($sql);
		return $result ? true : false;
	}

	public function update() {
		$this->password_sent = !is_blank($this->password);
		if($this->password_sent) {
			$this->set_hash_password();
		}
		return parent::update();
	}

	protected function validate() {
		$this->errors = [];

		parent::validate();
		
		// username
		$current_id = isset($this->id) ? $this->id : 0;
		if(is_blank($this->username)) {
			$this->errors[] = 'Username cannot be blank.';
		} elseif (!has_length($this->username, ['min' => 2, 'max' => 45])) {
			$this->errors[] = 'Username must be between 2 and 45 charackters long.';
		} elseif (!has_unique_username($this->username, $current_id)) {
			$this->errors[] = 'Username must be unique.';
		}

		if($this->password_sent) {
			//pasword
			// Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special sign
			if(is_blank($this->password)) {
				$this->errors[] = 'Password cannot be blank.';
			} elseif(!has_length($this->password, ['min' => 12])) {
				$this->errors[] = 'Password must contain 12 or more characters.';
			} elseif(!preg_match('/[A-Z]/', $this->password)) {
				$this->errors[] = 'Password must contain at least 1 uppercase letter.';
			} elseif(!preg_match('/[a-z]/', $this->password)) {
				$this->errors[] = 'Password must contain at least 1 lowercase letter.';
			} elseif(!preg_match('/[0-9]/', $this->password)) {
				$this->errors[] = 'Password must contain at least 1 number.';
			} elseif(!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
				$this->errors[] = 'Password must contain at least 1 symbol.';
			}

			if(is_blank($this->confirm_password)) {
				$this->errors[] = 'Confirm password cannot be blank.';
			} elseif($this->password !== $this->confirm_password) {
				var_dump($this->password);
				var_dump($this->confirm_password);
				$this->errors[] = 'Password and confirm password must match.';
			}
		}

		return $this->errors;
	}

	static public function find_by_first_name($first_name) {
		
		$sql = "SELECT id, first_name, last_name, username, email, position_name FROM ". static::$table_name . " ";
		$sql .= "LEFT JOIN positions ON users.position_id = positions.position_id ";
		$sql .= "WHERE first_name = '" . self::$db->db_escape($first_name) . "'";

		return static::find_by_sql($sql);
	}

	static public function find_by_username($username) {
		
		$sql = "SELECT id, username FROM ". static::$table_name . " ";
		$sql .= "WHERE username = '" . self::$db->db_escape($username) . "'";
		
		$object_array = static::find_by_sql($sql);
		return !empty($object_array) ? array_shift($object_array) : false;
	}
		
	static public function find_all() {		
		$sql = "SELECT * FROM " . static::$table_name;
		$sql .= " LEFT JOIN positions ";
		$sql .= "ON " . static::$table_name . ".position_id = positions.position_id";
		
		return static::find_by_sql($sql);
	}
}