<?php
	$host='localhost';
	$user='root';
	$password='';
	$db_name='vidyadan';

	$connect=mysqli_connect($host,$user,$password);

	$db_select=mysqli_select_db($connect,$db_name);
?>
