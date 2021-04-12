<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-one">

	<!-- Navbar brand -->
	<a class="navbar-brand" href="<?php echo $codePath . '/module/'; ?>">ACADPLUS</a>

	<!-- Collapse button -->
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<!-- Collapsible content -->
	<div class="collapse navbar-collapse" id="basicExampleNav">
		<!-- Links -->
		<ul class="navbar-nav mr-auto">
			<!-- Dropdown -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
				<div class="dropdown-menu dropdown-primary menuDouble bg-two" aria-labelledby="navbarDropdownMenuLink">
					<div class="row">
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/inst/'; ?>" class="dropdown-item">SetUp Institite</a>
							<a href="<?php echo $codePath . '/module/admission/'; ?>" class="dropdown-item">Admission</a>
							<a href="<?php echo $codePath . '/module/approval/'; ?>" class="dropdown-item">Approvals</a>
						</div>
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/manage_responsibility/'; ?>" class="dropdown-item">Assign Responsibility</a>
							<a href="<?php echo $codePath . '/module/sop/'; ?>" class="dropdown-item">SOP</a>
							<a href="<?php echo $codePath . '/module/committee/'; ?>" class="dropdown-item">Committees</a>
						</div>
					</div>
				</div>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Academics</a>
				<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
					<div class="row">
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/aa/'; ?>" class="dropdown-item">Setting </a>
							<a href="<?php echo $codePath . '/module/schedule/'; ?>" class="dropdown-item">Schedule</a>
							<a href="<?php echo $codePath . '/module/registration/'; ?>" class="dropdown-item">Registration</a>
						</div>
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/lms/'; ?>" class="dropdown-item">LMS</a>
							<a href="<?php echo $codePath . '/module/online/'; ?>" class="dropdown-item">Online Assessment</a>
						</div>
					</div>
				</div>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Examination</a>
				<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
					<div class="row">
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> Conduct </a>
							<a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> Evaluation </a>
						</div>
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Internal Assessment </a>
							<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Semester Result </a>
						</div>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="hr/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">HR</a>
				<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
					<div class="row">
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/hr/'; ?>" class="dropdown-item"> Staff </a>
							<a href="<?php echo $codePath . '/module/leave/'; ?>" class="dropdown-item"> Leave </a>
						</div>
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Support </a>
							<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Mentoring </a>
						</div>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Communication</a>
				<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
					<div class="row">
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> Email </a>
							<a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> SMS </a>
						</div>
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Feedback </a>
						</div>
					</div>
				</div>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Student Affair</a>
				<div class="dropdown-menu dropdown-primary menuDouble" aria-labelledby="navbarDropdownMenuLink">
					<div class="row">
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/stdAct/'; ?>" class="dropdown-item"> Activities </a>
							<a href="<?php echo $codePath . '/module/hostel/'; ?>" class="dropdown-item"> Hostel </a>
						</div>
						<div class="col-6">
							<a href="<?php echo $codePath . '/module/hostel/'; ?>" class="dropdown-item"> Mentoring </a>
						</div>
					</div>
				</div>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OBE</a>
				<div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
					<a href="<?php echo $codePath . '/module/obe/'; ?>" class="dropdown-item"> CO Attainment </a>
					<a href="<?php echo $codePath . '/module/obeFeedback/'; ?>" class="dropdown-item"> OBE Feedback </a>
					<a href="<?php echo $codePath . '/module/obe/'; ?>" class="dropdown-item"> PO Attainment </a>
				</div>
			</li>

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown">eOffice</a>
				<div class="dropdown-menu">
					<a href="<?php echo $codePath . '/module/office/'; ?>" class="dropdown-item"> eOffice </a>
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
					<a class="dropdown-item" href="<?php echo $codePath . '/module/profile/'; ?>">My Account</a>
					<a class="dropdown-item" href="<?php echo $codePath . '/logout.php'; ?>">Logout</a>
				</div>
			</li>
		</ul>
	</div>
	<!-- Collapsible content -->

</nav>
<h1>&nbsp;</h1><h6>&nbsp;</h6>