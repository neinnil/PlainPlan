<?php
session_start();
// update user activity as logout 
if(session_destroy())
{
	header("Location: index.html");
}
?>
