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
    if(isset($_GET['family_id']))
    {
        $family_id=str_replace("'", "\'", $_GET['family_id']);
    }
    $query3="select * 
			from family_details 
			where id='$family_id' and student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $family_rows=mysqli_num_rows($query3_run);
    $existing_data=mysqli_fetch_assoc($query3_run);
    $existing_income_certificate=$existing_data['income_certificate_path'];

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg='';

    if(isset($_POST['family_member_name']) && isset($_POST['relation']) && isset($_POST['service_bussiness']))
    {
        $family_member_name=str_replace("'", "\'", $_POST['family_member_name']);
        $relation=str_replace("'", "\'", $_POST['relation']);
        $education=str_replace("'", "\'", $_POST['education']);
        $service_bussiness=str_replace("'", "\'", $_POST['service_bussiness']);
        $monthly_income=str_replace("'", "\'", $_POST['monthly_income']);
        $other_income=str_replace("'", "\'", $_POST['other_income']);
        $total_annual_income=($monthly_income+$other_income)*12;
        $income_cert_submit=str_replace("'", "\'", $_POST['income_cert_submit']);

        if(!empty($_POST['family_member_name']) && !empty($_POST['relation']) && !empty($_POST['service_bussiness']))
        {
            if(!empty($_FILES['income_certificate']['name']))
            {
                $income_certificate_name=$_FILES['income_certificate']['name'];
                $income_certificate_tmp_name=$_FILES['income_certificate']['tmp_name'];
                $income_certificate_location='../images/income_certificates/';
                $income_certificate_extension=strtolower(substr($income_certificate_name, strpos($income_certificate_name,'.')+1));
                $income_certificate_type=$_FILES['income_certificate']['type'];

                $query2="UPDATE `family_details` 
						SET `name`='$family_member_name', `relation`='$relation', `education`='$education', `profession`='$service_bussiness', 
									`monthly_income`='$monthly_income', `other_monthly_income`='$other_income', `total_annual_income`='$total_annual_income',
									`income_cert_submitted`='$income_cert_submit', `income_certificate_path`='$income_certificate_name', `last_edited_by`='$admin_id', `last_edit_date`='$date'
						WHERE id='$family_id'";
                $query2_run=mysqli_query($connect,$query2);
                if(mysqli_affected_rows($connect)>0)
                {
                    $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'family details', 'edit', '$date')";
                    $query21_run=mysqli_query($connect,$query21);

                    if(!empty($income_certificate_tmp_name))
                    {
                      move_uploaded_file($income_certificate_tmp_name, $income_certificate_location.$income_certificate_name);
                    }

                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Family details updated successfully.
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
                              Unable to update Family details!
                            </div></center>';
                }
            }
            else
            {
                $income_certificate_name=$existing_income_certificate;

                $query2="UPDATE `family_details` 
							SET `name`='$family_member_name', `relation`='$relation', `education`='$education', `profession`='$service_bussiness',
										`monthly_income`='$monthly_income', `other_monthly_income`='$other_income', `total_annual_income`='$total_annual_income',
										`income_cert_submitted`='$income_cert_submit', `income_certificate_path`='$income_certificate_name',
										`last_edited_by`='$admin_id', `last_edit_date`='$date'
							WHERE id='$family_id'";
                $query2_run=mysqli_query($connect,$query2);
                if(mysqli_affected_rows($connect)>0)
                {
                    $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'family details', 'edit', '$date')";
                    $query21_run=mysqli_query($connect,$query21);
                    
                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Family details updated successfully.
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
                              Unable to update Family details!
                            </div></center>';
                }
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

    $query3="select * from family_details where id='$family_id' and student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $family_rows=mysqli_num_rows($query3_run);
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
                    <h3>Family details (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Family details</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                            if($family_rows==1)
                            {
                ?>
                                <?php if(isset($msg)){echo $msg; } ?>
                                    <form class="form-horizontal" action="edit_family_details?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST" enctype="multipart/form-data">
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Family member name*</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="family_member_name" placeholder="Family member name*" value="<?= $existing_data['name']; ?>" required>
                                            </div>
                                            <label class="col-sm-2 control-label">Relation*</label>
                                            <div class="col-sm-3">
                                                <select class="form-control chosen-select" name="relation" data-placeholder="Relation" required>
                                                    <option></option>
                                    <?php
                                            $query1="select * from decoding where specifier='relation' order by specifier";
                                            $query1_run=mysqli_query($connect, $query1);
                                            while($relation=mysqli_fetch_assoc($query1_run))
                                            {
                                    ?>  
                                                    <option value="<?php echo $relation['value']; ?>" <?php if(!empty($existing_data['relation']) && $existing_data['relation']==$relation['value']){ echo 'selected'; } ?>> <?php echo $relation['description']; ?> </option>
                                    <?php
                                            }
                                    ?>                                   
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="dotted">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Education</label>
                                            <div class="col-sm-3">
                                                <select class="form-control chosen-select" name="education" data-placeholder="Education*" required="">
                                                    <option></option>
														<?php
																$query1="select * from decoding where specifier='qualification' order by specifier";
																$query1_run=mysqli_query($connect, $query1);
																while($qualification=mysqli_fetch_assoc($query1_run))
																{
														?>  
																		<option value="<?php echo $qualification['value']; ?>" <?php if(!empty($existing_data['education']) && $existing_data['education']==$qualification['value']){ echo 'selected'; } ?>> <?php echo $qualification['description']; ?> </option>
														<?php
																}
														?>
                                                </select>
                                            </div>
											
                                            <label class="col-sm-2 control-label">Service/ Bussiness*</label>
                                            <div class="col-sm-3">
                                                <select class="form-control chosen-select" name="service_bussiness" data-placeholder="Service/ Bussiness*" required>
                                                    <option></option>
                                    <?php
                                            $query1="select * from decoding where specifier='occupation' order by specifier";
                                            $query1_run=mysqli_query($connect, $query1);
                                            while($occupation=mysqli_fetch_assoc($query1_run))
                                            {
                                    ?>  
                                                    <option value="<?php echo $occupation['value']; ?>" <?php if(!empty($existing_data['profession']) && $existing_data['profession']==$occupation['value']){ echo 'selected'; } ?>> <?php echo $occupation['description']; ?> </option>
                                    <?php
                                            }
                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="dotted">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Monthly Income</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" min="0" name="monthly_income" placeholder="Monthly Income" value="<?= $existing_data['monthly_income']; ?>"> (In $.)
                                            </div>
                                            <label class="col-sm-2 control-label">Other Income</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" min="0" name="other_income" placeholder="Other Income" value="<?= $existing_data['other_monthly_income']; ?>"> (In $.)
                                            </div>
                                        </div>
                                        
                                        <hr class="dotted">
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label">Tax Return Filed ?</label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" onchange="show_income_certificate();" id="income_cert_submit" name="income_cert_submit" data-placeholder="" required>
                                                <option></option>
                                                <option value="Yes" <?php if(!empty($existing_data['income_cert_submitted']) && $existing_data['income_cert_submitted']=='Yes'){ echo 'selected'; } ?>>Yes</option>
                                                <option value="No"<?php if(!empty($existing_data['income_cert_submitted']) && $existing_data['income_cert_submitted']=='No'){ echo 'selected'; } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="form-group" id="income_certificate_div" style="display: none;">
                                        <label class="col-sm-2 control-label">Copy of Tax Return </label>
                                        <div class="col-sm-7">
                                            <input type="file" class="form-control" id="income_certificate" name="income_certificate">
                                                Note : If you don't want to change existing file, keep this field empty.
                                                <br/>(Max file size should be 2MB.)
                                            </div>
                                        </div>
                                        <hr class="dotted">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <input type="submit" class="btn btn-primary pull-right" value="Update">
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
            $(document).ready(function(){
                show_income_certificate();
            })
        </script>
        <script type="text/javascript">
              function show_income_certificate(){
                var income_cert_submit = $('#income_cert_submit').val();

                if(income_cert_submit=='Yes')
                {
                  $('#income_certificate_div').css("display", "block");
                  $('#income_certificate').prop('required', true);
                }
                else
                {
                  $('#income_certificate_div').css("display", "none");
                  $('#income_certificate').prop('required', false);
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