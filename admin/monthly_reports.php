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
    $this_month=date('Y/m', strtotime($date));
    $month_start_date=$this_month.'/01 00:00:01 AM';
    $query20="select * from decoding where specifier='reporting_last_date'";
    $query20_run=mysqli_query($connect, $query20);
    $reporting_last_date_data=mysqli_fetch_assoc($query20_run);
    $reporting_last_date=$reporting_last_date_data['value'];
    $month_end_date=$this_month.'/'.$reporting_last_date.' 11:59:59 PM';
?>

<!DOCTYPE html>
<html lang="en">

<head>

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
            
            <div class="page-header" ><h1>Monthly Performance Reports </h1> </div> 
            
                <div class="panel panel-default">
                    <div class="panel-heading">Monthly Performance Reports </div> 
                    
                    <div class="panel-body">
                    
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Student Name</th>
                                    <th>Academic Year</th>
                                    <th>For month</th>
                                    <th>Submitted by the Respective Employee</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            $count=0;
                            if($admin_type!='kp')
                            {
                                $query="SELECT monthly_reports.id, monthly_reports.student_id, monthly_reports.year, monthly_reports.month, monthly_reports.submission_date, student_info.first_name as student_fname, student_info.last_name as student_lname, admin.first_name as admin_fname, admin.last_name as admin_lname FROM monthly_reports left join student_info on monthly_reports.student_id=student_info.id left join admin on monthly_reports.submitted_by_admin=admin.id order by monthly_reports.id desc";
                            }
                            else
                            {
                                $query="SELECT monthly_reports.id, monthly_reports.student_id, monthly_reports.year, monthly_reports.month, monthly_reports.submission_date, student_info.first_name as student_fname, student_info.last_name as student_lname, admin.first_name as admin_fname, admin.last_name as admin_lname FROM monthly_reports left join student_info on monthly_reports.student_id=student_info.id left join admin on monthly_reports.submitted_by_admin=admin.id left join kp_assigned on monthly_reports.student_id=kp_assigned.student_id where kp_assigned.kp_id='$admin_id' order by monthly_reports.id desc";
                            }
                            $query_run=@mysqli_query($connect, $query);
                            while ($result=@mysqli_fetch_assoc($query_run))
                            {
                                $count++;
                        ?>
                                <tr class="odd gradeX">
                                    <td><?= $count; ?></td>
                                    <td><a href="student_details?student_id=<?= $result['student_id']; ?>"><?= $result['student_fname'].' '.$result['student_lname']; ?></a></td>
                                    <td><?= $result['year']; ?></td>
                                    <td><?php echo date("F", strtotime($result['submission_date'])); ?></td>
                                    <td><?= $result['admin_fname'].' '.$result['admin_lname']; ?></td>
                                    <td><a class="text-success"><i class="fa fa-eye"></i> </a> 
                                        <?php 
                                            if($admin_type=='kp')
                                            {
                                                if($month_start_date<=$date && $date<=$month_end_date)
                                                { 
                                        ?>
                                                &nbsp;&nbsp;<a href="edit_monthly_performance?student_id=<?= $result['student_id']; ?>&&monthly_report_id=<?= $result['id']; ?>"><i class="fa fa-edit"></i> Edit </a>
                                        <?php 
                                                } 
                                            }
                                            else
                                            {
                                        ?>
                                                &nbsp;&nbsp;<a href="edit_monthly_performance?student_id=<?= $result['student_id']; ?>&&monthly_report_id=<?= $result['id']; ?>"><i class="fa fa-edit"></i> Edit </a>
                                        <?php
                                            }
                                        ?> 
                                        &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_monthy_report_<?php echo $result['id']; ?>" class="text-danger" onclick="delete_monthly_report(<?php echo $result['id']; ?>, <?php echo $result['student_id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                </tr>
                        <?php
                            }
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>        
        </div>
        <!-- Wrapper Ends Here (working area) -->
        
        <?php 
			include 'include/footer.php';
		?>   
    </section>
    <!-- Content Block Ends Here (right box)-->
       
  <!-- DateTime Picker -->
    <?php include 'include/footer-scripts.php';?>
        <script type="text/javascript">
            function delete_monthly_report(id, student_id){
               var retVal = confirm("Do you really want to delete this report ?");
               var $tr = $("#delete_monthy_report_"+id).closest('tr');
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_monthly_report.php",
                       data: {id:id, student_id:student_id},
                       success: function(data){
                                if(data)
                                {
                                    $tr.find('td').fadeOut(500,function(){ $tr.remove(); });
                                }
                                else
                                {
                                    alert("Error while deleting record...!");
                                }
                            },
                       error:function(){}
                    });
                }
               else
                {
                  alert("You wants to keep this report !");
                }
            }
        </script>



   
</body>

</html>



<?php
    }
?>