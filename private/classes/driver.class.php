<?php

class Driver extends DatabaseObject {
	
	protected static $table_name = 'drivers';

	protected static $db_columns = [
		'id', 'first_name', 'last_name', 'phone', 'email', 'position_id'];

	public $id;
	public $first_name;
	public $last_name;
	public $phone;
	public $email;
	public $reg_plate;
	public $vehicle_id;

	public $position_id;
	public $position_name;

	public $address_id;
	public $address_name;
	public $city_id;
	public $city_name;
	public $country_name;

	public function __construct($args=[]) {
		$this->first_name = isset($args['first_name']) ? $args['first_name'] : '';
		$this->last_name = isset($args['last_name']) ? $args['last_name'] : '';
		$this->phone = isset($args['phone']) ? $args['phone'] : '';
		$this->email = isset($args['email']) ? $args['email'] : '';
		$this->vehicle_id = isset($args['vehicle_id']) ? $args['vehicle_id'] : '';
		$this->reg_plate = isset($args['reg_plate']) ? $args['reg_plate'] : '';
		$this->position_id = isset($args['position_id']) ? $args['position_id'] : '';
		$this->address_id = isset($args['address_id']) ? $args['address_id'] : '';
		$this->address_name = isset($args['address_name']) ? $args['address_name'] : '';
		$this->city_id = isset($args['city_id']) ? $args['city_id'] : '';
		$this->city_name = isset($args['city_name']) ? $args['city_name'] : '';
		$this->country_id = isset($args['country_id']) ? $args['country_id'] : '';
		$this->country_name = isset($args['country_name']) ? $args['country_name'] : '';
		$this->position_name = isset($args['position_name']) ? $args['position_name'] : '';

	}

	public function full_name() {
		return $this->first_name . " " . $this->last_name;
	}

	public function insert() {
		
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

		if($result && $this->vehicle_id !== '0') {
			$sql = "INSERT INTO drivers_vehicles ";
			$sql .= "(driver_id, vehicle_id) ";
			$sql .= "VALUES (";
			$sql .= "'" . self::$db->db_escape($this->id) . "', ";
			$sql .= "'" . self::$db->db_escape($this->vehicle_id) . "' ";
			$sql .= ")";

			$result = self::$db->query($sql);
		}

		return $result;
	}

	public function update() {

		$result = parent::update();
		
		if($result) {
			if($this->vehicle_id == '0') {

				$sql = "DELETE FROM drivers_vehicles ";
				$sql .= "WHERE driver_id = '" . $this->id . "' ";
				$sql .= "LIMIT 1";
				// var_dump($sql);
				// exit();
				$result = self::$db->query($sql);

			} else {

				$sql = "SELECT COUNT(*) AS driver_count FROM drivers_vehicles ";
				$sql .= "WHERE driver_id = '" . $this->id . "'";

				$result = self::$db->query($sql);
				$driver_count = (int)self::$db->fetch_assoc($result);
				
				if($driver_count === 1) {
					$sql = "UPDATE drivers_vehicles ";
					$sql .= "SET ";
					$sql .= "vehicle_id = '" . self::$db->db_escape($this->vehicle_id) . "' ";
					$sql .= "WHERE driver_id = '" . self::$db->db_escape($this->id) . "' ";
					$sql .= "LIMIT 1";
					
					$result = self::$db->query($sql);
					
				} else {
					$sql = "INSERT INTO drivers_vehicles ";
					$sql .= "(driver_id, vehicle_id) ";
					$sql .= "VALUES (";
					$sql .= "'" . self::$db->db_escape($this->id) . "', ";
					$sql .= "'" . self::$db->db_escape($this->vehicle_id) . "' ";
					$sql .= ")";

					$result = self::$db->query($sql);
				}
			}
		}

		return $result;
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

		return $this->errors;
	}

	static public function find_by_first_name($first_name) {
		
		$sql = "SELECT * FROM drivers ";
		$sql .= "WHERE first_name = '" . self::$db->db_escape($first_name) . "'";

		return static::find_by_sql($sql);
	}

	static public function find_all() {
		$sql = "SELECT *, drivers.id AS id FROM drivers ";
		$sql .= "LEFT JOIN positions ON drivers.position_id = positions.position_id ";
		$sql .= "LEFT JOIN drivers_vehicles ON drivers_vehicles.driver_id = drivers.id ";
		$sql .= "LEFT JOIN vehicles ON drivers_vehicles.vehicle_id = vehicles.id";
		// echo $sql;
		return static::find_by_sql($sql);
	}

	static public function find_by_id($id=0) {
		$sql = "SELECT *, drivers.id FROM drivers ";
		$sql .= "LEFT JOIN positions ON positions.position_id = drivers.position_id ";
		$sql .= "LEFT JOIN address_drivers ON address_drivers.address_id = drivers.id ";
		$sql .= "LEFT JOIN city ON city.city_id = address_drivers.city_id ";
		$sql .= "LEFT JOIN country ON country.country_id = city.country_id ";
		$sql .= "LEFT JOIN drivers_vehicles ON drivers_vehicles.driver_id = drivers.id ";
		$sql .= "LEFT JOIN vehicles ON vehicles.id = drivers_vehicles.vehicle_id ";
		$sql .= "WHERE drivers.id = '" . self::$db->db_escape($id) . "'";
		// echo $sql;
		$object_array = static::find_by_sql($sql);
		return !empty($object_array) ? array_shift($object_array) : false;
	}

}