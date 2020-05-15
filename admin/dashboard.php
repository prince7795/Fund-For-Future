<?php
@session_start();
include_once 'include/include.php';

if(!isset($_SESSION['admin_id']) && empty($_SESSION['admin_id']) && !isset($_SESSION['admin_type']) && empty($_SESSION['admin_type']))
{
  header('location:login');
}
else
{ 
    $admin_id=$_SESSION['admin_id'];
    $admin_type=$_SESSION['admin_type'];
    ini_set( 'date.timezone', 'US/Eastern' );
    $date= date("m/d/Y h:i:s A");
    $yesterday= date('m/d/Y', strtotime("-1 days", strtotime($date)));
    $today= date('m/d/Y', strtotime($date));
    $this_month=date('m/Y', strtotime($date));

    $query1="SELECT id FROM student_info";
    $query1_run=mysqli_query($connect, $query1);
    $application_num=mysqli_num_rows($query1_run);

    if($admin_type!='kp')
    {
        $query2="SELECT id FROM student_info where status='Enrolled'";
    }
    else
    {
        $query2="SELECT student_info.id FROM student_info left join kp_assigned on student_info.id=kp_assigned.student_id 
				where kp_assigned.kp_id='$admin_id' and status='Enrolled'";
    }
    $query2_run=mysqli_query($connect, $query2);
    $student_num=mysqli_num_rows($query2_run);
    $total_students_array=array();
    while($total_student_data=mysqli_fetch_assoc($query2_run))
    {
        array_push($total_students_array, $total_student_data['id']);
    }

    $query3="SELECT id FROM admin where type='kp'";
    $query3_run=mysqli_query($connect, $query3);
    $kp_num=mysqli_num_rows($query3_run);

    if($admin_type!='kp')
    {
        $query4="SELECT id FROM monthly_reports";
    }
    else
    {
        $query4="SELECT monthly_reports.id FROM monthly_reports left join kp_assigned on monthly_reports.student_id=kp_assigned.student_id where kp_assigned.kp_id='$admin_id'";
    }
    $query4_run=mysqli_query($connect, $query4);
    $monthly_reports_num=mysqli_num_rows($query4_run);

    if($admin_type!='kp')
    {
        $query5="SELECT id FROM annual_reports";
    }
    else
    {
        $query5="SELECT annual_reports.id FROM annual_reports left join kp_assigned on annual_reports.student_id=kp_assigned.student_id where kp_assigned.kp_id='$admin_id'";
    }
    $query5_run=mysqli_query($connect, $query5);
    $annual_reports_num=mysqli_num_rows($query5_run);

    if($admin_type!='kp')
    {
        $query6="SELECT id FROM event_master";
        $query6_run=mysqli_query($connect, $query6);
        $events_num=mysqli_num_rows($query6_run);

       /* $query7="SELECT distinct student_id from monthly_reports where submission_date like '$yesterday%'";
        $query7_run=mysqli_query($connect, $query7);
        $reports_yesterday_num=mysqli_num_rows($query7_run);

        $query8="SELECT distinct student_id from monthly_reports where submission_date like '$today%'";
        $query8_run=mysqli_query($connect, $query8);
        $reports_today_num=mysqli_num_rows($query8_run);*/

        $query9="SELECT distinct student_id from monthly_reports where submission_date like '$this_month%'";
        $query9_run=mysqli_query($connect, $query9);
        $reports_this_month_num=mysqli_num_rows($query9_run);
        $reports_this_months_students=array();
        while($reports_this_month_data=mysqli_fetch_assoc($query9_run))
        {
            array_push($reports_this_months_students, $reports_this_month_data['student_id']);
        }

        $remaining_report_students=array();
        $remaining_report_students= array_diff($total_students_array, $reports_this_months_students);
        $remaining_report_students_num=sizeof($remaining_report_students);
        $remaining_report_student_string=implode("','", $remaining_report_students); 
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin panel</title>
    <?php
		include 'include/head.php';
	?>

</head>
<body data-ng-app>
  
    <!-- Preloader -->s
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
        
    <?php $page='dashboard'; ?>
    <?php include 'include/sidebar-admin.php';?>
    <!-- Aside Ends-->
    
    <section class="content">
        
        <?php include 'include/header.php'; ?>
        <!-- Header Ends -->
        
        
        <div class="wrapper container-fluid">
            
            <div class="page-header"><h1>Dashboard <small>Fund for a future</small></h1></div>
            
        <?php
            // echo '<br/> yesterday = '.$yesterday;
            // echo '<br/> today = '.$today;
            // echo '<br/> this month = '.$this_month;
            // echo '<br/> total student array = ';
            // print_r($total_students_array);
            // echo '<br/> reports this month student array = ';
            // print_r($reports_this_months_students);
            // echo '<br/> reports remaining student array = ';
            // print_r($remaining_report_students);
            // echo '<br/>'.$remaining_report_student_string;
            if($admin_type!='kp')
            {
        ?>
            <div class="row">
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="applications">
                            <div class="panel-body">
                                <h4><i class="fa fa-edit" style="font-size: 35px;color: orange;"></i> <b><?= $application_num; ?> Applications</b></h4>
                            </div>
                        </a>
                    </div>
                </div>
        <?php
            }
        ?>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="students">
                            <div class="panel-body">
                                <h4><i class="fa fa-graduation-cap" style="font-size: 35px;color: #e9573f;"></i> <b><?= $student_num; ?> Students</b></h4>
                            </div>
                        </a>
                    </div>
                </div>
        <?php
            if($admin_type!='kp')
            {
        ?>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="karyakarta_palak">
                            <div class="panel-body">
                                <h4><i class="fa fa-user" style="font-size: 35px;color: green;"></i> <b><?= $kp_num; ?> Employees</b></h4>
                            </div>
                        </a>
                    </div>
                </div>
            
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="events">
                            <div class="panel-body">
                                <h4><i class="fa fa-calendar" style="font-size: 35px;color: black;"></i> <b><?= $events_num; ?> Events</b></h4>
                            </div>
                        </a>
                    </div>
                </div>  
        <?php
            }
        ?>   

                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="monthly_reports">
                            <div class="panel-body">
                                <h4>
									<i class="fa fa-bar-chart" style="font-size: 35px;color: orange;">
									</i>
									<b>
										<?= $monthly_reports_num; ?>
										Monthly Reports
									</b>
								</h4>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="annual_reports">
                            <div class="panel-body">
                                <h4><i class="fa fa-bar-chart" style="font-size: 35px;color: blue;"></i> <b><?= $annual_reports_num; ?> Annual Reports</b></h4>
                            </div>
                        </a>
                    </div>
                </div>
        </div>

        <?php
            if($admin_type!='kp')
            {
        ?>
            <!--<div class="row">
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="monthly_reports">
                            <div class="panel-body">
                                <h4><i class="fa fa-bar-chart" style="font-size: 35px;color: green;"></i> <b><?= $reports_yesterday_num; ?> Reports Yesterday </b></h4>
                            </div>
                        </a>
                    </div>
                </div>-->
                
                <!--<div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="monthly_reports">
                            <div class="panel-body">
                                <h4><i class="fa fa-bar-chart" style="font-size: 35px;color: orange;"></i> <b><?= $reports_today_num; ?> Reports Today  </b></h4>
                            </div>
                        </a>
                    </div>
                </div>-->

                <!--<div class="col-lg-3">
                    <div class="panel panel-default">
                        <a href="monthly_reports">
                            <div class="panel-body">
                                <h4><i class="fa fa-bar-chart" style="font-size: 35px;color: brown;"></i> <b><?= $reports_this_month_num; ?> Reports This month  </b></h4>
                            </div>
                        </a>
                    </div>
                </div>-->
                
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <a>
                            <div class="panel-body">
                                <h4><i class="fa fa-bar-chart" style="font-size: 35px;color: red;"></i> <b><?= $remaining_report_students_num; ?> Reports Pending </b></h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php
            }
        ?> 
            
            
        <?php
            if($admin_type!='kp')
            {
        ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Pending Reports</div> 
                    
                    <div class="panel-body">
                    
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Student Name</th>
                                    <th>Office-Branches</th>
                                    <th>Contact Number</th>
                                    <th>Email ID</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            $count=0;
                            $query="SELECT student_info.id, student_info.first_name as student_fname, student_info.last_name as student_lname, admin.first_name as admin_fname, admin.last_name as admin_lname, admin.vsm_branch, admin.mobile_number, admin.email from student_info left join kp_assigned on kp_assigned.student_id=student_info.id left join admin on kp_assigned.kp_id=admin.id where kp_assigned.student_id in('$remaining_report_student_string')";
                            $query_run=@mysqli_query($connect, $query);
                            // echo $query;
                            while ($result=@mysqli_fetch_assoc($query_run))
                            {
                                $count++;
                        ?>
                                <tr class="odd gradeX">
                                    <td><?= $count; ?></td>
                                    <td><a href="student_details?student_id=<?= $result['id']; ?>"><?= $result['student_fname'].' '.$result['student_lname']; ?></a></td>
                                    <td><?= $result['admin_fname'].' '.$result['admin_lname'].' ('.$result['vsm_branch'].')'; ?></td>
                                    <td><?= $result['mobile_number']; ?></td>
                                    <td><?= $result['email']; ?></td>
                                   
                                </tr>
                        <?php
                            }
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        <?php
            }
        ?>

        </div>
        <!-- Wrapper Ends Here (working area) -->
        
        <?php include 'include/footer.php';?>
      
        
    </section>
    <!-- Content Block Ends Here (right box)-->
    

    <?php include 'include/footer-scripts.php';?>

   
</body>

</html>

<?php
}
?>