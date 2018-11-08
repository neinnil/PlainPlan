<?php
	include "../inc/database.php";

	$res = array('error'=>false);

	$action = "read";
	$tableName = "issues";
	$_file = "issue.php";

	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}

	$db = new DBHandler();

	$db->connect();

	if ($action == "read") {
		$condition = array();
		if (isset($_GET["id"])) {
			$condition["id"] = $_GET["id"];;
		}
		if (isset($_POST["taskId"])) {
			$condition["taskId"] = $_GET["taskId"];
		}
		$where = "";

		$query="select id, name, parentId, projectId, taskId, userId, title, description, status, tag, attachements, rootCause, response, prevent, assigneeId, duedate, priority, severity, closeddate, createdDate, modifiedDate, isValid from $tableName $where;";

		$result = $db->query($query);
		if( $result && $result->num_rows>0){
			$issues = array();
			while($row = $result->fetch_assoc()) {
				array_push($issues, $row);
			}
			$res["message"]="Success";
			$res["count"] = $result->num_rows;
			$res["issues"] = $issues;
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
 			 "title"=>$_POST['title'],
			 "description"=>$_POST['description'],
			 "status" => $_POST['status'],
			 "tag" => $_POST['tag'],
			 "attachements" => $_POST['attachements'],
			 "rootCause" => $_POST['rootCause'],
			 "response" => $_POST['response'],
			 "preventMethod" => $_POST['preventMethod'],
			 "assigneeId" => $_POST['assigneeId'],
			 "duedate" => $_POST['duedate'],
			 "closeddate" => $_POST['closeddate'],
			 "severity" => $_POST['severity'],
			 "priority" => $_POST['priority'],
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
 			 "title"=>$_POST['title'],
			 "contents"=>$_POST['contents'],
			 "status" => $_POST['status'],
			 "tag" => $_POST['tag'],
			 "attachements" => $_POST['attachements'],
			 "rootCause" => $_POST['rootCause'],
			 "response" => $_POST['response'],
			 "preventMethod" => $_POST['preventMethod'],
			 "assigneeId" => $_POST['assigneeId'],
			 "plandue" => $_POST['plandue'],
			 "closeddate" => $_POST['closeddate'],
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
