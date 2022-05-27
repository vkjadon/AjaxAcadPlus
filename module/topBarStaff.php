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
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://classconnect.in/api/get_portal_menu.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
curl_close($curl);
$group = json_decode($output, true);
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
				echo $mySclAbbri . '[' . $myDeptAbbri . '] ';
				echo '<b>' . $mySesName . '</b>';
				//echo "School ".$myScl;
				?>
			</div>
			<div class="col-md-2 mr-2">
				<?php
				echo $myProgAbbri . '[' . $myProg . ']-' . $myBatchName . '[' . $myBatch . ']';
				//echo "School ".$myScl;
				?>
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
				for ($i = 0; $i < count($group["data"]); $i++) {
					$pm_id = $group["data"][$i]["pm_id"];
					$curl = curl_init();
					$url = 'https://classconnect.in/api/get_portal_menuGroup.php?pm=' . $pm_id;
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					$output = curl_exec($curl);
					$output = json_decode($output, true);
				?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="academics/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $group["data"][$i]["pm_name"]; ?></a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<div class="card border">
								<div class="row">
									<div class="col-12 pr-0">
										<?php
										// echo "sd " . $output["success"];
										// echo "Count " . count($output["data"]);
										$linkCount=0;
										for ($j = 0; $j < count($output["data"]); $j++) {
											$path = $output["data"][$j]["pg_folder"];
											$pg_name = $output["data"][$j]["pg_name"];
											$pg_id = $output["data"][$j]["pg_id"];
											$sql = "select * from privilege_group where pg_id='$pg_id' and up_code='1'";
											if ($conn->query($sql)->num_rows > 0) {
												$linkCount++;
										?>
												<a href="<?php echo $codePath . '/module/' . $path . '/'; ?>" class="dropdown-item py-0"><?php echo $pg_name; ?></a>
										<?php
											}
										}
										if($linkCount==0)echo "No Active Links";
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