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

    if(isset($_POST['academic_year']) && isset($_POST['marks_units']) && isset($_POST['result']))
    {
        $class=str_replace("'", "\'", $_POST['class']);
        $academic_year=str_replace("'", "\'", $_POST['academic_year']);
        $type=str_replace("'", "\'", $_POST['type']);
        $extra_examinations=str_replace("'", "\'", $_POST['extra_examinations']);
        $marks_type=str_replace("'", "\'", $_POST['marks_type']);
        $marks_units=str_replace("'", "\'", $_POST['marks_units']);
        $result=str_replace("'", "\'", $_POST['result']);

        if(!empty($_POST['academic_year']) && !empty($_POST['marks_units']) && !empty($_POST['result']))
        {
            $query2="INSERT INTO `educational_details`(`student_id`, `class`, `academic_year`, `type`, `extra_exam_appeared`, `marks_type`, `marks_units`, `result`, `submitted_by_admin`, `submission_date`) VALUES ('$student_id', '$class', '$academic_year', '$type', '$extra_examinations', '$marks_type', '$marks_units', '$result', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'educational details', 'add', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                if(isset($_POST['submit_and_goback']))
                {
                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Educational details submitted successfully.
                        </div></center>';

                    header('Refresh:1; url=student_details?student_id='.$student_id);
                }
                else
                {
                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Educational details submitted successfully.
                        </div></center>

                        <center><div class="alert alert-info alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          You can add another Educational details now.
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
                          Unable to submit Educational details!
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
                    <h3>Educational details (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Educational details</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="add_educational_details?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Type*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" id="type" name="type" onselect="hide_show();" onchange="hide_show();" onchange="hide_show();" data-placeholder="" required>
                                                <option></option>
                                                <option value="Academic">Academic</option>
                                                <option value="Non-Academic">Non-Academic</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 control-label">Academic year*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="academic_year" data-placeholder="Academic year" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='academic-year' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($academic_year=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $academic_year['value']; ?>"> <?php echo $academic_year['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>
                                    </div>
                                    <div id="selective_div" style="display: none;">
                                        <hr class="dotted">
                                        <div class="form-group">
                                            <div id="class_div" style="display: none;">
                                                <label class="col-sm-2 control-label">Class</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="class" name="class" data-placeholder="Class">
                                                        <option></option>
                                        <?php
                                                $query1="select * from decoding where specifier='education_class' order by specifier";
                                                $query1_run=mysqli_query($connect, $query1);
                                                while($education_class=mysqli_fetch_assoc($query1_run))
                                                {
                                        ?>  
                                                        <option value="<?php echo $education_class['value']; ?>"> <?php echo $education_class['description']; ?> </option>
                                        <?php
                                                }
                                        ?>                                   
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="extra_exam_div" style="display: none;">
                                                <label class="col-sm-2 control-label">Appeared for extra examinations</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="extra_exam" name="extra_examinations" data-placeholder="">
                                                        <option></option>
                                        <?php
                                                $query1="select * from decoding where specifier='extra_exams' order by specifier";
                                                $query1_run=mysqli_query($connect, $query1);
                                                while($extra_exams=mysqli_fetch_assoc($query1_run))
                                                {
                                        ?>  
                                                        <option value="<?php echo $extra_exams['value']; ?>"> <?php echo $extra_exams['description']; ?> </option>
                                        <?php
                                                }
                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Marks Type</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="marks_type" data-placeholder="" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='education_units' order by specifier";
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
                                        <label class="col-sm-2 control-label">Marks units*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="marks_units" placeholder="Mark units obtained" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Result*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="result" data-placeholder="" required>
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='education_result' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($education_result=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $education_result['value']; ?>"> <?php echo $education_result['description']; ?> </option>
                                <?php
                                        }
                                ?>                                   
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <div class="col-sm-7">
                                            <input type="submit" class="btn btn-primary pull-right" name="add_more" value="Add more">
                                            <input type="submit" class="btn btn-success pull-right" name="submit_and_goback" value="Submit and go back">
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
                hide_show();
            });
        </script>

        <script type="text/javascript">
            function hide_show()
            {
                var type = $('#type').val();

                if(type=='')
                {
                    $('#selective_div').css('display', 'none');
                    $('#class_div').css('display', 'none');
                    $('#class').css('display', 'none');
                    $('#extra_exam_div').css('display', 'none');
                    $('#extra_exam').css('display', 'none');

                }
                else if(type=='Academic')
                {
                    $('#selective_div').css('display', 'block');
                    $('#class_div').css('display', 'block');
                    $('#class').css('display', 'block');
                    $('#extra_exam_div').css('display', 'none');
                    $('#extra_exam').css('display', 'none');
                }
                else if(type=='Non-Academic')
                {
                    $('#selective_div').css('display', 'block');
                    $('#class_div').css('display', 'none');
                    $('#class').css('display', 'none');
                    $('#extra_exam_div').css('display', 'block');
                    $('#extra_exam').css('display', 'block');
                }
            }
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