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

    <?php 
		include 'include/head.php';
	?>

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
        
    <?php $page='system_logs'; ?>
    <?php include 'include/sidebar-admin.php';?>
    <!-- Aside Ends-->
    
    <section class="content">
        
        <?php include 'include/header.php'; ?>
        <!-- Header Ends -->
        
       <div class="wrapper container-fluid">
            
            <div class="page-header"><h1>System Logs</h1> </div> 
            
                <div class="panel panel-default">
                    <div class="panel-heading">All the system logs</div> 
                    
                    <div class="panel-body">

                <?php
                    $admin_id=$_SESSION['admin_id'];
                    $admin_type=$_SESSION['admin_type'];

                    if($admin_type!='kp')
                    {
                ?>
                    
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Admin</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                   <!-- <th>Affected <br/>student</th>
                                    <th>Affected <br/>KP</th>
                                    <th>Affected <br/>Decoding</th>
                                    <th>Affected <br/>Event</th>-->
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            $count=0;
                            $query="SELECT system_logs.*, admin.first_name as admin_fname, admin.last_name as admin_lname, admin.vsm_branch FROM system_logs left join admin on system_logs.admin_id=admin.id order by system_logs.id desc";
                            $query_run=mysqli_query($connect, $query);
                            while ($result=mysqli_fetch_assoc($query_run))
                            {
                                $student_id=$result['affected_student'];
                                if($student_id && $student_id!='')
                                {
                                    $query2="SELECT first_name, last_name, student_code from student_info where id='$student_id'";
                                    $query2_run=mysqli_query($connect, $query2);
                                    $student_rows=mysqli_num_rows($query2_run);
                                    $student_data=mysqli_fetch_assoc($query2_run);
                                    if($student_rows>0)
                                    {
                                        $student_name=$student_data['first_name'].' '.$student_data['last_name'].' ('.$student_data['student_code'].') ';
                                    }
                                    else
                                    {
                                        $student_name='';
                                    }
                                }
                                else
                                {
                                    $student_name='';
                                }

                                $kp_id=$result['affected_kp'];
                                if($kp_id && $kp_id!='')
                                {
                                    $query3="SELECT first_name, last_name, vsm_branch from admin where id='$kp_id'";
                                    $query3_run=mysqli_query($connect, $query3);
                                    $kp_rows=mysqli_num_rows($query3_run);
                                    $kp_data=mysqli_fetch_assoc($query3_run);
                                    if($kp_rows>0)
                                    {
                                        $kp_name=$kp_data['first_name'].' '.$kp_data['last_name'].' ('.$kp_data['vsm_branch'].') ';
                                    }
                                    else
                                    {
                                        $kp_name='';
                                    }
                                }
                                else
                                {
                                    $kp_name='';
                                }

                                $decoding_id=$result['affected_decoding'];
                                if($decoding_id && $decoding_id!='')
                                {
                                    $query4="SELECT specifier, value from decoding where id='$decoding_id'";
                                    $query4_run=mysqli_query($connect, $query4);
                                    $decoding_rows=mysqli_num_rows($query4_run);
                                    $decoding_data=mysqli_fetch_assoc($query4_run);
                                    if($decoding_rows>0)
                                    {
                                        $decoding_info=$decoding_data['specifier'].' : '.$decoding_data['value'];
                                    }
                                    else
                                    {
                                        $decoding_info='';
                                    }
                                }
                                else
                                {
                                    $decoding_info='';
                                }

                                $event_id=$result['affected_event'];
                                if($event_id && $event_id!='')
                                {
                                    $query5="SELECT * from event_master where id='$event_id'";
                                    $query5_run=mysqli_query($connect, $query5);
                                    $event_rows=mysqli_num_rows($query5_run);
                                    $event_data=mysqli_fetch_assoc($query5_run);
                                    if($event_rows>0)
                                    {
                                        $event_info=$event_data['name'].' <br/>('.date('m/d/Y', strtotime($event_data['date'])).')';
                                    }
                                    else
                                    {
                                        $event_info='';
                                    }
                                }
                                else
                                {
                                    $event_info='';
                                }

                                $count++;
                        ?>
                                <tr class="odd gradeX">
                                    <td><?= $count; ?></td>
                                    <td><?php echo $result['admin_fname'].' '.$result['admin_lname'].' '; ?></td>
                                    <td><?php echo $result['module']; ?></td>
                                    <td><?php echo $result['action']; ?></td>
                                   <!-- <td><?php if(isset($student_name)){ echo $student_name; } ?></td>
                                    <td><?php if(isset($kp_name)){ echo $kp_name; } ?></td>
                                    <td><?php if(isset($decoding_info)){ echo $decoding_info; } ?></td>
                                    <td><?php if(isset($event_info)){ echo $event_info; } ?></td>-->
                                    <td><?php echo date('m/d/Y h:i:s A', strtotime($result['time'])); ?></td>
                                </tr>
                        <?php
                            }
                        ?>
                            </tbody>
                        </table>

                    </div>

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
        <!-- Wrapper Ends Here (working area) -->
        
        <?php
			include 'include/footer.php';
		?>  
    </section>
    <!-- Content Block Ends Here (right box)-->    
  <!-- DateTime Picker -->   

    <?php
		include 'include/footer-scripts.php';
	?>
        <script type="text/javascript">
            function deleterecord(id){
               var retVal = confirm("Do you really want to delete this event ?");
               var $tr = $("#delete_"+id).closest('tr');
               if( retVal == true )
                {
                    $.ajax({
                       type: "POST",
                       url: "delete_event.php",
                       data: {id:id},
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
                  alert("Admin wants to keep this event !");
                }
            }
        </script>



   
</body>

</html>



<?php
    }
?>