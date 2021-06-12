<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<?php require("../css.php"); ?>
</head>

<body>
	<?php require("../topBar.php"); ?>
	<div class="container-fluid moduleBody">
		<div class="row">
			<div class="col-2 p-0 m-0 pl-2 full-height">
				<div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
					<a class="list-group-item list-group-item-action active fq" id="list-fq-list" data-toggle="list" href="#list-fq" role="tab"> Feedback Question </a>
					<a class="list-group-item list-group-item-action df" id="list-df-list" data-toggle="list" href="#list-df" role="tab"> Design Feedback </a>
					<a class="list-group-item list-group-item-action sf" id="list-sf-list" data-toggle="list" href="#list-sf" role="tab"> Schedule Feedback </a>
					<a class="list-group-item list-group-item-action fr" id="list-fr-list" data-toggle="list" href="#list-fr" role="tab"> Feedback Report</a>
				</div>
			</div>
			<div class="col-10 leftLinkBody">
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane show active" id="list-fq" role="tabpanel">
						<div class="row">
							<div class="col-6 pr-0">
								<div class="container card mt-2 myCard">
									<!-- nav options -->
									<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="pill" href="#pills_fq" role="tab">Question</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="pills_leaveBalance" data-toggle="pill" href="#pills_balance" role="tab">Leave Balance</a>
										</li>
									</ul> <!-- content -->
									<div class="tab-content" id="pills-tabContent p-3">
										<div class="tab-pane fade show active" id="pills_fq" role="tabpanel">
											<div class="row">
												<div class="col-11 pr-0">
													<div class="form-group">
														<label>Question Statement </label>
														<input type="text" class="form-control form-control-sm" id="statement" name="statement" placeholder="Add Question Statement">
													</div>
												</div>
												<div class="col-1 pl-1 pr-1">
													<div class="form-group">
														<label>&nbsp;</label>
														<a href="#" class="atag p-0 m-0 addQuestion">
															<h3><i class="fa fa-floppy-o"></i></h3>
														</a>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-9 pr-1">
													<div class="form-group">
														<input type="text" class="form-control form-control-sm option">
													</div>
												</div>
												<div class="col-1 p-0 pr-1">
													<div class="form-group">
														<input type="number" class="form-control form-control-sm score">
													</div>
												</div>
												<div class="col-1 p-0 pr-1">
													<div class="form-group">
														<input type="number" class="form-control form-control-sm sno">
													</div>
												</div>
												<div class="col-1 p-0">
													<div class="form-group">
														<a href="#" class="atag p-0 m-0 addOption">
															<h3><i class="fa fa-floppy-o"></i></h3>
														</a>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<label class="footer">A question once added can not be deleted. You can edit it only before it is added to any on the Feedback.</label>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="pills_balance" role="tabpanel" aria-labelledby="pills_balance">
											<div class="row">
												<div class="col-12">
													<table class="table table-striped list-table-xs mt-2" id="leaveBalanceTable">
														<tr class="align-center">
															<th>Leave Type </th>
															<th>Credit</th>
															<th>Debit</th>
															<th>Balance</th>
														</tr>
													</table>
													<a href="#" class="atag leaveCredit">Credit Details</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="container card shadow mt-2 mb-2 myCard">
									<div class="card-title-xs leaveTableTitle" id="leaveTableTitle">Current Question</div>
								</div>
								<div class="container card m-0 myCard">
									<div class="row">
										<div class="col">
											<label>Statement</label>
											<div class="testQuestionText"></div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col">
											<label>Options</label>
											<table class="table table-striped list-table-xs" id="questionOptionTable">
												<tr class="align-center">
													<th>#</th>
													<th>Order</th>
													<th>Statement</th>
													<th>Score</th>
													<th><i class="fas fa-edit"></i></th>
													<th><i class="fas fa-trash"></i></th>
												</tr>
											</table>
											<div class="questionOption"></div>
											<div class="addQuestionToDatabaseButton"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<span class="questionList"></span>
					</div>
					<div class="tab-pane fade" id="list-df" role="tabpanel">
						<div class="row">
							<div class="col-5">
								<div class="container card myCard mt-2">
									<!-- nav options -->
									<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="pills_leaveType" data-toggle="pill" href="#pills_type" role="tab" aria-controls="pills_type" aria-selected="true">Leave Credit</a>
										</li>
									</ul> <!-- content -->
									<div class="tab-content" id="pills-tabContent p-3">
										<div class="tab-pane fade show active" id="pills_type" role="tabpanel" aria-labelledby="pills_leaveType">
											<form class="form-horizontal" id="addLeaveSetup">
												<div class="row">
													<?php
													$months = array(" ", "January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
													echo '<div class="col-6">';
													echo '<div class="form-group">';
													echo '<select class="form-control form-control-sm" name="sel_month" id="sel_month" required>';
													echo '<option selected disabled>Select Month</option>';
													for ($i = 1; $i < 13; $i++) echo '<option value="' . $i . '">' . $months[$i] . '</option>';
													echo '</select>';
													echo '</div>';
													echo '</div>';
													?>
													<?php
													$sql_lt = "select * from leave_type where lt_status='0' order by lt_name";
													$result = $conn->query($sql_lt);
													echo '<div class="col-6">';
													echo '<div class="form-group">';
													if ($result) {
														echo '<select class="form-control form-control-sm" name="sel_lt" id="sel_lt" required>';
														echo '<option selected disabled>Select Leave Type</option>';
														while ($rows = $result->fetch_assoc()) echo '<option value="' . $rows['lt_id'] . '">' . $rows['lt_name'] . '</option>';
														echo '</select>';
													} else echo $conn->error;
													echo '</div></div>';
													if ($result->num_rows == 0) echo 'No Data Found';
													?>
												</div>
												<div class="row">
													<div class="col-4">
														<div class="form-group">
															<label>Year</label>
															<input type="number" class="form-control form-control-sm" id="lsYear" name="lsYear" min="2020" value="<?php echo date("Y", time()); ?>">
														</div>
													</div>
													<div class="col-4">
														<div class="form-group">
															<label>Male</label>
															<input type="number" class="form-control form-control-sm" id="lsMale" name="lsMale" value="0">
														</div>
													</div>
													<div class="col-4">
														<div class="form-group">
															<label>Female</label>
															<input type="number" class="form-control form-control-sm" id="lsFemale" name="lsFemale" value="0">
														</div>
													</div>
												</div>
										</div>
										<input type="hidden" id="lsId" name="lsId" value="0">
										<input type="hidden" id="actionLeaveSetup" name="action" value="addLeaveSetup">
										<button class="btn btn-sm m-0" type="submit">Submit</button>
										</form>
									</div>
								</div>
							</div>
							<div class="col-7">
								<div class="container card shadow mt-2 mb-2 myCard">
									<label>Leave Credit</label>
								</div>
								<div class="container card shadow m-0 myCard">
									<table class="table table-bordered table-striped list-table-xs mt-3 leaveSetupTable" id="leaveSetupTable">
										<th><i class="fas fa-edit"></i></th>
										<th>Leave Type</th>
										<th>Month</th>
										<th>Year</th>
										<th>Male</th>
										<th>Female</th>
									</table>
								</div>
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
		currentQuestion()
		questionList()

		$(document).on("click", ".addQuestion", function() {
			var statement = $("#statement").val();
			if (statement == "") $.alert("Statement is Blank");
			else {
				$(".addQuestion").hide()
				//$(this).find("i.fa").removeClass("fa-floppy-o");
				$("#statement").addClass("statement");

				//$.alert("Question Save Clicked " + statement);
				$.post("feedbackSQL.php", {
					statement: statement,
					action: "addStatement"
				}, function() {}, "text").done(function(data, status) {
					$.alert(data);
					currentQuestion()
				})
			}
		})

		$(document).on("click", ".addOption", function() {
			var option = $(".option").val();
			var score = $(".score").val();
			var sno = $(".sno").val();

			if (option == "") $.alert("Option is Blank")
			else {
				$(this).find("i.fa").removeClass("fa-floppy-o");
				$(this).find("i.fa").addClass("fa-times-circle");
				$.alert("Option" + option + "Score" + score + " sno " + sno)

				$.post("feedbackSql.php", {
					statement: option,
					score: score,
					sno: sno,
					action: "addOption"
				}, function() {}, "text").done(function(data, staus) {
					// $.alert(data);
					$(".option").val("")
					$(".score").val("")
					$(".sno").val("")
					currentQuestion()

				}).fail(function() {
					$.alert("Error in Option Update")
				})
			}
		})

		$(document).on("blur", ".statement", function() {
			var statement = $("#statement").val();
			if (statement == "") $.alert("Statement is Blank");
			else {
				//$.alert("Question Save Clicked " + statement);
				$.post("feedbackSQL.php", {
					statement: statement,
					action: "updateStatement"
				}, function() {}, "text").done(function(data, status) {
					$.alert(data);
					currentQuestion()
				})
			}
		})

		$(document).on("click", ".acceptQuestionButton", function() {
			$.alert("Question Id ");
			$.post("feedbackSQL.php", {
				action: "acceptQuestion"
			}, function() {}, "text").done(function(data, status) {
				$.alert(data);
				currentQuestion()
			})
		})

		$(document).on("click", ".setActive", function() {
			var fq_id = $(this).attr("data-fq")
			$.alert("Question Id " + fq_id);
			$.post("feedbackSQL.php", {
				fq_id: fq_id,
				action: "setActive"
			}, function() {}, "text").done(function(data, status) {
				$.alert(data);
				currentQuestion()
				questionList()
			})
		})

		function currentQuestion() {
			$.post("feedbackSql.php", {
				action: "fetchCurrentQuestion"
			}, function() {}, "json").done(function(data, status) {
				// $.alert("Current Question" + data);
				$(".testQuestionText").html(data.fq_statement)
				// $("#currentQuestion").html(data.fq_statement)
				// Following statements are required if any incomplete question is in the database
				$("#statement").val(data.fq_statement)
				$("#statement").addClass("statement");
				var fq_id = data.fq_id;
				$(".addQuestion").hide()
			});
			$.post("feedbackSql.php", {
				action: "fetchCurrentQuestionOption"
			}, function() {}, "json").done(function(data, status) {
				// $.alert("Options " + data);
				var option = '';
				var count = 1;
				$.each(data, function(key, value) {
					option += '<tr>';
					option += '<td>' + count + '</td>';
					option += '<td>' + value.fo_sno + '</td>';
					option += '<td>' + value.fo_statement + '</td>';
					option += '<td>' + value.fo_score + '</td>';
					option += '<td><a href="#" class="editOption" data-fq="' + value.fq_id + '" data-fo="' + value.fq_sno + '"><i class="fa fa-edit"></i></a></td>';
					option += '<td><a href="#" class="trashOption" data-fq="' + value.fq_id + '" data-fo="' + value.fq_sno + '"><i class="fa fa-trash"></i></a></td>';
					option += '</tr>';
					count++;
				})
				$("#questionOptionTable").find("tr:gt(0)").remove();
				$("#questionOptionTable").append(option)
				if (count > 2) $(".addQuestionToDatabaseButton").html('<button class="btn btn-sm acceptQuestionButton">Add Question</button>')
				else $(".addQuestionToDatabaseButton").html("Add Options")
			});
			var row = '';
			row += '<input type="text" class="form-control form-control-sm option">';
			$(".newOption").html(row);
			var row = '';
			row += '<input type="number" class="form-control form-control-sm score">';
			// $("#options").find("tr:gt(0)").remove();
			$(".newScore").html(row);
			var row = '';
			row += '<input type="number" class="form-control form-control-sm sno">';
			// $("#options").find("tr:gt(0)").remove();
			$(".newSno").html(row);
			var row = '';
			row += '<a href="#" class="atag p-0 m-0 addOption"><h3><i class="fa fa-floppy-o"></i></h3></a>';
			$(".newSaveOption").html(row);
		}

		function questionList() {
			$.post("feedbackSql.php", {
				action: "questionList"
			}, function() {}, "json").done(function(data, status) {
				// $.alert("Current Question" + data);
				var card = '';
				var count = 1;
				var cols = 5;
				$.each(data, function(key, value) {
					if (count == 1) card += '<div class="row mt-2">';
					card += '<div class="col-3 pr-0">';
					card += '<div class="container card myCard" style="height:100px">';
					card += '<div class="row">';
					card += '<div class="col"><a href="#" class="setActive" data-fq="' + value.fq_id + '">Active</a></div>'
					card += '<div class="col"><a href="#" class="">Add to Test</a></div>'
					card += '</div>'

					card += '<div class="testQuestionText">';
					card += value.fq_statement;
					card += "Id" + value.fq_id + "count" + count;
					card += '</div>';
					card += '</div>';
					card += '</div>';
					count++
					if (count == cols) {
						card += '</div>';
						count = 1;
					}
				})
				$(".questionList").html(card);
			});
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
	});
</script>

</html>