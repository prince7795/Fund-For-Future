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
        
    <?php $page='karyakarta_palak'; ?>
    <?php include 'include/sidebar-admin.php';?>
    <!-- Aside Ends-->
    
    <section class="content">
        
        <?php include 'include/header.php'; ?>
        <!-- Header Ends -->
        
        
       <div class="wrapper container-fluid">
            
            <div class="page-header">
			<h1>
			Employees 
			<small> 
			<a href="add_karyakarta_palak" type="button" style="float:right" class="btn btn-primary">
			Create New
			</a>
			</small>
			</h1>
			</div> 
                <div class="panel panel-default">
                    <div class="panel-heading">Employee Details</div> 
                    
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Qualification</th>
                                    <th>Occupation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            $count=0;
                            $query="SELECT * FROM `admin` WHERE type='kp' order by id desc";
                            $query_run=@mysqli_query($connect, $query);
                            while ($result=@mysqli_fetch_assoc($query_run))
                            {
                                $count++;
                        ?>
                                <tr class="odd gradeX">
                                    <td><?= $count; ?></td>
                                    <td><?= $result['first_name'].' '.$result['last_name']; ?></td>
                                    <td><?= $result['email']; ?></td>
                                    <td><?= $result['mobile_number']; ?></td>
                                    <td><?= $result['academic_qualification']; ?></td>
                                    <td><?= $result['occupation']; ?></td>
                                    <td><a href="edit_karyakarta_palak?kp_id=<?= $result['id']; ?>">
									<i class="fa fa-edit">
									</i>
									Edit
									</a>&nbsp;&nbsp;<?php 
										if($admin_type!='kp'){
										?>
										<a href="javascript:void(0);" id="delete_<?php echo $result['id']; ?>" class="text-danger" onclick="deleterecord(<?php echo $result['id']; ?>)" >
										<i class="fa fa-trash">
										</i>
										Delete
										</a>
										<?php 
											}
										?>
										</td>
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
        <!-- wrapper Ends Here (working area) -->
        
        <?php include 'include/footer.php';?>
      
        
    
    </section>
    <!-- Content Block Ends Here (right box)-->
    
    
  <!-- DateTime Picker -->

    <?php include 'include/footer-scripts.php';?>

        <script type="text/javascript">
            function deleterecord(id){
               var retVal = confirm("Do you really want to delete this KP ?");
               var $tr = $("#delete_"+id).closest('tr');
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_kp.php",
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
                  alert("Admin wants to keep this KP !");
                }
            }
        </script>

</body>

</html>



<?php
    }
?>