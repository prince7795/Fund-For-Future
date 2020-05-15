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

    if(isset($_POST['career_plan']) && isset($_POST['earn_and_learn']) && isset($_POST['parent_contribution']))
    {
        $career_plan=str_replace("'", "\'", $_POST['career_plan']);
        $career_explanation=str_replace("'", "\'", $_POST['career_explanation']);
        $earn_and_learn=str_replace("'", "\'", $_POST['earn_and_learn']);
        $earn_and_learn_yes=str_replace("'", "\'", $_POST['earn_and_learn_yes']);
        $parent_contribution=str_replace("'", "\'", $_POST['parent_contribution']);
        $parent_contribution_yes=str_replace("'", "\'", $_POST['parent_contribution_yes']);

        if(!empty($_POST['career_plan']) && !empty($_POST['earn_and_learn']) && !empty($_POST['parent_contribution']))
        {
            $query2="INSERT INTO `career_plan`(`student_id`, `career_plan`, `career_explanation`, `earn_and_learn`, `earn_and_learn_explanation`,
												`parent_contribution`, `parent_contribution_explanation`, `submitted_by_admin`, `submission_date`) 
												VALUES ('$student_id', '$career_plan', '$career_explanation', '$earn_and_learn', '$earn_and_learn_yes',
														'$parent_contribution', '$parent_contribution_yes', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES ('$admin_id', 'career plan', 'add', '$student_id', '', '', '', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Career plan submitted successfully.
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
                          Unable to submit Career plan!
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

    $query3="select * from career_plan where student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $career_plan_rows=mysqli_num_rows($query3_run);

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
        <?php $page='students'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Career plan (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Career plan</div>
                            <div class="panel-body">
            <?php 
                if($student_rows==1)
                {
                    if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                    {
                        if($career_plan_rows==0)
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="add_career_plan?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Career plan* </label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" name="career_plan" data-placeholder="" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='career_option' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($career_option=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $career_option['value']; ?>"> <?php echo $career_option['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Explanation</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="career_explanation" placeholder="Explanation"></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Whether you are interested in the Earn & Learn Scheme ?*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" id="earn_and_learn" name="earn_and_learn" data-placeholder="" onchange="show_earn_and_learn();" required>
                                                <option></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="earn_and_learn_yes_div" style="display: none;">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="earn_and_learn_yes" placeholder="Explanation*"></textarea>
                                            Earn & Learn Scheme / Internships during holidays / part time job while taking education, Explain in details.
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Can parents share the expenses?*</label>
                                        <div class="col-sm-5">
                                            <select class="form-control chosen-select" id="parent_contribution" name="parent_contribution" data-placeholder="" onchange="show_parent_contribution();" required>
                                                <option></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="parent_contribution_yes_div" style="display: none;">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="parent_contribution_yes" placeholder="Explanation*"></textarea>
                                            How much / how can parents share the expenses, Explain in details.
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
                                    <h3>This student have already submitted Career plan.</h3>
                                    <a href="edit_career_plan?student_id=<?= $student_id; ?>&&student_code="><h4>You can edit the same by clicking here.</h4></a>
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
              function show_earn_and_learn(){
                var earn_and_learn = $('#earn_and_learn').val();

                if(earn_and_learn=='Yes')
                {
                  $('#earn_and_learn_yes_div').css("display", "block");
                  $('#earn_and_learn_yes').prop('required', true);
                }
                else
                {
                  $('#earn_and_learn_yes_div').css("display", "none");
                  $('#earn_and_learn_yes').prop('required', false);
                }
              };
        </script>

        <script type="text/javascript">
              function show_parent_contribution(){
                var parent_contribution = $('#parent_contribution').val();

                if(parent_contribution=='Yes')
                {
                  $('#parent_contribution_yes_div').css("display", "block");
                  $('#parent_contribution_yes').prop('required', true);
                }
                else
                {
                  $('#parent_contribution_yes_div').css("display", "none");
                  $('#parent_contribution_yes').prop('required', false);
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