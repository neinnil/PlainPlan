<?php
if(empty($_SESSION)) 
	session_start();
if(isset($_SESSION['userName'])) {
	header("location: index.html");
	exit;
}

include 'inc/database.php';

function console($str) {
	echo "<script>console.log('$str')</script>";
}

if(isset($_POST['submit'])) {
	$userEmail=$_POST['userEmail'];
	$password = $_POST['password'];
	
	$dbhandle = new DBHandler();
	$dbhandle->connect();
	$checkIdstr="select u.id as uid, u.email as uemail, u.name, u.role, d.name as departname, u.departmentId, c.name as companyname, u.companyId from users as u left join department as d on (u.departmentId=d.id) left join company as c on (u.companyId = c.id) where u.email='$userEmail' and u.password=PASSWORD('$password');";	

	$res = $dbhandle->query($checkIdstr);
//	$res  = &$dbhandle->result();

	$row = $res->fetch_assoc();
	$_isValidUser = $res->num_rows;
	$toURL = "";
	if ($_isValidUser>0) {
		$userid = $row['uid'];
		$username = $row['name'];
		$department = $row['departname'];
		$company = $row['companyname'];
		$role = $row['role'];
		$departmentId = $row['departmentId'];
		$companyId = $row['companyId'];
		$_SESSION['userid'] = $userid;
		$_SESSION['userEmail'] = $userEmail;
		$_SESSION['userName'] = $username;
		$_SESSION['role'] = $role;
		$_SESSION['departmentname'] = $department;
		$_SESSION['departmentId'] = $departmentId;
		$_SESSION['company'] = $company;
		$_SESSION['companyId'] = $companyId;
		$toURL="index.html"; 	
	} else {
		$toURL="login.php";
	}
	$res->close();
	$dbhandle->close();
	header("location: $toURL");
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset=utf-8>
<meta http-equiv=X-UA-Compatible content="IE=edge">
<meta name=viewport content="width=device-width,initial-scale=1">
<title>Sign In</title>
	<link rel="stylesheet" type="text/css" href="./css/spms_base.css">
</head>
<body onload="document.getElementById('userEmail').focus();">
	<div class="center middle">
	<h1 >Sign In</h1>

	<form id="form" method='post' action='./login.php'>
	<!--h2><?php echo $_SESSION['queryResult'] ?> </h2 //-->
		<div class="gray signin">User email </div>
		<div > <input type="text" autocaptialize="off" id="userEmail" name="userEmail" placeholder="usernam@sntek.com" style="width: 99%; padding: 5px 5px 5px 0px; border-spacing:0px;"> </div>

		<div class="gray signin">Password</div>
		<div > 
			<input id="password" type="password" autocaptialize="off" name="password" style="width: 98%;padding: 5px 5px 5px 0px; border-spacing:0px;"> </div>

		<div style="margin: 10px;">
			<div style="display: inline; width: 40%">
				<input class="loginBtn" name="submit" type="submit" value="login">
			</div>
			<div style="display: inline; width: 40%">
				<input class="loginBtn" name="reset" type="reset"  value="reset">
			</div>
		</div>
	</form>
	</div>
<script>
document.getElementById("userEmail")
	.addEventListener('keypress', (event) => {
        if (event.keyCode == 13) {
            event.preventDefault();
						console.log(event.key);
						document.getElementById("password").focus();
        }
    });

var form = document.getElementById("form");
form.addEventListener("focus", function( event ) {
  event.target.style.background = "skyblue";    
}, true);
form.addEventListener("blur", function( event ) {
  event.target.style.background = "aliceblue";    
}, true);

</script>
</body>
</html>

