<?php

function myDebug($contents) {
	error_log($contents, 3, "/var/log/php7/my-errors.log");
}

class DBHandler {
	private	$_dbServer = "localhost";
	private	$_dbUser = "spms";
	private	$_dbPass = "sang1234";
	private $_dbName = "spmsdb";

	protected $_connHdl = NULL;
	public $_res = NULL;

	public function connect() {
		$this->_connHdl = new mysqli($this->_dbServer, $this->_dbUser, $this->_dbPass, $this->_dbName);
		if ($this->_connHdl->connect_error) {
			return -1;
		}	
		else {
			return 0;
		}
	}

	public function close() {
		if (isset($this->_connHdl)) {
			$this->_connHdl->close();
		}
	}

	public function query (&$qstr) {
		if (!isset($this->_connHdl)) {
			myDebug("database.php [query] not connected\n");
			$this->connect();
		}

		myDebug("database.php [query] Query: $qstr\n");

		$this->_res = $this->_connHdl->query($qstr);
		return $this->_res;
	}

	public function &result() {
		return $this->_res; 
	}

	public function insert($table, array $varr) {
/**
		if (is_null(varr) ) {
			error_log("INSERT: \n", 3, "/var/log/php7/my-errors.log");
			return  array("error"=>true);
		}
**/
		
		$query = "INSERT INTO $table ";
		myDebug("INSERT: $table: $query \n");
		$cols = " (";
		$vals = " (";
		
		foreach ($varr as $key => $value)  {
			if (is_null($value)) {
				myDebug("INSERT: $table: $key has no value. \n");
				continue;
			}
			$cols .= " $key,";
			if (is_string($value)) {
				$vals .= " \"$value\",";
			}else {
				$vals .= " $value,";
			}
		}
		myDebug("INSERT: [$cols]  \n");
		myDebug("INSERT: [$vals]  \n");
		$cols = substr($cols, 0, -1)." )";
		myDebug("INSERT: [$cols]  \n");
		$vals = substr($vals, 0, -1)." )";
		myDebug("INSERT: [$vals]  \n");
		$query = "$query $cols VALUES $vals ;";
		myDebug("INSERT: $query \n");
		return $this->query($query);	
	}
	
	public function update($table, array $varr, array $conditions=NULL) {
		if (is_null($varr) ) return  array("error"=>true);
		$query = "UPDATE $table SET";
		
		foreach ($varr as $key => $value) {
			if (is_null($value)) continue;
			if (is_string($value) ){
				$query .= " $key=\"$value\", ";	
			} else {
				$query .= " $key=$value, ";	
			}
		}
		$query = substr($query, 0, -2)." ";
		if (!is_null($conditions)) {
			myDebug("UPDATE: where? \n");
			$valid = false;
			foreach($conditions as $key=>$value) {
					myDebug("UPDATE: (bf if)where? $key, $value\n");
				if (!is_null($value)){
					myDebug("UPDATE: where? $key, $value\n");
					 $valid = true;
				}
				if($valid) break;
			}
			if ($valid) {
				$where = " WHERE ";
				foreach ($conditions as $ckey=>$cval) {
					if (is_string($cval)){
						$where .= "$key = '$cval',";
					} else {
						$where .= "$key = $cval,";
					}
				}
				$where = substr($where, 0, -1);
				myDebug("UPDATE: $where \n");
				$query .= $where." ;";
			} else {
				myDebug(" Oooops!!! ");	
				$query .= ";";
			}
		}
		myDebug("UPDATE: $query\n");
		return $this->query($query);	
	}

	public function getAffectedRows() {
		return $this->_connHdl->affected_rows;
	}

	public function getError() {
		return $this->_connHdl->error;
	}
}

?>
