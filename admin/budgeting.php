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
        
    <?php $page='budgeting'; ?>
    <?php include 'include/sidebar-admin.php';?>
    <!-- Aside Ends-->
    
    <section class="content">
        
        <?php include 'include/header.php'; ?>
        <!-- Header Ends -->
        
        
       <div class="wrapper container-fluid">

            <?php
                $admin_id=$_SESSION['admin_id'];
                $admin_type=$_SESSION['admin_type'];
            ?>
            
            <div class="page-header" ><h1>Alloted Budgets </h1> </div>       
                <div class="panel panel-default">
                    <div class="panel-heading">Budgets </div>                
                    <div class="panel-body">                 
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Student</th>
                                    <th>Academic year</th>
                                    <th>Account head</th>
                                    <th>Budgeted Expenses</th>
                                    <th>Approved Amount</th>
                                <?php
									if($admin_type!='kp'){
								?>
                                    <th>Action</th>
                                <?php
									}
								?>
                                </tr>
                            </thead>
                            <tbody>
                         <?php
                            // $count=0;
                            // $query="select * from students order by id desc";
                            // $query_run=@mysqli_query($connect, $query);
                            // while ($result=@mysqli_fetch_assoc($query_run))
                            // {
                            //     $count++;
                                // $date_of_joining = $result['date_of_joining'];
                                // $explode = explode(" ",$date_of_joining);
                                // $date = $explode[0];
                                // $expiry = date('m/d/Y', strtotime("+6 months", strtotime($date)));

                        ?>
                                <tr class="odd gradeX">
                                    <td>1</td>
                                    <td><a href="student_details?student_id=1&&student_code=">Ravi Singh</a></td>
                                    <td>2017-2018</td>
                                    <td>Total Fees</td>
                                    <td>$ 50000</td>
                                    <td>$ 10000</td>
                                <?php if($admin_type!='kp'){ ?>
                                    <td><a href="allot_budget?student_id=1&&student_code="><i class="fa fa-edit"></i> Edit </a></td>
                                <?php } ?>
                                </tr>
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
    <?php 
		include 'include/footer-scripts.php';
	?>
        <script type="text/javascript">
            function deleterecord(id){
               var retVal = confirm("Do you really want to delete this client ?");
               var $tr = $("#delete_"+id).closest('tr');
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_client.php",
                       data: {id:id},
                       success: function(data){
                                if(data)
                                {
                                    console.log($(this).parent());
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
                  alert("Admin wants to keep this client !");
                }
            }
      </script> 
</body>
</html>

<?php
    }
?>