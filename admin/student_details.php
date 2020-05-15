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
    $date= date("m/d/y h:i:s A");
    $this_month=date('Y/m', strtotime($date));
    $month_start_date=$this_month.'/01 00:00:01 AM';
    $query20="select * from decoding where specifier='reporting_last_date'";
    $query20_run=mysqli_query($connect, $query20);
    $reporting_last_date_data=mysqli_fetch_assoc($query20_run);
    $reporting_last_date=$reporting_last_date_data['value'];
    $month_end_date=$this_month.'/'.$reporting_last_date.' 11:59:59 PM';

    if(isset($_GET['student_id']))
    {
        $student_id=str_replace("'", "\'", $_GET['student_id']);
    }
    $query1="SELECT * FROM student_info WHERE id='$student_id'";
    $query1_run=mysqli_query($connect, $query1);
    $student_rows=mysqli_num_rows($query1_run);
    $student_data=mysqli_fetch_assoc($query1_run);
    $student_code=$student_data['student_code'];

    if(isset($_POST['submit_status']) && isset($_POST['application_status']))
    {
        if(!empty($_POST['application_status']))
        {
            $status=$_POST['application_status'];

            if($status=='Enrolled' || $status=='Rejected')
            {
                $remark=$_POST['remark_by_commitee'];
            }
            else
            {
                $remark='';
            }

            if($student_code!='')
            {
                $query17="UPDATE `student_info` SET `status`='$status', `remark_by_commitee`='$remark' WHERE id='$student_id'";
            }
            else
            {
                $query19="SELECT MAX(student_code) as max_code FROM `student_info`";
                $query19_run=mysqli_query($connect,$query19);
                $max_result=mysqli_fetch_assoc($query19_run);
                if($max_result['max_code']=='')
                {
                    $new_stud_code='STUD1';
                }
                else
                {
                    $max_stud_code=(int)str_replace('STUD', '', $max_result['max_code']);
                    $new_no=$max_stud_code+1;
                    $new_stud_code='STUD'.$new_no;
                }
                $query17="UPDATE `student_info` SET `student_code`='$new_stud_code', `status`='$status', `remark_by_commitee`='$remark' WHERE id='$student_id'";
            }
            $query17_run=mysqli_query($connect,$query17);
            if(mysqli_affected_rows($connect)>0)
            {
                $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'application status', 'edit', '$date')";
                $query21_run=mysqli_query($connect,$query21);

                $msg='<center><div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Application status and remark updated successfully.
                        </div>
						</center>';

                if($status=='Enrolled')
                {
                    $kp_id=$_POST['kp_alloted'];
                    $start_date=$_POST['start_date'];

                    $query18="UPDATE `kp_assigned` SET `kp_id`='$kp_id', `from_date`='$start_date' WHERE student_id='$student_id'";
                    $query18_run=mysqli_query($connect,$query18);
                    if(mysqli_affected_rows($connect)>0)
                    {
                        $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
															VALUES ('$admin_id', 'KP allocation', 'edit', '$date')";
                        $query21_run=mysqli_query($connect,$query21);

                        $msg .='<center><div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                  </button>
                                  Employee allotment updated successfully.
                                </div></center>';
                    }
                    else
                    {
                        $msg .='<center><div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                  </button>
                                  Employee allotment is unchanged!<br/>
                                </div></center>';
                    }
                }
                else
                {
                    $kp_id='0';
                    $start_date='';

                    $query18="UPDATE `kp_assigned` SET `kp_id`='$kp_id', `from_date`='$start_date' WHERE student_id='$student_id'";
                    $query18_run=mysqli_query($connect,$query18);
                }
            }
            else
            {
                $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                          </button>
                          Unable to update Application status and remark!
                        </div></center>';

                if($status=='Enrolled')
                {
                    $kp_id=$_POST['kp_alloted'];
                    $start_date=$_POST['start_date'];

                    $query18="UPDATE `kp_assigned` SET `kp_id`='$kp_id', `from_date`='$start_date' WHERE student_id='$student_id'";
                    $query18_run=mysqli_query($connect,$query18);
                    if(mysqli_affected_rows($connect)>0)
                    {
                        $query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`) VALUES ('$admin_id', 'KP allocation', 'edit', '$date')";
                        $query21_run=mysqli_query($connect,$query21);
                        
                        $msg .='<center><div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                  </button>
                                  Employee allotment updated successfully.
                                </div></center>';
                    }
                    else
                    {
                        $msg .='<center><div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                  </button>
                                  Employee allotment is unchanged!<br/>
                                </div></center>';
                    }
                }
                else
                {
                    $kp_id='0';
                    $start_date='';

                    $query18="UPDATE `kp_assigned` SET `kp_id`='$kp_id', `from_date`='$start_date' WHERE student_id='$student_id'";
                    $query18_run=mysqli_query($connect,$query18);
                }
            }
        }
        else
        {
            $msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                      </button>
                      Please select application status before submit!
                    </div></center>';
        }
    }

    $query1="SELECT * FROM student_info WHERE id='$student_id'";
    $query1_run=mysqli_query($connect, $query1);
    $student_rows=mysqli_num_rows($query1_run);
    $student_data=mysqli_fetch_assoc($query1_run);

    $query19="SELECT kp_assigned.*, admin.first_name, admin.last_name, admin.vsm_branch FROM kp_assigned left join admin on kp_assigned.kp_id=admin.id WHERE kp_assigned.student_id='$student_id'";
    $query19_run=mysqli_query($connect, $query19);
    $kp_assigned_data=mysqli_fetch_assoc($query19_run);
    $kp_assigned_id=$kp_assigned_data['kp_id'];
    $kp_start_date=$kp_assigned_data['from_date'];

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
        <?php $page='students'; ?>
        <?php include 'include/sidebar-admin.php';?>
        <!-- Aside Ends-->
        <section class="content">
            <?php include 'include/header.php'; ?>
            <!-- Header Ends -->
            <div class="wrapper container-fluid">
                <div class="row">
            <?php 
                if($student_rows==1)
                {
                    if($_SESSION['admin_type']!='kp' || ($_SESSION['admin_type']=='kp' && $_SESSION['admin_id']==$kp_assigned_id))
                    {
            ?>
                    <?php if(isset($msg)){
							echo $msg; 
						} 
					?>
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>
							<?= $student_data['first_name'].' '.$student_data['middle_name'].' '.$student_data['last_name']; ?> 
							<small>
							<div class="pull-right">
							<mark>
							<b> Application Status: <?= $student_data['status']; ?> 
							</b>
							</mark> 
							<?php 
								if($admin_type!='kp'){ 
							?>
							<button class="btn btn-info" id="" data-toggle="modal" data-target="#modal-form">Action</button>
							<?php
								} 
							?> <button class="btn btn-success">
							<i class="fa fa-print">
							</i>
							Print Application
							</button>
							</div>
							</small> 
							</h1>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Personal Details <a href="edit_application?student_id=<?= $student_id; ?>&&student_code=" class="pull-right">
							<i class="fa fa-edit"></i> Edit </a></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <img src="../images/student_photos/<?= $student_data['photo']; ?>" class="img img-responsive" alt="Student photo" style="height: 130px; ">
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $query3="select student_info.*,contact_details.student_email,contact_details.student_mobile,contact_details.student_landline from student_info left join contact_details on student_info.id=contact_details.student_id where student_info.id='$student_id' order by id";
                                    $query3_run=mysqli_query($connect, $query3);
                                    $personal_details=mysqli_fetch_assoc($query3_run);
                                ?>
                                    <div class="col-lg-4">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p>
                                                    <b>Name:</b> <?= $personal_details['first_name'].' '.$personal_details['middle_name'].' '.$personal_details['last_name']; ?><br/>
                                                    <b>Date of Birth:</b> <?php if($personal_details['dob']){ echo date('d/m/Y', strtotime($personal_details['dob'])); } ?><br/>
                                                    <b>Email:</b> <?= $personal_details['student_email'] ?>  <br/>
                                                    <b>Mobile:</b> <?= $personal_details['student_mobile'] ?><br/>
                                                    
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p>
                                                    <b>Application no:</b> <?= $personal_details['application_id'] ?><br/>
                                                    <b>Student code:</b> <?= $personal_details['student_code'] ?><br/>
                                                    <mark><b>Employee alloted: <?php if($kp_assigned_data['first_name']!=''){ echo $kp_assigned_data['first_name'].' '.$kp_assigned_data['last_name'].' ('.$kp_assigned_data['vsm_branch'].') '; }else{ echo 'Not Alloted'; } ?></b></mark><br/>
                                                    <b>Office-Branch:</b> <?= $personal_details['vsm_branch'] ?></br>
                                                    <b>Application Status:</b> <?= $personal_details['status'] ?><br/>
                                                    <!--<b>CSR:</b> <?php if($personal_details['csr']=='Yes'){ echo $personal_details['csr_organisation']; }else{ echo $personal_details['csr']; } ?><br/>-->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                    $query4="select * from address_details where student_id='$student_id'";
                    $query4_run=mysqli_query($connect, $query4);
                    $address_rows=mysqli_num_rows($query4_run);
                    $address_data=mysqli_fetch_assoc($query4_run);
                ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Address details <?php if($address_rows>0){ ?>
								<a href="edit_address_details?student_id=<?= $student_id; ?>&&student_code=&&address_id=<?= $address_data['id']; ?>" class="pull-right">
									<i class="fa fa-edit">
										</i>
										Edit
										</a>
										<?php 
											}
											else{ 
										?>
										<a href="add_address_details?student_id=<?= $student_id; ?>&&student_code=" class="pull-right">
										<i class="fa fa-plus">
										</i>
										Add 
										</a>
										<?php
											} 
										?>
										</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p><b>Present Address:</b> <?= $address_data['present_address']; ?></p>
                                              
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <p><b>City:</b> <?= $address_data['present_city']; ?></p>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <p><b>State:</b> <?= $address_data['present_state']; ?></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><b>Postal Code:</b> <?= $address_data['present_pincode']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p><b>Permanent Address:</b> <?= $address_data['permanent_address']; ?></p>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <p><b>City:</b> <?= $address_data['permanent_city']; ?></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><b>State:</b> <?= $address_data['permanent_state']; ?></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><b>Postal Code:</b> <?= $address_data['permanent_pincode']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                    $query5="select * from contact_details where student_id='$student_id'";
                    $query5_run=mysqli_query($connect, $query5);
                    $contact_rows=mysqli_num_rows($query5_run);
                    $contact_data=mysqli_fetch_assoc($query5_run);
                ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Contact details <?php if($contact_rows>0){ ?><a href="edit_contact_details?student_id=<?= $student_id; ?>&&student_code=&&contact_id=<?= $contact_data['id']; ?>" class="pull-right">
							<i class="fa fa-edit"></i> Edit </a> 
							<?php 
								}else{ 
							?>
							<a href="add_contact_details?student_id=<?= $student_id; ?>&&student_code=" class="pull-right"><i class="fa fa-plus"></i> Add </a><?php } ?></div>
								<div class="panel-body">
									<div class="row">
                                    <div class="col-lg-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <h5>Parent</h5>
                                                <hr>
                                                <p><b>Mobile:</b> <?= $contact_data['parent_mobile']; ?></p>
                                                
                                                <p><b>Email:</b> <?= $contact_data['parent_email']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <h5>Alternative</h5>
                                                <hr>
                                                <p><b>Mobile:</b> <?= $contact_data['alternate_mobile']; ?></p>
                                                
                                                <p><b>Email:</b> <?= $contact_data['alternate_email']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <h5>Neighbour</h5>
                                                <hr>
                                                <p><b>Mobile:</b> <?= $contact_data['neighbour_mobile']; ?></p>
                                                
                                                <p><b>Email:</b> <?= $contact_data['neighbour_email']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Family details <a href="add_family_details?student_id=<?= $student_id; ?>&&student_code=" class="pull-right"><i class="fa fa-plus"></i> Add new </a></div>
                            <div class="panel-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Relation</th>
                                            <th>Education</th>
                                            <th>Service/ Business</th>
                                            <th>Monthly income</th>
                                            <th>Other Monthly income</th>
                                            
                                            <th>Income certificate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    $count=0;
                                    $query8="select * from family_details where student_id='$student_id'";
                                    $query8_run=mysqli_query($connect, $query8);
                                    while ($family_data=mysqli_fetch_assoc($query8_run))
                                    {
                                        $count++;
                                ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?= $family_data['name']; ?></td>
                                            <td><?= $family_data['relation']; ?></td>
                                            <td><?= $family_data['education']; ?></td>
                                            <td><?= $family_data['profession']; ?></td>
                                            <td><?php echo number_format($family_data['monthly_income']); ?></td>
                                            <td><?php echo number_format($family_data['other_monthly_income']); ?></td>
                                            
                                            <td><?= $family_data['income_cert_submitted']; ?> <?php if($family_data['income_cert_submitted']=='Yes'){ ?><a target="_blank" href="income_cert_viewer?file_name=<?= $family_data['income_certificate_path']; ?>" class="btn btn-primary pull-right"><i class="fa fa-file-image-o"></i>View</a><?php } ?></td>
                                            <td><a href="edit_family_details?student_id=<?= $student_id; ?>&&student_code=&&family_id=<?= $family_data['id']; ?>"><i class="fa fa-edit"></i> Edit </a> &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_family_detail_<?php echo $family_data['id']; ?>" class="text-danger" onclick="delete_family_detail(<?php echo $family_data['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Educational details <a href="add_educational_details?student_id=<?= $student_id; ?>&&student_code=" class="pull-right"><i class="fa fa-plus"></i> Add new </a></div>
                            <div class="panel-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Class</th>
                                            <th>Academic year</th>
                                            <th>Marks Type</th>
                                            <th>Extra examinations appeared</th>
                                            <th>Marks Obtained</th>
                                            <th>Result</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    $count=0;
                                    $query9="select * from educational_details where student_id='$student_id'";
                                    $query9_run=mysqli_query($connect, $query9);
                                    while ($educational_data=mysqli_fetch_assoc($query9_run))
                                    {
                                        $count++;
                                ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?= $educational_data['class']; ?></td>
                                            <td><?= $educational_data['academic_year']; ?></td>
                                            <td><?= $educational_data['type']; ?></td>
                                            <td><?= $educational_data['extra_exam_appeared']; ?></td>
                                            <td><?= $educational_data['marks_units']; ?></td>
                                            <td><?= $educational_data['result']; ?></td>
                                            <td><a href="edit_educational_details?student_id=<?= $student_id; ?>&&student_code=&&educational_id=<?= $educational_data['id']; ?>"><i class="fa fa-edit"></i> Edit </a> &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_educational_detail_<?php echo $educational_data['id']; ?>" class="text-danger" onclick="delete_educational_detail(<?php echo $educational_data['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                   
                <?php
                    $query6="select * from career_plan where student_id='$student_id'";
                    $query6_run=mysqli_query($connect, $query6);
                    $career_rows=mysqli_num_rows($query6_run);
                    $career_data=mysqli_fetch_assoc($query6_run);
                ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Career plan <?php if($career_rows>0){ ?><a href="edit_career_plan?student_id=<?= $student_id; ?>&&student_code=&&career_id=<?= $career_data['id']; ?>" class="pull-right"><i class="fa fa-edit"></i> Edit </a> <?php }else{ ?><a href="add_career_plan?student_id=<?= $student_id; ?>&&student_code=" class="pull-right"><i class="fa fa-plus"></i> Add </a><?php } ?></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p><b>Career plan:</b> <?= $career_data['career_plan']; ?></p>
                                                <p><b>Explanation:</b> <?= $career_data['career_explanation']; ?></p>
                                                <hr>
                                                <p><b>Earn and Learn:</b> <?= $career_data['earn_and_learn']; ?></p>
                                                <p><b>Explanation:</b> <?= $career_data['earn_and_learn_explanation']; ?></p>
                                                <hr>
                                                <p><b>Whether parent can contribute:</b> <?= $career_data['parent_contribution']; ?></p>
                                                <p><b>Explanation:</b> <?= $career_data['parent_contribution_explanation']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Budgeted / Projected Expenses <div class="pull-right">
							<a href="add_expenses?student_id=<?= $student_id; ?>&&student_code=" >
							<i class="fa fa-plus">
							</i>
							Add new
							</a>
							&nbsp;&nbsp;&nbsp; 
							<a target="_blank" href="letter?student_id=<?= $student_id; ?>&&student_code=" class="text-success">
							<i class="fa fa-print">
							</i>
							Print Letter 
							</a>
							</div>
						</div>
                            <div class="panel-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Year</th>
                                          
                                            <th>Budgeted expenses</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    $count=0;
                                    $query12="select * from budgeted_expenses where student_id='$student_id'";
                                    $query12_run=mysqli_query($connect, $query12);
                                    while ($expenses_data=mysqli_fetch_assoc($query12_run))
                                    {
                                        $count++;
                                ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?= $expenses_data['academic_year']; ?></td>
                                           <!-- <td><?= $expenses_data['expense_criteria']; ?></td>-->
                                            <td>$. <?php echo number_format($expenses_data['budgeted_expenses']); ?></td>
                                            <td><a href="edit_expenses?student_id=<?= $student_id; ?>&&student_code=&&expense_id=<?= $expenses_data['id']; ?>"><i class="fa fa-edit"></i> Edit </a> &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_expense_<?php echo $expenses_data['id']; ?>" class="text-danger" onclick="delete_expense(<?php echo $expenses_data['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Student Documents <a href="add_student_documents?student_id=<?= $student_id; ?>&&student_code=" class="pull-right"><i class="fa fa-plus"></i> Add new </a></div>
                            <div class="panel-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Document type</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    $count=0;
                                    $query13="select * from student_docs where student_id='$student_id'";
                                    $query13_run=mysqli_query($connect, $query13);
                                    while ($document_data=mysqli_fetch_assoc($query13_run))
                                    {
                                        $count++;
                                ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?= $document_data['doc_type']; ?></td>
                                            <td><?= $document_data['description']; ?></td>
                                            <td><?php if(!empty($document_data['file_path']) && $document_data['file_path']!=''){ ?><a target="_blank" href="stud_docs_viewer?file_name=<?= $document_data['file_path']; ?>" class="btn btn-primary pull-right"><i class="fa fa-file-image-o"></i>View</a><?php } ?> <a href="edit_student_documents?student_id=<?= $student_id; ?>&&student_code=&&document_id=<?= $document_data['id']; ?>"><i class="fa fa-edit"></i> Edit </a> &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_student_document_<?php echo $document_data['id']; ?>" class="text-danger" onclick="delete_student_document(<?php echo $document_data['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                                <?php
                                    }
                                ?>   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                    $query7="select * from referral_details where student_id='$student_id'";
                    $query7_run=mysqli_query($connect, $query7);
                    $referral_rows=mysqli_num_rows($query7_run);
                    $referral_data=mysqli_fetch_assoc($query7_run);
                ?>
                   
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Monthly Reports <?php if($month_start_date<=$date && $date<=$month_end_date){ ?><a href="add_monthly_performance?student_id=<?= $student_id; ?>&&student_code=" class="pull-right"><i class="fa fa-plus"></i> Add new </a> <?php } ?></div>
                            <div class="panel-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Report for Month</th>
                                            <th>Report for Year</th>
                                            <th>Submitted by the concerned Employee</th>
                                            <th>Date Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                                $count=0;
                                $query14="SELECT monthly_reports.id, monthly_reports.year, monthly_reports.month, monthly_reports.submission_date, admin.first_name as admin_fname, admin.last_name as admin_lname FROM monthly_reports left join admin on monthly_reports.submitted_by_admin=admin.id where monthly_reports.student_id='$student_id' order by monthly_reports.id desc";
                                $query14_run=@mysqli_query($connect, $query14);
                                while ($monthly_result=@mysqli_fetch_assoc($query14_run))
                                {
                                    $count++;
                            ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?php echo date("F", strtotime($monthly_result['submission_date'])); ?></td>
                                            <td><?= $monthly_result['year']; ?></td>
                                            <td><?= $monthly_result['admin_fname'].' '.$monthly_result['admin_lname']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($monthly_result['submission_date'])); ?></td>
                                            <td><a class="text-success"><i class="fa fa-eye"></i></a> 
                                                <?php 
                                                    if($admin_type=='kp')
                                                    {
                                                        if($month_start_date<=$date && $date<=$month_end_date)
                                                        { 
                                                ?>
                                                        &nbsp;&nbsp;<a href="edit_monthly_performance?student_id=<?= $student_id; ?>&&monthly_report_id=<?= $monthly_result['id']; ?>"><i class="fa fa-edit"></i> Edit </a>
                                                <?php 
                                                        } 
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        &nbsp;&nbsp;<a href="edit_monthly_performance?student_id=<?= $student_id; ?>&&monthly_report_id=<?= $monthly_result['id']; ?>"><i class="fa fa-edit"></i> Edit </a>
                                                <?php
                                                    }
                                                ?> 
                                                &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_monthy_report_<?php echo $monthly_result['id']; ?>" class="text-danger" onclick="delete_monthly_report(<?php echo $monthly_result['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                            <?php
                                }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Annual Report </div>
                            <div class="panel-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Report for the Year</th>
                                            <th>Submitted by the concerned Employee</th>
                                            <th>Date Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php
                            $count=0;
                            $query15="SELECT annual_reports.id, annual_reports.student_id, annual_reports.year, annual_reports.submission_date, admin.first_name as admin_fname, admin.last_name as admin_lname FROM annual_reports left join admin on annual_reports.submitted_by_admin=admin.id where annual_reports.student_id='$student_id' order by annual_reports.id desc";
                            $query15_run=@mysqli_query($connect, $query15);
                            while ($annual_result=@mysqli_fetch_assoc($query15_run))
                            {
                                $count++;
                        ?>
                                        <tr>
                                            <td><?= $count; ?></td>
                                            <td><?= $annual_result['year']; ?></td>
                                            <td><?= $annual_result['admin_fname'].' '.$annual_result['admin_lname']; ?></td>
                                            <td><?php echo date('m/d/Y', strtotime($annual_result['submission_date'])); ?></td>
                                            <td><a class="text-success"><i class="fa fa-eye"></i> </a> 
                                                <?php 
                                                    if($admin_type=='kp')
                                                    {
                                                        if($month_start_date<=$date && $date<=$month_end_date)
                                                        { 
                                                ?>
                                                        &nbsp;&nbsp;<a href="edit_annual_performance?student_id=<?= $student_id; ?>&&annual_report_id=<?= $annual_result['id']; ?>"><i class="fa fa-edit"></i> Edit </a>
                                                <?php 
                                                        } 
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        &nbsp;&nbsp;<a href="edit_annual_performance?student_id=<?= $student_id; ?>&&annual_report_id=<?= $annual_result['id']; ?>"><i class="fa fa-edit"></i> Edit </a>
                                                <?php
                                                    }
                                                ?> 
                                                &nbsp;&nbsp;<a href="javascript:void(0);" id="delete_annual_report_<?php echo $annual_result['id']; ?>" class="text-danger" onclick="delete_annual_report(<?php echo $annual_result['id']; ?>)" ><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                        <?php
                            }
                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <?php
                if($student_data['remark_by_commitee'])
                {
            ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Remarks by Admission committee (FOR OFFICE USE ONLY)</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p><br/><?= $student_data['remark_by_commitee']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
                    <div class="col-md-12">
                        <a href="students" type="button" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Back to students</a>
                    </div>
                </div>
        <?php 
                }
                else
                {
        ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <center>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <h3>This student is not alloted to you.</h3>
                                        <h4>Your username and IP is being traced for each such activity.</h4>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
            else
            {
        ?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <center>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <h3>No student found with this ID.</h3>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
            </div>

            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Application Status Action</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" action="student_details?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
                                <div class="form-group">
                                    <label for="application_status">Application Status*</label>
                                    <select class="form-control" id="application_status" name="application_status" data-placeholder="Application Status*" onchange="show_form();" onselect="show_form();" onclick="show_form();" required>
                                        <option></option>
                                        <option value="Pending" <?php if($student_data['status']!='' && $student_data['status']=='Pending'){ echo 'selected'; } ?>>Pending</option>
                                        <option value="Rejected" <?php if($student_data['status']!='' && $student_data['status']=='Rejected'){ echo 'selected'; } ?>>Rejected</option>
                                        <option value="Enrolled" <?php if($student_data['status']!='' && $student_data['status']=='Enrolled'){ echo 'selected'; } ?>>Enrolled</option>
                                    </select>
                                </div>
                                <div class="form-group" id="kp_alloted_div" style="display: none;">
                                    <label for="kp_alloted">Employee Alloted*</label>
                                    <select class="form-control" id="kp_alloted" name="kp_alloted" data-placeholder="Employee Alloted">
                                        <option value="0"<?php if(!empty($kp_assigned_id) && $kp_assigned_id==0){ echo 'selected'; } ?>>Not alloted</option>
                        <?php
                                $query1="select * from admin where type='kp' order by vsm_branch";
                                $query1_run=mysqli_query($connect, $query1);
                                while($kp_data=mysqli_fetch_assoc($query1_run))
                                {
                        ?>  
                                        <option value="<?php echo $kp_data['id']; ?>" <?php if(!empty($kp_assigned_id) && $kp_assigned_id==$kp_data['id']){ echo 'selected'; } ?>> <?php echo $kp_data['first_name'].' '.$kp_data['middle_name'].' '.$kp_data['last_name'].' ('.$kp_data['vsm_branch'].') '; ?> </option>
                        <?php
                                }
                        ?> 
                                    </select>
                                </div>
                                <div class="form-group" id="start_end_date_div" style="display: none;">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <label for="start_date">Start Date</label>
                                            <div class='input-group date datepicker'>
                                                <input type='text' class="form-control" id="start_date" name="start_date" value="<?= $kp_start_date; ?>" data-date-format="YYYY/MM/DD"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>Date from which an Employee will be assigned to that student.
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-group" id="remark_by_commitee_div" style="display: none;">
                                    <label for="remark_by_commitee">Remark by Admission Commitee</label>
                                    <textarea class="form-control" id="remark_by_commitee" name="remark_by_commitee" required><?= $student_data['remark_by_commitee']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" id="submit_status" name="submit_status" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
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
            function delete_family_detail(id){
               var retVal = confirm("Do you really want to delete this family member ?");
               var $tr = $("#delete_family_detail_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_family_detail.php",
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
                  alert("You wants to keep this family member !");
                }
            }
        </script>

        <script type="text/javascript">
            function delete_educational_detail(id){
               var retVal = confirm("Do you really want to delete this educational detail ?");
               var $tr = $("#delete_educational_detail_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_educational_detail.php",
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
                  alert("You wants to keep this educational detail !");
                }
            }
        </script>

        <script type="text/javascript">
            function delete_assistance_detail(id){
               var retVal = confirm("Do you really want to delete this assistance detail ?");
               var $tr = $("#delete_assistance_detail_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_assistance_detail.php",
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
                  alert("You wants to keep this assistance detail !");
                }
            }
        </script>

        <script type="text/javascript">
            function delete_academic_performance(id){
               var retVal = confirm("Do you really want to delete this academic performance ?");
               var $tr = $("#delete_academic_performance_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_academic_performance.php",
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
                  alert("You wants to keep this academic performance !");
                }
            }
        </script>

        <script type="text/javascript">
            function delete_expense(id){
               var retVal = confirm("Do you really want to delete this expense ?");
               var $tr = $("#delete_expense_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_expense.php",
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
                  alert("You wants to keep this expense !");
                }
            }
        </script>

        <script type="text/javascript">
            function delete_student_document(id){
               var retVal = confirm("Do you really want to delete this document ?");
               var $tr = $("#delete_student_document_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_student_document.php",
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
                  alert("You wants to keep this document !");
                }
            }
        </script>

        <script type="text/javascript">
            function delete_monthly_report(id){
               var retVal = confirm("Do you really want to delete this report ?");
               var $tr = $("#delete_monthy_report_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
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

        <script type="text/javascript">
            function delete_annual_report(id){
               var retVal = confirm("Do you really want to delete this report ?");
               var $tr = $("#delete_annual_report_"+id).closest('tr');
               var student_id = '<?php echo $student_id ?>';
               if( retVal == true )
                {
                  $.ajax({
                       type: "POST",
                       url: "delete_annual_report.php",
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

        <script type="text/javascript">
            $(document).ready(function(){
                show_form();
            })
        </script>

        <script type="text/javascript">
              function show_form(){
                var application_status = $('#application_status').val();

                if(application_status=='Enrolled')
                {
                    $('#kp_alloted_div').css("display", "block");
                    
                    $('#start_end_date_div').css("display", "block");      
                  
                    $('#remark_by_commitee_div').css("display", "block");
                    
                }
                else if(application_status=='Pending')
                {
                    $('#kp_alloted_div').css("display", "none");
                   
                    $('#start_end_date_div').css("display", "none");

                    $('#remark_by_commitee_div').css("display", "none");
                    
                }
                else if(application_status=='Rejected')
                {
                    $('#kp_alloted_div').css("display", "none");
                    
                    $('#start_end_date_div').css("display", "none");
                    
                    $('#remark_by_commitee_div').css("display", "block");
                    
                }
                else
                {
                    $('#kp_alloted_div').css("display", "none");
                   
                    $('#start_end_date_div').css("display", "none");
                    
                    $('#remark_by_commitee_div').css("display", "none");
                   
                }
              };
        </script>

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

