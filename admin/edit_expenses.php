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
    if(isset($_GET['expense_id']))
    {
        $expense_id=str_replace("'", "\'", $_GET['expense_id']);
    }

    $admin_id=$_SESSION['admin_id'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $msg='';

    if(isset($_POST['academic_year']) && isset($_POST['expenses']))
    {
        $academic_year=str_replace("'", "\'", $_POST['academic_year']);
        $expenses=str_replace("'", "\'", $_POST['expenses']);

        if(!empty($_POST['academic_year']) && !empty($_POST['expenses']))
        {
            $query2="UPDATE `budgeted_expenses` 
					SET `academic_year`='$academic_year', `budgeted_expenses`='$expenses', `last_edit_by`='$admin_id', `last_edit_date`='$date'
					WHERE id='$expense_id'";
            $query2_run=mysqli_query($connect,$query2);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'budgted expenses', 'edit', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                      </button>
                      Expenses updated successfully.
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
                          Unable to update Expenses!
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

    $query3="select * from budgeted_expenses where id='$expense_id' and student_id='$student_id'";
    $query3_run=mysqli_query($connect, $query3);
    $expenses_rows=mysqli_num_rows($query3_run);
    $existing_data=mysqli_fetch_assoc($query3_run);

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
            <div class="warper container-fluid">
                <div class="page-header">
                    <h3>Expenses (<?= $student_data['first_name'].' '.$student_data['last_name']; ?>)</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Expenses</div>
                            <div class="panel-body">
                <?php 
                    if($student_rows==1)
                    {
                        if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                        {
                            if($expenses_rows==1)
                            {
                ?>
                                <?php if(isset($msg)){echo $msg; } ?>
                                    <form class="form-horizontal" action="edit_expenses?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                        <br/>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Academic year*</label>
                                            <div class="col-sm-3">
                                                <select class="form-control chosen-select" name="academic_year" data-placeholder="Academic year*" required="">
                                                    <option></option>
                                    <?php
                                            $query1="select * from decoding where specifier='academic-year' order by specifier";
                                            $query1_run=mysqli_query($connect, $query1);
                                            while($academic_year=mysqli_fetch_assoc($query1_run))
                                            {
                                    ?>  
                                                    <option value="<?php echo $academic_year['value']; ?>" <?php if(!empty($existing_data['academic_year']) && $existing_data['academic_year']==$academic_year['value']){ echo 'selected'; } ?>> <?php echo $academic_year['description']; ?> </option>
                                    <?php
                                            }
                                    ?> 
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="dotted">
                                        <div class="form-group">
                                            <!--<label class="col-sm-2 control-label">Account head*</label>
                                            <div class="col-sm-3">
                                                <select class="form-control chosen-select" name="expense_head" data-placeholder="Account head*" required="">
                                                    <option></option>
                                    <?php
                                            $query1="select * from decoding where specifier='expense_head' order by specifier";
                                            $query1_run=mysqli_query($connect, $query1);
                                            while($expense_head=mysqli_fetch_assoc($query1_run))
                                            {
                                    ?>  
                                                    <option value="<?php echo $expense_head['value']; ?>" <?php if(!empty($existing_data['expense_criteria']) && $existing_data['expense_criteria']==$expense_head['value']){ echo 'selected'; } ?>> <?php echo $expense_head['description']; ?> </option>
                                    <?php
                                            }
                                    ?>
                                                </select>
                                            </div>-->
                                            <label class="col-sm-2 control-label">Budgeted expenses*</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" min="0" name="expenses" value="<?= $existing_data['budgeted_expenses']; ?>" placeholder="Budgeted expenses*" required>  ( In rupees. )
                                            </div>
                                        </div>
                                        <hr class="dotted">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <input type="submit" class="btn btn-primary pull-right" value="Update">
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
                                        <h3>No budgeted expense found for this student.</h3>
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
            <!-- Warper Ends Here (working area) -->
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