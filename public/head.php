<div id="head_message">
<div id="project_info" class="fleft">
	<div class="ttable">
		<div class="tbrow">
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
	</div>
</div>

<div id="user_info" class="fright">
	<div class="ttable">
		<div class="tbrow">
			<div class="tbcell">
				<h3 style="display:inline"><?php echo $_SESSION["userName"] ?>( <?php echo $_SESSION['role'] ?>)</h3>
				<a href="./logout.php">Log out</a>
			</div>
			<div class="tbcell">
				<?php
				if (isset($_SESSION["departmentname"])) {
				echo '<h3>Dept.: ('.$_SESSION["departmentname"].')</h3>';
				}
				echo '</div>';
			  echo '<div class="tbcell">';
				if (isset($_SESSION["company"])) {
				echo '<h3>COMPANY: ('.$_SESSION["company"].')</h3>';
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>

</div>
<br>
<div class="clear"></div>
