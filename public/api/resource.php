<?php
	include "../inc/database.php";

	$res = array("error"=>false);

	$action = "read";

	$tableName = "resources";
	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}

	$db = new DBHandler();

	$db->connect();

	if ($action == "read") {
		$where = "";
		if (isset($_GET["id"])) {
			$email = $_GET["id"];
			$where = "where id = '$id' ";
		}

		$query = "SELECT r.id, r.name, r.projectId, r.resourceId, r.type, r.role, r.privileges, r.amount, r.cost, r.overtimeCost, r.isValid FROM resources r; ";
		

		$result = $db->query($query);
		if( $result && $result->num_rows>=0){
			$resourcess = array();
			while($row = $result->fetch_assoc()) {
				array_push($resourcess, $row);
			}
			$res["message"]="Success";
			$res["count"] = $result->num_rows;
			$res["resourcess"] = $resourcess;
			$result->close();
		} else {
			$res["error"] = true;
			$res["message"] = "There is no data.";
		}
	}

	if ($action == "create") {
		$data = array ("name"=>$_POST["name"]
								  ,"parentId"=>$_POST["parentId"]
								  ,"projectId"=>$_POST["projectId"]
								  ,"resourceId"=>$_POST["resourceId"]
								  ,"type"=>$_POST["type"]
								  ,"role"=>$_POST["role"]
								  ,"privileges"=>$_POST["privileges"]
								  ,"amount"=>$_POST["amount"]
								  ,"cost"=>$_POST["cost"]
								  ,"overtimeCost"=>$_POST["overtimeCost"] );
									
		if($result = $db->insert($tableName, $data)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "$query";
		}
	}

	if ($action == "update" && isset($_POST["id"])) {
		$data = array ("name"=>$_POST["name"]
								  ,"parentId"=>$_POST["parentId"]
								  ,"projectId"=>$_POST["projectId"]
								  ,"resourceId"=>$_POST["resourceId"]
								  ,"type"=>$_POST["type"]
								  ,"role"=>$_POST["role"]
								  ,"privileges"=>$_POST["privileges"]
								  ,"amount"=>$_POST["amount"]
								  ,"cost"=>$_POST["cost"]
								  ,"overtimeCost"=>$_POST["overtimeCost"] );
									
		$where = array("id"=> $_POST["id"]);

		if ($result = $db->update($tableName, $data, $where)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = $db->getError();
		}
	}

	if ($action == "delete" && isset($_POST["id"])) {
		$id		 = $_POST["id"];
		$query = "delete from resourcess where id={$id};";
		if($result = $db->query($query)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] =  $db->getError();
		}
	}

	$db->close();

	header("Content-type: application/json");
	echo json_encode($res);

?>
