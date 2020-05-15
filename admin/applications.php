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
        
    <?php if(isset($_GET['type'])&&$_GET['type']=='Enrolled'){
			$page='applications?type=Enrolled';
			}
			else if(isset($_GET['type'])&&$_GET['type']=='Rejected'){
				$page='applications?type=Rejected'; 
			}
			else if(isset($_GET['type'])&&$_GET['type']=='Pending'){
				$page='applications?type=Pending';
			}else{
				$page='applications';
			}
	?>
    <?php include 'include/sidebar-admin.php';?>
    <?php
    if(isset($_GET['type']))
    {
        $application_type=str_replace("'","\'",$_GET['type']);
    }
    else
    {
        $application_type='';
    }
    ?>
    <!-- Aside Ends-->
    
    <section class="content">
        
        <?php include 'include/header.php'; ?>
        <!-- Header Ends -->
        <div class="wrapper container-fluid">        
            <div class="page-header" ><h1>
			<?php if($application_type=='Enrolled'){
				echo 'Approved Applications'; 
				}
				else if($application_type=='Rejected'){
					echo 'Rejected Applications'; 
				}
				else if($application_type=='Pending'){
					echo 'Pending Applications'; 
				}
				else{
					echo 'All Applications'; 
			} ?> 						
			<small>
				<a href="add_application" type="button" style="float:right" class="btn btn-primary">Create New</a>
			</small>
			</h1>
			</div> 
                    
                <div class="panel panel-default">
                    <div class="panel-heading">Application Details</div> 
                    
                    
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
                                    <th>Application. No.</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                         <?php
                            $count=0;
                            // if($admin_type!='kp')
                            // {
                                if($application_type=='')
                                {
                                    $query="SELECT student_info.*, contact_details.student_email, contact_details.student_mobile FROM student_info left join contact_details on student_info.id=contact_details.student_id order by id desc";
                                }
                                else
                                {
                                    $query="SELECT student_info.*, contact_details.student_email, contact_details.student_mobile FROM student_info left join contact_details on student_info.id=contact_details.student_id WHERE student_info.status='$application_type' order by id desc";
                                }
                            // }
                            // else
                            // {
                            //     if($application_type=='')
                            //     {
                            //         $query="SELECT student_info.*, contact_details.student_email, contact_details.student_mobile, kp_assigned.kp_id FROM student_info left join contact_details on student_info.id=contact_details.student_id left join kp_assigned on student_info.id=kp_assigned.student_id where kp_assigned.kp_id='$admin_id' order by student_info.id";
                            //     }
                            //     else
                            //     {
                            //         $query="SELECT student_info.*, contact_details.student_email, contact_details.student_mobile FROM student_info left join contact_details on student_info.id=contact_details.student_id left join kp_assigned on student_info.id=kp_assigned.student_id where kp_assigned.kp_id='$admin_id' and student_info.status='$application_type' order by student_info.id";
                            //     }
                            // }
                            $query_run=@mysqli_query($connect, $query);
                            while ($result=@mysqli_fetch_assoc($query_run))
                            {
                                $count++;
                        ?>
                                <tr class="odd gradeX">
                                    <td><?= $count; ?></td>
                                    <td><?= $result['application_id']; ?></td>
                                    <td><a href="student_details?student_id=<?= $result['id']; ?>&&student_code=""><?= $result['first_name'].' '.$result['last_name']; ?></a></td>
                                    <td><?php if($result['dob']){ echo date('d/m/Y', strtotime($result['dob'])); } ?></td>
                                    <td><?= $result['student_email']; ?></td>
                                    <td><?= $result['student_mobile']; ?></td>
                                    <td><b class="<?php if($result['status']=='Enrolled'){
														echo 'text-success';
														}
														else if($result['status']=='Rejected'){
															echo 'text-danger'; } ?>">
															<?= $result['status']; ?>
															</b>
															</td>
                                    <td><a href="edit_application?student_id=<?= $result['id']; ?>&&student_code=">
									<i class="fa fa-edit"></i> Edit </a>&nbsp;&nbsp;<?php if($admin_type!='kp'){ ?><a href="javascript:void(0);" id="delete_<?php echo $result['id']; ?>" class="text-danger" onclick="deleterecord(<?php echo $result['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a><?php } ?></td>
                                </tr>
                        <?php
                            }
                        ?>
                            </tbody>
                        </table>
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
        <!-- Wrapper Ends Here (working area) -->      
        <?php include 'include/footer.php';?> 
    </section>
    <!-- Content Block Ends Here (right box)-->
	
  <!-- DateTime Picker -->
    <?php include 'include/footer-scripts.php';?>
        <script type="text/javascript">
            function deleterecord(id){
               var retVal = confirm("Do you really want to delete this application ?");
               var $tr = $("#delete_"+id).closest('tr');
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_student.php",
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
                  alert("Admin wants to keep this application !");
                }
            }
        </script>
</body>
</html>

<?php
    }
?>