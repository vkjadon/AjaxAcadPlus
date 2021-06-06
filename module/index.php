<?php session_start();
require("../config_database.php");
require('../config_variable.php');
require('../php_function.php');

if (!isset($myScl)) {
	$myScl = getField($conn, $myId, "staff", "staff_id", "school_id");
	$_SESSION['mysclid'] = $myScl;
}
if (!isset($myDept)) {
	$sql = "select dept_id from staff_service where staff_id='$myId' and ss_status='0'";
	$myDept = getFieldValue($conn, "dept_id", $sql);
	$_SESSION['mydeptid'] = $myDept;
}
if (!isset($mySes)) {
	$sql = "select * from session_school where school_id='$myScl'";
	$mySes = getFieldValue($conn, "session_id", $sql);
	$_SESSION['mysid'] = $mySes;
}
if (!isset($myProg)) {
	$sql = "select p.* from program p, dept_program dp where p.program_id=dp.program_id and dp.dept_id='$myDept' and p.program_status='0' order by p.sp_abbri";
	$myProg = getFieldValue($conn, "program_id", $sql);
	$_SESSION['mypid'] = $myProg;
}
if (!isset($myBatch)) {
	$sql = "select * from batch where batch_status='0' order by batch desc";
	$myBatch = getFieldValue($conn, "batch_id", $sql);
	$_SESSION['myBatch'] = $myBatch;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<link rel="stylesheet" href="../table.css">
	<link rel="stylesheet" href="../style.css">
	<script type="text/javascript" src="https://latex.codecogs.com/latexit.js"></script>
</head>

<body>
	<?php require("topBar.php"); ?>
	<div class="container-fluid moduleBody">
		<div class="row">
			<div class="col-2">
				<?php
				require("setDefault.php");
				//require("sync_data.php");
				//echo "Dept $myDept School $myScl Session $mySes";
				?>
			</div>

		</div>
		<div class="navbar navbar-expand-md navbar-dark bg-dark fixed-bottom">
			<div>
				<p class="text-white">Product of EISOFTECH INC</p>
			</div>
		</div>
	</div>
</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	$(document).ready(function() {

		$(document).on('change', '#sel_program', function() {
			var x = $("#sel_program").val();
			//$.alert("Program Changed " + x);
			$.post("../check_user.php", {
				action: "setProgram",
				programId: x
			}, function(mydata, mystatus) {
				//$.alert("- Program Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		})
		$(document).on('change', '#sel_batch', function() {
			var x = $("#sel_batch").val();
			//$.alert("Batch Changed " + x);
			$.post("../check_user.php", {
				action: "setBatch",
				batchId: x
			}, function(mydata, mystatus) {
				//$.alert("- Batch Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		})

		$(document).on('change', '#sel_session', function() {
			var x = $("#sel_session").val();
			//$.alert("Session  Changed " + x);
			$.post("../check_user.php", {
				action: "setSession",
				sessionId: x
			}, function(mydata, mystatus) {
				//alert("- Session Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		})

		$(document).on('change', '#sel_dept', function() {
			var x = $("#sel_dept").val();
			//$.alert("Session  Changed " + x);
			$.post("../check_user.php", {
				action: "setDept",
				deptId: x
			}, function(mydata, mystatus) {
				//alert("- Session Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		})

		$(document).on('change', '#sel_school', function() {
			var x = $("#sel_school").val();
			//$.alert("Session  Changed " + x);
			$.post("../check_user.php", {
				schoolId: x,
				action: "setSchool",
			}, function(mydata, mystatus) {
				//alert("- School Updated -" + mydata);
				location.reload();

			}, "text").fail(function() {
				$.alert("Error !!");
			})
		})

	});
</script>

</html>