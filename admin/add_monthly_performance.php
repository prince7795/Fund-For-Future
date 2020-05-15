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
    $date=date("m/d/Y h:i:s A");
    $year=date('Y', strtotime('-1 months', strtotime($date)));
    $month=date('m', strtotime('-1 months', strtotime($date)));
    $msg='';

    if(isset($_POST['extra_curricular']) && isset($_POST['handling_social_work']) && isset($_POST['Contact_with_kp']))
    {
        $extra_curricular=str_replace("'", "\'", $_POST['extra_curricular']);
        /*$book_1_name=str_replace("'", "\'", $_POST['book_1_name']);
        $book_1_author=str_replace("'", "\'", $_POST['book_1_author']);
        $book_1_remarks=str_replace("'", "\'", $_POST['book_1_remarks']);
        $book_2_name=str_replace("'", "\'", $_POST['book_2_name']);
        $book_2_author=str_replace("'", "\'", $_POST['book_2_author']);
        $book_2_remarks=str_replace("'", "\'", $_POST['book_2_remarks']);
        $book_3_name=str_replace("'", "\'", $_POST['book_3_name']);
        $book_3_author=str_replace("'", "\'", $_POST['book_3_author']);
        $book_3_remarks=str_replace("'", "\'", $_POST['book_3_remarks']);*/

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
        //$advance_settlement=str_replace("'", "\'", $_POST['advance_settlement']);

        if(!empty($_POST['extra_curricular']) && !empty($_POST['handling_social_work']) && !empty($_POST['Contact_with_kp']))
        {
            $query2="INSERT INTO `monthly_reports`(`student_id`, `year`, `month`, `extra_curricular_activities`, `montly_events`,
													`event_remarks`, `comments_opinion`, `social_work_drive`, `social_work_explanation`,
													`noteworthy_experience`, `health_issue`, `contact_with_kp`,
													`submitted_by_admin`, `submission_date`)
													VALUES ('$student_id', '$year', '$month', '$extra_curricular',
													'$imploded_event_names', '$event_remarks', '$comments_opinion', '$handling_social_work',
													'$handling_social_work_explanation', '$noteworthy_experience', '$health_issue',
													'$Contact_with_kp', '$admin_id', '$date')";
													
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
							VALUES ('$admin_id', 'monthly report', 'add', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Monthly Report submitted successfully.
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
                          Unable to submit Monthly Report!
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
        <?php $page='monthly_reports'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="warper container-fluid">
                <div class="page-header"><?= $month; ?> <?= $year; ?>
                    <h3>Monthly Performance Report (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Submit Monthly Performance Report</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>

                                <form class="form-horizontal" action="add_monthly_performance?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <h3 class="text-center">Non-Academic Performance</h3>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Participation Details of Extra Curricular programs/ activities*</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="extra_curricular" required>NA</textarea>Participation Details of Extra Curricular programs/ prizes achieved.
                                        </div>
                                    </div>
                                   <!-- <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Quality reading (books other than test books) *</label>
                                        <div class="col-sm-9">
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>BOOK NAME</th>
                                                        <th>AUTHOR</th>
                                                        <th>REMARKS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="book_1_name" placeholder="Book 1 Name"></td>
                                                        <td><input type="text" class="form-control" min="0" name="book_1_author" placeholder=""></td>
                                                        <td><input type="text" class="form-control" min="0" name="book_1_remarks" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="book_2_name" placeholder="Book 2 Name"></td>
                                                        <td><input type="text" class="form-control" min="0" name="book_2_author" placeholder=""></td>
                                                        <td><input type="text" class="form-control" min="0" name="book_2_remarks" placeholder=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="book_3_name" placeholder="Book 3 Name"></td>
                                                        <td><input type="text" class="form-control" min="0" name="book_3_author" placeholder=""></td>
                                                        <td><input type="text" class="form-control" min="0" name="book_3_remarks" placeholder=""></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            ( if you have the reason to justify the student for not reading the book - kindly mention the same in monthly ahawal under remarks. )
                                        </div>
                                    </div>-->
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Monthly events </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="events[]" data-placeholder="" multiple>
                                                <option></option>
                                <?php
                                        $query1="select * from event_master order by id desc";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($event_master=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $event_master['name'].' - ('.$event_master['location'].') - '.$event_master['date']; ?>"> <?php echo $event_master['name'].' - ('.$event_master['location'].') - '.$event_master['date']; ?> </option>
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
                                            <textarea class="form-control" name="comments_opinion">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Handling any social work Drives or participation* </label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" id="handling_social_work" name="handling_social_work" data-placeholder=""  onchange="show_social_div();" required>
                                                <option></option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="social_div" style="display: none;">
                                        <label class="col-sm-2 control-label">Explain</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="handling_social_work_explanation" required placeholder="Explain about social work drive">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Noteworthy Experience </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="noteworthy_experience">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Health Issue (if any) </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="health_issue">NA</textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Contact with the Employee*</label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" name="Contact_with_kp" data-placeholder="" required>
                                                <option></option>
                                                <option value="Regular">Regular - 4/5 times in a month</option>
                                                <option value="Average">Average - 2 times in a month</option>
                                                <option value="Irregular">Irregular - once in a month</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--<hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Advance settlement type*</label>
                                        <div class="col-sm-4">
                                            <select class="form-control chosen-select" name="advance_settlement" data-placeholder="" required>
                                                <option></option>
                                                <option value="Fast">Fast - within a month</option>
                                                <option value="Slow">Slow - within 2/3 months</option>
                                                <option value="Delayed">Delayed - beyond 3 months</option>
                                            </select>
                                        </div>
                                    </div>-->
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
            <!-- Warper Ends Here (working area) -->
            <?php include 'include/footer.php';?>
        </section>
        <!-- Content Block Ends Here (right box)-->
        <!-- DateTime Picker -->
        <?php include 'include/footer-scripts.php';?>

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