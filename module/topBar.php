<?php
// echo "My School in SetDefault $myScl";
$myName = getField($conn, $myId, "staff", "staff_id", "staff_name");
$myUserId = getField($conn, $myId, "staff", "staff_id", "user_id");

if (isset($myScl)) $mySclAbbri = getField($conn, $myScl, "school", "school_id", "school_abbri");
else $mySclAbbri = "Select School";
if (isset($myDept)) $myDeptAbbri = getField($conn, $myDept, "department", "dept_id", "dept_abbri");
else $myDeptAbbri = "Select Dept";
if (isset($myProg)) $myProgAbbri = getField($conn, $myProg, "program", "program_id", "sp_abbri");
else $myProgAbbri = "Select Prog";
if (isset($mySes)) $mySesName = getField($conn, $mySes, "session", "session_id", "session_name");
else $mySesName = "Select Session";
if (isset($myBatch)) $myBatchName = getField($conn, $myBatch, "batch", "batch_id", "batch");
else $myBatchName = "Select Batch";
if (!isset($myProg)) $myProg = '';
if (!isset($myBatch)) $myBatch = '';
?>
<header>
	<div class="py-2">
		<div class="row">
			<div class="col-2 ml-2">
				<img src="<?php echo $setLogo; // Defined in check_user ?>" height="37px">
				<?php echo $myFolder;?>
			</div>
			<div class="col ml-2 text-center">
				<?php
				echo $mySclAbbri . '[' . $myDeptAbbri . '] ';
				echo '<b>' . $mySesName . '</b>';
				//echo "School ".$myScl;
				?>
			</div>
			<div class="col mr-2">
				<?php
				echo $myProgAbbri . '[' . $myProg . ']-' . $myBatchName . '[' . $myBatch . ']';
				//echo "School ".$myScl;
				?>
			</div>
			<div class="col float-right">
				<input type="text" class="form-control form-control-sm" id="indexSearch" name="indexSearch" placeholder="Search Staff" aria-label="Search">
				<p class='list-group overlapList' id="indexAutoList"></p>
			</div>

			<div class="col mr-2">
				<!-- <a href="<?php echo $codePath . '/module/forms/'; ?>" class="float-right">&nbsp; Forms &nbsp;</a> -->
				<!-- <a href="" class="float-right">&nbsp; Downloads &nbsp;</a> -->
				<a href="<?php echo $codePath . '/access/admission/'; ?>" class="float-right" target="_blank">&nbsp; Admission &nbsp;</a>
			</div>
		</div>

	</div>

	<nav id="navbar_top" class="navbar navbar-expand-lg bg-two">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo $codePath . '/module/index.php'; ?>">ClassConnect</a>
			<!-- Collapse button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon">Menu</span>
			</button>

			<!-- Collapsible content -->
			<div class="collapse navbar-collapse" id="main_nav">
				<!-- Links -->
				<ul class="navbar-nav mr-auto">
					<!-- Dropdown -->
					<!-- Administration -->
					<?php
					if ($myId < 4) {
					?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ERP Admin</a>
							<div class="dropdown-menu menuDouble" aria-labelledby="navbarDropdownMenuLink">
								<div class="card border">
									<div class="row">
										<div class="col-6 pr-0">
											<a href="<?php echo $codePath . '/module/setting/'; ?>" class="dropdown-item py-0">Institite Settings</a>
											<a href="<?php echo $codePath . '/module/aa/'; ?>" class="dropdown-item py-0">Academic Settings </a>
											<a href="<?php echo $codePath . '/module/user/'; ?>" class="dropdown-item py-0">Users and Links</a>
										</div>
										<div class="col-6 pl-0">
											
										</div>
									</div>
								</div>
							</div>
						</li>

					<?php
					}
					?>
					<!-- Administration -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
						<div class="dropdown-menu menuDouble" aria-labelledby="navbarDropdownMenuLink">
							<div class="card border">
								<div class="row">
									<div class="col-6 pr-0">
										<a href="<?php echo $codePath . '/module/setting/'; ?>" class="dropdown-item py-0">Institite Settings</a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0">Infrastructure</a>
									</div>
									<div class="col-6 pl-0">
										<!-- <a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0">Committees</a> -->
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0">Status Report</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- Academics -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Academics</a>
						<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
							<div class="card myCard border">
								<div class="row">
									<div class="col-6 pr-0">
										<!-- <a href="<?php echo $codePath . '/module/curriculum/'; ?>" class="dropdown-item py-0">Curriculum Design </a> -->
										<a href="<?php echo $codePath . '/module/subject/'; ?>" class="dropdown-item py-0">Manage Subjects </a>
										<a href="<?php echo $codePath . '/module/teachingLoad/'; ?>" class="dropdown-item py-0">Teaching Load</a>
										<a href="<?php echo $codePath . '/module/schedule/'; ?>" class="dropdown-item py-0">Schedule</a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/registration/'; ?>" class="dropdown-item py-0">Registration</a>
										<a href="<?php echo $codePath . '/module/lms/'; ?>" class="dropdown-item py-0">LMS</a>
										<a href="<?php echo $codePath . '/module/acReport/'; ?>" class="dropdown-item py-0">Academic Reports</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- Assessments -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assessment</a>
						<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
							<div class="card myCard border">
								<div class="row">
									<div class="col-6 pr-0">
										<a href="<?php echo $codePath . '/module/assessment/'; ?>" class="dropdown-item py-0">Assessment Design</a>
										<a href="<?php echo $codePath . '/module/online/'; ?>" class="dropdown-item py-0">Online Assessment</a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Internal Assessment </a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Exam Setting </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Conduct </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Semester Result </a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- Staff -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="hr/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
						<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
							<div class="card myCard border">
								<div class="row">
									<div class="col-6 pr-0">
										<a href="<?php echo $codePath . '/module/hr/'; ?>" class="dropdown-item py-0">Manage Staff</a>
										<a href="<?php echo $codePath . '/module/leave/'; ?>" class="dropdown-item py-0">Leave</a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Staff Event </a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Support </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Research </a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- Student -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Student</a>
						<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">

							<div class="card myCard border">
								<div class="row">
									<div class="col-6 pr-0">
										<a href="<?php echo $codePath . '/module/admission/'; ?>" class="dropdown-item py-0"> Manage Student </a>
										<a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item py-0"> SMS and Email </a>
										<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item py-0"> Feedback </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Mentoring </a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Hostel </a>
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item py-0"> Transport </a>
										<a href="<?php echo $codePath . '/module/enrichment/'; ?>" class="dropdown-item py-0">Enrichment</a>
									</div>
								</div>
							</div>
						</div>
					</li>

					<!-- Centers -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown">Accounts</a>
						<div class="dropdown-menu dropdown-default menuDouble">
							<div class="card myCard border">
								<div class="row">
									<div class=" col-6 pr-0">
										<a href="<?php echo $codePath . '/module/fee/'; ?>" class="dropdown-item py-0"> Fee </a>
										<a href="<?php echo $codePath . '/module/feeReceipt/'; ?>" class="dropdown-item py-0"> Fee Receipt </a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/payment/'; ?>" class="dropdown-item py-0"> Payment Voucher </a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- Centers -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown">Centers</a>
						<div class="dropdown-menu dropdown-default menuDouble">
							<div class="card myCard border">
								<div class="row">
									<div class=" col-6 pr-0">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> TPC </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Alumni </a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Store </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Manintenance </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> Library </a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- OBE -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown">OBE</a>
						<div class="dropdown-menu dropdown-default menuDouble">
							<div class="card myCard border">
								<div class="row">
									<div class=" col-6 pr-0">
										<a href="<?php echo $codePath . '/module/obaSettings/'; ?>" class="dropdown-item py-0"> OBA Settings </a>
										<a href="<?php echo $codePath . '/module/attainment/'; ?>" class="dropdown-item py-0"> CO Attainment </a>
										<a href="<?php echo $codePath . '/module/obeFeedback/'; ?>" class="dropdown-item py-0"> OBE Feedback </a>
									</div>
									<div class="col-6 pl-0">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> -- </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item py-0"> -- </a>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
				<!-- Links -->

				<ul class="navbar-nav ml-auto nav-flex-icons">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user"></i> <?php echo $myName; ?> </a>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
							<!-- <a class="dropdown-item py-0" href="<?php echo $codePath . '/module/profile/'; ?>">My Account</a> -->
							<a class="dropdown-item py-0" href="<?php echo $codePath . '/module/profile/'; ?>">Profile</a>
							<a class="dropdown-item py-0" href="<?php echo $codePath . '/logout.php';?>">Logout</a>
						</div>
					</li>
				</ul>
			</div> <!-- navbar-collapse.// -->
		</div> <!-- container-fluid.// -->
	</nav>
</header>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		window.addEventListener('scroll', function() {
			if (window.scrollY > 50) {
				document.getElementById('navbar_top').classList.add('fixed-top');
				// add padding top to show content behind navbar
				navbar_height = document.querySelector('.navbar').offsetHeight;
				document.body.style.paddingTop = navbar_height + 'px';
			} else {
				document.getElementById('navbar_top').classList.remove('fixed-top');
				// remove padding top from body
				document.body.style.paddingTop = '0';
			}
		});
	});
</script>