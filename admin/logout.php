<?PHP	
	session_start();
	require_once 'include/include.php';
	$admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");

	unset($_SESSION['admin_id']);
	unset($_SESSION['admin_type']);

	$query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
						VALUES ('$admin_id', 'admin panel', 'logout', '$date')";
    $query21_run=mysqli_query($connect,$query21);

	header('location:index');

?>