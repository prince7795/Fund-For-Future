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
	ini_set( 'date.timezone', 'US/Eastern' );
	$date=date("m/d/Y h:i:s A");
	$msg='';

	if(isset($_POST['vsm_branch']) && isset($_POST['kp_first_name'])
		&& isset($_POST['kp_surname']) && isset($_POST['kp_dob'])
		&& isset($_POST['kp_permanant_address']) && isset($_POST['kp_current_address'])
		&& isset($_POST['kp_email']) && isset($_POST['password']) && isset($_POST['kp_mobile'])
		&& isset($_POST['kp_qualification']) && isset($_POST['kp_occupation'])
		&& isset($_POST['meeting_location']) && isset($_POST['how_you_know']))
	{
		$vsm_branch=str_replace("'", "\'", $_POST['vsm_branch']);
		$kp_first_name=str_replace("'", "\'", $_POST['kp_first_name']);
		$kp_middle_name=str_replace("'", "\'", $_POST['kp_middle_name']);
		$kp_surname=str_replace("'", "\'", $_POST['kp_surname']);
		$kp_dob=str_replace("'", "\'", $_POST['kp_dob']);
		$kp_permanant_address=str_replace("'", "\'", $_POST['kp_permanant_address']);
		$kp_current_address=str_replace("'", "\'", $_POST['kp_current_address']);
		$kp_email=str_replace("'", "\'", $_POST['kp_email']);
		$kp_alternative_email=str_replace("'", "\'", $_POST['kp_alternative_email']);
		$password=str_replace("'", "\'", $_POST['password']);
		$kp_mobile=str_replace("'", "\'", $_POST['kp_mobile']);
		$kp_alternative_mobile=str_replace("'", "\'", $_POST['kp_alternative_mobile']);
		$kp_qualification=str_replace("'", "\'", $_POST['kp_qualification']);
		$kp_specialization=str_replace("'", "\'", $_POST['kp_specialization']);
		$kp_occupation=str_replace("'", "\'", $_POST['kp_occupation']);
		$kp_additional_skills=str_replace("'", "\'", $_POST['kp_additional_skills']);
		$ngo_work_experiance=str_replace("'", "\'", $_POST['ngo_work_experiance']);
		$ngo_explanation=str_replace("'", "\'", $_POST['ngo_explanation']);
		$meeting_location=str_replace("'", "\'", $_POST['meeting_location']);
		$mentor_volunteer=str_replace("'", "\'", $_POST['mentor_volunteer']);

		
		/*$overall_governance=$_POST['overall_governance'];
		$overall_governance_names ="";
		foreach ($overall_governance as $data)
		{
			$overall_governance_names[] .= $data;
		}
		$imploded_overall_governance_names= implode(', ', $overall_governance_names);
		
		
		$overall_administration=$_POST['overall_administration'];
		$overall_administration_names ="";
		foreach ($overall_administration as $data)
		{
			$overall_administration_names[] .= $data;
		}
		$imploded_overall_administration_names= implode(', ', $overall_administration_names);


		$academic=$_POST['academic'];
		$academic_names ="";
		foreach ($academic as $data)
		{
			$academic_names[] .= $data;
		}
		$imploded_academic_names= implode(', ', $academic_names);
		
		
		$accounts=$_POST['accounts'];
		$accounts_names ="";
		foreach ($accounts as $data)
		{
			$accounts_names[] .= $data;
		}
		$imploded_accounts_names= implode(', ', $accounts_names);
		
		
		$event_management=$_POST['event_management'];
		$event_management_names ="";
		foreach ($event_management as $data)
		{
			$event_management_names[] .= $data;
		}
		$imploded_event_management_names= implode(', ', $event_management_names);
		
		
		$public_relations=$_POST['public_relations'];
		$public_relations_names ="";
		foreach ($public_relations as $data)
		{
			$public_relations_names[] .= $data;
		}
		$imploded_public_relations_names= implode(', ', $public_relations_names);
		
		
		$database_management=$_POST['database_management'];
		$database_management_names ="";
		foreach ($database_management as $data)
		{
			$database_management_names[] .= $data;
		}
		$imploded_database_management_names= implode(', ', $database_management_names);
		
		
		$reports=$_POST['reports'];
		$reports_names ="";
		foreach ($reports as $data)
		{
			$reports_names[] .= $data;
		}
		$imploded_reports_names= implode(', ', $reports_names);*/
		
		
		$how_you_know=str_replace("'", "\'", $_POST['how_you_know']);
		$how_you_know_explain=str_replace("'", "\'", $_POST['how_you_know_explain']);
		$any_other_info=str_replace("'", "\'", $_POST['any_other_info']);
		

		if(!empty($_POST['vsm_branch']) && !empty($_POST['kp_first_name'])
			&& !empty($_POST['kp_surname']) && !empty($_POST['kp_dob'])
			&& !empty($_POST['kp_permanant_address']) && !empty($_POST['kp_current_address'])
			&& !empty($_POST['kp_email']) && !empty($_POST['password']) && !empty($_POST['kp_mobile'])
			&& !empty($_POST['kp_qualification']) && !empty($_POST['kp_occupation'])
			&& !empty($_POST['meeting_location']) && !empty($_POST['how_you_know']))
		{
			$query2="INSERT INTO `admin`(`type`, `first_name`, `middle_name`, `last_name`, `email`,
										`password`, `kp_code`, `vsm_branch`, `dob`, `permanent_address`,
										`current_address`, `alternate_email`, `mobile_number`, `alternative_number`,
										`academic_qualification`, `academic_specialization`, `occupation`, `additional_skills`,
										`worked_in_ngo`, `ngo_explanation`, `meeting_location`, `mentor_voluneer`, 
										`overall_governance`, `overall_administration`, `academic`, `accounts`, `event_management`,
										`public_relation`, `db_preparation`, `reports`, `how_know_vsm`, `how_know_vsm_explanation`,
										`any_other_info`, `submitted_by_admin`, `submission_date`)
										VALUES ('kp', '$kp_first_name', '$kp_middle_name', '$kp_surname', '$kp_email', 
												'$password', '$kp_code', '$vsm_branch', '$kp_dob', '$kp_permanant_address', 
												'$kp_current_address', '$kp_alternative_email', '$kp_mobile', '$kp_alternative_mobile',
												'$kp_qualification', '$kp_specialization', '$kp_occupation', '$kp_additional_skills',
												'$ngo_work_experiance', '$ngo_explanation', '$meeting_location', '$mentor_volunteer',
												'$imploded_overall_governance_names', '$imploded_overall_administration_names',
												'$imploded_academic_names', '$imploded_accounts_names', '$imploded_event_management_names',
												'$imploded_public_relations_names', '$imploded_database_management_names',
												'$imploded_reports_names', '$how_you_know', '$how_you_know_explain',
												'$any_other_info', '$admin_id', '$date')";
												
			$query2_run=mysqli_query($connect,$query2);
			if(mysqli_affected_rows($connect)>0)
			{
				$last_id = mysqli_insert_id($connect);

				$query21="INSERT INTO `system_logs`(`admin_id`, `module`, `action`, `time`)
								VALUES ('$admin_id', 'KP', 'add', '$date')";
													
                $query21_run=mysqli_query($connect,$query21);

				$msg='<center><div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						  </button>
						  Employee Details submitted successfully.
						</div></center>';

				header('Refresh:1; url=karyakarta_palak');
			}
			else
			{
				$msg='<center><div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						  </button>
						  Unable to submit the Employee details!
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
		<?php $page='karyakarta_palak'; ?>
		<?php include 'include/sidebar-admin.php';?>
		<!-- Aside Ends-->
		<section class="content">
			<?php include 'include/header.php'; ?>
			<!-- Header Ends -->
			<div class="wrapper container-fluid">
				<div class="page-header">
					<h3>New Employee</h3>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">Create New Employee</div>
							<div class="panel-body">
					<?php
		                $admin_id=$_SESSION['admin_id'];
		                $admin_type=$_SESSION['admin_type'];

		                if($admin_type!='kp')
		                {
		            ?>
							<?php
								if(isset($msg)){
									echo $msg;
								} 
							?>
								<form class="form-horizontal" action="add_karyakarta_palak" method="POST">
									<br/>
									<div class="form-group">
										<label class="col-sm-2 control-label">Employee Branch*</label>
										<div class="col-sm-3">
											<select class="form-control chosen-select" name="vsm_branch" data-placeholder="Employee Branch Allotted" required>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='vsm-branch' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($vsm_branch=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $vsm_branch['value']; ?>"> <?php echo $vsm_branch['description']; ?> </option>
								<?php
										}
								?>                                   
											</select>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Employee Name*</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="kp_first_name" placeholder="First Name*" required>
											Do not enter PREFIX such as, Mr/Ms/Mrs.
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="kp_middle_name" placeholder="Middle name">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="kp_surname" placeholder="Surname*" required>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Date of Birth*</label>
										<div class="col-sm-3">
											<div class='input-group date datepicker'>
												<input type='text' class="form-control" name="kp_dob" data-date-format="YYYY/MM/DD" required />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											Note : Format should be strictly yyyy/mm/dd.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Current Address*</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="kp_current_address" placeholder="Full address*" required></textarea>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Permanent Address*</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="kp_permanant_address" placeholder="Full address*" required></textarea>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Email*</label>
										<div class="col-sm-3">
											<input type="email" class="form-control" name="kp_email" placeholder="Email*" required>
											<b>Will be used as your username for future login</b>.
										</div>
										<label class="col-sm-2 control-label">Alternative Email</label>
										<div class="col-sm-3">
											<input type="email" class="form-control" name="kp_alternative_email" placeholder="Alternative Email">
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Password*</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="password" placeholder="Password*" required>
											<b>Password for future login</b>.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Mobile Number*</label>
										<div class="col-sm-3">
											<input type="number" class="form-control" min="0" max="9999999999" maxlength="10" name="kp_mobile" placeholder="Mobile Number*" required>
										</div>
										<label class="col-sm-2 control-label">Alternative Number</label>
										<div class="col-sm-3">
											<input type="number" class="form-control" min="0" max="99999999999999" maxlength="14" name="kp_alternative_mobile" placeholder="Alternative Number">
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Academic Qualification*</label>
										<div class="col-sm-3">
											<select class="form-control chosen-select" name="kp_qualification" data-placeholder="Academic Qualification*" required="">
												<option></option>
								<?php
										$query1="select * from decoding where specifier='qualification' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($qualification=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $qualification['value']; ?>"> <?php echo $qualification['description']; ?> </option>
								<?php
										}
								?>
											</select>
										</div>
										<label class="col-sm-2 control-label">Academic Specialization </label>
										<div class="col-sm-3">
											<select class="form-control chosen-select" name="kp_specialization" data-placeholder="Academic Specialization">
												<option></option>
								<?php
										$query1="select * from decoding where specifier='academic_specialization' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($academic_specialization=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $academic_specialization['value']; ?>"> <?php echo $academic_specialization['description']; ?> </option>
								<?php
										}
								?>
											</select>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Occupation*</label>
										<div class="col-sm-5">
											<select class="form-control chosen-select" name="kp_occupation" data-placeholder="Occupation*" required>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='occupation' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($occupation=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $occupation['value']; ?>"> <?php echo $occupation['description']; ?> </option>
								<?php
										}
								?>
											</select>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Additional Skills/ Expertise/ Interests</label>
										<div class="col-sm-7">
											<textarea class="form-control" name="kp_additional_skills" placeholder="Additional Skills/ Expertise/ Interests"></textarea>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Do you have any Previous Experience of working in an NGO?</label>
										<div class="col-sm-3">
											<select class="form-control chosen-select" id="ngo_work_experiance" name="ngo_work_experiance" data-placeholder=""  onchange="show_ngo();">
												<option></option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</div>
									</div>
									<div class="form-group" id="ngo_explaination_div" style="display: none;">
										<label class="col-sm-2 control-label"></label>
										<div class="col-sm-7">
											<textarea class="form-control" id="ngo_explanation" name="ngo_explanation" placeholder="Describe Experience*"></textarea>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Future Employee Meeting Location*</label>
										<div class="col-sm-5">
											<select class="form-control chosen-select" name="meeting_location" data-placeholder="Future Employee Meeting Location*" required>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='vsm-branch' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($vsm_branch=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $vsm_branch['value']; ?>"> <?php echo $vsm_branch['description']; ?> </option>
								<?php
										}
								?> 
											</select>
										</div>
									</div>
									<!--<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">What are you ?</label>
										<div class="col-sm-4">
											<select class="form-control chosen-select" name="mentor_volunteer" data-placeholder="What are you ?">
												<option></option>
												<option value="Mentor">Mentor</option>
												<option value="Volunteer">Volunteer</option>
											</select>
										</div>
									</div>-->
									<!--<hr class="dotted">
									<h3 class="text-center">VSM Activites by Function</h3>
									<h5 class="text-center">KP/Volunteer should give Area of preference where he/she is sure of contributing time and efforts for VSM with required skill sets and expertise. IT SHOULD NOT BE  JUST A WISH LIST.</h5>
									<br/>
									<div class="form-group">
										<label class="col-sm-2 control-label">Overall Govergence</label>
										<div class="col-sm-5">
											<select class="form-control" name="overall_governance[]" data-placeholder="" multiple>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='overall_governance' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($overall_governance=mysqli_fetch_assoc($query1_run))
										{
								?>  
								
								<option value="<?php echo $overall_governance['value']; ?>">
								<?php
									echo $overall_governance['description'];
								?>
								</option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Overall Administration </label>
										<div class="col-sm-5">
											<select class="form-control" name="overall_administration[]" data-placeholder="" multiple>
												<option></option>
								<?php
									$query1="select * from decoding where specifier='overall_admin' order by specifier";
									$query1_run=mysqli_query($connect, $query1);
									while($overall_admin=mysqli_fetch_assoc($query1_run))
									{
								?>  
								<option value="<?php
												echo $overall_admin['value']; 
												?>">
								<?php
									echo $overall_admin['description'];
								?>
								</option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Academic </label>
										<div class="col-sm-5">
											<select class="form-control" name="academic[]" data-placeholder="" multiple>
												<option></option>
								<?php
									$query1="select * from decoding where specifier='academic' order by specifier";
									$query1_run=mysqli_query($connect, $query1);
									while($academic=mysqli_fetch_assoc($query1_run))
									{
								?>  
								<option value="<?php echo $academic['value']; ?>"> 
								<?php
									echo $academic['description'];
								?>
								</option>
								<?php
										}
								?>                                   
								</select>
								Note: for multiple values press CTRL and select.
								</div>
								</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Accounts </label>
										<div class="col-sm-5">
											<select class="form-control" name="accounts[]" data-placeholder="" multiple>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='accounts' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($accounts=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $accounts['value']; ?>"> <?php echo $accounts['description']; ?> </option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Event Management </label>
										<div class="col-sm-5">
											<select class="form-control" name="event_management[]" data-placeholder="" multiple>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='event_management' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($event_management=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $event_management['value']; ?>"> <?php echo $event_management['description']; ?> </option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Public Relations/Social Media </label>
										<div class="col-sm-5">
											<select class="form-control" name="public_relations[]" data-placeholder="" multiple>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='public-social' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($public_relations=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $public_relations['value']; ?>"> <?php echo $public_relations['description']; ?> </option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Database preparation & Management </label>
										<div class="col-sm-5">
											<select class="form-control" name="database_management[]" data-placeholder="" multiple>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='db-preparation' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($database_management=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $database_management['value']; ?>"> <?php echo $database_management['description']; ?> </option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Reports </label>
										<div class="col-sm-5">
											<select class="form-control" name="reports[]" data-placeholder="" multiple>
												<option></option>
								<?php
										$query1="select * from decoding where specifier='reports' order by specifier";
										$query1_run=mysqli_query($connect, $query1);
										while($reports=mysqli_fetch_assoc($query1_run))
										{
								?>  
												<option value="<?php echo $reports['value']; ?>"> <?php echo $reports['description']; ?> </option>
								<?php
										}
								?>                                   
											</select>
											Note: for multiple values press CTRL and select.
										</div>
									</div>-->
									<hr class="dotted">
									<h3 class="text-center">Additional Information</h3>
									<br/>
									<div class="form-group">
										<label class="col-sm-2 control-label">How did you come to know about Fund for a Future? *</label>
										<div class="col-sm-5">
											<select class="form-control chosen-select" id="how_you_know" name="how_you_know" data-placeholder=""  onchange="show_other();" required>
												<option></option>
												<option value="Through reference">Through reference</option>
												<option value="Through website">Through website</option>
												<option value="Through print media">Through print media</option>
												<option value="Other">Other</option>
											</select>
										</div>
									</div>
									<div class="form-group" id="how_you_know_other_div" style="display: none;">
										<label class="col-sm-2 control-label"></label>
										<div class="col-sm-7">
											<textarea class="form-control" id="how_you_know_explain" name="how_you_know_explain" placeholder="Describe Other*"></textarea>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<label class="col-sm-2 control-label">Any other information you wish to share which may be useful to the Employee/Office </label>
										<div class="col-sm-7">
											<textarea class="form-control" name="any_other_info" placeholder="">
											</textarea>
										</div>
									</div>
									<hr class="dotted">
									<div class="form-group">
										<div class="col-sm-6">
											<input type="submit" class="btn btn-primary pull-right" value="Submit">
										</div>
									</div>
								</form>
								<?php if(isset($msg)){
									echo $msg; 
								} 
								?>
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
			function show_other(){
				var how_you_know = $('#how_you_know').val();

				if(how_you_know=='Other')
				{
				  $('#how_you_know_other_div').css("display", "block");
				  $('#how_you_know_explain').prop('required', true);
				}
				else
				{
				  $('#how_you_know_other_div').css("display", "none");
				  $('#how_you_know_explain').prop('required', false);
				}
			};

			function show_ngo(){
				var ngo_work_experiance = $('#ngo_work_experiance').val();

				if(ngo_work_experiance=='Yes')
				{
				  $('#ngo_explaination_div').css("display", "block");
				  $('#ngo_explanation').prop('required', true);
				}
				else
				{
				  $('#ngo_explaination_div').css("display", "none");
				  $('#ngo_explanation').prop('required', false);
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