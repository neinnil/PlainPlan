<?php
	include "../inc/database.php";

	$res = array("error"=>false);

	$_file = "user.php";
	$action = "read";

	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}

	$db = new DBHandler();

	$db->connect();

	if ($action == "read") {
		$where = "";
		if (isset($_GET["email"])) {
			$email = $_GET["email"];
			$where = "where email = '$email' ";
		}
		if (isset($_GET["name"])) {
			$s_name = $_GET["name"];
			$where = " where u.name like '$s_name%' ";
		}
		if (isset($_GET["id"])) {
			$s_id = $_GET["id"];
			$where = " where u.id = $s_id ";
		}

		$query="select u.id id,u.email email,u.name name ,u.role role ,u.userCode userCode ,u.departmentId departmentId ,u.companyId companyId, c.name companyName, d.name departmentName from users as u left join company as c on (u.companyId = c.id) left join department as d on (u.departmentId = d.id)  $where;";

		$result = $db->query($query);
		if( $result && $result->num_rows>=0){
			$users = array();
			while($row = $result->fetch_assoc()) {
				array_push($users, $row);
			}
			$res["message"]="Success";
			$res["count"] = $result->num_rows;
			$res["users"] = $users;
			$result->close();
		} else {
			$res["error"] = true;
			$res["message"] = "There is no data.";
		}
	}

	if ($action == "create") {
		$data = array (
		"email" => $_POST["email"],
		"name" => $_POST["name"],
		"password" => $_POST["password"],
		"role" => $_POST["role"],
		"userCode" => $_POST["userCode"],
		"departmentId" => $_POST["departmentId"],
		"companyId" => $_POST["companyId"],
		);
		
	//	$query = "insert into users (email, name, password, role, userCode, departmentId, companyId) values ('$email', '$name', PASSWORD('$password'),'$role', '$userCode', $departmentId, $companyId);";
	//	myDebug("$_file[$action] Query: $query\n");
		$result = $db->insert("users", $data);
		if($db->getAffectedRows()>0) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "$query";
		}
	}

	if ($action == "update" && isset($_POST["id"])) {
		$id = $_POST["id"];
		$setClause = "";
		if (isset($_POST["email"])) {
			$email = $_POST["email"];
			$setClause .=" email = '$email'";
		}	
		if (isset($_POST["name"])) {
			$name = $_POST["name"];
			if(strlen($setClause)> 0) {
				$setClause .= ", ";
			}
			$setClause .=" name = '$name'";
		
		}	
		if (isset($_POST["password"])) {
			$password = $_POST["password"];
			if(strlen($setClause)> 0) {
				$setClause .= ", ";
			}
			$setClause .= " password = PASSWORD('$password')";
		}
		if (isset($_POST["role"])) {
			$role = $_POST["role"];
			if(strlen($setClause)> 0) {
				$setClause .= ", ";
			}
			$setClause .= " role = '$role'";
		}
		if (isset($_POST["userCode"])) {
			$userCode = $_POST["userCode"];
			if(strlen($setClause)> 0) {
				$setClause .= ", ";
			}
			$setClause .= " userCode = '$userCode'";
		}
		if (isset($_POST["departmentId"])) {
			$departmentId = $_POST["departmentId"];
			if(strlen($setClause)> 0) {
				$setClause .= ", ";
			}
			$setClause .= " departmentId = $departmentId";
		}
		if (isset($_POST["companyId"])) {
			$companyId = $_POST["companyId"];
			if(strlen($setClause)> 0) {
				$setClause .= ", ";
			}
			$setClause .= " companyId = $companyId";
		}
		$query = "update users set {$setClause}  where id = {$id};";
		if ($result = $db->query($query)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "$query";
		}
	}

	if ($action == "delete" && isset($_POST["id"])) {
		$id		 = $_POST["id"];
		//$email = $_POST["email"];
		$query = "delete from users where id={$id};";
		if($result = $db->query($query)) {
			$res["message"] = "Success";
		} else {
			$res["error"] = true;
			$res["message"] = "Delete Fail";
		}
	}

	$db->close();

	header("Content-type: application/json");
	echo json_encode($res);

?>
