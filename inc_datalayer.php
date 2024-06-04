<?php

//This uses PHP new MySQLi not the old MySQL_connect
 
class datalayer {
	var $link;
	var $id = 0;
	var $isinsert = false;
	var $errors = array();
	var $debug = false;


	function datalayer() {
	}

	function connect( $host, $name, $pass, $db) {
		$link = new mysqli($host, $name, $pass);
		if(!$link) {
			$this->seterror('Couldn\'t connect to database server');
			return false;
		}

		if(!$link->select_db($db)) {
			$this->seterror('Couldn\'t select database: '.$db);
			return false;
		}
		$this->link = $link;
		return true;
	}

	function geterror() {
		return $this->errors[count($this->errors)-1];
	}

	function seterror($str) {
		array_push($this->errors, $str);
	}

	function _query($query) {
		if(!$this->link) {
			$this->seterror('No active database connection');
			return false;
		}
		$result=$this->link->query($query);
		if(!$result) {
			$this->seterror('Error: ' .$link->error);
		} else {
			if($this->isinsert) {
				$this->id = mysqli_insert_id($this->link); //$link->insert_id;
				$this->debug('Insert ID value = '.$this->id);
			}
		}
		return $result;
	}

	function setquery($query){
		if(!$result=$this->_query($query)) {
			return false;
		}
		if($this->isinsert) {
			return mysqli_insert_id($this->link); //$link->insert_id;
		} else {
			return $this->link->affected_rows;
		}
	}

	function getquery($query){
		if(!$result=$this->_query($query)) {{ };
			return false;
		}
		$ret = array();
		while($row=$result->fetch_assoc()) {
			$ret[]=$row;
		}
		return $ret;
	}

	function getResource() {
		return $this->link;
	}

	function select($table, $condition='', $sort='') {
		$query = 'SELECT * FROM '.$table;
		$query .= $this->_makewherelist($condition);
		if ($sort != '') {
			$query .= ' ORDER BY '.$sort;
		}
		$this->debug($query);
		return @$this->getquery($query, $error);
	}

	function sql($query) {
		$this->debug($query);
		$start = strtoupper(substr($query,0,6));
		if($start=='SELECT') {
			return @$this->getquery($query, $error);
		} else {
			return @$this->setquery($query, $error);
		}
	}

	function insert($table, $add_array) {
		$add_array = $this->_quote_vals($add_array);
		$keys = '(`' .implode(array_keys($add_array), '`, `').'`)';
		$values = 'VALUES (' .implode(array_values($add_array), ', ') .')';
		$query = 'INSERT INTO '.$table.' '.$keys.' '.$values;
		$this->isinsert = true;
		$this->debug($query);
		return $this->setquery($query);
	}

	function update($table, $update_array, $condition='') {
		$update_pairs=array();
		foreach($update_array as $field=>$val)
			array_push($update_pairs, '`'.$field.'`'.'='.$this->_quote_val($val));
		$query='UPDATE '.$table.' SET ';
		$query.=implode(', ', $update_pairs);
		$query.=$this->_makeWhereList($condition);
		$this->debug($query);
		return $this->setquery($query);
	}

	function delete($table, $condition='') {
		$query='DELETE FROM '.$table;
		$query.=$this->_makeWhereList($condition);
		$this->debug($query);
		return @$this->setquery($query, $error);
	}

	function debug($msg) {
		if ($this->debug)
			print $msg.'<br>';
	}

	function _makeWhereList($condition) {
		if (empty($condition))
			return '';
		$retstr=' WHERE ';
		if (is_array($condition)) {
			$cond_pairs=array();
			foreach($condition as $field=>$val)
				array_push($cond_pairs, $field.'='.$this->_quote_val($val));
			$retstr.=implode(' AND ', $cond_pairs);
		} elseif (is_string($condition) && ! empty($condition))
			$retstr.=$condition;
		return $retstr;
	}

	function _quote_val($val){
		if (is_numeric($val))
			return $val;
		return '\''.addslashes($val).'\'';
	}

	function _quote_vals($array) {
		foreach($array as $key=>$val)
			$ret[$key]=$this->_quote_val($val);
		return $ret;
	}

}

?>
