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

    if(isset($_POST['student_mobile']) && isset($_POST['parent_mobile']))
    {
        $student_email=str_replace("'", "\'", $_POST['student_email']);
        $student_mobile=str_replace("'", "\'", $_POST['student_mobile']);
        $student_landline=str_replace("'", "\'", $_POST['student_landline']);
        $parent_email=str_replace("'", "\'", $_POST['parent_email']);
        $parent_mobile=str_replace("'", "\'", $_POST['parent_mobile']);
        $parent_landline=str_replace("'", "\'", $_POST['parent_landline']);
        $alt_email=str_replace("'", "\'", $_POST['alt_email']);
        $alt_mobile=str_replace("'", "\'", $_POST['alt_mobile']);
        $alt_landline=str_replace("'", "\'", $_POST['alt_landline']);
        $neighbour_email=str_replace("'", "\'", $_POST['neighbour_email']);
        $neighbour_mobile=str_replace("'", "\'", $_POST['neighbour_mobile']);
        $neighbour_landline=str_replace("'", "\'", $_POST['neighbour_landline']);

        if(!empty($_POST['student_mobile']) && !empty($_POST['parent_mobile']))
        {
            $query2="INSERT INTO `contact_details`(`student_id`, `student_email`, `student_mobile`, `student_landline`, `parent_email`, `parent_mobile`, `parent_landline`, `alternate_email`, `alternate_mobile`, `alternate_landline`, `neighbour_email`, `neighbour_mobile`, `neighbour_landline`, `submitted_by_admin`, `submission_date`) VALUES ('$student_id', '$student_email', '$student_mobile', '$student_landline', '$parent_email', '$parent_mobile', '$parent_landline', '$alt_email', '$alt_mobile', '$alt_landline', '$neighbour_email', '$neighbour_mobile', '$neighbour_landline', '$admin_id', '$date')";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `affected_student`, `affected_kp`, `affected_decoding`, `affected_event`, `time`) VALUES ('$admin_id', 'contact details', 'add', '$student_id', '', '', '', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Contact details submitted successfully.
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
                          Unable to submit Contact details!
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

    $query3="select * from contact_details where student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $contact_rows=mysqli_num_rows($query3_run);

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
                    <h3>Contact details (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Add New Contact</div>
                            <div class="panel-body">
            <?php 
                if($student_rows==1)
                {
                    if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                    {
                        if($contact_rows==0)
                        {
            ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="add_contact_details?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                               <!-- <th>Whatsapp no.</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Student Contact</td>
                                                <td><input type="email" class="form-control" name="student_email" placeholder="Email"></td>
                                                <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="student_mobile" placeholder="Mobile*" required></td>
                                               <!-- <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="student_landline" placeholder="Whatsapp no."></td>-->
                                            </tr>
                                            <tr>
                                                <td>Parent Contact</td>
                                                <td><input type="email" class="form-control" name="parent_email" placeholder="Email"></td>
                                                <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="parent_mobile" placeholder="Mobile*" required></td>
                                              <!--  <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="parent_landline" placeholder="Whatsapp no."></td>-->
                                            </tr>
                                            <tr>
                                                <td>Alternative Contact</label></td>
                                                <td><input type="email" class="form-control" name="alt_email" placeholder="Email"></td>
                                                <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="alt_mobile" placeholder="Mobile"></td>
                                               <!-- <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="alt_landline" placeholder="Whatsapp no."></td>-->
                                            </tr>
                                            <tr>
                                                <td>Neighbour Contact</td>
                                                <td><input type="email" class="form-control" name="neighbour_email" placeholder="Email"></td>
                                                <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="neighbour_mobile" placeholder="Mobile"></td>
                                               <!-- <td><input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="neighbour_landline" placeholder="Whatsapp no."></td>-->
                                            </tr>
                                        </tbody>
                                    </table>
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
                                    <h3>This student have already submitted contact details.</h3>
                                    <a href="edit_contact_details?student_id=<?= $student_id; ?>&&student_code="><h4>You can edit the same by clicking here.</h4></a>
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
            $(".datetimepicker").datetimepicker();
            $(".datepicker").datetimepicker({ pickTime: false });
            $(".timepicker2").datetimepicker({ pickDate: false });
        </script>
    </body>
</html>
<?php
    }
?>