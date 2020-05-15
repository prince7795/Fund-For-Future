<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']) && !isset($_SESSION['admin_type']) && empty($_SESSION['admin_type']))
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
                    <h3>Budget</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Allotment Details</div>
                            <div class="panel-body">
                        <?php
                            $admin_id=$_SESSION['admin_id'];
                            $admin_type=$_SESSION['admin_type'];

                            if($admin_type!='kp')
                            {
                        ?>
                                <form class="form-horizontal" action="allot_budget?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Student Name*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" id="student_name" name="student_name" data-placeholder="Student Name*" required>
                                                <option></option>
                                            </select>
                                        </div>
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
                                                <option value="<?php echo $academic_year['value']; ?>"> <?php echo $academic_year['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--<hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Account head*</label>
                                        <div class="col-sm-3">
                                            <select class="form-control chosen-select" name="expense_head" data-placeholder="Account head*" required="">
                                                <option></option>
                                <?php
                                        $query1="select * from decoding where specifier='expense_head' order by specifier";
                                        $query1_run=mysqli_query($connect, $query1);
                                        while($expense_head=mysqli_fetch_assoc($query1_run))
                                        {
                                ?>  
                                                <option value="<?php echo $expense_head['value']; ?>"> <?php echo $expense_head['description']; ?> </option>
                                <?php
                                        }
                                ?>
                                            </select>
                                        </div>
                                    </div>-->
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Budgeted expenses*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="expenses" placeholder="Budgeted expenses*" required>  (In $)
                                        </div>
                                        <label class="col-sm-2 control-label">Revised Amount*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="revised_amt" placeholder="Revised Amount*" required>  (In $)
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Revised reason</label>
                                        <div class="col-sm-7">
                                            <textarea class="form-control" name="revised_reason" placeholder="Revised reason"></textarea>
                                        </div>
                                    </div>
                                    <hr class="dotted">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Sanction Amount*</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" min="0" name="sanction_amt" placeholder="Sanction Amount*" required>  (In $)
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
            <!-- Wrapper Ends Here (working area) -->
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