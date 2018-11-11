<?php
	include "../inc/database.php";

	$res = array('error'=>false);

	$action = "read";
	$tableName = "note";
	$_file = "worknote.php";

	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}

	$db = new DBHandler();

	$db->connect();

	if ($action == "read") {
		$where = "";
		if (isset($_GET["projectId"])) {
			$projectId = $_GET["projectId"];
			$where = " projectId=$projectId ";
		}
		if (isset($_GET["taskId"])) {
			$taskId = $_GET["taskId"];
			$where = " and taskId=$taskId ";
		}

//		$query="select id, name, projectId, taskId, userId, writer, workingtime, today, nextday, attachedObjs, parentId, status, revision, type, createdDate, modifiedDate, isValid from $tableName $where;";

		$query = "select n.* , u.name as writername, prj.name as projectname, t.name as taskname from note as n left join users as u on (n.writer = u.id) left join project as prj on (n.projectId = prj.id) left join task as t on (n.taskId = t.id) $where; ";
		$result = $db->query($query);
		if( $result && $result->num_rows>0){
			$notes = array();
			while($row = $result->fetch_assoc()) {
				array_push($notes, $row);
			}
			$res["message"]="Success";
			$res["count"] = $result->num_rows;
			$res["notes"] = $notes;
			$result->close();
		} else {
			$res["error"] = true;
			$res["message"] = "There is no data.";
		}
	}

	if ($action == "create") {
		$data = array (
		"name" => $_POST['name'],
		"projectId" => $_POST['projectId'],
		"taskId" => $_POST['taskId'],
		"parentId" => $_POST['parentId'],
		"userId" => $_POST['userId'],
		"writer" => $_POST['writer'],
		"today" => $_POST['today'],
		"nextday" => $_POST['nextday'],
		"attachedObjs" => $_POST['attachedObjs'],
		"status" => $_POST['status'],
		"revision" => $_POST['revision'],
		"type" => $_POST['type'],
		"workingtime" => $_POST['workingtime'],
		);
		myDebug("$_file [Create] $tableName \n");
		if($result = $db->insert($tableName, $data)) {
			myDebug("Success: $_file [Create] $tableName \n");
			$res["message"] = "Success";
		} else {
			myDebug("Fail: $_file [Create] $tableName \n");
			$res["error"] = true;
			$res["message"] = "Insert Fail";
		}
	}

	if ($action == "update") {
		$data = array (
		"name" => $_POST['name'],
		"projectId" => $_POST['projectId'],
		"taskId" => $_POST['taskId'],
		"parentId" => $_POST['parentId'],
		"userId" => $_POST['userId'],
		"writer" => $_POST['writer'],
		"today" => $_POST['today'],
		"nextday" => $_POST['nextday'],
		"attachedObjs" => $_POST['attachedObjs'],
		"status" => $_POST['status'],
		"revision" => $_POST['revision'],
		"type" => $_POST['type'],
		"workingtime" => $_POST['workingtime'],
		);
		$where = array();;
		if (isset($_POST["id"])) {
			$id = $_POST['id'];
			$where["id"] = $_POST['id'];
			$val = $where["id"];
			myDebug("$_file:(update) $id, $val \n");
		}
		
		if($result = $db->update($tableName, $data, $where)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "Update Fail";
		}
	}

	if ($action == "delete") {
		$id = $_POST["id"];
		$query = "delete from $tableName where id=$id;";
		if($result = $db->query($query)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "Insert Fail";
		}
	}

	$db->close();
	header("Content-type: application/json");
	echo json_encode($res);

?>
