<?php
    @session_start();
    include_once 'include/include.php';
    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");

    if($_POST['id'])
	{
		$id=$_POST['id'];

		$query="DELETE FROM event_master WHERE id='$id'";
		$query_run=mysqli_query($connect, $query);
		if(mysqli_affected_rows($connect)>0)
		{
			$query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'events', 'delete', '$date')";
            $query21_run=mysqli_query($connect,$query21);

			echo 'Deleted.';
		}
	}
?>