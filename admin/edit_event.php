<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']) && !isset($_SESSION['admin_type']) && empty($_SESSION['admin_type']))
{
  header('location:login');
}
else
{

    if(isset($_GET['event_id']))
    {
        $event_id=str_replace("'", "\'", $_GET['event_id']);
    }

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg='';

    if(isset($_POST['name']) && isset($_POST['location']) && isset($_POST['event_date']))
    {
        $name=str_replace("'", "\'", $_POST['name']);
        $location=str_replace("'", "\'", $_POST['location']);
        $event_date=str_replace("'", "\'", $_POST['event_date']);

        if(!empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['event_date']))
        {
            $query2="UPDATE `event_master` SET `name`='$name', `location`='$location', `date`='$event_date' WHERE id='$event_id'";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
									VALUES ('$admin_id', 'events', 'edit', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                      </button>
                      Event updated successfully.
                    </div></center>';

                header('Refresh:1; url=events');
            }
            else
            {
                $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Unable to update Event!
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

    $query3="select * from event_master where id='$event_id'";
    $query3_run=mysqli_query($connect, $query3);
    $event_rows=mysqli_num_rows($query3_run);
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
        <?php $page='events'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="page-header">
                    <h3>Edit Event (<?= $existing_data['name']; ?>) </h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Event</div>
                            <div class="panel-body">
                <?php 
                    $admin_id=$_SESSION['admin_id'];
                    $admin_type=$_SESSION['admin_type'];

                    if($admin_type!='kp')
                    {
                        if($event_rows==1)
                        {
                ?>
                            <?php if(isset($msg)){echo $msg; } ?>
                                <form class="form-horizontal" action="edit_event?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name*</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="name" value="<?= $existing_data['name']; ?>" placeholder="Name*" required>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Location*</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="location" value="<?= $existing_data['location']; ?>" placeholder="Location*" required>
                                        </div>
                                        <label class="col-sm-2 control-label">Event Date*</label>
                                        <div class="col-sm-3">
                                            <div class='input-group date datepicker'>
                                                <input type='text' class="form-control" name="event_date" value="<?= $existing_data['date']; ?>" data-date-format="YYYY/MM/DD" required />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
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
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <h3>No such event record found.</h3>
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
            $(".datetimepicker").datetimepicker();
            $(".datepicker").datetimepicker({ pickTime: false });
            $(".timepicker2").datetimepicker({ pickDate: false });
        </script>
    </body>
</html>
<?php
    }
?>