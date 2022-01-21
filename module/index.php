<?php
session_start();
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
require("../util/config_database.php");
require('../php_function.php');
require('../util/config_variable.php');

//echo "dsd";

if (!isset($myDept)) {
	$sql = "select dept_id from staff_service where staff_id='$myId' and ss_status='0'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$rows = $result->fetch_assoc();
		$myDept = $rows["dept_id"];
		$_SESSION['mydeptid'] = $myDept;
	} else $_SESSION['mydeptid'] = '1';
}
if (!isset($myProg)) {
	$sql = "select p.* from program p where p.program_status='0' order by p.sp_abbri";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$rows = $result->fetch_assoc();
		$myProg = $rows["program_id"];
		$_SESSION['mypid'] = $myProg;
	} else $_SESSION['mypid'] = '1';
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
	<link rel="stylesheet" href="../css/table.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/todo.css">
	<link rel="stylesheet" href="../css/card.css">
	<script type="text/javascript" src="https://latex.codecogs.com/latexit.js"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>
	<?php require("topBar.php"); ?>
	<div class="container-fluid moduleBody">
		<div class="row">
			<div class="col-md-3">
				<div class="container card myCard">
					<div class="card-body p-1">
						<p class="largeText userName"> Welcome Guest</p>
						<div class="row">
							<div class="col-md-4 pl-3">
								<div class="card myCard">
									<div class="card-body p-1">
										<span class="staffImage"><img src="../images/upload.jpg"></span>
										<div class="text-center"><?php echo '[' . $myUserId . ']'; ?></div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<p class="smallerText userDesignation"> Not Set</p>
								<p class="smallerText userEmail"> Not Set</p>
								<p class="smallerText userMobile"></p>
								<p class="smallerText userDoJ"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="card myCard mt-2">
					<div class="card-body">
						<span class="largeText">To Do List</span>
						<form action="javascript:void(0);">
							<input type="text" class="form-control add-task" placeholder="New Task...">
						</form>
						<ul class="nav nav-pills todo-nav">
							<li role="presentation" class="nav-item all-task active"><a href="#" class="nav-link">All</a></li>
							<li role="presentation" class="nav-item active-task"><a href="#" class="nav-link">Active</a></li>
							<li role="presentation" class="nav-item completed-task"><a href="#" class="nav-link">Completed</a></li>
						</ul>
						<div class="todo-list">
							<div class="todo-item">
								<div class="checker"><span class=""><input type="checkbox"></span></div>
								<span>Create theme</span>
								<a href="javascript:void(0);" class="float-right remove-todo-item"><i class="icon-close"></i></a>
							</div>
							<div class="todo-item">
								<div class="checker"><span class=""><input type="checkbox"></span></div>
								<span>Work on wordpress</span>
								<a href="javascript:void(0);" class="float-right remove-todo-item"><i class="icon-close"></i></a>
							</div>
							<div class="todo-item">
								<div class="checker"><span class=""><input type="checkbox"></span></div>
								<span>Organize office main department</span>
								<a href="javascript:void(0);" class="float-right remove-todo-item"><i class="icon-close"></i></a>
							</div>
							<div class="todo-item">
								<div class="checker"><span><input type="checkbox"></span></div>
								<span>Error solve in HTML template</span>
								<a href="javascript:void(0);" class="float-right remove-todo-item"><i class="icon-close"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-7 pl-0 pr-0">
				<div class="card p-3 myCard">
					<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="pill" href="#scheduler" role="tab" aria-controls="scheduler" aria-selected="true">Scheduler</a>
						</li>
						<li class="nav-item">
							<a class="nav-link discussion" data-toggle="pill" href="#discussion" role="tab" aria-controls="discussion" aria-selected="true">Discussion</a>
						</li>
						<li class="nav-item">
							<a class="nav-link discussion" data-toggle="pill" href="#calendar" role="tab" aria-controls="calendar" aria-selected="true">Calendar</a>
						</li>
						<li class="nav-item">
							<a class="nav-link announcement" data-toggle="pill" href="#announcement" role="tab" aria-controls="calendar" aria-selected="true">Announcement</a>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent p-3">
						<div class="tab-pane show active" id="scheduler" role="tabpanel" aria-labelledby="scheduler">
							<div class="row">
								<div class="col-4">
									<span><input type="date" class="form-control form-control-xs scheduler" id="scheduler" value="<?php echo date("d-m-Y", strtotime($submit_date)); ?>"></span>
								</div>
							</div>
							<div class="text-center"><?php echo date("d-m-Y", strtotime($submit_date)); ?></div>
							<div align="center">
								<table class="table table-scheduler">
									<tr>
										<th>08:00</th>
										<td>Welcome</td>
									</tr>
									<tr>
										<th>09:00</th>
										<td>Speaker One <span>Earth Stage</span></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="tab-pane show active" id="discussion" role="tabpanel" aria-labelledby="discussion">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<?php
				require("setDefault.php");
				if (!isset($myId) || strlen($myId) == 0) {
					echo "My Id Check ";
					require("../logout.php");
				}
				//require("sync_data.php");
				//echo "Dept $myDept School $myScl Session $mySes";
				?>

				<div class="list-group">
					<span style="color:#FFFFFF; font-size:14px; background:#737373;">Quick Links</span>
					<a href="index.php?tag=prlbi" class="list-group-item" style="padding:2px">Leave</a>
					<a href="index.php?tag=accaws" class="list-group-item" style="padding:2px">LMS</a>
					<a href="index.php?tag=acmm" class="list-group-item" style="padding:2px">Upload Marks</a>
					<a href="index.php?tag=accs" class="list-group-item" style="padding:2px">Lesson Plan/Resource</a>
					<a href="index.php?tag=acac" class="list-group-item" style="padding:2px">Academic Calender </a>
				</div>

				<div class="card myCard">
					<div class="card-body m-0 p-1" style="background-color:floralwhite">
						<label class="warning">Birthday Reminder</label>
					</div>
				</div>
			</div>
		</div>

		<?php require("bottom_bar.php"); ?>
	</div>
