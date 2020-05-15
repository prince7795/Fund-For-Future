<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']) && !isset($_SESSION['admin_type']) && empty($_SESSION['admin_type']))
{
  header('location:login');
}
else
{

    if(isset($_GET['kp_id']))
    {
        $kp_id=str_replace("'", "\'", $_GET['kp_id']);
    }

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date=date("m/d/Y h:i:s A");
    $msg='';

    if(isset($_POST['vsm_branch']) && isset($_POST['kp_first_name']) && isset($_POST['kp_surname']) && isset($_POST['kp_dob'])
				&& isset($_POST['kp_permanant_address']) && isset($_POST['kp_current_address']) && isset($_POST['kp_email'])
				&& isset($_POST['password']) && isset($_POST['kp_mobile']) && isset($_POST['kp_qualification'])
				&& isset($_POST['kp_occupation']) && isset($_POST['meeting_location']) && isset($_POST['how_you_know']))
    {
    
        $vsm_branch=str_replace("'", "\'", $_POST['vsm_branch']);
        $kp_first_name=str_replace("'", "\'", $_POST['kp_first_name']);
        $kp_middle_name=str_replace("'", "\'", $_POST['kp_middle_name']);
        $kp_surname=str_replace("'", "\'", $_POST['kp_surname']);
        $kp_dob=str_replace("'", "\'", $_POST['kp_dob']);
        $kp_current_address=str_replace("'", "\'", $_POST['kp_current_address']);
        $kp_permanant_address=str_replace("'", "\'", $_POST['kp_permanant_address']);
        $kp_alternative_email=str_replace("'", "\'", $_POST['kp_alternative_email']);
        $password=str_replace("'", "\'", $_POST['password']);
        $kp_mobile=str_replace("'", "\'", $_POST['kp_mobile']);
        $kp_alternative_mobile=str_replace("'", "\'", $_POST['kp_alternative_mobile']);
        $kp_qualification=str_replace("'", "\'", $_POST['kp_qualification']);
        $kp_specialization=str_replace("'", "\'", $_POST['kp_specialization']);
        $kp_occupation=str_replace("'", "\'", $_POST['kp_occupation']);
        $kp_additional_skills=str_replace("'", "\'", $_POST['kp_additional_skills']);
        $ngo_work_experiance=str_replace("'", "\'", $_POST['ngo_work_experiance']);
        $ngo_explanation=str_replace("'", "\'", $_POST['ngo_explanation']);
        $meeting_location=str_replace("'", "\'", $_POST['meeting_location']);

        $how_you_know=str_replace("'", "\'", $_POST['how_you_know']);
        $how_you_know_explain=str_replace("'", "\'", $_POST['how_you_know_explain']);
        $any_other_info=str_replace("'", "\'", $_POST['any_other_info']);

        if(!empty($_POST['vsm_branch']) && !empty($_POST['kp_first_name']) && !empty($_POST['kp_surname'])
			&& !empty($_POST['kp_dob']) && !empty($_POST['kp_current_address']) && !empty($_POST['kp_permanant_address'])
			&& !empty($_POST['kp_email']) && !empty($_POST['password']) && !empty($_POST['kp_mobile']) && !empty($_POST['kp_qualification'])
			&& !empty($_POST['kp_occupation']) && !empty($_POST['meeting_location']) && !empty($_POST['how_you_know']))
        {
            $query2="UPDATE `admin` SET `first_name`='$kp_first_name', `middle_name`='$kp_middle_name', `last_name`='$kp_surname',
										`password`='$password', `vsm_branch`='$vsm_branch', `dob`='$kp_dob', `current_address`='$kp_current_address',
										`permanent_address`='$kp_permanant_address', `alternate_email`='$kp_alternative_email', 
										`mobile_number`='$kp_mobile', `alternative_number`='$kp_alternative_mobile',
										`academic_qualification`='$kp_qualification', `academic_specialization`='$kp_specialization', 
										`occupation`='$kp_occupation', `additional_skills`='$kp_additional_skills', 
										`worked_in_ngo`='$ngo_work_experiance', `ngo_explanation`='$ngo_explanation',
										`meeting_location`='$meeting_location', `how_know_vsm`='$how_you_know',
										`how_know_vsm_explanation`='$how_you_know_explain', `any_other_info`='$any_other_info', 
										`last_edited_by`='$admin_id', `last_edit_date`='$date'
										WHERE id='$kp_id'";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES ('$admin_id', 'KP', 'edit', '', '$kp_id', '', '', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Employee submitted successfully.
                        </div></center>';

                header('Refresh:1; url=karyakarta_palak');
            }
            else
            {
                $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Unable to submit Employee details!
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

    $query3="select * from admin where id='$kp_id' and type='kp'";
    $query3_run=mysqli_query($connect, $query3);
    $admin_rows=mysqli_num_rows($query3_run);
    $existing_data=mysqli_fetch_assoc($query3_run);


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
        <?php $page='karyakarta_palak'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Edit Employee Details(<?= $existing_data['first_name'].' '.$existing_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Employee Details</div>
                            <div class="panel-body">
                    <?php
                        $admin_id=$_SESSION['admin_id'];
                        $admin_type=$_SESSION['admin_type'];

                        if($admin_type!='kp')
                        {
                            if($admin_rows==1)
                            {
                        ?>
                                <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="edit_karyakarta_palak?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Employee Branch*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="vsm_branch" data-placeholder="VSM Branch" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='vsm-branch' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($vsm_branch=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $vsm_branch['value']; ?>" <?php if(!empty($existing_data['vsm_branch']) && $existing_data['vsm_branch']==$vsm_branch['value']){ echo 'selected'; } ?>> <?php echo $vsm_branch['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Employee Name*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="kp_first_name" value="<?= $existing_data['first_name']; ?>" placeholder="First Name*" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="kp_middle_name" value="<?= $existing_data['middle_name']; ?>" placeholder="Middle name">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="kp_surname" value="<?= $existing_data['last_name']; ?>" placeholder="Surname*" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Date of Birth*</label>
                                        <div class="col-sm-3">
                                            <div class='input-group date datepicker'>
                                                <input type='text' class="form-control" name="kp_dob" data-date-format="YYYY/MM/DD" value="<?= $existing_data['dob']; ?>" required />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            Note : Format should be strictly yyyy/mm/dd.
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Current Address*</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="kp_current_address" placeholder="Full address*" required><?= $existing_data['current_address']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Permanent Address*</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="kp_permanant_address" placeholder="Full address*" required><?= $existing_data['permanent_address']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email*</label>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="kp_email" value="<?= $existing_data['email']; ?>" placeholder="Email*" readonly>
                                            <b>Username will be used for future login</b>.
                                        </div>
                                        <label class="col-sm-2 control-label">Alternative Email</label>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="kp_alternative_email" value="<?= $existing_data['alternate_email']; ?>" placeholder="Alternative Email">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="password" placeholder="Password*" value="<?= $existing_data['password']; ?>" required>
                                            <b>Password to be used for future login</b>.
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile Number*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="kp_mobile" value="<?= $existing_data['mobile_number']; ?>" placeholder="Mobile Number*" required>
                                        </div>
                                        <label class="col-sm-2 control-label">Alternative Number</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" max="99999999999999" maxlength="14" name="kp_alternative_mobile" value="<?= $existing_data['alternative_number']; ?>" placeholder="Alternative Number">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Academic Qualification*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="kp_qualification" data-placeholder="Academic Qualification*" required="">
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='qualification' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($qualification=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $qualification['value']; ?>" <?php if(!empty($existing_data['academic_qualification']) && $existing_data['academic_qualification']==$qualification['value']){ echo 'selected'; } ?>> <?php echo $qualification['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 control-label">Academic Specialization </label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="kp_specialization" data-placeholder="Academic Specialization">
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='academic_specialization' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($academic_specialization=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $academic_specialization['value']; ?>" <?php if(!empty($existing_data['academic_specialization']) && $existing_data['academic_specialization']==$academic_specialization['value']){ echo 'selected'; } ?>> <?php echo $academic_specialization['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Occupation*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" name="kp_occupation" data-placeholder="Occupation*" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='occupation' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($occupation=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $occupation['value']; ?>" <?php if(!empty($existing_data['occupation']) && $existing_data['occupation']==$occupation['value']){ echo 'selected'; } ?>> <?php echo $occupation['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Additional Skills/ Expertise/ Interests</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="kp_additional_skills" placeholder="Additional Skills/ Expertise/ Interests"><?= $existing_data['additional_skills']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Do you have any Previous Experience of working in an NGO?</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" id="ngo_work_experiance" name="ngo_work_experiance" data-placeholder=""  onchange="show_ngo();">
                                                <option></option>
                                                <option value="Yes" <?php if(!empty($existing_data['worked_in_ngo']) && $existing_data['worked_in_ngo']=='Yes'){ echo 'selected'; } ?>>Yes</option>
                                                <option value="No" <?php if(!empty($existing_data['worked_in_ngo']) && $existing_data['worked_in_ngo']=='No'){ echo 'selected'; } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="ngo_explaination_div" style="display: none;">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" id="ngo_explanation" name="ngo_explanation" placeholder="Describe Experience*"><?= $existing_data['ngo_explanation']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Employee Meeting Location*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" name="meeting_location" data-placeholder="VSM Meeting Location*" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='vsm-branch' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($vsm_branch=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $vsm_branch['value']; ?>" <?php if(!empty($existing_data['meeting_location']) && $existing_data['meeting_location']==$vsm_branch['value']){ echo 'selected'; } ?>> <?php echo $vsm_branch['description']; ?> </option>
                                <?php
                                        }
                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <hr class="dotted">
                                    <h3 class="text-center">Additional Information</h3>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">How did you come to know about Fund For a future? *</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" id="how_you_know" name="how_you_know" data-placeholder=""  onchange="show_other();" required>
                                                <option></option>
                                                <option value="Through reference" <?php if(!empty($existing_data['how_know_vsm']) && $existing_data['how_know_vsm']=='Through reference'){ echo 'selected'; } ?>>Through reference</option>
                                                <option value="Through website" <?php if(!empty($existing_data['how_know_vsm']) && $existing_data['how_know_vsm']=='Through website'){ echo 'selected'; } ?>>Through website</option>
                                                <option value="Through print media" <?php if(!empty($existing_data['how_know_vsm']) && $existing_data['how_know_vsm']=='Through print media'){ echo 'selected'; } ?>>Through print media</option>
                                                <option value="Other" <?php if(!empty($existing_data['how_know_vsm']) && $existing_data['how_know_vsm']=='Other'){ echo 'selected'; } ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="how_you_know_other_div" style="display: none;">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" id="how_you_know_explain" name="how_you_know_explain" placeholder="Describe Other*"><?= $existing_data['how_know_vsm_explanation']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Any other information you wish to share which may be useful to the Office</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="any_other_info" placeholder=""><?= $existing_data['any_other_info']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <input type="submit" class="btn btn-primary pull-right" value="Submit">
                                        </div>
                                    </div>
                                </form>
                                <?php if(isset($msg)){echo $msg; } ?>
                        <?php 
                            }
                            else
                            {
                        ?>
                                <center>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <h3>No karyakarta palak found with this ID.</h3>
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
            <!-- wrapper Ends Here (working area) -->
            <?php include 'include/footer.php';?>
        </section>
        <!-- Content Block Ends Here (right box)-->
        <!-- DateTime Picker -->
        <?php include 'include/footer-scripts.php';?>

        <script type="text/javascript">
            $(document).ready(function(){
                show_other();
                show_ngo();
            })
        </script>

        <script type="text/javascript">
              function show_other(){
                var how_you_know = $('#how_you_know').val();

                if(how_you_know=='Other')
                {
                  $('#how_you_know_other_div').css("display", "block");
                  $('#how_you_know_explain').prop('required', true);
                }
                else
                {
                  $('#how_you_know_other_div').css("display", "none");
                  $('#how_you_know_explain').prop('required', false);
                }
              };

              function show_ngo(){
                var ngo_work_experiance = $('#ngo_work_experiance').val();

                if(ngo_work_experiance=='Yes')
                {
                  $('#ngo_explaination_div').css("display", "block");
                  $('#ngo_explanation').prop('required', true);
                }
                else
                {
                  $('#ngo_explaination_div').css("display", "none");
                  $('#ngo_explanation').prop('required', false);
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