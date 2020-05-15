<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']) && !isset($_SESSION['admin_type']) && empty($_SESSION['admin_type']))
{
    header('location:login');
}
else
{
    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg='';

    $query4="SELECT MAX(id) as max_id FROM `student_info`";
    $query4_run=mysqli_query($connect,$query4);
    $max_result=mysqli_fetch_assoc($query4_run);
    if($max_result['max_id']=='')
    {
        $new_app_id='APPL1';
    }
    else
    {
        $max_id=$max_result['max_id'];
        $new_id=$max_id+1;
        $new_app_id='APPL'.$new_id;
    }

    if(isset($_POST['first_name']) && isset($_POST['surname']) && isset($_POST['dob']) && isset($_POST['vsm_branch']))
    {
        $first_name=str_replace("'", "\'", $_POST['first_name']);
        $middle_name=str_replace("'", "\'", $_POST['middle_name']);
        $surname=str_replace("'", "\'", $_POST['surname']);
        $dob=str_replace("'", "\'", $_POST['dob']);
        $vsm_branch=str_replace("'", "\'", $_POST['vsm_branch']);

        $photo_name=$_FILES['photo']['name'];
        $photo_tmp_name=$_FILES['photo']['tmp_name'];
        $photo_location='../images/student_photos/';
        $photo_extension=strtolower(substr($photo_name, strpos($photo_name,'.')+1));
        $photo_type=$_FILES['photo']['type'];

        if(!empty($_POST['first_name']) && !empty($_POST['surname']) && !empty($_POST['dob']) && !empty($_POST['vsm_branch']))
        {
            $query2="INSERT INTO `student_info`(`application_id`, `first_name`, `middle_name`,
												`last_name`, `dob`, `vsm_branch`, `photo`, `submitted_by_admin`, `submission_date`)
					VALUES ('$new_app_id', '$first_name', '$middle_name', '$surname', '$dob', '$vsm_branch', '$photo_name', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $last_id = mysqli_insert_id($connect);

                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) 
										VALUES ('$admin_id', 'application', 'add', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                if(!empty($photo_tmp_name))
                {
                  move_uploaded_file($photo_tmp_name, $photo_location.$photo_name);
                }

                $query3="INSERT INTO `kp_assigned`(`student_id`) VALUES ('$last_id')";
                $query3_run=mysqli_query($connect,$query3);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Application submitted successfully.
                        </div></center>';

                header('Refresh:1; url=student_details?student_id='.$last_id);
            }
            else
            {
                $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Unable to submit Application!
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
        <?php $page='applications'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>New Application</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Create New Application</div>
                            <div class="panel-body">
                    <?php
                        $admin_id=$_SESSION['admin_id'];
                        $admin_type=$_SESSION['admin_type'];

                        if($admin_type!='kp')
                        {
                    ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="add_application" method="POST" enctype="multipart/form-data">
                                    <br/>
                                  
                                    <hr class="dotted"> 
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Student Name*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="first_name" placeholder="First Name*" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="middle_name" placeholder="Middle name">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="surname" placeholder="Surname*" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Date of Birth*</label>
                                        <div class="col-sm-3">
                                            <div class='input-group date datepicker'>
                                                <input type='text' class="form-control" name="dob" data-date-format="YYYY/MM/DD" required />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                      
									<hr class="dotted">
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Office-Branch*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="vsm_branch" data-placeholder="Office-Branch" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='vsm-branch' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($vsm_branch=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $vsm_branch['value']; ?>"> <?php echo $vsm_branch['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group" id="income_certificate_file">
                                        <label class="col-sm-2 control-label">Student Photo</label>
                                        <div class="col-sm-7">
                                            <input type="file" class="form-control" name="photo">
                                            (Max file size should be 2MB.)
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
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <h3>You are trying to access an action not authorized to you.</h3>
                                    <h4>Your username and IP is being traced for each such activity.</h4>
                                </div>
                            </center>
                    <?php
                        }
                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Wrapper Ends Here (working area) -->
            <?php include 'include/footer.php';?>
        </section>
        <!-- Content Block Ends Here (right box)-->


        <!-- DateTime Picker -->
        <?php
			include 'include/footer-scripts.php';
		?>
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