<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']))
{
  header('location:login');
}
else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<?php include 'include/head.php'; ?>
	
</head>
<body style="margin: 0">
<?php
	if(isset($_GET['file_name']))
    {
       $file_name=str_replace("'", "\'", $_GET['file_name']);
    }
    else
    {
      $file_name='';
    }
?>
      <center>
		    <iframe src="../images/student_documents/<?= $file_name; ?>" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width: 100%; height: 100%;" frameborder="0">Your browser does not support this content.</iframe>
      </center>
</body>
</html>
<?php
}
?>