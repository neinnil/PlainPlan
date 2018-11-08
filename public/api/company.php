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
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$where = 'where id = "$id" ';
		}

		$query='select id,name,companyCode,isValid from company '.$where.' ;';

		$result = $db->query($query);
		if( $result && $result->num_rows>0){
			$companies = array();
			while($row = $result->fetch_assoc()) {
				array_push($companies, $row);
			}
			$res['message']='Success';
			$res['companies'] = $companies;
			$result->close();
		} else {
			$res['error'] = true;
			$res['message'] = 'There is no data.';
		}
	}

	if ($action == 'create') {
		$name = $_POST["name"];
		$query="INSERT INTO company  (name) VALUES ('$name');";
		if($result = $db->query($query)) {
			$res['message'] = 'Success';
		} else {
			$res['error'] = true;
			$res['message'] = 'Insert Fail';
		}
	}

	if ($action == "delete") {
		$id = $_POST["id"];
		$query = "delete from company where id='$id';";
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
