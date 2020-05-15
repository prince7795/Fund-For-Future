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
    $date= date("Y/m/d h:i:s A");
    $msg='';

    if(isset($_POST['doc_type']) && isset($_FILES['student_document']['name']))
    {
        $doc_type=str_replace("'", "\'", $_POST['doc_type']);
        $doc_explanation=str_replace("'", "\'", $_POST['doc_explanation']);

        $student_document_name=$_FILES['student_document']['name'];
        $student_document_tmp_name=$_FILES['student_document']['tmp_name'];
        $student_document_location='../images/student_documents/';
        $student_document_extension=strtolower(substr($student_document_name, strpos($student_document_name,'.')+1));
        $student_document_type=$_FILES['student_document']['type'];

        if(!empty($_POST['doc_type']) && !empty($_FILES['student_document']['name']))
        {
            $query2="INSERT INTO `student_docs`(`student_id`, `doc_type`, `file_path`, `description`, `submitted_by_admin`, `submission_date`) VALUES ('$student_id', '$doc_type', '$student_document_name', '$doc_explanation', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES ('$admin_id', 'student documents', 'add', '$student_id', '', '', '', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                if(!empty($student_document_tmp_name))
                {
                  move_uploaded_file($student_document_tmp_name, $student_document_location.'testdocument');
                }

                if(isset($_POST['submit_and_goback']))
                {
                    $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Student Document submitted successfully.
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
                          Student Document submitted successfully.
                        </div></center>

                        <center><div class="alert alert-info alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          You can add another Student Document now.
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
                          Unable to submit Student Document!
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
                    <h3>Student Documents (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add Student Documents</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="add_student_documents?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST" enctype="multipart/form-data">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Document type*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="doc_type" data-placeholder="Document type*" required="">
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='document_type' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($document_type=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $document_type['value']; ?>"> <?php echo $document_type['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group" id="income_certificate_file">
                                        <label class="col-sm-2 control-label">Select document*</label>
                                        <div class="col-sm-7">
                                            <input type="file" class="form-control" name="student_document">
                                            (Max file size should be 2MB.)
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Explanation (if required)</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="doc_explanation" placeholder="Explanation">
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