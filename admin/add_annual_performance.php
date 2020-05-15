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
    $year=date('Y', strtotime('-1 months', strtotime($date)));
    $msg='';

    if(isset($_POST['earn_and_learn']) && isset($_POST['final_conclusion']))
    {
        $earn_and_learn=str_replace("'", "\'", $_POST['earn_and_learn']);
        $earn_and_learn_explanation=str_replace("'", "\'", $_POST['earn_and_learn_explanation']);
        $work_responsibility_of_vsm=str_replace("'", "\'", $_POST['work_responsibility_of_vsm']);
        $activities_by_outstation_students=str_replace("'", "\'", $_POST['activities_by_outstation_students']);
        $strength=str_replace("'", "\'", $_POST['strength']);
        $help_or_need=str_replace("'", "\'", $_POST['help_or_need']);
        $can_offer_help_in=str_replace("'", "\'", $_POST['can_offer_help_in']);
        $can_be_volunteer=str_replace("'", "\'", $_POST['can_be_volunteer']);
        $continuation_discontinuation=str_replace("'", "\'", $_POST['continuation_discontinuation']);
        $final_conclusion=str_replace("'", "\'", $_POST['final_conclusion']);

        if(!empty($_POST['earn_and_learn']) && !empty($_POST['final_conclusion']))
        {
            $query2="INSERT INTO `annual_reports`(`student_id`, `year`, `earn_and_learn`, `earn_and_learn_explanation`, `any_vsm_work`,
									`activity_outstation_student`, `strengths`, `need_help_in`, `can_offer_help_in`, `future_volunteer`,
									`continuation_discontinuation`, `final_conclusion`, `submitted_by_admin`, `submission_date`)
					VALUES ('$student_id', '$year', '$earn_and_learn', '$earn_and_learn_explanation', '$work_responsibility_of_vsm',
							'$activities_by_outstation_students', '$strength', '$help_or_need', '$can_offer_help_in', '$can_be_volunteer',
							'$continuation_discontinuation', '$final_conclusion', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'annual report', 'add', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Annual Report submitted successfully.
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
                          Unable to submit Annual Report!
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

    $query19="SELECT kp_assigned.*, admin.first_name, admin.last_name, admin.vsm_branch
				FROM kp_assigned left join admin on kp_assigned.kp_id=admin.id
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
        <?php $page='annual_reports'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Annual Performance Report (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Create Annual Performance Report</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="add_annual_performance?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-3">
                                            <h5 class="text-center"><a href="add_monthly_performance?student_id=<?= $student_id; ?>&&monthly_report_id=" target="_blank">View Monthly report( March 2020 )</a></h5>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <h5 class="text-center"><a href="add_monthly_performance?student_id=<?= $student_id; ?>&&monthly_report_id=" target="_blank">View Monthly report( April 2020 )</a></h5>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <h5 class="text-center"><a href="add_monthly_performance?student_id=<?= $student_id; ?>&&monthly_report_id=" target="_blank">View Monthly report( May 2020 )</a></h5>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <br/>
                                    <h4 class="text-center">Subjective MANUAL Inputs are to be entered by the Respective Employee Based on his/ her review of monthly performance reports.</h4>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Whether the student does earn and learn? * </label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" id="earn_and_learn" name="earn_and_learn" data-placeholder=""  onchange="show_earn_and_learn();" required>
                                                <option></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="earn_and_learn_yes_div" style="display: none;">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="earn_and_learn_explanation" placeholder="Earn and learn explanation*">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Handling any work responsibility of the Employee</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="work_responsibility_of_vsm">NA</textarea>Handling any work responsibility of the Employee.
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Stengths of your Student</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="strength">NA</textarea>
                                        </div>
                                    </div>
  
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Areas in which he/ she needs any particular help - guidance</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="help_or_need">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Areas in which your student can offer help to other students of Employee</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="can_offer_help_in">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Can he/ she be groomed as future Employee of Fund for a Future</label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" name="can_be_volunteer" data-placeholder="" required>
                                                <option></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Recommendation for continuation/ discontinuation</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="continuation_discontinuation">NA</textarea>Recommendation by the Employee for continuation/ discontinuation (Reasons for continuation/ discontinuation).
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Final Conclusion*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" name="final_conclusion" data-placeholder="" required>
                                                <option></option>
                                                <option>Continue</option>
                                                <option>Discontinue</option>
                                                <option>Continue with special attention</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <input type="submit" class="btn btn-primary pull-right" value="Submit"></small>
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
              function show_earn_and_learn(){
                var earn_and_learn = $('#earn_and_learn').val();

                if(earn_and_learn=='Yes')
                {
                  $('#earn_and_learn_yes_div').css("display", "block");
                  $('#earn_and_learn_explanation').prop('required', true);
                }
                else
                {
                  $('#earn_and_learn_yes_div').css("display", "none");
                  $('#earn_and_learn_explanation').prop('required', false);
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