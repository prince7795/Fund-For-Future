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
                            <div class="panel-heading">Create Student</div>
                            <div class="panel-body">
                                <form class="form-horizontal" action="new_application" method="POST">
                                   
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Student Code*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="student_code" id="student_code" placeholder="Student Code" required>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
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
                                       <!-- <label class="col-sm-2 control-label">Caste</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-flat" name="caste" placeholder="Caste">
                                        </div>
                                    </div>-->
                                    
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Permanent Address*</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="p_address" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">City*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="p_city" placeholder="City" required>
                                        </div>
                                       <!-- <label class="col-sm-2 control-label">Taluka</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="p_taluka" placeholder="Taluka">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">District</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="p_district" placeholder="District">
                                        </div>-->
                                        <label class="col-sm-2 control-label">State*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="p_state" placeholder="State" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Pin Code*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="p_pin_code" min="0" placeholder="Pin Code" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Present Address*</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="t_address" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">City*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="t_city" placeholder="City" required>
                                        </div>
                                       <!-- <label class="col-sm-2 control-label">Taluka</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="t_taluka" placeholder="Taluka">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">District</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="t_district" placeholder="District">
                                        </div>-->
                                        <label class="col-sm-2 control-label">State*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="t_state" placeholder="State" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Pin Code*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="t_pin_code" min="0" placeholder="Pin Code" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Applicant Contact</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="applicant_tel_1" placeholder="Telephone 1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="applicant_tel_2" placeholder="Telephone 2">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="applicant_email" placeholder="Email">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Student Contact</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="student_tel_1" placeholder="Telephone 1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="student_tel_2" placeholder="Telephone 2">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="student_email" placeholder="Email">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Parent Contact</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="parent_tel_1" placeholder="Telephone 1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="parent_tel_2" placeholder="Telephone 2">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="parent_email" placeholder="Email">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Alternative Contact</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="alt_tel_1" placeholder="Telephone 1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="alt_tel_2" placeholder="Telephone 2">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="email" class="form-control" name="alt_email" placeholder="Email">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Income Cerificate Submitted ?</label>
                                        <div class="col-sm-7">
                                            <div class="switch-button showcase-switch-button">YES
                                                <input id="switch-button-6" name="income_cert_submit" type="radio">
                                                <label for="switch-button-6"></label>
                                            </div>
                                            <div class="switch-button danger showcase-switch-button">NO
                                                <input id="switch-button-3" name="income_cert_submit" type="radio" checked>
                                                <label for="switch-button-3"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Career plan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="career_plan" placeholder="Career Plan">
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Projected Expenses*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="lodging_boarding" placeholder="Lodging Boarding*" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="total_fees" placeholder="Total Fees*">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="study_material" placeholder="Study Material*" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="conveyance" placeholder="Conveyance*" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="other_expence" placeholder="Other">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="total_expence" placeholder="Total*" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <small><input type="submit" class="btn btn-primary pull-right" value="Submit"></small>
                                        </div>
                                    </div>
                                </form>
                              
                            </div>
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

