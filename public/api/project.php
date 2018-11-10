<?php
	include "../inc/database.php";

	$res = array('error'=>false);

	$action = "read";
	$tableName = "project";

	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}

	$db = new DBHandler();

	$db->connect();

	if ($action == "read") {
		error_log("project.php [$action] Query: project read\n", 3, "/var/log/php7/my-errors.log");
		$where = "";
		if (isset($_GET["id"])) {
			$projectId = $_GET["id"];
			$where = "where id=$projectId ";
		}

		$query="select id, name, projectCode as code, parentId, description, startDate as start, endDate as end, actualStartDate as actualstart, actualEndDate as actualend, status, projectManager, projectLeaders from project $where;";

		error_log("Query: $query\n", 3, "/var/log/php7/my-errors.log");

		$result = $db->query($query);
		if( $result && $result->num_rows>=0){
			$projlist = array();
			while($row = $result->fetch_assoc()) {
				array_push($projlist, $row);
			}
			$res["message"]="Success";
			$res["count"] = $result->num_rows;
			$res["projects"] = $projlist;
			$result->close();
		} else {
			$res["error"] = true;
			$res["message"] = "There is no data.";
		}
	}

	if ($action == "create") {
		$name = $_POST["name"];
		$projectCode = $_POST["code"];
		$description = $_POST["description"];
		$startDate = $_POST["startDate"];
		$endDate = $_POST["endDate"];
		$projectManager =  $_POST["manager"];
		//$projectLeaders = $_POST["projectLeaders"];
		$query = "insert into project (name, projectCode, description, startDate, endDate) values ('$name','$projectCode', '$description','$startDate','$endDate');";
		myDebu("project.php [$action] Query: $query\n");
		$result = $db->query($query);
		if($db->getAffectedRows()>0) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "Insert Fail";
		}
		//$result->close();
	}

	if ($action == "update") {
		$data = array (
		"name" => $_POST["name"],
		"projectCode" => $_POST["projectCode"],
		"startDate" => $_POST["start"],
		"endDate" => $_POST["end"],
		"parentId" => $_POST["parentId"],
		"actualStartDate" => $_POST["actualStartDate"],
		"actualEndDate" => $_POST["actualEndDate"],
		"isMilestone" => $_POST["isMilestone"],
		"isTaskGroup" => $_POST["isTaskGroup"],
		"status" => $_POST["status"],
		"projectManager" => $_POST["projectManager"],
		"projectLeaders" => $_POST["projectLeaders"],
		"description" => $_POST["description"],
		);
		$where = NULL;
		if (isset($_POST["id"])) 
				$where = array("id" => $_POST["id"]);

		if($result = $db->update($tableName, $data, $where)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "Insert Fail";
		}
	}

	if ($action == "delete") {
		$id = $_POST["id"];
		$query = "delete from project where id=$id;";
		error_log("project.php [$action] Query: $query\n", 3, "/var/log/php7/my-errors.log");
		if($result = $db->query($query)) {
			$res["message"] = "Success";
//			$result->close();
		} else {
			$res["error"] = true;
			$res["message"] = "Insert Fail";
		}
	}

	$db->close();
	header("Content-type: application/json");
	echo json_encode($res);

?>
