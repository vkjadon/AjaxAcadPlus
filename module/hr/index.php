<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : AcadPlus</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<link rel="stylesheet" href="../../table.css">
	<link rel="stylesheet" href="../../style.css">
</head>

<body>
<?php require("../topBar.php");?>
<div class="container-fluid">

		<div class="row">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header bg-light">
						<h4 class="mb-0">Select Panel</h4>
					</div>
					<div class="card-body bg-light">
						<?php
						$sql = "select * from department where dept_status='0'";
						selectList($conn, "Select a Department", array("0", "dept_id", "dept_name", "dept_abbri", "sel_dept"), $sql);
						?>
					</div>
				</div>
				<div id="showUploadForm" class="bg-info py-1">
					<div class="card-body bg-light">
						<form id="upload_staff" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-9"><input type="file" name="staff_upload" /></div>
								<div class="col-sm-3"><input type="submit" name="upload" id="upload" value="Upload" class="btn btn-info btn-sm" /></div>
							</div>
							<input type="hidden" name="inst_id" id="uploadInst" />
							<input type="hidden" name="dept_id" id="uploadDept" />
						</form>
					</div>
				</div>
				A-Sno; B-StaffName; C-FName; D-MName;E-Mobilr; F-Email; G-DoB; H-DoJ; I-Aadhar; J-Address; K-Type
				L-Teaching; M-Gender
			</div>
			<div class="col-sm-8">
				<!-- form user info -->
				<div class="card" id="showstaffForm">
					<div class="card-header">
						<h4 class="mb-0">Staff Form - Basic Information (DeptId-<span id="dept"></span>)</h4>
					</div>
					<div class="card-body bg-light">
						<div>
							<form method="post" id="formStaff">
								<div class="form-group row">
									<div class="col-lg-4">
										Name<input type="text" class="form-control form-control-sm" id="staffName" name="staff_name" required>
										Father Name<input type="text" class="form-control form-control-sm" name="staff_fname">
										Mother's Name<input type="text" class="form-control form-control-sm" name="staff_mname">
										Mobile<input type="text" class="form-control form-control-sm" name="staff_mobile">
									</div>
									<div class="col-lg-4">
										Email<input type="email" class="form-control form-control-sm" name="staff_email">
										Date of Birth<input type="date" class="form-control form-control-sm" name="staff_dob" value="<?= $today; ?>">
										Date of Joining<input class="form-control form-control-sm" type="date" name="staff_doj" value="<?= $today; ?>"> Adhaar Number<input class="form-control form-control-sm" name="staff_adhaar" type="text">
									</div>
									<div class="col-lg-4">
										Address<textarea class="form-control form-control-sm" rows="3" cols="30" name="staff_address"></textarea>
										<input type="radio" checked name="staff_type" value="C">Core
										<input type="radio" name="staff_type" value="V">Visiting

										<br>
										<input type="radio" checked name="staff_teaching" value="Y">Teaching
										<input type="radio" name="staff_teaching" value="N">Non Teaching

										<input type="radio" name="staff_gender" value="M" checked>Male
										<input type="radio" name="staff_gender" value="F">Female
									</div>
								</div>

								<div class="form-group row">
									<div class="col-lg-4">
										<input type="hidden" name="inst_id" id="inst_id">
										<input type="hidden" name="dept_id" id="dept_id">
										<input type="hidden" name="action" value="addStaff">
										<input type="submit" class="btn btn-primary btn-block" value="Add Staff">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- /Card -->
				<div id="showstaffEditForm"></div>

			</div>
		</div>
		<div id="staffList"></div>

		<div class="table-responsive" id="uploaded_data"></div>
	</div>
	</div>
	</div>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
	function resetForm() {
		document.getElementById("formStaff").reset();
	}

	$(document).ready(function() {
		$("#instDept").hide();

		$(".topBarTitle").text("HR");
		$("#showstaffForm").hide();
		$("#staffList").hide();
		$("#showUploadForm").hide();
		$(document).on('click', '.addUser', function() {
			var y = $("#sel_dept").val();
			var staffId = $(this).attr('id');
			$.confirm({
				title: 'Confirm!',
				content: 'Please confirm that you want to Add User.',
				buttons: {
					confirm: function() {
						$.post("admin_staffSql.php", {
							staffId: staffId,
							action: "addUser"
						}, function(mydata, mystatus) {
							// the below $.alert to be removed
							$.alert(" Added as User. Mobile is Username and Password");
							$("#staffList").hide();
							staffList(y);
						}, "text").fail(function() {
							$.alert("fail in place of error");
						})
					},
					cancel: function() {
						$.alert('Canceled!');
					},
				}
			});
		});

		$(document).on('click', '.removeUser', function() {
			var staffId = $(this).attr('id');
			var y = $("#sel_dept").val();
			$.confirm({
				title: 'Confirm!',
				content: 'Please confirm that you want to Remove User.',
				buttons: {
					confirm: function() {
						$.post("admin_staffSql.php", {
							staffId: staffId,
							action: "removeUser"
						}, function(mydata, mystatus) {
							// the below $.alert to be removed
							$.alert(" User Removed !!");
							$("#staffList").hide();
							staffList(y);
						}, "text").fail(function() {
							$.alert("fail in place of error");
						})
					},
					cancel: function() {
						$.alert('Canceled!');
					},
				}
			});
		});
		$('#teachingCheck').click(function() {
			var check = $('#teachingCheck').prop('checked');
			//alert("Checkbox state = " + check);
		});

		$(document).on('click', ".editData", function() {
			var staffId = $(this).attr('id');
			//$.alert("Edit Pressed"+staffId);
			$("#showstaffForm").hide();
			$.post("admin_staffSql.php", {
				staff_id: staffId,
				action: "staffEditForm"
			}, function(mydata, mystatus) {
				//$.alert(" Status: Added Successfully "+mydata);
				$("#showstaffEditForm").show();
				$("#showstaffEditForm").html(mydata);
			}, "text").fail(function() {
				$.alert("Request Failed!!");
			})
		});

		$(document).on("change", "#sel_dept", function() {
			var y = $("#sel_dept").val();
			$("#dept_id").val(y);
			//alert( "Handler for called" + x + "Dept " + y);
			$.post("admin_staffSql.php", {
				deptId: y,
				action: "staffList"
			}, function(mydata, mystatus) {
				// the below $.alert to be removed
				//$.alert(" Status: Added Successfully "+mydata);
				$("#staffList").show();
				$("#showstaffForm").show();
				$("#showUploadForm").show();
				$("#dept").html(y);
				$("#staffList").html(mydata);
			}, "text").fail(function() {
				$.alert("fail in place of error");
			})
		});
		$('#formStaff').submit(function(event) {
			event.preventDefault();
			var y = $("#sel_dept").val();
			var formData = $(this).serialize();
			//$.alert(formData);
			// action and test_id are passed as hidden
			$.post("admin_staffSql.php", formData, function(mydata, mystatus) {
				// the below $.alert to be removed
				$.alert(" Status: Added Successfully ");
				resetForm();
				staffList(y);
			}, "text").fail(function() {
				$.alert("fail in place of error");
			})
		});
		$(document).on("submit", "#formStaffUpdate", function(event) {
			event.preventDefault();
			var y = $("#sel_dept").val();
			var formData = $(this).serialize();
			//$.alert(formData);
			// action and test_id are passed as hidden
			$.post("admin_staffSql.php", formData, function(mydata, mystatus) {
				// the below $.alert to be removed
				$.alert(" Back from Update " + mydata);
				resetForm();
				staffList(y);
			}, "text")
		});
		$('#upload_staff').on("submit", function(event) {
			event.preventDefault(); //form will not submitted
			var x = $("#myInst").val();
			var y = $("#sel_dept").val();
			$('#uploadInst').val(x);
			$('#uploadDept').val(y);
			$.ajax({
				url: "staff_uploadSql.php",
				method: "POST",
				data: new FormData(this),
				contentType: false, // The content type used when sending data to the server.  
				cache: false, // To unable request pages to be cached  
				processData: false, // To send DOMDocument or non processed data file it is set to false  
				success: function(data) {
					//alert("List "+data);
					$("#staffList").hide();
					$('#uploaded_data').html(data);
					staffList(y);
				}
			})
		});

		function staffList(y) {
			$.post("admin_staffSql.php", {
				deptId: y,
				action: "staffList"
			}, function(mydata, mystatus) {
				$("#staffList").show();
				//	alert("List ");
				$("#staffList").html(mydata);
			}, "text").fail(function() {
				$.alert("fail in place of error");
			})
		}
	});
</script>