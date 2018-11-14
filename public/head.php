<div id="head_message" style="max-width:100%">
	<div id="head_project_info" class="fleft" style="padding-left:3em;">
			<?php
			if (isset($_SESSION['projectname'])){
				echo '<div class="tbcell">';
				echo '<h3>'.$_SESSION["projectname"];
				if (isset($_SESSION['projectcode'])) {
					echo '('.$_SESSION['projectcode'].')';
				}
				echo '</h3>';
				echo '</div>';
			}
			?>
	</div>

	<div id="head_user_info" class="fright" style="padding-right:3em;">
		<h3 style="display:inline"><?php echo $_SESSION["userName"] ?>
		( <?php echo $_SESSION['role'] ?>)</h3>
		&nbsp;&nbsp;&nbsp;<a href="/logout.php">Log out</a>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
