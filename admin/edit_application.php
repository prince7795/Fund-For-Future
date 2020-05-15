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
    $query1="select * from student_info where id='$student_id'";
    $query1_run=mysqli_query($connect, $query1);
    $student_rows=mysqli_num_rows($query1_run);
    $student_data=mysqli_fetch_assoc($query1_run);
    $existing_photo=$student_data['photo'];

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg='';

    if(isset($_POST['first_name']) && isset($_POST['surname']) && isset($_POST['dob']) && isset($_POST['vsm_branch']))
    {
        $first_name=str_replace("'", "\'", $_POST['first_name']);
        $middle_name=str_replace("'", "\'", $_POST['middle_name']);
        $surname=str_replace("'", "\'", $_POST['surname']);
        $dob=str_replace("'", "\'", $_POST['dob']);
        //$caste=str_replace("'", "\'", $_POST['caste']);
        $vsm_branch=str_replace("'", "\'", $_POST['vsm_branch']);
        //$csr=str_replace("'", "\'", $_POST['csr']);
       // $csr_organisation=str_replace("'", "\'", $_POST['csr_organisation']);

        if(!empty($_POST['first_name']) && !empty($_POST['surname']) && !empty($_POST['dob']) && !empty($_POST['vsm_branch']))
        {
            if(!empty($_FILES['photo']['name']))
            {
                $photo_name=$_FILES['photo']['name'];
                $photo_tmp_name=$_FILES['photo']['tmp_name'];
                $photo_location='../images/student_photos/';
                $photo_extension=strtolower(substr($photo_name, strpos($photo_name,'.')+1));
                $photo_type=$_FILES['photo']['type'];

                $query2="UPDATE `student_info` SET `first_name`='$first_name', `middle_name`='$middle_name', `last_name`='$surname',
						`dob`='$dob', `vsm_branch`='$vsm_branch', `photo`='$photo_name', `last_edited_by`='$admin_id',
						`last_edit_date`='$date' WHERE id='$student_id'";
                $query2_run=mysqli_query($connect,$query2);
                if(mysqli_affected_rows($connect)>0)
                {
                    $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES ('$admin_id', 'application', 'edit', '$student_id', '', '', '', '$date')";
                    $query21_run=mysqli_query($connect,$query21);

                    if(!empty($photo_tmp_name))
                    {
                        move_uploaded_file($photo_tmp_name, $photo_location.$photo_name);
                    }
                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                              </button>
                              Application Updated successfully.
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
                              Unable to update Application!
                            </div></center>';
                }
            }
            else
            {
                $photo_name=$existing_photo;

                $query2="UPDATE `student_info` SET `first_name`='$first_name', `middle_name`='$middle_name', 
												`last_name`='$surname', `dob`='$dob', `vsm_branch`='$vsm_branch', `photo`='$photo_name', `last_edited_by`='$admin_id', `last_edit_date`='$date' 
				WHERE id='$student_id'";
                $query2_run=mysqli_query($connect,$query2);
                if(mysqli_affected_rows($connect)>0)
                {
                    $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES ('$admin_id', 'application', 'edit', '$student_id', '', '', '', '$date')";
                    $query21_run=mysqli_query($connect,$query21);
                    
                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                              </button>
                              Application updated successfully.
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
                              Unable to update Application!
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

    $query19="SELECT kp_assigned.*, admin.first_name, admin.last_name, admin.vsm_branch FROM kp_assigned left join admin on kp_assigned.kp_id=admin.id 
			WHERE kp_assigned.student_id='$student_id'";
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
        <?php $page='applications'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Edit Application</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Application</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>    
                                <form class="form-horizontal" action="edit_application?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST" enctype="multipart/form-data">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Application number*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="application_no" id="application_no" onkeyup="check_application_no()" value="<?= $student_data['application_id']; ?>" placeholder="Application number*" readonly>
                                        </div>
                                        <div class="col-sm-4" id="ajax_application_no">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Student Code*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="student_code" id="student_code*" value="<?= $student_data['student_code']; ?>" placeholder="" readonly>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Student Name*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="first_name" value="<?= $student_data['first_name']; ?>"  placeholder="First Name*" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="middle_name" value="<?= $student_data['middle_name']; ?>"  placeholder="Middle name">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="surname" value="<?= $student_data['last_name']; ?>"  placeholder="Surname*" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Date of Birth*</label>
                                        <div class="col-sm-3">
                                            <div class='input-group date datepicker'>
                                                <input type='text' class="form-control" name="dob" value="<?= $student_data['dob']; ?>" data-date-format="YYYY/MM/DD" required />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <!--<label class="col-sm-2 control-label">Caste*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="caste" data-placeholder="Caste" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='caste' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($caste=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $caste['value']; ?>" <?php if(!empty($student_data['caste']) && $student_data['caste']==$caste['value']){ echo 'selected'; } ?>> <?php echo $caste['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>-->
                                    </div>
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
                                                <option value="<?php echo $vsm_branch['value']; ?>" <?php if(!empty($student_data['vsm_branch']) && $student_data['vsm_branch']==$vsm_branch['value']){ echo 'selected'; } ?>> <?php echo $vsm_branch['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>
                                    </div>
                                    <!--<hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Eligible for CSR*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" id="csr" name="csr" data-placeholder=""  onchange="show_div();" required>
                                                <option></option>
                                                <option value="Yes" <?php if(!empty($student_data['csr']) && $student_data['csr']=='Yes'){ echo 'selected'; } ?>>Yes</option>
                                                <option value="No" <?php if(!empty($student_data['csr']) && $student_data['csr']=='No'){ echo 'selected'; } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="csr_yes_div" style="display: none;">
                                        <label class="col-sm-2 control-label">CSR Organisation*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" name="csr_organisation" data-placeholder="VSM Branch">
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='organisation' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($csr_organisation=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $csr_organisation['value']; ?>" <?php if(!empty($student_data['csr_organisation']) && $student_data['csr_organisation']==$csr_organisation['value']){ echo 'selected'; } ?>> <?php echo $csr_organisation['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>
                                    </div>-->
                                    <hr class="dotted">
                                    <div class="form-group" id="income_certificate_file">
                                        <label class="col-sm-2 control-label">Student Photo</label>
                                        <div class="col-sm-7">
                                            <input type="file" class="form-control" name="photo">
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
            <!-- Wrapper Ends Here (working area) -->
            <?php include 'include/footer.php';?>
        </section>
        <!-- Content Block Ends Here (right box)-->


        <!-- DateTime Picker -->
        <?php include 'include/footer-scripts.php';?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                show_div();
            })
        </script>

        <script type="text/javascript">
              function show_div(){
                var csr = $('#csr').val();

                if(csr=='Yes')
                {
                  $('#csr_yes_div').css("display", "block");
                  $('#csr_organisation').prop('required', true);
                }
                else
                {
                  $('#csr_yes_div').css("display", "none");
                  $('#csr_organisation').prop('required', false);
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