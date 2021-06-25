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
	<?php require("../topBar.php"); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-2 p-0 m-0 pl-2 full-height">
				<h5 class="mt-3">Online Assessment</h5>
				<div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
					<a class="list-group-item list-group-item-action active mt" id="list-mt-list" data-toggle="list" href="#list-mt" role="tab" aria-controls="mt"> Manage Test </a>
					<a class="list-group-item list-group-item-action aq" id="list-aq-list" data-toggle="list" href="#list-aq" role="tab" aria-controls="aq"> Add Question </a>
					<a class="list-group-item list-group-item-action ti" id="list-ti-list" data-toggle="list" href="#list-ti" role="tab" aria-controls="ti"> Instructions/Text </a>
					<a class="list-group-item list-group-item-action pt" id="list-pt-list" data-toggle="list" href="#list-pt" role="tab" aria-controls="pt"> Publish Test </a>
					<a class="list-group-item list-group-item-action tr" id="list-tr-list" data-toggle="list" href="#list-tr" role="tab" aria-controls="tr"> Test Report</a>
				</div>
			</div>
			<div class="col-10 leftLinkBody">
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane show active" id="list-mt" role="tabpanel" aria-labelledby="list-mt-list">
						<div class="row">
							<div class="col-6">
								<div class="container card myCard p-2">
									<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="pill" href="#pills_test" role="tab">Test</a>
										</li>
										<li class="nav-item">
											<a class="nav-link participant" data-toggle="pill" href="#pills_tp" role="tab">Participants</a>
										</li>
										<li class="nav-item">
											<a class="nav-link schedule" data-toggle="pill" href="#pills_schedule" role="tab">Schedule</a>
										</li>
									</ul>
									<!-- content -->
									<div class="tab-content" id="pills-tabContent p-3">
										<div class="tab-pane fade show active" id="pills_test" role="tabpanel">
											<form class="form-horizontal" id="addTestForm">
												<div class="row">
													<div class="col-9 pr-0">
														<div class="form-group">
															<label>Test Name</label>
															<input type="text" class="form-control form-control-sm" id="test_name" data-toggle="tooltip" title="xyz" name="test_name" />
														</div>
													</div>
													<div class="col-3 pl-1">
														<div class="form-group">
															<label>Section</label>
															<input type="number" class="form-control form-control-sm" id="test_section" data-toggle="tooltip" title="xyz" name="test_section" min="1" value="1" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<input type="hidden" id="testAction" name="action" value="addTest">
													<!-- Test id is required 0 for insert and other to update -->
													<input type="hidden" id="test_id" name="test_id" value="0">
													<button class="btn btn-sm submitAddTestForm">Submit</button>
												</div>
											</form>
										</div>
										<div class="tab-pane fade" id="pills_tp" role="tabpanel">
											<div class="row">
												<div class="col">
													<p id="deptClass"></p>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills_schedule" role="tabpanel">
											<form class="form-horizontal" id="addTestScheduleForm">
												<div class="row">
													<div class="col-3 pr-0">
														<div class="form-group">
															<label>From</label>
															<input type="date" class="form-control form-control-sm" id="from_date" name="test_from_date" value="<?php echo $submit_date; ?>" />
														</div>
													</div>
													<div class="col-2 pl-1 pr-0">
														<div class="form-group">
															<label>Time</label>
															<input type="time" class="form-control form-control-sm" id="from_time" name="test_from_time" value="" />
														</div>
													</div>
													<div class="col-3 pl-1 pr-0">
														<div class="form-group">
															<label>To</label>
															<input type="date" class="form-control form-control-sm" id="to_date" name="test_to_date" value="<?php echo $submit_date; ?>" />
														</div>
													</div>
													<div class="col-2 pl-1 pr-0">
														<div class="form-group">
															<label>Time</label>
															<input type="time" class="form-control form-control-sm" id="to_time" name="test_to_time" value="" />
														</div>
													</div>
													<div class="col-2 pl-1">
														<div class="form-group">
															<label>Duration</label>
															<input type="number" class="form-control form-control-sm" id="test_duration" name="test_duration" value="60" min="10" placeholder="minutes" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<input type="hidden" id="scheduleAction" name="action" value="addSchedule">
													<button class="btn btn-sm">Submit</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="container card myCard mt-2">
									<table class="table table-bordered table-striped list-table-xs mt-3" id="testTable">
										<tr>
											<th><i class="fa fa-pencil-alt"></i></th>
											<th>#</th>
											<th>Test Name</th>
											<th>Section</th>
										</tr>
									</table>
								</div>
								<div class="col-6 mt-1 mb-1" id="testRight">
								</div>
							</div>
							<div class="col-6">
								<div class="container card mt-2 myCard">
									<h5 class="card-title">Test Summary</h5>
									<div class="container col-12">
										<table class="table list-table-xs smallText">
											<tr class="smallText">
												<td width="20%">Test Name</td>
												<td id="nameSR" colspan="3"></td>
												<td width="20%">Section</td>
												<td><span id="sectionSR"></span></td>
											</tr>
											<tr>
												<td>From </td>
												<td><span id="from_dateSR"></span> <span id="from_timeSR"></span></td>
												<td width="15%">To </td>
												<td><span id="to_dateSR"></span> <span id="to_timeSR"></span></td>
												<td>Duration </td>
												<td><span id="durationSR"></span></td>
											</tr>
											<tr>
												<td>Participants</td>
												<td colspan="5"><span id="participantSR"></span></td>
											</tr>
											<tr>
												<td>Questions</td>
												<td><span id="questionSR"></span></td>
												<td>Marks</td>
												<td><span id="questionMarksSR"></span></td>
												<td>NMarks</td>
												<td><span id="questionNMarksSR"></span></td>
											</tr>
											<tr>
												<td colspan="6">Created by <span  class="smallText" id="staffSR"></span> and Last updated on <span class="smallText" id="updateSR"></span> at <span class="smallText" id="updateTimeSR"></span> </td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="list-aq" role="tabpanel" aria-labelledby="list-aq-list">
						<div class="row">
							<div class="col-5 mt-1 mb-1">
								<div class="container card myCard">
									<h5 class="mt-2">Add New Question Panel</h5>
									<div class="row mt-1">
										<div class="col pr-0">
											<label>Topic Tag</label>
											<input type="text" class="form-control form-control-sm subjectTopic" id="subjectTopic" name="subjectTopic" value="">
										</div>
										<div class="col-3 pl-1 pr-0">
											<label>Marks</label>
											<input type="text" class="form-control form-control-sm defaultMarks" id="defaultMarks" name="marks" value="4">
										</div>
										<div class="col-3 pl-1">
											<label>N Marks</label>
											<input type="text" class="form-control form-control-sm defaultNMarks" id="defaultNMarks" name="nmarks" value="0">
										</div>
									</div>
									<div class="row">
										<div class="col">
											Section : <span id="selectedSection">1</span>
											<textarea rows="4" class="content" id="question" name="question"></textarea>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<input type="hidden" id="actionCode" name="actionCode">
											<button class="btn btn-sm addQuestion">Add Question</button>
											<button class="btn btn-sm showQuestionLibrary"> Library</button>
											<button class="btn btn-sm showTestQuestion">Show Test</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-7 mt-1 mb-1">
								<p class="showActiveQuestion"></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p class="sectionQuestionList"></p>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="list-ti" role="tabpanel" aria-labelledby="list-ti-list">
						<div class="row">
							<div class="col-5 mt-1 mb-1">
								<p id="testHeading"></p>
							</div>
							<div class="col-7 mt-1 mb-1">
								<p id="instructionHeading"></p>
								<form class="instructionForm" id="instructionForm">
									<div class="form-group row">
										<div class="col-sm-12">
											<vkj class="content" id="instruction" name="instruction"></vkj>
										</div>
									</div>
									<input type="hidden" id="instructionId" name="instructionId">
									<input type="hidden" id="testId" name="testId">
									<input type="hidden" id="sectionId" name="sectionId">
									<button class="btn btn-secondary btn-square-sm saveNotice">Save</button>
								</form>

							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="list-pt" role="tabpanel" aria-labelledby="list-pt-list">
						<div class="row">
							<div class="col-8 mt-1 mb-1">
							</div>
							<div class="col-4 mt-1 mb-1">

							</div>
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
<?php require("../js.php"); ?>
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
		testList();
		testSummary();

		// Add Question Block

		$(document).on("click", ".aq, .showTestQuestion", function() {
			//$.alert("Add Question");
			$("#questionForm").show()
			$("#actionCode").val("add")
			questionHeading()
			sectionQuestionList()
			activeQuestion()
		});

		function questionHeading(section) {
			//$.alert("In SAS Claim List");
			$.post("onlineSql.php", {
				action: "questionHeading"
			}, function(data, status) {
				//$.alert("Success " + data);
				$("#questionHeading").show()
				$("#questionHeading").html(data);
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		}

		function activeQuestion() {
			var selectedSection = $("#selectedSection").text()
			//$.alert("Section  " + selectedSection)
			$.post("sectionQuestionListSql.php", {
				sectionId: selectedSection,
				action: "activeQuestion"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				$(".showActiveQuestion").html(data)
			}).fail(function() {
				$.alert("Error !!");
			})
		}

		function sectionQuestionList() {
			var selectedSection = $("#selectedSection").text()
			// $.alert("Section  " + selectedSection)
			$.post("sectionQuestionListSql.php", {
				sectionId: selectedSection,
				action: "sectionQuestionList"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				$(".sectionQuestionList").html(data)
			}).fail(function() {
				$.alert("Error !!");
			})
		}

		// Add Test Block
		$(document).on("submit", "#addTestForm", function() {
			event.preventDefault(this);
			var formData = $(this).serialize();
			$.alert("Form Submitted " + formData)
			$.post("onlineSql.php", formData, function() {}, "text").done(function(data, success) {
				$.alert(data)
				$('#addTestForm')[0].reset();
				testList()
			})
		});
		$(document).on("click", ".editTest", function() {
			var test_id = $(this).attr("data-test")
			// $().removeClass();
			$(".editTest").removeClass('fa-circle')
			$(".editTest").addClass('fa-pencil-alt')

			$(this).removeClass('fa-pencil-alt');
			$(this).addClass('fa-circle')

			// $.alert("Edit - Fetch " + test_id);
			$.post("onlineSql.php", {
				test_id: test_id,
				action: "fetchTest"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(" Update " + feedback_id);
				$("#test_id").val(data.test_id)
				$("#test_name").val(data.test_name)
				$("#test_section").val(data.test_section)
				deptClassList();
				testSummary();
			})
		})
		$(document).on("click", ".participantClass", function() {
			var classId = $(this).attr("data-class")
			var status = $(this).is(":checked");
			// $.alert("Participant Class Id " + classId + status);
			$.post("onlineSql.php", {
				classId: classId,
				status: status,
				action: "participant"
			}, function() {}, "text").done(function(data, status) {
				// $.alert(data)
			})
		})
		$(document).on("click", ".participant", function() {
			deptClassList();
		})
		$(document).on("submit", "#addTestScheduleForm", function() {
			event.preventDefault(this);
			var formData = $(this).serialize();
			$.alert("Form Submitted " + formData)
			$.post("onlineSql.php", formData, function() {}, "text").done(function(data, success) {
				$.alert(data)
				$('#addTestScheduleForm')[0].reset();
				// testList()
			})
		});

		function deptClassList() {
			// $.alert("Class List ");
			$.post("onlineSql.php", {
				action: "deptClassList"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data)
				var card = '';
				var count = 1;
				$.each(data, function(key, value) {
					var check = value.check;
					card += '<div class="row m-1">';
					card += '<div class="col">';
					if (check == '1') card += '<input type="checkbox" class="participantClass" checked data-class="' + value.class_id + '"> ' + value.class_name;
					else card += '<input type="checkbox" class="participantClass" data-class="' + value.class_id + '"> ' + value.class_name;
					card += ' [' + value.class_section + '] ';
					// card += ' [' + check + '] ';
					card += '</div>';
					card += '</div>';
				})
				// $("#programClassTable").find("tr:gt(0)").remove();
				$("#deptClass").html(card);
			})
		}
		function testSummary() {
			// $.alert('hello');
			$.post("onlineSql.php", {
				action: "testSR",
			}, () => {}, "json").done(function(data, status) {
				// $.alert(data.participant);
				$("#nameSR").html(data.test_name);
				$("#sectionSR").html(data.test_section);
				$("#from_dateSR").html(getFormattedDate(data.test_from_date, "dmY"));
				$("#from_timeSR").html(data.test_from_time);
				$("#to_dateSR").html(getFormattedDate(data.test_to_date, "dmY"));
				$("#to_timeSR").html(data.test_to_time);
				$("#durationSR").html(data.test_duration);
				$("#participantSR").html(data.participant);
				$("#questionSR").html(data.question);
				$("#staffSR").html(data.staff);
				$("#updateSR").html(getFormattedDate(data.update, "dmY"));
				$("#updateTimeSR").html(getTime(data.update));
			}).fail(function() {
				$.alert("Test is Not Responding");
			})
		}

		function testList() {
			// $.alert('hello');
			$.post("onlineSql.php", {
				action: "testList",
			}, () => {}, "json").done(function(data, status) {
				var card = '';
				var count = 1;
				// $.alert(data);
				$.each(data, function(key, value) {
					status = value.test_status;
					card += '<tr>';
					if (status == "0") card += '<td><a href="#" class="editTest fa fa-circle" data-test="' + value.test_id + '"></td>';
					else card += '<td><a href="#" class="editTest fa fa-pencil-alt" data-test="' + value.test_id + '"></td>';
					card += '<td>' + count++ + '</td>';
					card += '<td>' + value.test_name + '</td>';
					card += '<td>' + value.test_section + '</td>';
					card += '</tr>';
				});
				$("#testTable").find("tr:gt(0)").remove()
				$("#testTable").append(card);
			}).fail(function() {
				$.alert("Test is Not Responding");
			})
		}

		$(".ti").click(function() {
			//$.alert("Add Question");
			$("#instructionForm").hide()
			$("#questionForm").hide()
			testHeading()
		});

		$(".showQuestionLibrary").click(function() {
			//$.alert("Add Question");
			$(".showActiveQuestion").html("");
			questionLibrary()
		});

		$(document).on("click", ".addQuestionToTest", function() {
			var qb_id = $(this).attr("data-qb")
			var test_section = $("#selectedSection").text()
			//$.alert("Id" + qb_id + " Section " + test_section)

			$.post("sectionQuestionListSql.php", {
				qb_id: qb_id,
				test_section: test_section,
				action: "addLibraryQuestionToTest"
			}, () => {}, "html").done(function(data, status) {
				//$.alert(data);
				questionLibrary();
			})
		});
		$(document).on("click", ".testQuestion", function() {
			var qb_id = $(this).attr("data-qb")
			var test_id = $(this).attr("data-test")
			var tag = $(this).attr("data-tag")
			//$.alert("Id" + qb_id)
			$.post("sectionQuestionListSql.php", {
				qb_id: qb_id,
				test_id: test_id,
				tag: tag,
				action: "testQuestion"
			}, () => {}, "html").done(function(data, status) {
				//$.alert(data);
				activeQuestion();
			})
		});
		$(document).on('click', '.trashCP, .trashOption, .trashQuestion', function() {
			var id = $(this).attr("data-qb");
			var sno = $(this).attr("data-sno");
			var tag = $(this).attr("data-tag");
			//var test_id = $(this).attr("data-test");
			//$.alert(" QbId  " + id + " Sno " + sno + " Tag " + tag)
			$.confirm({
				title: 'Confirm!',
				draggable: true,
				content: "Please confirm to delete!! ",
				buttons: {
					confirm: {
						btnClass: 'btn-blue',
						action: function() {
							$.post("onlineSql.php", {
								id: id,
								sno: sno,
								tag: tag,
								action: "delete"
							}, function() {}, "text").done(function(data, status) {
								//$.alert(data);
								if (tag == "tq") sectionQuestionList();
								else activeQuestion();
							})
						}
					},
					cancel: {
						btnClass: "btn-danger",
						action: function() {}
					},
				}
			});
		});
		$(document).on('blur', '.checkPoint', function() {
			var qc_sno = $(this).attr("data-sno");
			var qb_id = $(this).attr("data-qb");
			var tag = $(this).attr("data-tag");
			var value = $(this).val();
			//Confirm Alert Plugin shows Alert Box twice
			//alert(" Parameter  " + qc_sno + " QB " + qb_id + " Value " + value + " Tag " + tag);
			$.post("onlineSql.php", {
				qb_id: qb_id,
				qc_sno: qc_sno,
				tag: tag,
				value: value,
				action: "updateCP"
			}, function(mydata, mystatus) {
				//$.alert("Updated!!");
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on("click", ".updateCP", function() {
			var qb_id = $(this).attr("data-qb");
			var qc_sno = $(this).attr("data-sno");
			var value = $("#newCP").val();
			//$.alert(" QbId  " + qb_id + " CP Sno " + qc_sno + " CP " + value)
			$.post("onlineSql.php", {
				qb_id: qb_id,
				qc_sno: qc_sno,
				qc_name: value,
				action: "updateCP"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				activeQuestion()
			}).fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on("click", ".addCheckPoint", function() {
			var qb_id = $(this).attr("data-qb");
			var qc_sno = $(this).attr("data-sno");
			var value = $("#newCP").val();
			var valueMarks = $("#newCPMarks").val();
			//$.alert(" QbId  " + qb_id + " CP Sno " + qc_sno + " CP " + value)
			$.post("onlineSql.php", {
				qb_id: qb_id,
				qc_sno: qc_sno,
				qc_name: value,
				qc_marks: valueMarks,
				action: "addCP"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				activeQuestion()
			}).fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on('blur', '.parameter, .testQuestionUpdate, .questionOption, .testName', function() {
			var qp_sno = $(this).attr("data-qp");
			var qb_id = $(".testQuestionUpdate").attr("data-qb");
			var test_id = $(".testName").attr("data-test");
			var qo_code = $(this).attr("data-code");
			var tag = $(this).attr("data-tag");
			if (tag == "qb_text") var value = $("textarea#uq").val();
			else if (tag == "qo_text") var value = $(this).val();
			else var value = $(this).val();

			//Confirm Alert Plugin shows Alert Box twice
			//$.alert(" Parameter  " + qp_sno + " QB " + qb_id + " Value " + value + " Tag " + tag);
			$.post("onlineSql.php", {
				qb_id: qb_id,
				qp_sno: qp_sno,
				qo_code: qo_code,
				test_id: test_id,
				tag: tag,
				value: value,
				action: "updateText"
			}, function(data, status) {}, "text").done(function(data, status) {
				//$.alert("Updated!!" + mydata);
				sectionQuestionList()
			}).fail(function() {
				$.alert("Error !!");
			})
		});

		$(document).on("click", ".changeOption", function() {
			var qb_id = $(this).attr('data-qb');
			var qo_code = $(this).attr('data-code');
			var change_code = $(this).attr('data-set');
			//$.alert("Qb  " + qb_id + " Code " + qo_code + " Change " + change_code)
			$.post("onlineSql.php", {
				qb_id: qb_id,
				qo_code: qo_code,
				change_code: change_code,
				action: "changeOption"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				activeQuestion()
			}).fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on("click", ".activeQuestion", function() {
			var qb_id = $(this).attr('data-qb');
			//$.alert("Qb  " + qb_id)
			$.post("onlineSql.php", {
				qb_id: qb_id,
				action: "activeQuestion"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				activeQuestion()
				sectionQuestionList();
			}).fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on("click", ".addOption", function() {
			//var content = tinyMCE.get('question').getContent();
			var content = $("#newOption").val();

			//$.alert("Option  " + content)
			$.post("onlineSql.php", {
				content: content,
				action: "addOption"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				activeQuestion()
			}).fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on("click", ".addQuestion", function() {
			var selectedSection = $("#selectedSection").text()
			var defaultMarks = $("#defaultMarks").val()
			var defaultNMarks = $("#defaultNMarks").val()
			var actionCode = $("#actionCode").val()
			//var question = get('question').getContent();
			var question = $("textarea#question").val();

			//$.alert("Section  " + selectedSection + "Question" + question)
			$.post("onlineSql.php", {
				sectionId: selectedSection,
				defaultMarks: defaultMarks,
				defaultNMarks: defaultNMarks,
				question: question,
				actionCode: actionCode,
				action: "addQuestion"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert("Updated!!" + data);
				//tinyMCE.get('question').setContent("")
				$("textarea#question").val("");
				$("#actionCode").val("add")
				sectionQuestionList()
			}).fail(function() {
				$.alert("Error !!");
			})
		});

		$(document).on('click', '.defaultSection', function() {
			var id = $(this).attr('data-section');
			var value = $("#defaultSection" + id).text();
			//$.alert("Decrement " + id + "Value" + value);
			$("#selectedSection").text(value);
		});
		$(document).on('click', '.defaultMarks, .defaultNMarks', function() {
			var id = $(this).attr('id');
			var value = $("." + id).text();
			//$.alert("Decrement " + id + "Value" + value);
			var newValue = Number(value) + 1;
			if (newValue > 0) $("." + id).html(newValue);
			else $("." + id).html(value);
		});

		$(document).on('click', ".newQuestionButton", function() {
			//$.alert("New Question")
			$("#questionForm").toggle();
			var id = $(this).attr("data-test")
			var section = $(this).attr("data-section")
			$.alert("Fetch Question  " + id + " Section " + section);
			$.post("onlineSql.php", {
				testId: id,
				sectionId: section,
				action: "fetchQuestion"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "json").done(function(data, status) {
				tinyMCE.get('question').setContent(data.qb_text)
				//$.alert("Fecth" + data.content);
			}).fail(function() {
				$.alert("Error !!");
			})
			//$("#action").val("addTest")
		});
		$(document).on("submit", "#instructionForm", function() {
			event.preventDefault(this);
			var formData = $(this).serialize();
			$.alert("Form Submitted " + formData)
			$.post("onlineSql.php", formData, function() {}, "text").done(function(data, success) {
				$.alert(data)
			})
		});
		$(document).on('click', '.showTest', function() {
			var id = $(this).attr("data-test")
			//$.alert("Section Instruction " + id + " Section " + section);
			$.post("onlineSql.php", {
				testId: id,
				action: "showTest"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert("Fecth" + data.content);
			}).fail(function() {
				$.alert("Error !!");
			})
			$("#instructionHeading").html("<h5>Test Question List/Details</h5>")
			$("#instructionForm").hide()
			$("#questionForm").hide()

		});

		$(document).on('click', '.sectionInstruction', function() {
			var id = $(this).attr("data-test")
			var section = $(this).attr("data-section")
			//$.alert("Section Instruction " + id + " Section " + section);
			$.post("onlineSql.php", {
				testId: id,
				sectionId: section,
				action: "fetchInstruction"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "json").done(function(data, status) {
				tinyMCE.get('instruction').setContent(data.content)
				//$.alert("Fecth" + data.content);
			}).fail(function() {
				$.alert("Error !!");
			})

			$("#instructionHeading").html("<h5>Instructions : Section - " + section + "</h5>")
			$("#instructionId").val("S")
			$("#action").val("addInstruction")
			$("#instructionForm").show()
			//$("#questionForm").show()
			$("#testId").val(id)
			$("#testIdQuestion").val(id)
			$("#sectionId").val(section)
			$("#sectionIdQuestion").val(section)
			$("#actionQuestion").val("addQuestion")
			questionHeading(section)
		});
		$(document).on('click', '.testInstruction', function() {
			var id = $(this).attr("data-test")
			//$.alert("Test Instruction " + id);
			$.post("onlineSql.php", {
				testId: id,
				action: "fetchInstruction"
			}, function(data, status) {
				//$.alert("Fecth" + data.content);
				tinyMCE.get('instruction').setContent(data.content)
			}, "json").fail(function() {
				$.alert("Error !!");
			})
			$("#instructionForm").show()
			$("#instructionHeading").html("<h5>Instructions : Test </h5>")
			$("#instructionId").val("T")
			$("#testId").val(id)
			$("#questionForm").hide()
			$("#questionHeading").hide()
			$("#sectionId").val("-")
		});


		$(document).on("click", ".setActiveButton", function() {
			var id = $(this).attr("data-test")
			//$.alert("Id" + id)
			$.post("onlineSql.php", {
				id: id,
				action: "setActive"
			}, () => {}, "html").done(function(data, status) {
				$.alert(data);
				testList();
			})
		});
		$(document).on("click", ".addQuestionButton", function() {
			var id = $(this).attr("data-test")
			//$.alert("Id " + id);
			$.post("onlineSql.php", {
				action: "addQuestion"
			}, function(data, status) {
				//$.alert("Success " + data);
				$("#testRight").html(data);
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on("click", ".removeTestButton", function() {
			var id = $(this).attr("data-test")
			//$.alert("Id" + id)
			$.confirm({
				title: 'Confirm!',
				draggable: true,
				content: "Please confirm to delete!! ",
				buttons: {
					confirm: {
						btnClass: 'btn-blue',
						action: function() {
							$.post("onlineSql.php", {
								id: id,
								action: "removeTest"
							}, () => {}, "html").done(function(data, status) {
								$.alert(data);
								testList();
							})
						}
					},
					cancel: {
						btnClass: "btn-danger",
						action: function() {}
					},
				}
			});
		});

		$(document).on('click', '.decrement', function() {
			var id = $(this).attr('id');
			var value = $("." + id).text();
			//$.alert("Decrement " + id + "Value" + value);
			$.post('onlineSql.php', {
				action: "decrement",
				id: id,
				value: value
			}, function(data, status) {
				var newValue = Number(value) - 1;
				if (newValue > 0) $("." + id).html(newValue);
				else $("." + id).html(value);
				//$.alert("Updated !! " + data);
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		});
		$(document).on('click', '.increment', function() {
			var id = $(this).attr('id');
			var value = $("." + id).text();
			//$.alert("Increment " + id + "Value" + value);
			$.post('onlineSql.php', {
				action: "increment",
				id: id,
				value: value
			}, function(data, status) {
				var newValue = Number(value) + 1;
				$("." + id).html(newValue);
				//$.alert("Updated !! " + data);
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		});



		function questionLibrary() {
			//$.alert("Library  ")
			$.post("sectionQuestionListSql.php", {
				action: "questionLibrary"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				$(".sectionQuestionList").html(data)
			}).fail(function() {
				$.alert("Error !!");
			})
		}



		function testHeading() {
			//$.alert("In SAS Claim List");
			$.post("onlineSql.php", {
				action: "testHeading"
			}, function(data, status) {
				//$.alert("Success " + data);
				$("#testHeading").html(data);
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		}

		function testQuestionList() {
			//$.alert("In SAS Claim List");
			$.post("onlineSql.php", {
				action: "testQuestionList"
			}, function(data, status) {
				//$.alert("Success " + data);
				$("#testRight").html(data);
			}, "text").fail(function() {
				$.alert("Error !!");
			})
		}

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
<script>
	$(document).on('click', '.uploadQuestionImage, .uploadOptionImage, .uploadKeyFile', function() {
		var uploadId = $(this).attr("data-upload");
		var tag = $(this).attr("data-tag");
		var code = $(this).attr("data-sno");
		//$.alert("Upload Id" + uploadId + "tag " + tag + " Cde " + code);
		$("#uploadId").val(uploadId);
		$("#uploadTag").val(tag);
		$("#uploadCode").val(code);
		if (tag == "questionImage") $(".modalTitle").html("Upload Question Image");
		else if (tag == "optionImage") $(".modalTitle").html("Upload Option Image");
		else $(".modalTitle").html("Upload Key File");
		$('#uploadModal').modal('show');

	});
	$(document).on('submit', '#uploadModalForm', function(event) {
		event.preventDefault();
		var formData = $(this).serialize();
		//$.alert(formData);
		// action and uploadId are passed as hidden
		$.ajax({
			url: "uploadSql.php",
			method: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server.  
			cache: false, // To unable request pages to be cached  
			processData: false, // To send DOMDocument or non processed data file it is set to false  
			success: function(data) {
				//$.alert("List " + data);
				$('#uploadModal').modal('hide');
				$('#uploadModalForm')[0].reset();

			}
		})
	});
</script>
<!-- Modal Section-->
<div class="modal" id="uploadModal">
	<div class="modal-dialog modal-md">
		<form class="form-horizontal" id="uploadModalForm">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modalTitle"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div> <!-- Modal Header Closed-->

				<!-- Modal body -->
				<div class="modal-body">
					<div class="uploadForm">
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<input type="file" name="upload_file">
								</div>
							</div>
						</div>
					</div>
				</div> <!-- Modal Body Closed-->
				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="action" value="upload">
					<input type="hidden" id="uploadId" name="uploadId">
					<input type="hidden" id="uploadTag" name="uploadTag">
					<input type="hidden" id="uploadCode" name="uploadCode">
					<button type="submit" class="btn btn-success btn-sm">Submit</button>
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
				</div> <!-- Modal Footer Closed-->
			</div> <!-- Modal Conent Closed-->
		</form>
	</div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>