</body>

<!-- MDB -->
<script>
	$(document).ready(function() {
		"use strict";
		var todo = function() {
			$('.todo-list .todo-item input').click(function() {
				if ($(this).is(':checked')) {
					$(this).parent().parent().parent().toggleClass('complete');
				} else {
					$(this).parent().parent().parent().toggleClass('complete');
				}
			});

			$('.todo-nav .all-task').click(function() {
				$('.todo-list').removeClass('only-active');
				$('.todo-list').removeClass('only-complete');
				$('.todo-nav li.active').removeClass('active');
				$(this).addClass('active');
			});

			$('.todo-nav .active-task').click(function() {
				$('.todo-list').removeClass('only-complete');
				$('.todo-list').addClass('only-active');
				$('.todo-nav li.active').removeClass('active');
				$(this).addClass('active');
			});

			$('.todo-nav .completed-task').click(function() {
				$('.todo-list').removeClass('only-active');
				$('.todo-list').addClass('only-complete');
				$('.todo-nav li.active').removeClass('active');
				$(this).addClass('active');
			});

			$('#uniform-all-complete input').click(function() {
				if ($(this).is(':checked')) {
					$('.todo-item .checker span:not(.checked) input').click();
				} else {
					$('.todo-item .checker span.checked input').click();
				}
			});

			$('.remove-todo-item').click(function() {
				$(this).parent().remove();
			});
		};

		todo();

		$(".add-task").keypress(function(e) {
			if ((e.which == 13) && (!$(this).val().length == 0)) {
				$('<div class="todo-item"><div class="checker"><span class=""><input type="checkbox"></span></div> <span>' + $(this).val() + '</span> <a href="javascript:void(0);" class="float-right remove-todo-item"><i class="icon-close"></i></a></div>').insertAfter('.todo-list .todo-item:last-child');
				$(this).val('');
			} else if (e.which == 13) {
				alert('Please enter new task');
			}
			$(document).on('.todo-list .todo-item.added input').click(function() {
				if ($(this).is(':checked')) {
					$(this).parent().parent().parent().toggleClass('complete');
				} else {
					$(this).parent().parent().parent().toggleClass('complete');
				}
			});
			$('.todo-list .todo-item.added .remove-todo-item').click(function() {
				$(this).parent().remove();
			});
		});

		profile();

		function profile() {
			$.post("indexSql.php", {
				action: "profile"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data);
				$(".userName").html(data.staff_name);
				$(".userMobile").html(data.staff_mobile);
				$(".userEmail").html(data.staff_email);
				$(".userDoJ").html(getFormattedDate(data.staff_doj, "dmY"));
				if (data.staff_image === null) $(".staffImage").html('<img  src="../images/upload.jpg" width="100%">');
				else $(".staffImage").html('<img  src="<?php echo '../' . $myFolder . 'staffImages/'; ?>' + data.staff_image + '" width="100%">');
			}).fail(function() {
				$.alert("Could not Fetch staff Data!!");
			})
		}
		$(document).on('change', '#sel_program', function() {
			var x = $("#sel_program").val();
			//$.alert("Program Changed " + x);
			$.post("../util/check_user.php", {
				action: "setProgram",
				programId: x
			}, function(mydata, mystatus) {
				//$.alert("- Program Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error in Program!!");
			})
		})
		$(document).on('change', '#sel_batch', function() {
			var x = $("#sel_batch").val();
			//$.alert("Batch Changed " + x);
			$.post("../util/check_user.php", {
				action: "setBatch",
				batchId: x
			}, function(mydata, mystatus) {
				//$.alert("- Batch Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error in Natch !!");
			})
		})
		$(document).on('change', '#sel_session', function() {
			var x = $("#sel_session").val();
			//$.alert("Session  Changed " + x);
			$.post("../util/check_user.php", {
				action: "setSession",
				sessionId: x
			}, function(mydata, mystatus) {
				//alert("- Session Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Error in Session !!");
			})
		})
		$(document).on('change', '#sel_dept', function() {
			var x = $("#sel_dept").val();
			//$.alert("Session  Changed " + x);
			$.post("../util/check_user.php", {
				deptId: x,
				action: "setDept"
			}, function(mydata, mystatus) {
				//alert("- Session Updated -" + mydata);
				location.reload();
			}, "text").fail(function() {
				$.alert("Erro Dept !!");
			})
		})
		$(document).on('change', '#sel_school', function() {
			var x = $("#sel_school").val();
			//$.alert("Session  Changed " + x);
			$.post("../util/check_user.php", {
				schoolId: x,
				action: "setSchool",
			}, function(mydata, mystatus) {
				//alert("- School Updated -" + mydata);
				location.reload();

			}, "text").fail(function() {
				$.alert("Error in School!!");
			})
		})

		function getFormattedDate(ts, fmt) {
			var a = new Date(ts);
			var day = a.getDate();
			var month = a.getMonth() + 1;
			var year = a.getFullYear();
			var date = day + '-' + month + '-' + year;
			var dateYmd = year + '-' + month + '-' + day;
			if (fmt == "dmY") return date;
			else return dateYmd;
		}
	});
</script>


</html>