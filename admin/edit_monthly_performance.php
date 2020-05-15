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
    if(isset($_GET['monthly_report_id']))
    {
        $monthly_report_id=str_replace("'", "\'", $_GET['monthly_report_id']);
    }

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date=date("m/d/Y h:i:s A");
    $year=date('Y', strtotime('-1 months', strtotime($date)));
    $month=date('m', strtotime('-1 months', strtotime($date)));
    $msg='';

    if(isset($_POST['extra_curricular']) && isset($_POST['handling_social_work']) && isset($_POST['Contact_with_kp']))
    {
        $extra_curricular=str_replace("'", "\'", $_POST['extra_curricular']);

        $events=$_POST['events'];
        $event_names ="";
        foreach ($events as $event)
        {
            $event_names[] .= $event;
        }
        $imploded_event_names= implode(', ', $event_names);

        $event_remarks=str_replace("'", "\'", $_POST['event_remarks']);
        $comments_opinion=str_replace("'", "\'", $_POST['comments_opinion']);
        $handling_social_work=str_replace("'", "\'", $_POST['handling_social_work']);
        $handling_social_work_explanation=str_replace("'", "\'", $_POST['handling_social_work_explanation']);
        $noteworthy_experience=str_replace("'", "\'", $_POST['noteworthy_experience']);
        $health_issue=str_replace("'", "\'", $_POST['health_issue']);
        $Contact_with_kp=str_replace("'", "\'", $_POST['Contact_with_kp']);
      

        if(!empty($_POST['extra_curricular']) && !empty($_POST['handling_social_work']) && !empty($_POST['Contact_with_kp']))
        {
            $query2="UPDATE `monthly_reports`
					SET `extra_curricular_activities`='$extra_curricular', `montly_events`='$imploded_event_names',
												`event_remarks`='$event_remarks', `comments_opinion`='$comments_opinion',
												`social_work_drive`='$handling_social_work', `social_work_explanation`='$handling_social_work_explanation',
												`noteworthy_experience`='$noteworthy_experience', `health_issue`='$health_issue', 
												`contact_with_kp`='$Contact_with_kp',`last_edited_by`='$admin_id', `last_edit_date`='$date'
					WHERE id='$monthly_report_id'";
												
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'monthly report', 'edit', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Monthly Report updated successfully.
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
                          Unable to update Monthly Report!
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

    $query3="select * from monthly_reports where id='$monthly_report_id' and student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $monthly_report_rows=mysqli_num_rows($query3_run);
    $existing_data=mysqli_fetch_assoc($query3_run);
    $existing_events=$existing_data['montly_events'];
    $existing_events_array=explode(', ', $existing_events);

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
        <?php $page='monthly_reports'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Monthly Performance Report (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Monthly Performance Report</div>
                            <div class="panel-body">
            <?php 
                if($student_rows==1)
                {
                    if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                    {
                        if($monthly_report_rows==1)
                        {
            ?>
                            <?php if(isset($msg)){echo $msg; } ?>

                                <form class="form-horizontal" action="edit_monthly_performance?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <h3 class="text-center">Non-Academic Performance</h3>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Extra Curricular Activities Participation*</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="extra_curricular" required><?= $existing_data['book1_name']; ?></textarea>Participation Details of Extra Curricular programs/ prizes achieved.
                                        </div>
                                    </div>
                                   
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Events Attended</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="events[]" data-placeholder="" multiple>
                                                <option></option>
                                <?php
                                        $query1="select * from event_master order by id desc";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($event_master=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $event_master['name'].' - ('.$event_master['location'].') - '.$event_master['date']; ?>" <?php if(!empty($existing_events_array) && in_array($event_master['name'].' - ('.$event_master['location'].') - '.$event_master['date'], $existing_events_array)){ echo 'selected'; } ?>> <?php echo $event_master['name'].' - ('.$event_master['location'].') - '.$event_master['date']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                            Note: for multiple values press CTRL and select.
                                        </div>
                                        <label class="col-sm-1 control-label">Remarks</label>
                                        <div class="col-sm-4">
                                            <textarea class="form-control" name="event_remarks">NA</textarea>
                                            ( Remarks for any events, if the student was absent or have done excellent work. )
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Comments [Your opinion about student - to be entered on basis of his record].</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="comments_opinion"><?= $existing_data['comments_opinion']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Handling any social work Drives or participation* </label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" id="handling_social_work" name="handling_social_work" data-placeholder=""  onchange="show_social_div();" required>
                                                <option></option>
                                                <option value="Yes" <?php if(!empty($existing_data['social_work_drive']) && $existing_data['social_work_drive']=='Yes'){ echo 'selected'; } ?>>Yes</option>
                                                <option value="No" <?php if(!empty($existing_data['social_work_drive']) && $existing_data['social_work_drive']=='No'){ echo 'selected'; } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="social_div" style="display: none;">
                                        <label class="col-sm-2 control-label">Explain</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="handling_social_work_explanation" required placeholder="Explain about social work drive"><?= $existing_data['social_work_explanation']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Noteworthy Experience </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="noteworthy_experience"><?= $existing_data['noteworthy_experience']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Health Issue (if any) </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="health_issue"><?= $existing_data['health_issue']; ?></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Contact with the Respective Employee*</label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" name="Contact_with_kp" data-placeholder="" required>
                                                <option></option>
                                                <option value="Regular" <?php if(!empty($existing_data['contact_with_kp']) && $existing_data['contact_with_kp']=='Regular'){ echo 'selected'; } ?>>Regular - 4/5 times in a month</option>
                                                <option value="Average" <?php if(!empty($existing_data['contact_with_kp']) && $existing_data['contact_with_kp']=='Average'){ echo 'selected'; } ?>>Average - 2 times in a month</option>
                                                <option value="Irregular" <?php if(!empty($existing_data['contact_with_kp']) && $existing_data['contact_with_kp']=='Irregular'){ echo 'selected'; } ?>>Irregular - once in a month</option>
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
                                    <h3>No monthly report found for this student.</h3>
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
                show_social_div();
            })
        </script>

        <script type="text/javascript">
              function show_social_div(){
                var handling_social_work = $('#handling_social_work').val();

                if(handling_social_work=='Yes')
                {
                  $('#social_div').css("display", "block");
                  $('#handling_social_work_explanation').prop('required', true);
                }
                else
                {
                  $('#social_div').css("display", "none");
                  $('#handling_social_work_explanation').prop('required', false);
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