<aside class="left-panel">
    
<?php
    $admin_id=$_SESSION['admin_id'];
    $admin_type=$_SESSION['admin_type'];
    $query20="SELECT first_name FROM admin WHERE id='$admin_id'";
    $query20_run=mysqli_query($connect, $query20);
    $admin_data=mysqli_fetch_assoc($query20_run);
    $admin_fname=$admin_data['first_name'];
?>		
    <div class="user text-center">
        <img src="../images/logo.jpg" class="img-circle" alt="...">
        <h4 class="user-name"><?= $admin_fname; ?></h4>
    </div>
            
            <!-- <?php isset($page)?$page:''; ?> -->

    <nav class="navigation">
        <ul class="list-unstyled">
            <li <?php if(isset($page) && $page == 'dashboard') {
				echo 'class="active"';
				}
				?>>
			<a href="dashboard">
			<i class="fa fa-dashboard">
			</i>
			<span class="nav-label">
			Dashboard
			</span>
			</a>
			</li> 
		<?php
			if($admin_type!='kp')
			{
		?>
            <li <?php 
				if(isset($page) && ($page == 'applications' || $page == 'applications?type=Enrolled' || $page == 'applications?type=Rejected' || $page == 'applications?type=Pending')){
					echo 'class="has-submenu active"';
				}
				else{
					echo 'class="has-submenu"'; 
					}
			?>>
			<a href="#">
			<i class="fa fa-edit">
			</i>
			<span class="nav-label">Applications</span>
			</a>
                <ul class="list-unstyled">
                    <li <?php if(isset($page) && $page == 'applications') {echo 'class="active"';} ?>>
					<a href="applications">All Applications</a>
					</li>
                    <li <?php if(isset($page) && $page == 'applications?type=Pending') {echo 'class="active"';} ?>>
					<a href="applications?type=Pending">Pending Applications</a>
					</li>
                    <li <?php if(isset($page) && $page == 'applications?type=Enrolled') {echo 'class="active"';} ?>>
					<a href="applications?type=Enrolled">Enrolled Applications</a>
					</li>
                    <li <?php if(isset($page) && $page == 'applications?type=Rejected') {echo 'class="active"';} ?>>
					<a href="applications?type=Rejected">Rejected Applications</a>
					</li>
                </ul>
            </li>
    <?php
        }
    ?>
		    <li <?php if(isset($page) && $page == 'students') {echo 'class="active"';} ?>>
			<a href="students">
			<i class="fa fa-graduation-cap">
			</i>
			<span class="nav-label">Students</span>
			</a>
			</li>
    <?php
        if($admin_type!='kp')
        {
    ?>
		    <li <?php if(isset($page) && $page == 'karyakarta_palak') {echo 'class="active"';} ?>>
			<a href="karyakarta_palak">
			<i class="fa fa-user">
			</i>
			<span class="nav-label">Employees</span>
			</a>
			</li>
    <?php
        }
    ?>
            <li <?php if(isset($page) && ($page == 'monthly_reports' || $page == 'annual_reports')) {echo 'class="active"';} ?> class="has-submenu">
			<a href="#">
			<i class="fa fa-bar-chart">
			</i>
			<span class="nav-label">Reports</span>
			</a>
            <ul class="list-unstyled">
                    <li <?php if(isset($page) && $page == 'monthly_reports') {echo 'class="active"';} ?>>
					<a href="monthly_reports">Monthly Performance Reports</a>
					</li>
                    <li <?php if(isset($page) && $page == 'annual_reports') {echo 'class="active"';} ?>>
					<a href="annual_reports">Annual Performance Reports</a>
					</li>
                </ul>
            </li>
            <li <?php 
					if(isset($page) && $page == 'budgeting') {
						echo 'class="active"';
					}
				?>>
			<a href="budgeting">
			<i class="fa fa-user">
			</i>
			<span class="nav-label">Budgeting</span>
			</a>
			</li>
    <?php
        if($admin_type!='kp')
        {
    ?>
            <li <?php
					if(isset($page) && ($page == 'settings' || $page == 'decoding' || $page == 'events')) {
						echo 'class="has-submenu active"';
					}
					else{
						echo 'class="has-submenu"';
					}
				?>>
			<a href="#">
			<i class="fa fa-cog">
			</i>
			<span class="nav-label">Settings</span>
			</a>
                <ul class="list-unstyled">
                    <li <?php if(isset($page) && $page == 'decoding') {echo 'class="active"';} ?>>
					<a href="decoding">Overall Scroll Down Options</a>
					</li>
                    <li <?php if(isset($page) && $page == 'events') {echo 'class="active"';} ?>>
					<a href="events">All the Events</a>
					</li>
                </ul>
            </li>
            <li <?php if(isset($page) && $page == 'system_logs') {echo 'class="active"';} ?>>
			<a href="system_logs">
			<i class="fa fa-clock-o">
			</i>
			<span class="nav-label">System Logs</span>
			</a>
			</li>
    <?php
        }
    ?>
			<li class=""><a href="logout">
			<i class="fa fa-arrow-left">
			</i>
			<span class="nav-label">Logout</span>
			</a>
			</li>
		</ul>
    </nav>       
</aside>