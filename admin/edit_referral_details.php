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
    if(isset($_GET['referral_id']))
    {
        $referral_id=str_replace("'", "\'", $_GET['referral_id']);
    }

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg='';

    if(isset($_POST['referral_name']) && isset($_POST['referral_type']))
    {
        $referral_name=str_replace("'", "\'", $_POST['referral_name']);
        $refferal_mobile=str_replace("'", "\'", $_POST['refferal_mobile']);
        $refferal_email=str_replace("'", "\'", $_POST['refferal_email']);
        $referral_type=str_replace("'", "\'", $_POST['referral_type']);

        if(!empty($_POST['referral_name']) && !empty($_POST['referral_type']))
        {
            $query2="UPDATE `referral_details` SET `name_of_referral`='$referral_name', `mobile`='$refferal_mobile',
								`email`='$refferal_email', `type`='$referral_type', `last_edited_by`='$admin_id', `last_edit_date`='$date'
						WHERE id='$referral_id'";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
							VALUES ('$admin_id', 'referral details', 'edit', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Referral details updated successfully.
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
                          Unable to update Referral details!
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

    $query3="select * from referral_details where id='$referral_id' and student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $referral_rows=mysqli_num_rows($query3_run);
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
                    <h3>Referral Details (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Referral Details</div>
                            <div class="panel-body">
            <?php 
                if($student_rows==1)
                {
                    if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                    {
                        if($referral_rows==1)
                        {
            ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="edit_referral_details?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name of Referral*</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="referral_name" value="<?= $existing_data['name_of_referral']; ?>" placeholder="Full Name*" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="refferal_mobile" value="<?= $existing_data['mobile']; ?>"  placeholder="Mobile">
                                        </div>
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="refferal_email" value="<?= $existing_data['email']; ?>" placeholder="Email">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Type of Referral*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" id="referral_type" name="referral_type" data-placeholder=""  onchange="show_other();" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='referral_type' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($referral_type=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>
                                                <option value="<?php echo $referral_type['value']; ?>" <?php if(!empty($existing_data['type']) && $existing_data['type']==$referral_type['value']){ echo 'selected'; } ?>> <?php echo $referral_type['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="referral_type_other_div" style="display: none;">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="referral_type_other" placeholder="Specify Other*">
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
                                    <h3>No family record found for this student.</h3>
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
            function show_other(){
                var referral_type = $('#referral_type').val();

                if(referral_type=='Other')
                {
                  $('#referral_type_other_div').css("display", "block");
                  $('#referral_type_other').prop('required', true);
                }
                else
                {
                  $('#referral_type_other_div').css("display", "none");
                  $('#referral_type_other').prop('required', false);
                }
            };
        </script>
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