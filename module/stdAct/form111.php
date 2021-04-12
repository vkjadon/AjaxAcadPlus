<?php
session_start();
include('../openDb.php');
require('../php_function.php');
include('../phpFunction/onlineFunction.php');
$submit_date = date("Y-m-d", time());
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<?php require('../css.php'); ?>
	<link rel="stylesheet" href="../style.css">

</head>

<body>
	<div class="container-fluid">
		<table style="background-color:crimson;" width="100%">
			<tr>
				<td width="15%">
					<div class="digital-clock">00:00:00</div>
				</td>
				<td width="5%"></td>
				<td width="55%">
					<h5 class="text-white"></h5>
				</td>
			</tr>
		</table>
		<div class="row">
			<div class="col-sm-8 p-2">
				<button class="btn btn-sm btn-secondary addActivity">Add Activity [1.1.1]</button>
			</div>
			<div class="col-4 mt-2 pt-2">
				<div class="card bg-light text-white">
					<div class="card-body">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div id="activityList"></div>
			</div>
			<div class="col-sm-4">
				<div id="activitySummary"></div>
			</div>
		</div>
	</div>
</body>

<?php require("../js.php"); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
	// Storing data:

	$(document).ready(function() {
		clockUpdate();
		$('.subjectCode').hide();
		$('.className').hide();
		$(document).on('click', '.addActivity', function() {
			//$.alert("Add Subject");
			$('#modal_title').text("Add Activity");
			$('#action').val("addSubject");
			$('#firstModal').modal('show');
		});
		$(document).on('click', '#atCU', function() {
			$('.subjectCode').show()
		});
		$(document).on('click', '#atCO', function() {
			$('.subjectCode').hide()
		});
		$(document).on('click', '#alClass', function() {
			$('.className').show()
		});
		$(document).on('click', '#alDepartment, #alSchool, #alUniversity', function() {
			$('.className').hide()
		});

		function clockUpdate() {
			var date = new Date();
			$('.digital-clock').css({
				'color': '#fff',
				'text-shadow': '0 0 6px #ff0'
			});
			var h = addZero(twelveHour(date.getHours()));
			var m = addZero(date.getMinutes());
			var s = addZero(date.getSeconds());
			$('.digital-clock').text(h + ':' + m + ':' + s)

			function addZero(x) {
				if (x < 10) {
					return x = '0' + x;
				} else {
					return x;
				}
			}

			function twelveHour(x) {
				if (x > 12) {
					return x = x - 12;
				} else if (x == 0) {
					return x = 12;
				} else {
					return x;
				}
			}
		}
	});
</script>

<div class="modal" id="firstModal">
	<div class="modal-dialog modal-lg">
		<form class="form-horizontal" id="modalForm">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div> <!-- Modal Header Closed-->
				<!-- Modal body -->
				<div class="modal-body">
					<div class="activityForm">
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<span class="inputLabel">Activity Name</span>
									<input type="text" class="form-control form-control-sm" id="activity_name" name="activity_name" placeholder="Activity Name">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									<span class="inputLabel">Coordinator</span>
									<input type="text" class="form-control form-control-sm" id="activity_coordinator" name="activity_coordinator" placeholder="Employee Id">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<div class="form-group">
									<span class="inputLabel">School Name (Abbri)</span>
									<input type="text" class="form-control form-control-sm" id="activity_school" name="activity_school" placeholder="CUIET/CBS/CCSM/CCAE">
								</div>
							</div>

							<div class="col-4">
								<div class="form-group">
									From
									<input type="date" class="form-control form-control-sm" id="activity_from" name="activity_from" value="<?php echo $submit_date; ?>">
								</div>
							</div>
							<div class="col-4">
								<div class="form-group">
									To
									<input type="date" class="form-control form-control-sm" id="activity_sno" name="activity_to" value="<?php echo $submit_date; ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<span class="inputLabel">SDG (if any) Number</span>
									<input type="text" class="form-control form-control-sm" id="activity_SDG" name="activity_SDG" placeholder="SDG Mapping">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<span class="inputLabel">University Charter (keywords only)</span>
									<input type="text" class="form-control form-control-sm" id="activity_charter" name="activity_charter" placeholder="Charter Point">
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-3">
								<span class="inputLabel">Activity Type</span>
							</div>
							<div class="col-sm-9">
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="atCU" name="activity_type" value="CU">Curricular
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="atCO" name="activity_type" value="CO">Co-Curricular
								</div>
								<div class="col subjectCode">
									<div class="form-group">
										Subject Code (Separate by coma[,] for more)
										<input type="text" class="form-control form-control-sm" id="subjectCode" name="subjectCode">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"><span class="inputLabel">Activity Category</span></div>
							<div class="col">
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="acExpL" name="activity_category" value="EL">Experiential
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="acPL" name="activity_category" value="PL">Participative
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="acPBL" name="activity_category" value="PB">PBL
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="acFS" name="activity_category" value="FS">Finishing School
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"><span class="inputLabel">Activity Level</span></div>
							<div class="col">
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="alClass" name="activity_level" value="C">Class
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="alDepartment" name="activity_level" value="D">Department
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="alSchool" name="activity_level" value="S">School
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="alUniversity" name="activity_level" value="U">University
								</div>
								<div class="col className">
									<div class="form-group">
										Class Sem and Program (Separate by coma[,] for more)
										<input type="text" class="form-control form-control-sm" id="className" name="className" placeholder="BBA(1Sem)/CSE(3Sem) etc">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3"><span class="inputLabel">Organizer</span></div>
							<div class="col">
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="aoLOC" name="activity_org" value="LOC">Local Society/Club
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="aoSCH" name="activity_org" value="SCH">Student Chapter
								</div>
								<div class="form-check-inline">
									<input type="radio" class="form-check-input" id="aoOSA" name="activity_org" value="OSA">OSA
								</div>
								<div class="col society">
									<div class="form-group">
										Society/Club/Chapter Name
										<input type="text" class="form-control form-control-sm" id="societyName" name="societyName">
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
								<span class="inputLabel">Remarks (if any)</span>
									<input type="text" class="form-control form-control-sm" id="activity_remarks" name="activity_remarks" placeholder="Activity Remarks">
								</div>
							</div>
						</div>
						<hr>
						<span class="inputLabel">The suggestive documents in the file of these activities</span><p>(1) Approval/Office Order (2) Constitution of committee (3) Proposed budget (4) Brochure (outcome-PO, content/syllabus, timeline etc) (5) Rgistration Forms (6) Schedule (7) Attendance (8) Evaluation/Jury (Rubics, Constitution of Jury, Score List) (9) Report (10) Attainment etc. You may add some other document if required or available or ignore if not relevant to the activity.</p>
					</div>
				</div> <!-- Modal Body Closed-->

				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" id="action" name="action">
					<button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div> <!-- Modal Footer Closed-->
			</div> <!-- Modal Conent Closed-->

		</form>
	</div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>