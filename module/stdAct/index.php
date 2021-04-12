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
	<?php require("../css.php");?>

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
			<div class="col-4">
			</div>
			<div class="col-3 mt-2 pt-2">
				<div class="card">
					<h3 class="text-center">Sorry!!</h1>
						<div class="card-body">
						<h5> Some missing parameter landed you here. Please check the URL.</h5>
						</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php require("../js.php");?>

<script>
	// Storing data:

	$(document).ready(function() {
		$("#currentQuestionId").hide();

		$('#userForm').submit(function(event) {
			event.preventDefault(this);
			var formData = $(this).serialize();
			//alert(formData);
			$.post("olat_user.php", formData, function(mydata, mystatus) {
				//alert(" success " + mydata.found);
			}, "text").done(function(data, mystatus) {
				alert("Id " + data);
				if (data != "NotFound") {
					location.href = "admin.php";
				} else alert("Not Found");
			}).fail(function() {
				alert("fail in place of error");
			})
		});

		clockUpdate();
		setInterval(clockUpdate, 1000);
		var i = 1;
		setInterval(function() {
			var m = Math.floor(i / 60);
			var s = i - m * 60;
			$("#stopWatch").html("<h6>" + m + " min " + s + " Sec</h6>");
			i++;
		}, 1000);

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