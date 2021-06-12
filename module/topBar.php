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
			<div class="col ml-2">
				<span class="inputLabel">
					<?php
					echo $myName . '[' . $myUserId . ']';
					//echo "School ".$myScl;
					?>
				</span>
			</div>

			<div class="col ml-2 text-center">
				<?php
				echo $mySclAbbri . '[' . $myDeptAbbri . '] ';
				echo '<b>' . $mySesName . '</b>';
				//echo "School ".$myScl;
				?>
			</div>
			<div class="col mr-2">
				<span class="float-right">
					<?php
					echo $myProgAbbri . '[' . $myProg . ']-' . $myBatchName . '[' . $myBatch . ']';
					//echo "School ".$myScl;
					?></span>
			</div>
			<div class="col mr-2">

				<a href="<?php echo $codePath . '/module/forms/'; ?>" class="float-right">&nbsp; Forms &nbsp;</a>
				<a href="" class="float-right">&nbsp; Downloads &nbsp;</a>
				<a href="<?php echo $codePath . '/eoffice/'; ?>" class="float-right" target="_blank">&nbsp; eOffice &nbsp;</a>
			</div>
		</div>

	</div>

	<nav id="navbar_top" class="navbar navbar-expand-lg bg-two">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo $codePath . '/module/'; ?>">ACADPLUS</a>
			<!-- Collapse button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- Collapsible content -->
			<div class="collapse navbar-collapse" id="main_nav">
				<!-- Links -->
				<ul class="navbar-nav mr-auto">
					<!-- Dropdown -->
					<!-- Administration -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
						<div class="dropdown-menu menuDouble" aria-labelledby="navbarDropdownMenuLink">
							<div class="card myCard border">
								<div class="row">
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/inst/'; ?>" class="dropdown-item pb-1">SetUp Institite</a>
										<a href="<?php echo $codePath . '/module/admission/'; ?>" class="dropdown-item pb-1">Admission</a>
									</div>
									<div class="col-6">
										<!-- <a href="<?php echo $codePath . '/module/sop/'; ?>" class="dropdown-item pb-1">SOP</a> -->
										<!-- <a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1">Committees</a> -->
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1">Infrastructure</a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1">Users and Links</a>

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
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/aa/'; ?>" class="dropdown-item pb-1">Academic Settings </a>
										<!-- <a href="<?php echo $codePath . '/module/curriculum/'; ?>" class="dropdown-item pb-1">Curriculum Design </a> -->
										<a href="<?php echo $codePath . '/module/subject/'; ?>" class="dropdown-item pb-1">Manage Subjects </a>
										<a href="<?php echo $codePath . '/module/teachingLoad/'; ?>" class="dropdown-item pb-1">Teaching Load</a>
									</div>
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/schedule/'; ?>" class="dropdown-item pb-1">Schedule</a>
										<a href="<?php echo $codePath . '/module/registration/'; ?>" class="dropdown-item pb-1">Registration</a>
										<a href="<?php echo $codePath . '/module/lms/'; ?>" class="dropdown-item pb-1">LMS</a>
										<a href="<?php echo $codePath . '/module/enrichment/'; ?>" class="dropdown-item pb-1">Enrichment</a>
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
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/assessment/'; ?>" class="dropdown-item pb-1">Assessment Design</a>
										<a href="<?php echo $codePath . '/module/online/'; ?>" class="dropdown-item pb-1">Online Assessment</a>
										<a href="<?php echo $codePath . '/module/obaSettings/'; ?>" class="dropdown-item pb-1"> OBA Settings </a>
										<a href="<?php echo $codePath . '/module/attainment/'; ?>" class="dropdown-item pb-1"> CO Attainment </a>
										<a href="<?php echo $codePath . '/module/obeFeedback/'; ?>" class="dropdown-item pb-1"> OBE Feedback </a>
									</div>
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Exam Setting </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Conduct </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Evaluation </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Internal Assessment </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Semester Result </a>
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
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/hr/'; ?>" class="dropdown-item pb-1"> HR </a>
										<a href="<?php echo $codePath . '/module/leave/'; ?>" class="dropdown-item pb-1">Leave</a>
									</div>
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Support </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Research </a>
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
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item pb-1"> SMS and Email </a>
										<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item pb-1"> Feedback </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Mentoring </a>
									</div>
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Hostel </a>
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Transport </a>
										<a href="<?php echo $codePath . '/module/notsub/'; ?>" class="dropdown-item pb-1"> Student's Events </a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown">Registry</a>
						<div class="dropdown-menu dropdown-default menuDouble">
							<div class="card myCard border">
								<div class="row">
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Accounts </a>
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Fee </a>
									</div>
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Store </a>
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Manintenance </a>
									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown">Centers</a>
						<div class="dropdown-menu dropdown-default menuDouble">
							<div class="card myCard border">
								<div class="row">
									<div class=" col-6">
										<a href="<?php echo $codePath . '/module/tpc/'; ?>" class="dropdown-item pb-1"> TPC </a>
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Alumni </a>
									</div>
									<div class="col-6">
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Store </a>
										<a href="<?php echo $codePath . '/module/alumni/'; ?>" class="dropdown-item pb-1"> Manintenance </a>
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
							<i class="fas fa-user"></i> Profile </a>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
							<a class="dropdown-item pb-1" href="<?php echo $codePath . '/module/profile/'; ?>">My Account</a>
							<a class="dropdown-item pb-1" href="<?php echo $codePath . '/logout.php'; ?>">Logout</a>
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