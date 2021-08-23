<?php
session_start();
include('openTestDb.php');
require('../php_function.php');
include('../phpFunction/onlineFunction.php');
$id = $_GET['id'];
$array = testQuestionList($conn, $id, "0");
$totalQuestions = count($array["data"]);

if ($totalQuestions > 0) {
	$test_name = getField($conn, $id, "test", "test_id", "test_name");
} else $test_name = "Invalid Test Link";
//echo $totalQuestions;
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>

	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
	<!-- MDB -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<link rel="stylesheet" href="../table.css">
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
					<h5 class="text-white"><?php echo $test_name; ?></h5>
				</td>
				<td class="text-white">
					<h5><?php echo 'Test Questions : ' . $totalQuestions; ?></h5>
				</td>
				<td>
					<form method="post">
						<button type="submit" class="btn btn-light btn-square-sm">ReTest</button>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
					</form>
				</td>
			</tr>
		</table>
		<?php
		if ($totalQuestions > 0) {
			for ($i = 0; $i < $totalQuestions; $i++) {
				$qb[$i] = $array["data"][$i]["qb_id"];
				//echo '-' . $qb[$i];
			}
			$currentQuestion = $qb[rand(0, ($totalQuestions - 1))]; //set first question for the test
			$currentQuestion = $qb[0]; //set first question for the test
		} else {
			echo '<a href="index.php" class="btn btn-info btn-lg">Not a Valid Test!! Click to Go Back to Test Home</a>';
			die();
		}
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-9 pr-0">
						<p class="showQuestion"></p>
					</div>
					<div class="col-sm-3">
						<div class="row">
							<div class="col-sm-6 pr-0">
								<div class="card-header">
									Start Time
									<div id="startTime">
										<h6><?php echo date("h:i:s", time()); ?></h6>
									</div>
								</div>
							</div>
							<div class="col-sm-6 pl-0">
								<div class="card-header">
									Time Used
									<div id="stopWatch">0</div>
								</div>
							</div>
						</div>
						<span id="currentQuestionId"><?php echo $currentQuestion; ?></span>
						<p class="questionPallete"></p>
						<div class="row">
							<div class="col"><a href="index.php" class="btn btn-info btn-block btn-lg">More Tests...</a></div>
						</div>
						<!-- <span id="remainingQuestions"></span> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	tinymce.init({
		selector: 'textarea',
		plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		toolbar_mode: 'floating',
		height: "320",
	});
</script>

