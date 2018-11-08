<?php
	include "../inc/database.php";

	$res = array('error'=>false);

	$action = "read";
	$tableName = "task";

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

		$query="select id, name, projectId, parentId, taskId, parentTaskId, upTaskId, downTaskId, level, wbs, assigneeId, startDate as start, endDate as end, duration, actualStartDate, actualEndDate, precedenceTasks, successorTasks, isMilestone, isTaskGroup, isValid, note from task $where;";

		$result = $db->query($query);
		if( $result && $result->num_rows>=0){
			$tasklist = array();
			while($row = $result->fetch_assoc()) {
				array_push($tasklist, $row);
			}
			$res["message"]="Success";
			$res["count"] = $result->num_rows;
			$res["tasks"] = $tasklist;
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
		"parentTaskId" => $_POST['parentTaskId'],
		"upTaskId" => $_POST['upTaskId'],
		"downTaskId" => $_POST['downTaskId'],
		"level" => $_POST['level'],
		"wbs" => $_POST['wbs'],
		"assigneeId" => $_POST['assigneeId'],
		"duration" => $_POST['duration'],
		"startDate" => $_POST['startDate'],
		"endDate" => $_POST['endDate'],
		"duration" => $_POST['duration'],
		"actualStartDate" => $_POST['actualStartDate'],
		"actualEndDate" => $_POST['actualEndDate'],
		"precedenceTasks" => $_POST['precedenceTasks'],
		"sucessorTasks" => $_POST['sucessorTasks'],
		"isMilestone" => $_POST['isMilestone'],
		"isTaskGroup" => $_POST['isTaskGroup'],
		"note" => $_POST['note'],
		);
		$tmpDuration = $_POST['duration'];
		error_log("tasks.php [Create] $tableName Duration: $tmpDuration \n", 3, "/var/log/php7/my-errors.log");
		error_log("tasks.php [Create] $tableName \n", 3, "/var/log/php7/my-errors.log");
		if($result = $db->insert($tableName, $data)) {
			error_log("Success: tasks.php [Create] $tableName \n", 3, "/var/log/php7/my-errors.log");
			$res["message"] = "Success";
		} else {
			error_log("Fail: tasks.php [Create] $tableName \n", 3, "/var/log/php7/my-errors.log");
			$res["error"] = true;
			$res["message"] = "Insert Fail";
		}
	}

	if ($action == "update") {
		$data = array (
		"name" => $_POST["name"],
		"projectId" => $_POST["projectId"],
		"startDate" => $_POST["startDate"],
		"endDate" => $_POST["endDate"],
		"duration" => $_POST["duration"],
		"taskId" => $_POST["taskId"],
		"parentTaskId" => $_POST["parentTaskId"],
		"upTaskId" => $_POST["upTaskId"],
		"downTaskId" => $_POST["downTaskId"],
		"level" => $_POST["level"],
		"wbs" => $_POST["wbs"],
		"assigneeId" => $_POST["assigneeId"],
		"startDate" => $_POST["startDate"],
		"endDate" => $_POST["endDate"],
		"duration" => $_POST["duration"],
		"actualStartDate" => $_POST["actualStartDate"],
		"actualEndDate" => $_POST["actualEndDate"],
		"precedenceTasks" => $_POST["precedenceTasks"],
		"sucessorTasks" => $_POST["sucessorTasks"],
		"isMilestone" => $_POST["isMilestone"],
		"isTaskGroup" => $_POST["isTaskGroup"],
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
