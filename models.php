<?php
require_once 'conn.php';
db_conn();
define('SECURITY_TOKEN', '1251512asf');
/**********************************
 * Model definition.
 * (C) 2001 Alexander Forselius 
* //TIMEWARP
 **********************************/


class Model {
	var $_conn;
	var $_id;
	var $_fields = array("id");
	var $_dbtable = "[model]";
	var $_row;
	function __construct($id = NULL) {
		$this->_id = $id;
		if($id) {
	
	
			$sql = "SELECT * FROM " . $this->_dbtable . " WHERE _id = " . ($id);
			$result = mysql_query($sql) or die(mysql_error());
			while($row = mysql_fetch_array($result)) {
				$this->_row = $row;
				$this->id = $id;
			}
			
			foreach (array_keys(get_class_vars(get_class($this))) as $var) {
			
				
				if(strrpos($var, '_') !== 0) {
					$this->{$var} = $this->_row[$var];
				}
				
				
			}
		}
	}
	function create($id = NULL) {
		$this->__construct($id);
	}
	function select($fields = "*", $conditions = array(), $order = NULL) {
		$sql = "SELECT " . (is_array($fields) ? implode(',', $fields) : $fields) . " FROM " .$this->_dbtable . " WHERE ";
		$conds = array();
		foreach($conditions as $k => $v) {
			$conds[] = $k . " = '" . mysql_real_escape_string($v) . "'";
		}
		$sql .= implode(' AND ', $conds);
		if(strlen($order) > 0) {
			$sql .= "ORDER BY ";
			$sql .= $order;
		}
		$result = mysql_query($sql) or die(mysql_error()); 
		return $result;
	}
	function insert($values) {
		$fields = array_keys($values);
		$sql = "INSERT INTO " . $this->_dbtable . " (".implode(',', ($fields)).") VALUES (";
		$vals = array();
		
		// die(var_dump($values));
		foreach($values as $k => $v) {
			var_dump($values);

			$val = '2';
	
			if(gettype($val) == 'string') {
				$val = "'". mysql_real_escape_string($v). "'";
			}

			if(is_numeric($val)) {
				$val = $v;
			}

			if(is_object($v)) {
				 $val = $v->_id;
			}
			if(count($val) > 0)
			$vals[] = $val;
			
			
		}
		$sql .= implode(',', $vals);
		$sql .= ")";
		mysql_query($sql) or die(mysql_error()." ". $sql);
	}
	function update($id, $values) {
		$sql = "UPDATE " . $this->_dbtable . " SET ";
		foreach($values as $k => $v) {
			$sql .= $k . " = '" . mysql_real_escape_string($v) . "'";
		}
		$sql .= "WHERE id = ". mysql_real_escape_string($id);
		$q = mysql_query($sql) or die(mysql_error());
		$result = mysql_result($q);
	}
	function delete($id) {
		$sql = "DELETE FROM " . $this->_dbtable . " WHERE _id = " . ($id);
		mysql_query($sql) or die(mysql_error());
	}
	function save($t = TRUE) {
		$fields = array();
		$vars = get_class_vars(get_class($this));
		foreach (array_keys($vars) as $var) {
			
			if(strrpos('_', $var) !== 0) {
				if(is_string($this->{$var}))
					$fields[$var] = $this->{$var};
				if(is_numeric($this->{$var})) {
					
					$fields[$var] = $this->{$var};
				}
				$val = $this->{$var};
				if(is_object($val)) {	
					
					$fields[$var.'_id'] = $val->_id;
				}
			}
		}
		$this->insert($fields);
	}
}
function current_user() {
	if(!user_is_logged_in()) {
		return FALSE;
	}
	$user = new User();
	$user->create($_COOKIE['user_id']);
	return $user;
}
function get_user($username) {
	$user = new User();
	$users = $user->select(array("_id", "username"), array('username' => $username));
	// var_dump($users);
	while($user = mysql_fetch_array($users)) {

		if($user['username'] === $username) {
		
			$user2 = new User($user['_id']);
			$user2->create($user['_id']);
			return $user2;
		}
	}
	return NULL;
}
class User  extends Model {
	var $_id;
	var $username;
	var $password;
	var $_dbtable = "users";
	var $_fields = array('username', 'email', 'password');
	function __construct($id = NULL) {
		parent::__construct($id);
		
	}
	
	function login($password) {
		if(md5($password.SECURITY_TOKEN) === ($this->password)) {
			
			setcookie('user_id', $this->_id, time() + 3600 * 8);
			return TRUE;
		}
		return FALSE;
	}
	function logout() {
		setcookie('user_id', NULL, time() - 3600);
	}
}
function user_is_logged_in() {
	return isset($_COOKIE['user_id']);
}
class Sport extends Model {
	var $_id;
	var $title;
	function __construct($id = NULL) {
		parent::construct($id);
	}
	function create($id = NULL) {
		$this->__construct($id);
	}
}	
class Swim  extends Model {
	var $_id;
	var $metres;
	var $time;
	var $user;
	var $user;
	
	var $duration;
	var $_dbtable = "swims";
	var $_fields = array('metres', 'duration', 'time', 'user');
	function __construct($id = NULL) {

		parent::__construct($id);
		
	}
	function create($id = NULL) {
		$this->__construct($id);
	}
}
class Collection {
	var $_model = "Model";
	function Collection($model) {
		$this->_model = $model;
		
	}

	function query($fields, $conditions = array(), $order = NULL) {
		$instance = new $this->_model();
		$sql = "SELECT _id FROM " . $instance->_dbtable . " WHERE ";
		foreach($conditions as $k => $v) {
			$conds[] = $k . " = '" . mysql_real_escape_string($v) . "'";
		}
		
		$sql .= implode(' AND ', $conds);
		if(strlen($order) > 0) {
			var_dump($order);
			$sql .= " ORDER BY ";
			$sql .= $order;
		}
		$result = mysql_query($sql);
		$rows = array();
		
		while($row = mysql_fetch_array($result)) {
			// var_dump($row);
			$swim = new $this->_model($row['_id']);
			$swim->create($row['_id']);
			$rows[] = $swim;
			// var_dump($rows);
		}
		
		return $rows;
	}
}// var_dump