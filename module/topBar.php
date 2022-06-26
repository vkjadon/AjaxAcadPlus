<?php
// echo "My School in SetDefault $myScl";
$myName = getField($conn, $myId, "staff", "staff_id", "staff_name");
$myUserId = getField($conn, $myId, "staff", "staff_id", "user_id");

if (isset($myScl)) $mySclAbbri = getField($conn, $myScl, "school", "school_id", "school_abbri");
else $mySclAbbri = "Select School";
if (isset($myDept)) $myDeptAbbri = getField($conn, $myDept, "department", "dept_id", "dept_abbri");
else $myDeptAbbri = "Select Dept";
if (isset($myProg)) $myProgAbbri = getField($conn, $myProg, "program", "program_id", "program_abbri");
else $myProgAbbri = "Select Prog";

if (isset($myProg)) $mySpAbbri = getField($conn, $myProg, "program", "program_id", "sp_abbri");
else $mySpAbbri = "Not Set";

if (isset($mySes)) $mySesName = getField($conn, $mySes, "session", "session_id", "session_name");
else $mySesName = "Select Session";
if (isset($myBatch)) $myBatchName = getField($conn, $myBatch, "batch", "batch_id", "batch");
else $myBatchName = "Select Batch";
if (!isset($myProg)) $myProg = '';
if (!isset($myBatch)) $myBatch = '';

$sql_menu = "select * from portal_menu where pm_status='0' order by pm_sno";
$result_menu = $conn->query($sql_menu);
$pm_idArray = array();
$pm_nameArray = array();
$count = 0;
while ($rowsMenu = $result_menu->fetch_assoc()) {
	$pm_idArray[$count] = $rowsMenu["pm_id"];
	$pm_nameArray[$count] = $rowsMenu["pm_name"];
	$count++;
}
?>
<header>
	<div class="py-2">
		<div class="row">
			<div class="col-md-1 ml-2">
				<img src="<?php echo $setLogo; // Defined in check_user 
									?>" height="37px">
				<?php //echo $setLogo; // Defined in check_user 
				?>
			</div>
			<div class="col-md-2 ml-2 text-center">
				<?php
				echo $mySclAbbri . '[' . $myDeptAbbri . '-'.$myDept.'] ';
				echo '<b>' . $mySesName . '['.$mySes.']</b>';
				//echo "School ".$myScl;
				?>
			</div>
			<div class="col-md-2 mr-2">
				<span class="progSes"><?php echo $mySpAbbri; ?></span>
				<?php
				echo $myBatchName . '[' . $myBatch . ']';
				//echo "School ".$myScl;
				?>
			</div>
			<div class="col-md-2 mr-2">
				<!-- <a href="<?php echo $codePath . '/module/forms/'; ?>" class="float-right">&nbsp; Forms &nbsp;</a> -->
				<!-- <a href="" class="float-right">&nbsp; Downloads &nbsp;</a> -->
				<a href="<?php echo $codePath . '/access/admission/'; ?>" class="float-right" target="_blank">&nbsp; Admission &nbsp;</a>
			</div>
			<div class="col-md-2 text-right largeText" id="clock"></div>
		</div>
	</div>
	<nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark">
		<a class="navbar-brand" href="<?php echo $codePath . '/module/index.php'; ?>">ClassConnect</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto">
				<?php
				if ($myId < 4) {
				?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ERP Admin</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<div class="card border">
								<div class="row">
									<div class="col-12 pr-0">
										<a href="<?php echo $codePath . '/module/setting/'; ?>" class="dropdown-item py-0">Institute Setting</a>
										<a href="<?php echo $codePath . '/module/aa/'; ?>" class="dropdown-item py-0">Academic Setting</a>
										<a href="<?php echo $codePath . '/module/user/'; ?>" class="dropdown-item py-0">Users and Links</a>
										<a href="<?php echo $codePath . '/module/event/'; ?>" class="dropdown-item py-0">Events and Awards</a>
										<a href="<?php echo $codePath . '/module/ayp/'; ?>" class="dropdown-item py-0">AY Planner</a>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php
				}
				for ($i = 1; $i < count($pm_idArray); $i++) {
					$pm_id = $pm_idArray[$i];
					$sql = "select * from portal_group where pm_id='$pm_id' and pg_status='0' order by pg_sno";
					$result = $conn->query($sql);
				?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $pm_nameArray[$i]; ?></a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<div class="card border">
								<div class="row">
									<div class="col-12 pr-0">
										<?php
										// echo "sd " . $output["success"];
										$responsibilitylinkStatus = 0;
										while ($pgRows = $result->fetch_assoc()) {
											$path = $pgRows["pg_folder"];
											$pg_name = $pgRows["pg_name"];
											$pg_id = $pgRows["pg_id"];
											if ($myId > 3) {
												if (in_array($pg_id, $myLinks)) {
													$responsibilitylinkStatus = 1;
										?>
													<a href="<?php echo $codePath . '/module/' . $path . '/index.php?tag='.$pg_id; ?>" class="dropdown-item py-0 groupLink" data-folder="<?php echo $path ?>"><?php echo $pg_name; ?></a>
												<?php
												}
											} else {
												$responsibilitylinkStatus = 1;
												?>
												<a href="<?php echo $codePath . '/module/' . $path . '/index.php?tag='.$pg_id; ?>" class="dropdown-item py-0 groupLink" data-folder="<?php echo $path ?>"><?php echo $pg_name; ?></a>
										<?php
											}
										}
										if ($responsibilitylinkStatus == '0') echo "No Active Link";
										?>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php
				}
				?>
			</ul>
			<ul>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user"></i> <?php echo $myName; ?> </a>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item py-1" href="<?php echo $codePath . '/module/profile/'; ?>">Profile</a>
						<a class="dropdown-item py-1" href="<?php echo $codePath . '/logout.php'; ?>">Logout</a>
					</div>
				</li>
			</ul>
		</div>
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

	function showTime() {
		// to get current time/ date.
		var date = new Date();
		// to get the current hour
		var h = date.getHours();
		// to get the current minutes
		var m = date.getMinutes();
		//to get the current second
		var s = date.getSeconds();
		// AM, PM setting
		var session = "AM";

		//conditions for times behavior 
		if (h == 0) {
			h = 12;
		}
		if (h >= 12) {
			session = "PM";
		}

		if (h > 12) {
			h = h - 12;
		}
		m = (m < 10) ? m = "0" + m : m;
		s = (s < 10) ? s = "0" + s : s;

		//putting time in one variable
		var time = h + ":" + m + ":" + s + " " + session;
		//putting time in our div
		$('#clock').html(time);
		//to change time in every seconds
		setTimeout(showTime, 1000);
	}
	showTime();
</script>