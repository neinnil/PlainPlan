<?php

echo '<script src="https://unpkg.com/vue/dist/vue.js"></script>';
echo '<script>';
$serverIp = $_SERVER['HTTP_HOST'];
echo 'const serverIP="'.$serverIp.'";';
echo 'const baseURL="/";'; 

$uid = $_SESSION['userid'];
$username = $_SESSION['userName'];
$useremail = 	$_SESSION['userEmail'] ;
$role =		$_SESSION['role'];
$departmentname = $_SESSION['departmentname'];
$departmentId = $_SESSION['departmentId'];
$companyname =	$_SESSION['company'];
$companyId =	$_SESSION['companyId'];

echo "const loginUser = { id: $uid, name:'$username' , email: '$useremail', role: '$role' , departmentname: '$departmentname' , departmentid: $departmentId, companyname: '$companyname', companyid: $companyId };";
echo '</script>';

?>



