<?php
    @session_start();
    include_once 'include/include.php';
    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");

    if($_POST['id'])
	{
		$id=$_POST['id'];
		$student_id=$_POST['student_id'];

		$query1="SELECT income_certificate_path from family_details where id='$id'";
		$query1_run=mysqli_query($connect, $query1);
		$result=mysqli_fetch_assoc($query1_run);
		$file_name=$result['income_certificate_path'];
		echo $file_name;

		$query="DELETE FROM family_details WHERE id='$id'";
		$query_run=mysqli_query($connect, $query);
		if(mysqli_affected_rows($connect)>0)
		{
			$query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
						VALUES ('$admin_id', 'family details', 'delete', '$date')";
            $query21_run=mysqli_query($connect,$query21);

			$query2="SELECT id from family_details where income_certificate_path='$file_name'";
			$query2_run=mysqli_query($connect, $query2);
			$rows=mysqli_num_rows($query2_run);
			echo $rows;
			if($rows==0)
			{
				unlink('../images/income_certificates/'.$file_name);
			}
			echo 'Deleted.';
		}
	}
?>