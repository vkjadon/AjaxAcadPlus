<?php
session_start();
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
require("../util/config_database.php");
require('../php_function.php');
require('../util/config_variable.php');
require('../util/myLinks.php');

//echo "dsd";

if (!isset($myDept)) {
	$sql = "select dept_id from staff_service where staff_id='$myId' and ss_status='0'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$rows = $result->fetch_assoc();
		$myDept = $rows["dept_id"];
		$_SESSION['mydeptid'] = $myDept;
	} //else $_SESSION['mydeptid'] = '1';
}
if (!isset($myProg)) {
	$sql = "select p.* from program p where p.program_status='0' order by p.sp_abbri";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$rows = $result->fetch_assoc();
		$myProg = $rows["program_id"];
		$_SESSION['mypid'] = $myProg;
	} //else $_SESSION['mypid'] = '1';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/table.css">
	<link rel="stylesheet" href="../css/toggle.css">
	<link rel="stylesheet" href="../css/card.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

	<!-- Plugins -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
	<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
</head>

<body>
	<?php
	require("topBar.php");
	?>
	<div class="container-fluid moduleBody">
		<div class="row">
			<div class="col-md-3">
				<?php
				// echo 'P-'.$privilege;
				require("setDefault.php");
				?>
				<div class="card myCard">
					<div class="card-body m-0 p-1">
						<div class="text-center">
							<label class="warning">Today's Classes </label>
						</div>
						<table class="table table-scheduler classSchedule"></table>
					</div>
				</div>
				<div class="card myCard">
					<div class="card-body m-0 p-1" style="background-color:floralwhite">
						<label class="warning">Birthday Reminder</label>
					</div>
				</div>
				<?php 
				// print_r($myLinks);
				?>
			</div>
			<div class="col-md-6 pl-0 pr-0">
				<div class="card p-3 myCard">
					<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="pill" href="#scheduler" role="tab" aria-controls="scheduler" aria-selected="true">Scheduler</a>
						</li>
						<li class="nav-item">
							<a class="nav-link discussion" data-toggle="pill" href="#discussion" role="tab" aria-controls="discussion" aria-selected="true">Discussion</a>
						</li>
						<li class="nav-item">
							<a class="nav-link announcement" data-toggle="pill" href="#announcement" role="tab" aria-controls="calendar" aria-selected="true">Announcement</a>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent p-3">
						<div class="tab-pane show active" id="scheduler" role="tabpanel" aria-labelledby="scheduler">
							<div class="row mb-2">
								<div class="col-3">
									<div class="text-center">
										<span><input type="date" class="form-control form-control-sm scheduler" id="scheduler" value="<?php echo $submit_date; ?>"></span>
									</div>
								</div>
								<div class="col-md-9">
									<span class="float-right"><a href="#" class="xlText fa fa-plus-circle addSchedule"></a></span>
								</div>
							</div>
							<div align="center">
								<table class="table table-scheduler scheduleTable">
								</table>
							</div>
						</div>
						<div class="tab-pane show active" id="discussion" role="tabpanel" aria-labelledby="discussion">
						</div>
					</div>
				</div>
				<div class="card myCard mt-2">
					<div class="card-body">
						<span class="largeText">Event List</span>
						<div class="event-list"></div>
					</div>
				</div>

				<div class="card mt-3 myCard">
					<div class="m-4" id="calendar"></div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="container card myCard">
					<div class="card-body p-1">
						<p class="largeText userName"> Welcome Guest</p>
						<div class="row">
							<div class="col-md-4 pl-1 pr-0">
								<div class="card myCard">
									<div class="card-body p-1">
										<span class="staffImage"><img src="../images/upload.jpg"></span>
										<div class="text-center"><?php echo '[' . $myUserId . ']'; ?></div>
									</div>
								</div>
							</div>
							<div class="col-md-8 pl-1">
								<p class="smallerText m-0 userDesignation text-danger"> Designation Not Set</p>
								<p class="smallerText m-0 userDepartment text-primary"> Department Not Set</p>
								<p class="smallerText m-0 userEmail"> Not Set</p>
								<p class="smallerText m-0 userMobile"></p>
								<p class="smallerText userDoJ"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="card myCard mt-2">
					<div class="card-body">
						<span class="largeText">To Do List</span>
						<form action="javascript:void(0);">
							<input type="text" class="form-control add-task" id="add-task" placeholder="New Task...">
							<input type="hidden" class="form-control" id="todo_id" value="0">
						</form>
						<div class="todo-list"></div>
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
		var calendar = $('#calendar').fullCalendar({
			editable: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
		})
		$(function() {
			$(document).tooltip();
		});
		dateTime()
		todo();
		scheduleList();

		$(document).on('click', '.addSchedule', function() {
			// $.alert("Schedule ");
			$("#modalId").val("0")
			$('#modal_title').html("Add New Meeting/Schedule/Event");
			$('#action').val("updateSchedule");
			$('#firstModal').modal('show');
			$('.scheduleForm').show();
			dateTime()
		});
		$(document).on('submit', '#modalForm', function(event) {
			event.preventDefault(this);
			var formData = $(this).serialize();
			$('#firstModal').modal('hide');
			$.alert(" Form Data " + formData);
			$.post("indexSql.php", formData, () => {}, "text").done(function(data) {
				$.alert(data);
				scheduleList();
				$("#modalForm")[0].reset();
			}).fail(function() {
				$.alert("Error");
			})
		});
		$(document).on('click', '.scheduleEdit', function() {
			var schedule_id = $(this).attr("data-sdl");
			$("#modalId").val(schedule_id)
			// $.alert("Schedule " + schedule_id);
			$.post("indexSql.php", {
				schedule_id: schedule_id,
				action: "scheduleFetch"
			}, () => {}, "json").done(function(data, status) {
				// $.alert(data.schedule_name);
				$("#schedule_name").val(data.schedule_name)
				$("#schedule_venue").val(data.schedule_venue)
				$("#schedule_date_from").val(data.schedule_date_from)
				$("#schedule_time_from").val(data.schedule_time_from)
				$("#schedule_time_to").val(data.schedule_time_to)
				$("#registration_link").val(data.registration_link)
				$("#webinar_ink").val(data.webinar_ink)
				$("#schedule_remarks").val(data.schedule_remarks)
				$('#modal_title').html("Update Meeting/Event");
				$('#action').val("updateSchedule");
				$('#firstModal').modal('show');
				$('.scheduleForm').show();
			})
		})
		$(document).on('click', '.scheduleRemove', function() {
			var schedule_id = $(this).attr("data-sdl");
			// $.alert("Remove Schedule " + schedule_id);
			$.post("indexSql.php", {
				schedule_id: schedule_id,
				action: "scheduleRemove"
			}, () => {}, "text").done(function(data, status) {
				// $.alert(data);
				scheduleList();
			})
		})
		$(document).on('click', '.scheduleApprove', function() {
			var schedule_id = $(this).attr("data-sdl");
			// $.alert("Remove Schedule " + schedule_id);
			$.post("indexSql.php", {
				schedule_id: schedule_id,
				action: "scheduleApprove"
			}, () => {}, "text").done(function(data, status) {
				// $.alert(data);
				scheduleList();
			})
		})

		function scheduleList() {
			$.post("indexSql.php", {
				action: "scheduleList"
			}, () => {}, "json").done(function(data, status) {
				// $.alert(data);
				var card = '';
				$.each(data, function(key, value) {
					card += '<tr>';
					card += '<th>' + value.schedule_time_from + '</th>';
					if (value.schedule_status == '1') card += '<td><span class="completed">' + value.schedule_name + ' [' + value.schedule_venue + ']</span></td>';
					else card += '<td><span class="schedule-over">' + value.schedule_name + ' [' + value.schedule_venue + ']</span></td>';
					card += '<td><a href="#" class="fa fa-pencil-alt scheduleEdit" data-sdl="' + value.schedule_id + '" title="Edit the meeting"></a></td>';
					if (value.schedule_status == '1') card += '<td><a href="#" class="scheduleApprove" data-sdl="' + value.schedule_id + '" title="Retrieve to the List"><i class="fa fa-refresh approve"></i></a></td>';
					else card += '<td><a href="#" class="scheduleRemove" data-sdl="' + value.schedule_id + '" title="Remove from the List"><i class="fa fa-times warning"></i></a></td>';
					card += '</tr>';
				})
				$(".scheduleTable").html(card);
			})
		}

		$(document).on('click', '.todoEdit', function() {
			var todo_id = $(this).attr("data-todo");
			//$.alert("Program Changed " + x);
			$.post("indexSql.php", {
				todo_id: todo_id,
				action: "fetchTodo"
			}, () => {}, "json").done(function(data, status) {
				// $.alert(data);
				$("#add-task").val(data.todo_name)
				$("#todo_id").val(data.todo_id)
			})
		})

		$(document).on('click', '.markCompleted', function() {
			var todo_id = $(this).attr("data-todo");
			// $.alert(" Todo " + todo_id);
			$.post("indexSql.php", {
				todo_id: todo_id,
				action: "markCompleted"
			}, () => {}, "text").done(function(data, status) {
				// $.alert(data);
				todo();
			})
		})

		$(document).on('click', '.unlist', function() {
			var todo_id = $(this).attr("data-todo");
			// $.alert(" Todo " + todo_id);
			$.post("indexSql.php", {
				todo_id: todo_id,
				action: "unlist"
			}, () => {}, "text").done(function(data, status) {
				// $.alert(data);
				todo();
			})
		})

		$(document).on('keypress', ".add-task", function(e) {
			if ((e.which == 13) && (!$(this).val().length == 0)) {
				var todo_name = $(this).val()
				var todo_id = $("#todo_id").val()
				$(this).val('');
				// $.alert("New Task Added " + todo_name + " Id " + todo_id);
				$.post("indexSql.php", {
					todo_name: todo_name,
					todo_id: todo_id,
					action: "updateTodo"
				}, () => {}, "text").done(function(data, status) {
					// $.alert("List Updated" + data);
					todo();
				});
			} else if (e.which == 13) {
				alert('Please enter new task');
			}
		});

		function todo() {
			$.post("indexSql.php", {
				action: "todoList"
			}, () => {}, "json").done(function(data, status) {
				// $.alert(data);
				var card = '';
				var status = '';
				$.each(data, function(key, value) {
					status = value.todo_status;
					if (status == '0') card += '<div class="todo-item">';
					else card += '<div class="todo-item complete">';
					card += '<span><a href="#" class="fa fa-pencil-alt todoEdit" data-todo="' + value.todo_id + '"></a> </span>';
					card += '<span>' + value.todo_name + '</span>';
					if (status == '0') card += '<span class="float-right"><a href="#" class="fa fa-check markCompleted" data-todo="' + value.todo_id + '" title="Check to Mark Completed."></a></span>';
					else card += '<span class="float-right"><a href="#" class="fa fa-times unlist" data-todo="' + value.todo_id + '" title="Remove from the List"></a></span>';
					card += '</div>';
				})
				$(".todo-list").html(card);
			})
		}

		classSchedule();

		function classSchedule() {
			$.post("indexSql.php", {
				action: "classSchedule"
			}, () => {}, "text").done(function(data, status) {
				// $.alert(data);
				$(".classSchedule").html(data);
			})
		}
		profile();

		function profile() {
			$.post("indexSql.php", {
				action: "profile"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data);
				$(".userName").html(data.staff_name);
				$(".userMobile").html(data.staff_mobile);
				$(".userEmail").html(data.staff_email);
				$(".userDesignation").html(data.userDesignation);
				$(".userDepartment").html(data.userDepartment);
				$(".userDoJ").html(getFormattedDate(data.staff_doj, "dmY"));
				if (data.staff_image === null) $(".staffImage").html('<img  src="../images/upload.jpg" width="100%">');
				else $(".staffImage").html('<img  src="<?php echo '../' . $myFolder . 'staffImages/'; ?>' + data.staff_image + '" width="100%">');
			}).fail(function() {
				$.alert("Could not Fetch staff Data!!");
			})
		}

		$(document).on('change', '#sel_program', function() {
			var x = $("#sel_program").val();
			// $.alert("Program Changed " + x);
			$.post("../util/session_variable.php", {
				action: "setProgram",
				programId: x
			}, function(mydata, mystatus) {
				// $.alert("- Program Updated -" + mydata);
				location.reload();
			}).fail(function() {
				$.alert("Error in Program!!");
			})
		})
		$(document).on('change', '#sel_batch', function() {
			var x = $("#sel_batch").val();
			//$.alert("Batch Changed " + x);
			$.post("../util/session_variable.php", {
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
			$.post("../util/session_variable.php", {
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
			$.post("../util/session_variable.php", {
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
			$.post("../util/session_variable.php", {
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

		function dateTime() {
			var date = new Date();
			var day = date.getDate(),
				month = date.getMonth() + 1,
				year = date.getFullYear(),
				hour = date.getHours(),
				min = date.getMinutes();

			month = (month < 10 ? "0" : "") + month;
			day = (day < 10 ? "0" : "") + day;
			hour = (hour < 10 ? "0" : "") + hour;
			min = (min < 10 ? "0" : "") + min;

			var today = year + "-" + month + "-" + day,
				displayTime = hour + ":" + min;

			$("#schedule_date_from").val(today);
			$("#schedule_time_from").val(displayTime);
			$("#schedule_time_to").val(displayTime);
		}
	});
</script>

<!-- Modal Section-->
<div class="modal" id="firstModal">
	<div class="modal-dialog">
		<form class="form-horizontal" id="modalForm">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div> <!-- Modal Header Closed-->
				<!-- Modal body -->
				<div class="modal-body">
					<div class="scheduleForm">
						<div class="col-12 py-1">
							<div class="form-check-inline">
								<input type="radio" class="form-check-input schedule_type" id="meeting" name="schedule_type" value="0">Meeting
							</div>
							<div class="form-check-inline">
								<input type="radio" class="form-check-input schedule_type" id="event" name="schedule_type" value="1">Event
							</div>
						</div>
						<div class="row">
							<div class="col-6 pr-0">
								<div class="form-group">
									Title
									<input type="text" class="form-control form-control-sm" id="schedule_name" name="schedule_name" placeholder="Schedule Name" required>
								</div>
							</div>
							<div class="col-3 pl-1 pr-0">
								<div class="form-group">
									Title (Abbri)
									<input type="text" class="form-control form-control-sm" id="schedule_abbri" name="schedule_abbri" placeholder="Abbri" required>
								</div>
							</div>
							<div class="col-3 pl-1">
								<div class="form-group">
									Venue
									<input type="text" class="form-control form-control-sm" id="schedule_venue" name="schedule_venue" placeholder="Schedule Venue" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-3 pr-0">
								<div class="form-group">
									Date From
									<input type="date" class="form-control form-control-sm" id="schedule_date_from" name="schedule_date_from" placeholder="Schedule From Date">
								</div>
							</div>
							<div class="col-3 pl-1 pr-0">
								<div class="form-group">
									Time From
									<input type="time" class="form-control form-control-sm" id="schedule_time_from" name="schedule_time_from">
								</div>
							</div>
							<div class="col-3 pl-1 pr-0">
								<div class="form-group">
									Date To
									<input type="date" class="form-control form-control-sm" id="schedule_date_from_to" name="schedule_date_from_to" placeholder="Schedule To Date">
								</div>
							</div>
							<div class="col-3 pl-1">
								<div class="form-group">
									Time To
									<input type="time" class="form-control form-control-sm" id="schedule_time_to" name="schedule_time_to">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									Rgistration Link
									<input type="text" class="form-control form-control-sm" id="registration_link" name="registration_link" placeholder="Registration Link">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									Webinar Link
									<input type="text" class="form-control form-control-sm" id="webinar_link" name="webinar_link" placeholder="Webinar Link">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									Remarks
									<textarea class="form-control form-control-sm" rows="4" id="schedule_remarks" name="schedule_remarks" placeholder="Schedule Remarks"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- Modal Body Closed-->

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" id="modalId" name="modalId" value="0">
					<input type="hidden" id="action" name="action">
					<button type="submit" class="btn btn-sm" id="submitModalForm">Submit</button>
					<button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
				</div> <!-- Modal Footer Closed-->
			</div> <!-- Modal Conent Closed-->

		</form>
	</div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>