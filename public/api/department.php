<?php
	include "../inc/database.php";

	$res = array('error'=>false);

	$action = "read";

	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	}

	$db = new DBHandler();

	$db->connect();

	if ($action =='read') {
		$where = '';
		if (isset($_GET['departmentId'])) {
			$departmentId = $_GET['departmentId'];
			$where = 'where departmentId = "$departmentId" ';
		}

		$query='select id,name,departmentCode, companyId, parentId, isValid from department '.$where.' ;';

		$result = $db->query($query);
		if( $result && $result->num_rows>0){
			$departs = array();
			while($row = $result->fetch_assoc()) {
				array_push($departs, $row);
			}
			$res['message']='Success';
			$res['departs'] = $departs;
			$result->close();
		} else {
			$res['error'] = true;
			$res['message'] = 'There is no data.';
		}
	}

	if ($action == 'create') {
		$name = $_POST["name"];
		$companyId = $_POST["companyId"];
		$query="INSERT INTO department (name, compnayId) VALUES($name, $companyId);";
		if($result = $db->query($query)) {
			$res['message'] = 'Success';
		} else {
			$res['error'] = true;
			$res['message'] = 'Insert Fail';
		}
	}

	if ($action == "delete") {
		$id = $_POST["id"];
		$query = "delete from users where id='$id';";
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
