<?php
ob_start();
@session_start();
if(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']))
{
	header('location:dashboard');
}
else{
	header('location:login');
}
?>
