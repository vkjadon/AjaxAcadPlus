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
				<div class="mt-2">
					<h5>Feedback</h5>
				</div>

				<div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
					<a class="list-group-item list-group-item-action active df" id="list-df-list" data-toggle="list" href="#list-df" role="tab"> Design Feedback </a>
					<a class="list-group-item list-group-item-action fq" id="list-fq-list" data-toggle="list" href="#list-fq" role="tab"> Feedback Question </a>
					<a class="list-group-item list-group-item-action sf" id="list-sf-list" data-toggle="list" href="#list-sf" role="tab"> Schedule Feedback </a>
					<a class="list-group-item list-group-item-action fr" id="list-fr-list" data-toggle="list" href="#list-fr" role="tab"> Feedback Report</a>
				</div>
			</div>
			<div class="col-10 leftLinkBody">
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane show active" id="list-df" role="tabpanel">
						<div class="row">
							<div class="col-5">
								<div class="container card myCard mt-2">
									<div class="row mt-2">
										<div class="col">
											<label>Select/Design Template</label>
										</div>
									</div>
									<form class="form-horizontal" id="addTemplateForm">
										<div class="row mt-2">
											<div class="col-6">
												<div class="form-group">
													<label>Feedback Type</label>
													<?php
													$sql = "select * from master_name where mn_code='ft' and mn_status='0' order by mn_name";
													selectList($conn, "Select Feedback Type", array("1", "mn_id", "mn_name", "", "sel_ft"), $sql);
													?>
												</div>
											</div>
											<div class="col-6">
												<div class="form-group">
													<label>Template Name </label>
													<input type="text" class="form-control form-control-sm" id="template_name" name="template_name" placeholder="Template Name">
												</div>
											</div>

										</div>
										<input type="hidden" name="action" value="addTemplate">
										<button type="submit" class="btn btn-sm">Submit</button>
									</form>
								</div>
								<div class="container card shadow mt-2 mb-2 myCard">
									<label>Feedback Statistics</label>
									<div class="row">
										<div class="col">
											<span class="footerNote"> The Feeback is taken for any existing Template. So, if existing templates do not satisfy your requirements, please, create a New template. Previously used templates can not be edited. </span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-7 p-0">
								<div class="templateList"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="list-fq" role="tabpanel">
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
												<div class="col-7 pr-1">
													<div class="form-group">
														<label>Option</label>
														<input type="text" class="form-control form-control-sm option" data-tag="fo_statement">
													</div>
												</div>
												<div class="col-2 p-0 pr-1">
													<div class="form-group">
														<label>Score</label>
														<input type="number" class="form-control form-control-sm score" data-tag="fo_score">
													</div>
												</div>
												<div class="col-2 p-0 pr-1">
													<div class="form-group">
														<label>Order</label>
														<input type="number" class="form-control form-control-sm sno" data-tag="fo_sno">
													</div>
												</div>
												<div class="col-1 p-0">
													<div class="form-group">
														<input type="hidden" id="fq_id" name="fq_id">
														<input type="hidden" id="fo_sno" name="fo_sno">
														<label>&nbsp;</label>
														<a href="#" class="atag p-0 m-0 addOption">
															<h3><i class="fa fa-floppy-o"></i></h3>
														</a>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<label class="footer">A question once added can not be deleted. You can edit it only before it is added to any one of the Feedback.</label>
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
										<div class="col-2 pr-1">
											<label>Question</label>
										</div>
										<div class="col pl-1">
											<div class="currentQuestionStatement testQuestionText"></div>
										</div>
									</div>
									<div class="row mt-1">
										<div class="col-2 pr-1">
											<div class="addQuestionToDatabaseButton"></div>
										</div>
										<div class="col pl-1">
											<table class="table table-striped list-table-xs" id="questionOptionTable">
												<tr class="align-center">
													<th>#</th>
													<th>Order</th>
													<th>Option</th>
													<th>Score</th>
													<th><i class="fas fa-edit"></i></th>
													<th><i class="fas fa-trash"></i></th>
												</tr>
											</table>
											<div class="questionOption"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<a href="#" class="atag showQuestion">Question List</a>
				<span class="questionList"></span>

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
		$(".questionList").hide()

		$(".showQuestion").click(function() {
			$(".questionList").toggle();
			// $("#action").val("addTest")
		});

		// Feedback Template Block
		$(document).on("click", ".df", function() {
			$(".addToTemplate").show()
			$(".setActive").hide()
			$(".questionList").hide()
		})
		$(document).on("change", "#sel_ft", function() {
			var ft_id = $("#sel_ft").val();
			if (ft_id == "") $.alert("Select a FeedBack Type to Proceed!!");
			else templateList()
		})
		$(document).on("submit", "#addTemplateForm", function() {
			event.preventDefault(this);
			//$.alert("Form Submitted ");
			var formData = $(this).serialize();
			$.alert(formData);
			$.post("feedbackSql.php", formData, () => {}, "text").done(function(mydata, mystatus) {
				$.alert(mydata);
				// $('#addTemplateForm')[0].reset();
			}).fail(function() {
				$.alert("fail in place of error");
			})
		})
		$(document).on("click", ".addToTemplate", function() {
			var fq_id = $(this).attr("data-fq")
			$.alert("Question Id " + fq_id);
			$.post("feedbackSQL.php", {
				fq_id: fq_id,
				action: "addToTemplate"
			}, function() {}, "text").done(function(data, status) {
				$.alert(data);
				// questionList()
			})
		})
		$(document).on("click", ".setActiveTemplate", function() {
			var template_id = $(this).attr("data-template")
			//$.alert("Question Id " + fq_id);
			$.post("feedbackSQL.php", {
				template_id: template_id,
				action: "setActiveTemplate"
			}, function() {}, "text").done(function(data, status) {
				$.alert(data);
				templateList()
			})
		})
		$(document).on("click", ".showTemplateModal", function() {
			var template_id = $(this).attr("data-template")
			$.alert("Question Id " + template_id);
			$.post("feedbackSQL.php", {
				template_id: template_id,
				action: "templateQuestionList"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data);
				var card = '';
				$.each(data, function(key, value) {
					var template_name = value.fq_statement;
					card += '<div class="row mt-2">';
					card += '<div class="col">';
					card += template_name;
					// card += "Id" + value.fq_id + "count" + count;
					card += '</div>';
					card += '</div>';
				})
				$(".showTemplate").html(card);
				$('#firstModal').modal('show');

			})
		})

		function templateList() {
			var ft_id = $("#sel_ft").val();
			// $.alert("Fb Type " + ft_id);
			$.post("feedbackSql.php", {
				ft_id: ft_id,
				action: "templateList"
			}, function() {}, "json").done(function(data, status) {
				if (data.success == "0") {
					var success = "No Template Found! Please create a Template by adding Template Name to Start"
					$(".templateList").html(success)

				} else {
					var card = '';
					var count = 1;
					var cols = 3;
					$.each(data, function(key, value) {
						var template_name = value.template_name;
						if (template_name != null) {
							var template_id = value.template_id;
							if (count == 1) card += '<div class="row mt-2">';
							card += '<div class="col-6">';
							if (value.template_status == "0") card += '<div class="container card myCard bg-two text-white">';
							else card += '<div class="container card myCard">';
							card += '<div class="testQuestionText">';
							card += template_name;
							// card += "Id" + value.fq_id + "count" + count;
							card += '</div>';
							card += '<div class="row">';
							if (value.template_status == "0") {
								card += '<button class="btn btn-sm btn-active showTemplateModal"  data-template="' + template_id + '">Show</button>'
								card += '<button class="btn btn-sm btn-active showTemplateModal">Use</button>'
							} else {
								card += '<button class="btn btn-sm showTemplateModal" data-template="' + template_id + '">Show</button>'
								card += '<button class="btn btn-sm setActiveTemplate" data-template="' + template_id + '">Active</button>'
								card += '<button class="btn btn-sm showTemplateModal">Use</button>'
							}
							card += '</div>'

							card += '</div>';
							card += '</div>';
							count++
							if (count == cols) {
								card += '</div>';
								count = 1;
							}
						}
					})
					$(".templateList").html(card);
				}
			})
		}
		// Feedback Question Block
		$(document).on("click", ".fq", function() {
			$(".setActive").show()
			$(".addToTemplate").hide()
			$(".questionList").hide()
		})
		$(document).on("click", ".addQuestion", function() {
			var statement = $("#statement").val();
			if (statement == "") $.alert("Statement is Blank");
			else {
				$(".addQuestion").hide()
				//$(this).find("i.fa").removeClass("fa-floppy-o");
				$("#statement").addClass("statement");

				$.alert("Question Save Clicked " + statement);
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
				// $(this).find("i.fa").removeClass("fa-floppy-o");
				// $(this).find("i.fa").addClass("fa-times-circle");
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
					//$.alert(data);
					currentQuestion()
				})
			}
		})
		$(document).on("blur", ".option, .sno, .score", function() {
			var tag = $(this).attr("data-tag");
			if (tag == "fo_statement") var value = $(".option").val();
			else if (tag == "fo_score") var value = $(".score").val();
			else var value = $(".sno").val();
			var fq_id = $("#fq_id").val();
			var fo_sno = $("#fo_sno").val();
			//$.alert("Tag " + tag + " value " + value + " Fq " + fq_id);
			$.post("feedbackSQL.php", {
				fq_id: fq_id,
				fo_sno: fo_sno,
				tag: tag,
				value: value,
				action: "updateOption"
			}, function() {}, "text").done(function(data, status) {
				//$.alert(data);
				currentQuestion()
			})
		})
		$(document).on("click", ".acceptQuestionButton", function() {
			// $.alert("Question Id ");
			$("#statement").removeClass("statement");
			$.post("feedbackSQL.php", {
				action: "acceptQuestion"
			}, function() {}, "text").done(function(data, status) {
				//$.alert(data);
				currentQuestion()
				questionList()
			})
		})
		$(document).on("click", ".setActive", function() {
			var fq_id = $(this).attr("data-fq")
			//$.alert("Question Id " + fq_id);
			$.post("feedbackSQL.php", {
				fq_id: fq_id,
				action: "setActive"
			}, function() {}, "text").done(function(data, status) {
				//$.alert(data);
				currentQuestion()
				questionList()
			})
		})
		$(document).on("click", ".editOption", function() {
			var fq_id = $(this).attr("data-fq")
			var fo_sno = $(this).attr("data-fo")
			$("#fq_id").val(fq_id)
			$("#fo_sno").val(fo_sno)

			// $.alert("Question Id " + fq_id + " Option sno" + fo_sno);
			$.post("feedbackSQL.php", {
				fq_id: fq_id,
				fo_sno: fo_sno,
				action: "fetchOption"
			}, function() {}, "json").done(function(data, status) {
				// $.alert(data.fo_statement);
				$(".option").val(data.fo_statement)
				$(".score").val(data.fo_score)
				$(".sno").val(data.fo_sno)
				// currentQuestion()
				// questionList()
			})
		})

		function currentQuestion() {
			$.post("feedbackSql.php", {
				action: "fetchCurrentQuestion"
			}, function() {}, "json").done(function(data, status) {
				//$.alert("Current Question" + data.fq_statement);
				$(".currentQuestionStatement").html(data.fq_statement)
				// $("#currentQuestion").html(data.fq_statement)
				// Following statements are required if any incomplete question is in the database
				if (data.fq_statement == "No Question is Active") {
					$("#statement").val("")
					$(".addQuestion").show()
				} else {
					$("#statement").val(data.fq_statement)
					$("#statement").addClass("statement");
					// var fq_id = data.fq_id;
					$(".addQuestion").hide()
				}
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
					option += '<td><a href="#" class="editOption" data-fq="' + value.fq_id + '" data-fo="' + value.fo_sno + '"><i class="fa fa-edit"></i></a></td>';
					option += '<td><a href="#" class="trashOption" data-fq="' + value.fq_id + '" data-fo="' + value.fo_sno + '"><i class="fa fa-trash"></i></a></td>';
					option += '</tr>';
					count++;
				})
				$("#questionOptionTable").find("tr:gt(0)").remove();
				$("#questionOptionTable").append(option)
				if (count > 2) $(".addQuestionToDatabaseButton").html('<button class="btn btn-sm btn-block acceptQuestionButton m-1 p-1">Add</button>')
				// else $(".addQuestionToDatabaseButton").html("Add Options")
			});
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
					card += '<div class="col"><a href="#" class="setActive" data-fq="' + value.fq_id + '">Active</a>'
					card += '<a href="#" class="addToTemplate" data-fq="' + value.fq_id + '">Template</a></div>'
					card += '</div>'

					card += '<div class="testQuestionText">';
					card += value.fq_statement;
					// card += "Id" + value.fq_id + "count" + count;
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
				$(".setActive").hide()

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
<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">
        <!-- Modal body -->
          <div class="card myCard ml-3 mr-3 mt-3 mb-1">
            <div class="card-title"><h5>Template Questions</h5></div>
            <div class="row mb-2">
              <div class="col ml-2">
                <div class="showTemplate"></div>
              </div>
            </div>
          </div>
        <div class="card myCard">
          <div class="row">
            <div class="col">
              <button class="btn btn-sm btn-approve" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>