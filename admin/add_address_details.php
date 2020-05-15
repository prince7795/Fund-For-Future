<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']) && !isset($_SESSION['admin_type']) && empty($_SESSION['admin_type']))
{
  header('location:login');
}
else
{
    if(isset($_GET['student_id']))
    {
        $student_id=str_replace("'", "\'", $_GET['student_id']);
    }

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg=''; 

    if(isset($_POST['p_address']) && isset($_POST['p_city']) && isset($_POST['p_state']) && isset($_POST['p_pin_code']) 
			&& isset($_POST['t_address']) && isset($_POST['t_city']) && isset($_POST['t_state']) && isset($_POST['t_pin_code']))
    {
        $p_address=str_replace("'", "\'", $_POST['p_address']);
        $p_city=str_replace("'", "\'", $_POST['p_city']);
        $p_state=str_replace("'", "\'", $_POST['p_state']);
        $p_pin_code=str_replace("'", "\'", $_POST['p_pin_code']);
        $t_address=str_replace("'", "\'", $_POST['t_address']);
        $t_city=str_replace("'", "\'", $_POST['t_city']);
        $t_state=str_replace("'", "\'", $_POST['t_state']);
        $t_pin_code=str_replace("'", "\'", $_POST['t_pin_code']);

        if(!empty($_POST['p_address']) && !empty($_POST['p_city']) && !empty($_POST['p_state']) && !empty($_POST['p_pin_code'])
			&& !empty($_POST['t_address']) && !empty($_POST['t_city']) && !empty($_POST['t_state']) && !empty($_POST['t_pin_code']))
        {
            $query2="INSERT INTO `address_details`(`student_id`, `present_address`, `present_city`, `present_state`, `present_pincode`,
													`permanent_address`, `permanent_city`, `permanent_state`, `permanent_pincode`,
													`submited_by_admin`, `submission_date`)
						VALUES ('$student_id', '$t_address', '$t_city', '$t_state', '$t_pin_code', '$p_address', '$p_city', 
									'$p_state', '$p_pin_code', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'address details', 'add', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Address details submitted successfully.
                        </div></center>';

                header('Refresh:1; url=student_details?student_id='.$student_id);
            }
            else
            {
                $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Unable to submit Address details!
                        </div></center>';
            }
        }
        else
        {
            $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                      </button>
                      Fill all the required fields first!<br/>
                      required fields are marked as ( * ).
                    </div></center>';
        }
    }

    $query1="select * from student_info where id='$student_id'";
    $query1_run=mysqli_query($connect, $query1);
    $student_rows=mysqli_num_rows($query1_run);
    $student_data=mysqli_fetch_assoc($query1_run);

    $query3="select * from address_details where student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $address_rows=mysqli_num_rows($query3_run);
    $existing_data=mysqli_fetch_assoc($query3_run);

    $query19="SELECT kp_assigned.*, admin.first_name, admin.last_name, admin.vsm_branch FROM kp_assigned left join admin on kp_assigned.kp_id=admin.id WHERE kp_assigned.student_id='$student_id'";
    $query19_run=mysqli_query($connect, $query19);
    $kp_assigned_data=mysqli_fetch_assoc($query19_run);
    $kp_assigned_id=$kp_assigned_data['kp_id'];
    $kp_start_date=$kp_assigned_data['from_date'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin panel</title>
        <?php include 'include/head.php';?>
    </head>
    <body data-ng-app>
        <!-- Preloader -->
        <div class="loading-container">
            <div class="loading">
                <div class="l1">
                    <div></div>
                </div>
                <div class="l2">
                    <div></div>
                </div>
                <div class="l3">
                    <div></div>
                </div>
                <div class="l4">
                    <div></div>
                </div>
            </div>
        </div>
        <!-- Preloader -->
        <?php $page='students'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Address details (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add New Address</div>
                            <div class="panel-body">
            <?php 
                if($student_rows==1)
                {
                    if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                    {
                        if($address_rows==0)
                        {
            ?>
                            <?php if(isset($msg)){echo $msg; } ?>

                                <form class="form-horizontal" action="add_address_details?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Present Address*</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="p_address" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">City*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="p_city" placeholder="City" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">State*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="p_state" placeholder="State" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Postal Code*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="p_pin_code" min="0" placeholder="Pin Code" maxlength="8" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Permanent Address*</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="t_address" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">City*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="t_city" placeholder="City" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">State*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="t_state" placeholder="State" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Postal Code*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="t_pin_code" min="0" placeholder="Pin Code" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <input type="submit" class="btn btn-primary pull-right" value="Submit">
                                        </div>
                                    </div>
                                </form>
            <?php 
                        }
                        else
                        {
            ?>
                            <center>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <h3>This student have already submitted address details.</h3>
                                    <a href="edit_address_details?student_id=<?= $student_id; ?>&&student_code=&&address_id=<?= $existing_data['id']; ?>"><h4>You can edit the same by clicking here.</h4></a>
                                </div>
                            </center>
            <?php 
                        }
                    }
                    else
                    {
            ?>
                        <center>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <h3>This student is not alloted to you.</h3>
                                <h4>Your username and IP is being traced for each such activity.</h4>
                            </div>
                        </center>
            <?php
                    }
                }
                else
                {
            ?>
                    <center>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <h3>No student found with this ID.</h3>
                        </div>
                    </center>
            <?php
                }
            ?>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- wrapper Ends Here (working area) -->
            <?php include 'include/footer.php';?>
        </section>
        <!-- Content Block Ends Here (right box)-->
        <!-- DateTime Picker -->
        <?php include 'include/footer-scripts.php';?>

        <script type="text/javascript">
            $(".datetimepicker").datetimepicker();
            $(".datepicker").datetimepicker({ pickTime: false });
            $(".timepicker2").datetimepicker({ pickDate: false });
        </script>
    </body>
</html>
<?php
    }
?>