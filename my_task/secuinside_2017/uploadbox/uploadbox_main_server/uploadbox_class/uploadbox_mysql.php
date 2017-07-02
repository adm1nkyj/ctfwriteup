<?php
	class uploadbox_mysql{
		private static $con;
		public static function do_connect(){
			if(!isset(self::$con)) self::$con = mysqli_connect('localhost', 'root', 'apmsetup');

			mysqli_select_db(self::$con, 'uploadbox');
			return self::$con;

		}
		public static function insert_query($input, $table){
			$query = '';
			$column_list = '';
			$value_lsit = '';

			foreach ($input as $key => $value) {
				$column_list .= $key.' ,';
				$value_lsit .= "'".$value."'".' ,';
			}

			$column_list = substr($column_list, 0, -1);
			$value_lsit = substr($value_lsit, 0, -1);
		
			$query = "INSERT INTO {$table} (".$column_list.") VALUES (".$value_lsit.");";
			if(mysqli_query(self::do_connect(), $query)){
				return true;
			}
			else{
				echo mysqli_error(self::$con);
			}
			return false;
		}
		public static function update_query($condition, $table, $update){
			$change = "";
			foreach ($update as $key => $value) {
				$change .= "{$key}='$value',";
			}
			$change = substr($change, 0, -1);
			$query = "UPDATE {$table} SET {$change} WHERE $condition";
			if(mysqli_query(self::do_connect(), $query)){
				return true;
			}
			else{
				echo mysqli_error(self::$con);
			}
			return false;
		}
		public static function select_fetch_query($condition, $table, $orderBy='', $limit=''){
			$query = "SELECT * FROM {$table} WHERE {$condition};";		
			if($result = mysqli_query(self::do_connect(), $query)){
				$return_value = array();
				while($query_result = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					$return_value[] = $query_result;
				}
				if($return_value){

					return $return_value;
				}
			}
			else{
				echo mysqli_error(self::$con);
			}
			return false;
		}
		public static function select_query($condition, $table, $orderBy='', $limit=''){
			$query = "SELECT * FROM {$table} WHERE {$condition};";		
			if($result = mysqli_query(self::do_connect(), $query)){
				
				$query_result = mysqli_fetch_array($result, MYSQLI_ASSOC);
				if($query_result){

					return $query_result;
				}
			}
			else{
				echo mysqli_error(self::$con);
			}
			return false;
		}
	}
?>