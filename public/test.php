<?php

	function update($table, array $varr, array $conditions=NULL) {
		if (is_null($varr) ) return  array("error"=>true);
		$query = "UPDATE $table SET";
		
		foreach ($varr as $key => $value) {
			if (is_null($value)) continue;
			if (is_string($value) ){
				$query .= " $key='$value', ";	
			} else {
				$query .= " $key=$value, ";	
			}
		}
		$query = substr($query, 0, -2)." ";
		if (!is_null($conditions)) {
			print_r("UPDATE: where? \n");
			$valid = false;
			foreach($conditions as $key=>$value) {
					print_r("UPDATE: (bf if)where? $key, $value\n");
				if (!is_null($value)){
					print_r("UPDATE: where? $key, $value\n");
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
				print_r("UPDATE: $where \n");
				$query .= $where." ;";
			} else {
				print_r(" Oooops!!! ");	
				$query .= ";";
			}
		}
		print_r("UPDATE: $query\n");
	}

	$data = array (
			"name" => "Kim Jeen",
			"age" => 32,
		);
	$needT = true;
	$where = array();
	if ($needT) {
		$where["id"] = 2;
	}
	
	$tablename = "Ta";

	print_r($data);
	print_r($where);
	
	update($tablename, $data, $where);


?>