<script>
	// Storing data:

	$(document).ready(function() {
		$("#currentQuestionId").hide();
		clockUpdate();
		setInterval(clockUpdate, 1000);
		var response_value = [];
		var qbArray = <?php echo json_encode($qb); ?>;

		$("#remainingQuestions").html(qbArray);
		questionPallete();
		getQuestion("0");
		var i = 1;
		setInterval(function() {
			var m = Math.floor(i / 60);
			var s = i - m * 60;
			$("#stopWatch").html("<h6>" + m + " min " + s + " Sec</h6>");
			i++;
		}, 1000);

		$(document).on("click", ".evaluateCP", function() {
			var icp = $(this).attr("data-icp");
			var ans = $(this).attr("data-ans");
			var range = $(this).attr("data-range");
			var response = $("#res" + icp).val();
			const max = 0.01 * (100 + parseFloat(range)) * ans;
			const min = 0.01 * (100 - parseFloat(range)) * ans;
			//$.alert(" ICP " + icp + " answer " + ans + " Response " + response + " Range " + range + " Max " + max + " Min " + min);
			if (response >= min && response <= max) {
				//$.alert("Correct");
				$("#icp" + icp).html('<i class="fa fa-check"></i>');
			} else {
				//$.alert("InCorrect");
				$("#icp" + icp).html('<i class="fa fa-times"></i>');
			}
		});

		$(document).on("click", ".qpBtnNotVisited, .qpBtnVisited", function() {
			var qb_id = $(this).attr("data-qb");
			$(".qpBtnCurrent").removeClass("qpBtnCurrent").addClass("qpBtnVisited");				
			//$("#pallete" + qb_id).removeClass("qpBtnVisited qpBtnNotVisited").addClass("qpBtnCurrent");				
			//$.alert("Get Question " + qb_id)
			var index = qbArray.indexOf(qb_id);
			var currentQuestionId = qbArray[index];
			//$.alert("df" + index + " Length " + qbArray.length + " QbId " + currentQuestionId);
			$("#currentQuestionId").html(currentQuestionId);
			getQuestion(index);
		})


		$(document).on("click", ".nextQuestion", function() {
			var qb_id = $(this).attr("data-qb");
			$("#pallete" + qb_id).removeClass("qpBtnCurrent").addClass("qpBtnVisited");
				
			$.alert("Get Question " + qb_id + " Response " + response_value)
			var index = qbArray.indexOf(qb_id) + 1;
			if (index == qbArray.length) index = 0;
			response_value = [];
			var currentQuestionId = qbArray[index];
			//$.alert("df" + index + " Length " + qbArray.length + " QbId " + currentQuestionId);
			$("#currentQuestionId").html(currentQuestionId);
			getQuestion(index);
		})
		$(document).on("click", ".submitOption", function() {
			var qb_id = $(this).attr("data-qb");
			var qo_code = $(this).attr("data-code");
			$("#pallete" + qb_id).removeClass("qpBtnCurrent");
			$("#pallete" + qb_id).addClass("qpBtnSubmitted");
			//$.alert("Get Question " + qb_id + " Code " + qo_code + " Response " + response_value)
			$.post("openTestSql.php", {
				response_value: response_value,
				qb_id: qb_id,
				qo_code: qo_code,
				action: "submitOption"
			}, function() {}, "text").done(function(data, status) {
				//$.alert(" Result " + data);
				if (data == "Correct") {
					//$.alert("Congratulations!!");
					//const index = qbArray.indexOf(qb_id);
					//if (index > -1) {
						//qbArray.splice(index, 1);
					//}
					//$("#remainingQuestions").html(qbArray);
					response_value = [];
					//var currentQuestionId = qbArray[index];
					// Generate Random Number
					//var currentQuestionId = qbArray[Math.floor(Math.random() * qbArray.length)];
					//$.alert("JS Array " + qbArray + " Current " + currentQuestionId);
					//$("#currentQuestionId").html(currentQuestionId);

					$.confirm({
						title: 'Congratulations!!',
						content: 'You are going Great',
						type: 'green',
						typeAnimated: true,
						buttons: {
							tryAgain: {
								text: 'Try More',
								btnClass: 'btn-green',
								action: function() {}
							},
						}
					});
					//getQuestion(index);
				} else {
					$.confirm({
						title: 'Wrong Attempt! Good Try !!',
						content: 'You can try again',
						type: 'red',
						typeAnimated: true,
						buttons: {
							tryAgain: {
								text: 'Try Again',
								btnClass: 'btn-red',
								action: function() {}
							},
						}
					});
				}
			}).fail(function(data) {
				$.alert("Error!!");
			})
		})
		$(document).on("click", ".markOption", function() {
			var qb_id = $(this).attr("data-qb");
			var qo_code = $(this).attr("data-code");
			var status = $("#" + qo_code).html();
			if (status == "") {
				response_value.push(qo_code);
				$("#" + qo_code).html('<i class="fa fa-check"></i>');
			} else {
				$("#" + qo_code).html("");
				const index = response_value.indexOf(qo_code);
				if (index > -1) {
					response_value.splice(index, 1);
				}
			}
			//$.alert(" Response Array " + response_value)
		})

		function getQuestion(sno) {
			var qb_id = $("#currentQuestionId").html();
			//$.alert("Get Question Function  " + qb_id)
			$.post("openTestSql.php", {
				test_id: <?php echo $id ?>,
				qb_id: qb_id,
				sno: sno,
				action: "getQuestion"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				$("#pallete" + qb_id).removeClass("qpBtnNotVisited qpBtnVisited qpBtnSubmitted");
				$("#pallete" + qb_id).addClass("qpBtnCurrent");
				//var text = $("#pallete" + qb_id).html();
				//text = $("#pallete" + qb_id).html('<span class="text-danger">' + text + '</b>');
				$(".showQuestion").html(data)
			}).fail(function(data) {
				$.alert("Error!!");
			})
		}

		function questionPallete() {
			//$.alert("Section  " + qbArray)
			$.post("openTestSql.php", {
				test_id: <?php echo $id ?>,
				qbArray: qbArray,
				action: "questionPallete"
			}, function() {
				//$.alert("Fecth" + mydata);
			}, "text").done(function(data, status) {
				//$.alert(data);
				$(".questionPallete").html(data)
			}).fail(function(data) {
				$.alert("Error www !!");
			})
		}

		function testHeading() {
			//$.alert("In SAS Claim List");
			$.post("openTestSql.php", {
				test_id: <?php echo $id ?>,
				action: "testHeading"
			}, function(data, status) {
				//$.alert("Success " + data);
				$("#testHeading").html(data);
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

</html>