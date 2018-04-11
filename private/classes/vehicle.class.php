<?php

class Vehicle extends DatabaseObject {

	protected static $table_name = 'vehicles';

	protected static $db_columns = [
		'reg_plate', 'make_id', 'model', 'engine', 'fuel_type', 'kilometrage', 'reg_date', 'prod_year'];

	const FUEL_TYPE = ['1' => 'ED', '2' => 'BMB', '3' => 'TNG/BMB'];

	public $id;
	
	public $reg_plate;
	public $make_id;

	public $make_name;
	public static $make_names = [];

	public $model;
	public $engine;
	public $fuel_type;
	public $kilometrage;
	public $reg_date;
	public $prod_year;

	public function __construct($args=[]) {
		$this->reg_plate = isset($args['reg_plate']) ? $args['reg_plate'] : '';
		$this->make_id = isset($args['make_id']) ? $args['make_id'] : '';
		$this->make_name = isset($args['make_name']) ? $args['make_name'] : '';
		$this->model = isset($args['model']) ? $args['model'] : '';
		$this->engine = isset($args['engine']) ? $args['engine'] : '';
		$this->fuel_type = isset($args['fuel_type']) ? $args['fuel_type'] : '';
		$this->kilometrage = isset($args['kilometrage']) ? $args['kilometrage'] : '';
		$this->reg_date = isset($args['reg_date']) ? $args['reg_date'] : '';
		$this->prod_year = isset($args['prod_year']) ? $args['prod_year'] : '';

		self::set_make_names();
	}

	static private function set_make_names() {
		$result_set = self::$db->query("SELECT make_id, make_name FROM vehicles_make");
		// var_dump($result_set);
		foreach ($result_set as $result) {
			// var_dump($result);
			self::$make_names[] = $result;
		}
	}

	static public function get_make_names() {
		return self::$make_names;
	}

	protected function validate() {
		$this->errors = [];

		// write validation here for vehicle
		// validate reg plate
		if(is_blank($this->reg_plate)) {
			$this->errors[] = "Polje registraciona oznaka ne sme biti prazno";
		} elseif( !( strpos($this->reg_plate, 'BG ') == 0 && has_inclusion_of(strpos($this->reg_plate, '-'), [6,7]) ) ) {
			$this->errors[] = "Registraciona oznaka mora biti sledećeg formata BG 123-AB ili BG 1234-AB";
		}

		// validate rest input - check if some inputs is blank
		if(is_blank($this->model)) {
			$this->errors[] = "Polje model ne sme biti prazno";
		}
		if(is_blank($this->engine)) {
			$this->errors[] = "Polje tip motora ne sme biti prazno";
		}
		if(is_blank($this->kilometrage)) {
			$this->errors[] = "Polje kilometraza ne sme biti prazno";
		}
		if(is_blank($this->prod_year)) {
			$this->errors[] = "Polje godina proizvodnje ne sme biti prazno";
		}

		return $this->errors;
	}

	static public function find_all() {		
		$sql = "SELECT * FROM " . static::$table_name . " ";
		$sql .= "ORDER BY reg_date ASC";
		return static::find_by_sql($sql);
	}

	public static function find_by_id($id=0) {
		
		$sql = "SELECT * FROM vehicles ";
		$sql .= "LEFT JOIN vehicles_make ";
		$sql .= "ON vehicles.make_id = vehicles_make.make_id ";
		$sql .= "WHERE id = '" . self::$db->db_escape($id) . "'";
		// echo $sql;
		$object_array = static::find_by_sql($sql);
		return !empty($object_array) ? array_shift($object_array) : false;
	}

	public static function get_available_vehicles($current_vehicle) {

		$sql = "SELECT vehicles.id, reg_plate FROM vehicles ";
		$sql .= "LEFT JOIN drivers_vehicles ON vehicles.id = drivers_vehicles.vehicle_id ";
		$sql .= "WHERE id = '" . self::$db->db_escape($current_vehicle) . "' OR vehicle_id IS NULL";
	
		return static::find_by_sql($sql);
	}

	public static function find_by_reg_plate($reg_plate) {
		
		$sql = "SELECT * FROM ". static::$table_name . " ";
		$sql .= "WHERE reg_plate = '" . self::$db->db_escape($reg_plate) . "'";

		$object_array = static::find_by_sql($sql);
		return !empty($object_array) ? array_shift($object_array) : false;
	}

	public static function find_vehicles_by_reg_period($period=5) {
		$sql = "SELECT * FROM vehicles ";
		$sql .= "WHERE DATE_ADD(reg_date, INTERVAL 1 YEAR) < CURDATE() ";
		$sql .= "OR DATE_ADD(reg_date, INTERVAL 1 YEAR) < DATE_ADD(CURDATE(), INTERVAL " . self::$db->db_escape($period) . " DAY) ";
		$sql .= "ORDER BY reg_date ASC";

		return static::find_by_sql($sql);
	}

}