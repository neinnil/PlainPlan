<!DOCTYPE HTML>
<?php

if (empty($_SESSION)){
	session_start();
}
if (isset($_SESSION['userName'])){
} else {
	header("location: login.php");
	exit;
}
?>

<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/spms_base.css">
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<!-- script src="https://unpkg.com/vue/dist/vue.js"></script //-->
	<?php
		include './inc/scripts.php';
	?>
	<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
	<script src="./ext/datepicker/vuejs-datepicker.js"></script>
  <script src="./ext/frappe/frappe-gantt.js"></script>
  <link rel="stylesheet" type="text/css" href="./ext/frappe/frappe-gantt.css">
	<title>.PMS. </title>
	</head>
<body>
<?php
include "head.php";
?>
<noscript>
	<strong>We're sorry but pms doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div id="app"></div>
<!-- div id="app">
		<h1> Test </h1>
		<div class="ttable">
		<div class="tbrow">
		<div id="sidemenu" class="tbcell fleft" style="max-width:20%;border:solid 1px red;min-width:10em;">
			<ul>
				<li><router-link to="/spms/">Home</router-link></li>
				<li><router-link to="/spms/summary">summary</router-link></li>
				<li><router-link to="/spms/project">project</router-link></li>
				<li><router-link to="/spms/user">user</router-link></li>
			</ul>
		</div>
		<div id="contents" class="tbcell topalign" style="padding:0px;">
			<router-view></router-view>
		</div>
		<div class="tbcell clear"></div>
		</div>
		</div>
		</div>
</div>
<script src="./project.js"></script>
<script src="./user.js"></script>
<script src="./index.js"></script>
<script>
var basepath = "<?php echo $_SERVER['CONTEXT_PREFIX']?>";
console.log (basepath);
</script //-->

</body>
</html>
