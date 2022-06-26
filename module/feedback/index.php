<?php
require('../requireSubModule.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<?php require("../css.php"); ?>
</head>

<body>
	<?php require("../topBar.php");
	if ($myId > 3) {
		if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
		elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
		elseif (!in_array("24", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
	}
	?>
	<div class="container-fluid moduleBody">
		<div class="row">
			<div class="col-1 p-0 m-0 full-height">
				<div class="mt-2 pl-1">
					<h5>Feedback</h5>
				</div>
				<div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
					<a class="list-group-item list-group-item-action show active sf" id="list-sf-list" data-toggle="list" href="#list-sf" role="tab"> Create Feedback </a>
					<a class="list-group-item list-group-item-action fq" data-toggle="list" href="#list-fq" role="tab"> Feedback Question </a>
					<a class="list-group-item list-group-item-action ap" data-toggle="list" href="#ap" role="tab"> Participants </a>
				</div>
			</div>
			<div class="col-11">
				<div class="tab-content" id="nav-tabContent">
					<div class="row">
						<div class="col-md-12">
							<div class="card myCard p-2">
								<div class="row">
									<div class="col-md-3">
										<span class="footNote text-primary" id="nameSR"><span class="text-danger"> Please Select a Feedback </span> </span>
									</div>
									<div class="col-md-2">
										Created on <span class="smallText" id="updateSR"></span>
									</div>
									<div class="col-md-7">
										Participants: <span id="participantSR"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane show active" id="list-sf" role="tabpanel">
						<div class="row">
							<div class="col-5 pr-0">
								<div class="container card mt-2 myCard">
									<div class="largeText mb-2">Create Feedback</div>
									<div class="tab-content" id="pills-tabContent p-3">
										<div class="tab-pane fade show active" id="pills_af" role="tabpanel">
											<form class="form-horizontal" id="updateFeedbackForm">
												<div class="row">
													<div class="col-md-9 pr-0">
														<div class="form-group">
															<label>Feedback Name </label>
															<input type="text" class="form-control form-control-sm" id="feedback_name" name="feedback_name" placeholder="Feedback Name">
														</div>
													</div>
													<div class="col-md-3 pl-1">
														<div class="form-group">
															<label>Section </label>
															<input type="number" min="1" class="form-control form-control-sm" id="feedback_section" name="feedback_section">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-3 pr-0">
														<div class="form-group">
															<label>Feedback Open </label>
															<input type="date" class="form-control form-control-sm" id="feedback_open_date" name="feedback_open_date" value="<?php echo $submit_date; ?>">
														</div>
													</div>
													<div class="col-3 pl-1 pr-1">
														<div class="form-group">
															<label>Time </label>
															<input type="time" class="form-control form-control-sm" id="feedback_open_time" name="feedback_open_time" value="07:00" required>
														</div>
													</div>
													<div class="col-3 pl-1 pr-1">
														<div class="form-group">
															<label>Feedback Close </label>
															<input type="date" class="form-control form-control-sm" id="feedback_close_date" name="feedback_close_date" value="<?php echo $submit_date; ?>">
														</div>
													</div>
													<div class="col-3 pl-0">
														<div class="form-group">
															<label> Time </label>
															<input type="time" class="form-control form-control-sm" id="feedback_close_time" name="feedback_close_time" value="17:00">
														</div>
													</div>
												</div>
												<input type="hidden" id="feedback_idHidden" name="feedback_id" value="0">
												<input type="hidden" name="action" value="updateFeedback">
												<button type="submit" class="btn btn-sm">Submit</button>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="col-7 pl-1">
								<div class="container card mt-2 myCard">
									<div class="card-title-xs">Other Feedback List</div>
									<table class="table table-striped list-table-xs" id="otherFeedbackList">
										<tr class="align-center">
											<th>#</th>
											<th>Id</th>
											<th> Name</th>
											<th> Session </th>
											<th> Open</th>
											<th> Close</th>
											<th><span title="Copy All the Questions From this Feedback"><i class="fas fa-copy"></i></th>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="list-fq" role="tabpanel">
						<div class="row">
							<div class="col-5 pr-0">
								<div class="container card mt-2 myCard">
									<form class="form-horizontal" id="feedbackQuestionForm">
										<div class="row">
											<div class="col-md-2 pr-0">
												<div class="form-group">
													<label>SNo</label>
													<input type="number" class="form-control form-control-sm" id="fq_sno" name="fq_sno" value="1">
												</div>
											</div>
											<div class="col-md-10 pl-1">
												<div class="form-group">
													<label>Question Statement </label>
													<input type="text" class="form-control form-control-sm" id="fq_statement" name="fq_statement" placeholder="Add Question Statement">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-1 pr-0">
												<label>#</label>
												<input type="text" disabled class="form-control form-control-sm mt-1" value="1">
												<input type="text" disabled class="form-control form-control-sm mt-1" value="2">
												<input type="text" disabled class="form-control form-control-sm mt-1" value="3">
												<input type="text" disabled class="form-control form-control-sm mt-1" value="4">
												<input type="text" disabled class="form-control form-control-sm mt-1" value="5">
											</div>
											<div class="col-9 pl-1 pr-0">
												<div class="form-group">
													<label>Option</label>
													<input type="text" class="form-control form-control-sm mt-1" id="fq_option1" name="fq_option1">
													<input type="text" class="form-control form-control-sm mt-1" id="fq_option2" name="fq_option2">
													<input type="text" class="form-control form-control-sm mt-1" id="fq_option3" name="fq_option3">
													<input type="text" class="form-control form-control-sm mt-1" id="fq_option4" name="fq_option4">
													<input type="text" class="form-control form-control-sm mt-1" id="fq_option5" name="fq_option5">
												</div>
											</div>
											<div class="col-2 pl-1">
												<div class="form-group">
													<label>Score</label>
													<input type="number" class="form-control form-control-sm mt-1" id="fq_score1" name="fq_score1" value="1">
													<input type="number" class="form-control form-control-sm mt-1" id="fq_score2" name="fq_score2" value="1">
													<input type="number" class="form-control form-control-sm mt-1" id="fq_score3" name="fq_score3" value="1">
													<input type="number" class="form-control form-control-sm mt-1" id="fq_score4" name="fq_score4" value="1">
													<input type="number" class="form-control form-control-sm mt-1" id="fq_score5" name="fq_score5" value="1">
												</div>
											</div>
										</div>
										<input type="hidden" id="fq_fb" name="feedback_id" value="0">
										<input type="hidden" id="fq_idHidden" name="fq_id" value="0">
										<input type="hidden" name="action" value="fqUpdate">
										<button type="submit" class="btn btn-sm fqUpdateButton">Add/Update</button>
									</form>
								</div>
							</div>
							<div class="col-7">
								<div class="container card shadow mt-2 mb-2 myCard">
									<div class="card-title-xs leaveTableTitle" id="leaveTableTitle">Question List</div>
								</div>
								<div class="container card m-0 myCard">
									<div class="row mt-1">
										<div class="col pl-1">
											</table>
											<div class="questionList"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="ap" role="tabpanel">
						<div class="row">
							<div class="col-5 pr-0">
								<div class="container card mt-2 myCard">
									<!-- nav options -->
									<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active fp" data-toggle="pill" href="#pills_aClass" role="tab">Class</a>
										</li>
										<li class="nav-item">
											<a class="nav-link arcr" data-toggle="pill" href="#pills_arcr" role="tab">AR/CR</a>
										</li>
									</ul> <!-- content -->
									<div class="tab-content" id="pills-tabContent p-3">
										<div class="tab-pane show active" id="pills_aClass" role="tabpanel">
											<div id="programClassTable">Please Click on the Class Tab to Show the Class List</div>
										</div>
										<div class="tab-pane fade" id="pills_arcr" role="tabpanel">
											<div>Only Submit Button with Cut-Off Attendance.It will add School Id </div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-7">

							</div>
						</div>
					</div>
				</div>
				<div class="row mt-1">
					<div class="col-md-5 pr-0">
						<div class="card myCard p-2">
							<div class="card-title-xs">My Feedback List</div>
							<table class="table table-striped list-table-xs" id="myFeedbackList">
								<tr class="align-center">
									<th><i class="fas fa-edit"></i></th>
									<th>#</th>
									<th>Id</th>
									<th> Name</th>
									<th> Session</th>
									<th> Open</th>
									<th> Close</th>
									<th><i class="fas fa-trash"></i></th>
								</tr>
							</table>
							<p id="myFeedbackListError"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php require("../bottom_bar.php"); ?>
	</div>
</body>
<!-- MDB -->
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	tinymce.init({
		selector: 'vkj',
		plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		toolbar_mode: 'floating',
		height: "320",
	});
</script>

<script>
	$(document).ready(function() {
		$(function() {
			$(document).tooltip();
		});
		questionList()
		feedbackList()
		otherFeedbackList()

		// Add Feedback
		$(document).on("click", ".editFeedback", function() {
			var feedback_id = $(this).attr("data-fb")
			$("#feedback_idHidden").val(feedback_id)
			$("#fq_fb").val(feedback_id)
			// $().removeClass();
			$(".editFeedback").removeClass('fa-circle')
			$(".editFeedback").addClass('fa-pencil-alt')

			$(this).removeClass('fa-pencil-alt');
			$(this).addClass('fa-circle')

			// feedbackList()
			// $.alert("Edit - Fetch " + feedback_id);
			$.post("feedbackSql.php", {
				feedback_id: feedback_id,
				action: "fetchFeedback"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(" Update " + data.feedback_open_date);
				$("#feedback_name").val(data.feedback_name)
				$("#feedback_section").val(data.feedback_section)
				$("#feedback_open").val(data.feedback_open_date)
				$("#feedback_open_time").val(data.feedback_open_time)
				$("#feedback_close").val(data.feedback_close)
				$("#feedback_close_time").val(data.feedback_close_time)

				$("#nameSR").html(data.feedback_name + " [ Section : " + data.feedback_section + "]")
				questionList();
			})

		})

		$(document).on("submit", "#updateFeedbackForm", function() {
			event.preventDefault(this);
			//$.alert("Form Submitted ");
			var formData = $(this).serialize();
			// $.alert(formData);
			$.post("feedbackSql.php", formData, () => {}, "text").done(function(mydata, mystatus) {
				// $.alert(mydata);
				$('#updateFeedbackForm')[0].reset();
				feedbackList()
			}).fail(function() {
				$.alert("fail in place of error");
			})
		})

		function feedbackList() {
			// $.alert("Fb Type In Feedback  " + mn_id);
			$.post("feedbackSql.php", {
				action: "feedbackList"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data)
				if (data.success == "0") {
					var success = "No Feedback Found for this Session. Please select a Template using Feedback Template to Proceed"
					$("#myFeedbackListError").html(success)

				} else {
					// $("#myFeedbackList").html("Found")
					var card = '';
					var count = 1;
					$.each(data, function(key, value) {
						var open_date = value.feedback_open_date
						var close_date = value.feedback_close_date
						var status = value.feedback_status
						if (status != null) {
							card += '<tr>';
							if (status == 0) card += '<td><a href="#" class="editFeedback fa fa-circle" data-fb="' + value.feedback_id + '"></a></td>';
							else card += '<td><a href="#" class="editFeedback fa fa-pencil-alt" data-fb="' + value.feedback_id + '"></a></td>';
							card += '<td>' + count++ + '</td>';
							card += '<td>' + value.feedback_id + '</td>';
							card += '<td>' + value.feedback_name + '</td>';
							card += '<td>' + value.session_name + '</td>';
							card += '<td>' + getFormattedDate(open_date, "dmY") + '</td>';
							card += '<td>' + getFormattedDate(close_date, "dmY") + '</td>';
							card += '<td><a href="#" class="trashFeedback" data-fb="' + value.feedback_id + '"><i class="fa fa-trash"></i></td>';
							card += '</tr>';
						}
					})

					$("#myFeedbackList").find("tr:gt(0)").remove();
					$("#myFeedbackList").append(card);
					$("#myFeedbackListError").html()
				}
			})
		}

		function otherFeedbackList() {
			// $.alert("Other Feedback  ");
			$.post("feedbackSql.php", {
				tag: "other",
				action: "feedbackList"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data)
				if (data.success == "0") {
					var success = "No Feedback Found for this Session"
					$("#otherFeedbackListError").html(success)

				} else {
					var card = '';
					var count = 1;
					$.each(data, function(key, value) {
						var open_date = value.feedback_open_date
						var open_time = value.feedback_open_time
						var close_date = value.feedback_close_date
						var close_time = value.feedback_close_time
						var status = value.feedback_status
						if (status != null) {
							card += '<tr>';
							card += '<td>' + count++ + '</td>';
							card += '<td>' + value.feedback_id + '</td>';
							card += '<td>' + value.feedback_name + '</td>';
							card += '<td>' + value.session_name + '</td>';
							card += '<td>' + getFormattedDate(open_date, "dmY") + '</td>';
							card += '<td>' + getFormattedDate(close_date, "dmY") + '</td>';
							card += '<td><a href="#" class="copyFeedback" data-fb="' + value.feedback_id + '"><i class="fa fa-copy"></i></td>';
							card += '</tr>';
						}
					})
					$("#otherFeedbackList").find("tr:gt(0)").remove();
					$("#otherFeedbackList").append(card);
					$("#otherFeedbackListError").html()
				}
			})
		}

		$(document).on("click", ".copyFeedback", function() {
			var fqCopy_to = $("#feedback_idHidden").val()
			if (fqCopy_to > 0) {
				var fqCopy_from = $(this).attr("data-fb")
				// $.alert("Edit - Fetch " + feedback_id);
				$.post("feedbackSql.php", {
					feedback_id: fqCopy_from,
					action: "questionListCopy"
				}, function() {}, "text").done(function(data, status) {
					// $.alert(" Open Modal " + data);
					// questionList();
					$("#fqCopy_from").val(fqCopy_from)
					$("#fqCopy_to").val(fqCopy_to)
					$(".feedbackQuestionList").html(data)
					$('#firstModal').modal('show');
				})
			} else $.alert("Please Select the Target Feedback !! ")
		})

		$(document).on("submit", "#copyModalForm", function() {
			event.preventDefault(this);
			//$.alert("Form Submitted ");
			var formData = $(this).serialize();
			// $.alert(formData);
			$.post("feedbackSql.php", formData, () => {}, "text").done(function(mydata, mystatus) {
				// $.alert(mydata);
				$('#copyModalForm')[0].reset();
				$('#firstModal').modal('hide');
			}).fail(function() {
				$.alert("fail in place of error");
			})
		})

		// Feedback Question Block

		$(document).on("click", ".fqEdit", function() {
			var fq_id = $(this).attr("data-fq")
			$("#fq_idHidden").val(fq_id)
			// $().removeClass();
			$(".fqEdit").removeClass('fa-circle')
			$(".fqEdit").addClass('fa-pencil-alt')

			$(this).removeClass('fa-pencil-alt');
			$(this).addClass('fa-circle')

			// $.alert("Edit - Fetch " + fq_id);

			$.post("feedbackSql.php", {
				fq_id: fq_id,
				action: "fetchCurrentQuestion"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(" Update " + data.feedback_open_date);
				$("#fq_sno").val(data.fq_sno)
				$("#fq_statement").val(data.fq_statement)
				$("#fq_option1").val(data.fq_option1)
				$("#fq_option2").val(data.fq_option2)
				$("#fq_option3").val(data.fq_option3)
				$("#fq_option4").val(data.fq_option4)
				$("#fq_option5").val(data.fq_option5)
				$("#fq_score1").val(data.fq_score1)
				$("#fq_score2").val(data.fq_score2)
				$("#fq_score3").val(data.fq_score3)
				$("#fq_score4").val(data.fq_score4)
				$("#fq_score5").val(data.fq_score5)
				questionList();
			})
		})

		$(document).on("submit", "#feedbackQuestionForm", function() {
			event.preventDefault(this);
			var feedback_id = $("#fq_fb").val()
			if (feedback_id > 0) {
				//$.alert("Form Submitted ");
				var formData = $(this).serialize();
				// $.alert(formData);
				$.post("feedbackSql.php", formData, () => {}, "text").done(function(mydata, mystatus) {
					// $.alert(mydata);
					$('#feedbackQuestionForm')[0].reset();
					$("#fq_idHidden").val("0")
					questionList();
				}).fail(function() {
					$.alert("fail in place of error");
				})
			} else $.alert("Please Select a Feedback !!")
		})

		function questionList() {
			var feedback_id = $("#fq_fb").val()
			$.post("feedbackSql.php", {
				feedback_id: feedback_id,
				action: "questionList"
			}, function() {}, "json").done(function(data, status) {
				// $.alert("Current Question" + data);
				var card = '';
				card += '<table class="table table-striped list-table-xs">';
				card += '<tr><th><i class="fa fa-pencil-alt"></i></th><th>SNo</th><th>Statement</th><th>Option-1</th><th>Option-2</th><th>Option-3</th><th>Option-4</th><th>Option-5</th></tr>'
				$.each(data, function(key, value) {
					card += '<tr>';
					if (value.fq_status == 0) card += '<td><a href="#" class="fqEdit fa fa-circle" data-fq="' + value.fq_id + '"></a></td>';
					else card += '<td><a href="#" class="fqEdit fa fa-pencil-alt" data-fq="' + value.fq_id + '"></a></td>';
					card += '<td>' + value.fq_sno + '</td>';
					card += '<td>' + value.fq_statement + '</td>';
					card += '<td>' + value.fq_option1 + '[' + value.fq_score1 + ']</td>';
					card += '<td>' + value.fq_option2 + '[' + value.fq_score2 + ']</td>';
					card += '<td>' + value.fq_option3 + '[' + value.fq_score3 + ']</td>';
					card += '<td>' + value.fq_option4 + '[' + value.fq_score4 + ']</td>';
					card += '<td>' + value.fq_option5 + '[' + value.fq_score5 + ']</td>';
					card += '</tr>';
				})
				card += '</table>';
				$(".questionList").html(card);
			});
		}

		// Add Participants

		$(document).on("click", ".fp", function() {
			programClassList()
		})

		function programClassList() {
			var feedback_id = $("#feedback_idHidden").val()
			if (feedback_id > 0) {
				// $.alert(" Program class list  " + feedback_id);
				$.post("feedbackSql.php", {
					feedback_id: feedback_id,
					action: "programClassList"
				}, function() {}, "json").done(function(data, status) {
					// $.alert(data)
					var card = '';
					var count = 1;
					$.each(data, function(key, value) {
						card += '<div class="row border m-1">';
						card += '<div class="col-sm-4">';
						if (value.status == 0) card += '<input type="checkbox" class="fpClass" data-class="' + value.class_id + '"> ' + value.class_name;
						else card += '<input type="checkbox" checked class="fpClass" data-class="' + value.class_id + '"> ' + value.class_name;
						card += '</div>';
						card += '<div class="col-sm-2 p-1">';
						if (value.status == 0)card += '';
						else card += '<input type="number" min="0" max="100" class="form-control form-control-sm updateFp" title="Cut-Off Attentance (%)" name="fp_cutoff" data-tag="fp_cutoff" data-class="' + value.class_id + '" id="co' + value.class_id + '" value="' + value.fp_cutoff + '">';
						card += '</div>';
						card += '<div class="col-sm-3 p-1">';
						// card += value.fp_open_date
						if (value.status == 0)card += '';
						else card += '<input type="date" class="form-control form-control-sm updateFp" title="Start date for the Feedback for this class" name="fp_open_date" data-tag="fp_open_date" data-class="' + value.class_id + '" id="fo' + value.class_id + '" value="' + value.fp_open_date + '">';
						card += '</div>';
						card += '<div class="col-sm-3 p-1">';
						if (value.status == 0)card += '';
						else card += '<input type="date" class="form-control form-control-sm updateFp" title="Close date for the Feedback for this class" data-tag="fp_close_date"  name="fp_close_date" data-class="' + value.class_id + '" id="fc' + value.class_id + '" value="' + value.fp_close_date + '">';
						card += '</div>';
						card += '</div>';
					})
					$("#programClassTable").html(card);
				})
			} else $.alert("Please Select a Feedback !!")
		}

		$(document).on("click", ".fpClass", function() {
			var feedback_id = $("#feedback_idHidden").val()
			if (feedback_id > 0) {
				var classId = $(this).attr("data-class")
				var status = $(this).is(":checked");
				// $.alert("Participant Class Id " + classId + status);
				$.post("feedbackSql.php", {
					feedback_id: feedback_id,
					classId: classId,
					status: status,
					action: "participantClass"
				}, function() {}, "text").done(function(data, status) {
					// $.alert(data)
					programClassList()
				})
			} else $.alert("Please Select a Feedback !!")
		})

		$(document).on("blur", ".updateFp", function() {
			var feedback_id = $("#feedback_idHidden").val()

			var class_id = $(this).attr('data-class');
			var tag = $(this).attr('data-tag');

			if (tag == 'fp_cutoff') var value = $("#co" + class_id).val();
			else if (tag == 'fp_open_date') var value = $("#fo" + class_id).val();
			else if (tag == 'fp_close_date') var value = $("#fc" + class_id).val();
			// $.alert(" Tag  " + tag + " feedback_id " + feedback_id + " Class " + class_id + " vale " + value)
			$.post("feedbackSql.php", {
				tag: tag,
				value: value,
				class_id: class_id,
				feedback_id: feedback_id,
				action: "updateFp"
			}, function() {}, "text").done(function(data, status) {
				// $.alert(data);
			})
		});

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

		function getTime(ts) {
			var a = new Date(ts);
			var time = a.getHours() + ':' + a.getMinutes();
			return time;
		}

	});
</script>
<div class="modal" id="firstModal">
	<div class="modal-dialog modal-lg">
		<form class="form-horizontal" id="copyModalForm">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_uploadTitle"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div> <!-- Modal Header Closed-->

				<!-- Modal body -->
				<div class="modal-body">
					<p class="feedbackQuestionList"></p>
				</div> <!-- Modal Body Closed-->
				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="fqCopy_from" id="fqCopy_from">
					<input type="hidden" name="fqCopy_to" id="fqCopy_to">
					<input type="hidden" name="action" id="action" value="copyQuestion">
					<input type="submit" class="btn btn-sm btn-danger" value="Confirm Copy" />
					<button type="button" class="btn btn-sm" data-dismiss="modal">Cancel</button>
				</div> <!-- Modal Footer Closed-->
			</div> <!-- Modal Conent Closed-->
		</form>
	</div> <!-- Modal Dialog Closed-->
</div>

</html>