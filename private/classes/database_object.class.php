<?php

class DatabaseObject {

	static protected $db; // database

	static protected $table_name = "";
	static protected $db_columns = [];
	public $errors = [];

	public static $city_names = [];
	public static $position_names = [];

	// ------------------ ACTIVE RECORD ----------------------------------
	
	static public function set_database($db) {
		self::$db = $db;
	}

	static public function find_by_sql($sql="") {
		
		$result_set = self::$db->query($sql);

		$object_array = [];
		while ($row = self::$db->fetch_assoc($result_set)) {
			$object_array[] = static::instantiate($row);
		}
		// var_dump($object_array);
		
		return $object_array;
	}

	static public function find_all() {		
		$sql = "SELECT * FROM " . static::$table_name;
		return static::find_by_sql($sql);
	}

	static public function find_by_id($id=0) {
		
		$sql = "SELECT * FROM " . static::$table_name . " ";
		$sql .= "LEFT JOIN address_" . static::$table_name . " ON " . static::$table_name . ".id = address_". static::$table_name .".address_id ";
		$sql .= "LEFT JOIN city ON address_".static::$table_name.".city_id = city.city_id ";
		$sql .= "LEFT JOIN country ON city.country_id = country.country_id ";
		$sql .= "LEFT JOIN positions ON " . static::$table_name . ".position_id = positions.position_id ";
		$sql .= "WHERE id = '" . self::$db->db_escape($id) . "'";
		// echo $sql;
		$object_array = static::find_by_sql($sql);
		return !empty($object_array) ? array_shift($object_array) : false;
	}

	static public function count_all() {
		$sql = "SELECT COUNT(*) FROM ". static::$table_name ." ";
		$result_set = self::$db->query($sql);
		$result = self::$db->fetch_array($result_set);
		return array_shift($result);
	}

	private static function instantiate($record) {
		$object = new static;

		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}

	private function has_attribute($attribute) {
		$object_vars = get_object_vars($this);
		return array_key_exists($attribute, $object_vars);
	}

	static public function authenticate($username="", $password="") {

		$sql = "SELECT * FROM " . static::$table_name . " ";
		$sql .= "WHERE username ='" . static::$db->db_escape($username) . "' ";
		$sql .= "AND hash_password = '" .  static::$db->db_escape($password) . "' ";
		$sql .= "LIMIT 1";
		
		$object_array = static::find_by_sql($sql);
		// if user doesn't exist $object_array = [];
		return !empty($object_array) ? array_shift($object_array) : false;
	}

	protected function attributes() {
		$attributes = [];
		foreach (static::$db_columns as $column) {
			if($column == 'id') { continue; }
			$attributes[$column] = $this->$column;
		}
		return $attributes;
	}

	protected function escape_attributes_value() {

		$escaped_attributes = [];
		foreach ($this->attributes() as $key => $value) {
			$escaped_attributes[$key] = self::$db->db_escape($value);
		}
		return $escaped_attributes;
	}

	public function change_attributes($args=[]) {
		foreach ($args as $key => $value) {
			if(property_exists($this, $key) && !is_null($value)) {
				$this->$key = $value;
			}
		}
	}

	protected function validate() {
		$this->errors = [];

		// first name
		if(is_blank($this->first_name)) {
			$this->errors[] = 'First Name cannot be blank.';
		} elseif(!has_length($this->first_name, ['min' => 2, 'max' => 45])) {
			$this->errors[] = 'First Name must be between 2 and 45 charackters long.';
		}

		// last name
		if(is_blank($this->last_name)) {
			$this->errors[] = 'Last Name cannot be blank.';
		} elseif(!has_length($this->last_name, ['min' => 2, 'max' => 45])) {
			$this->errors[] = 'Last Name must be between 2 and 255 charackters long.';
		}

		// email
		if(is_blank($this->email)) {
			$errors[] = 'Email cannot be blank.';
		} elseif(!has_valid_email_format($this->email)) {
			$errors[] = 'Email must have a valid email format.';
		}

		// last name
		if(is_blank($this->address_name)) {
			$this->errors[] = 'Address Name cannot be blank.';
		}

		return $this->errors;
	}

	public function insert() {

		$attributes = $this->escape_attributes_value();

		$this->validate();

		if(!empty($this->errors)) { 
			return false;
		}

		$sql = "INSERT INTO " . static::$table_name . " (";
		$sql .= implode(', ', array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= implode("', '", array_values($attributes));
		$sql .= "');";
		// echo $sql;
		$result = self::$db->query($sql);
		// echo $result;

		if($result) {
			$this->id = self::$db->insert_id();
		}
		return $result;
	}

	public function update() {

		$this->validate();

		if(!empty($this->errors)) { 
			return false;
		}

		$attributes = $this->escape_attributes_value();
		$attribute_pairs = [];
		foreach ($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ". static::$table_name . " SET ";
		$sql .= join(', ', $attribute_pairs);
		$sql .= " WHERE id ='" . $this->id . "' ";
		$sql .= "LIMIT 1";
		$result = self::$db->query($sql);
		
		if(!$result) { return false; }

		if(get_called_class() != 'Vehicle') {
			$sql = "UPDATE address_" . static::$table_name . " ";
			$sql .= "SET ";
			$sql .= "address_name = '" . self::$db->db_escape($this->address_name) . "', ";
			$sql .= "city_id = '" . self::$db->db_escape($this->city_id) . "' ";
			$sql .= "WHERE address_id = '" . $this->id . "' ";
			$sql .= "LIMIT 1";

			// echo $sql;
			$result = self::$db->query($sql);
		}
		
		return $result;
	}

	public function delete() {
		$sql = "DELETE FROM " . static::$table_name . " ";
		$sql .= "WHERE id = '". self::$db->db_escape($this->id) ."' ";
		$sql .= "LIMIT 1";
		return self::$db->query($sql);
	}


	static protected function set_city_names() {

		$sql = "SELECT city_id, city_name FROM city ";

		$result_set = self::$db->query($sql);
		self::$city_names = [];
		foreach ($result_set as $result) {
			// var_dump($result);
			self::$city_names[] = $result;
		}
	}

	static public function get_city_names() {
		return self::$city_names;
	}

	static protected function set_position_names() {

		$sql = "SELECT position_id, position_name FROM positions ";

		$result_set = self::$db->query($sql);
		// var_dump($result_set);
		self::$position_names = [];
		foreach ($result_set as $result) {
			self::$position_names[] = $result;
		}
	}

	static public function get_position_names() {
		return self::$position_names;
	}

}