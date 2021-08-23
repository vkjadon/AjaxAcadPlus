<?php
session_start();
include('../openDb.php');
require('../php_function.php');
include('../phpFunction/onlineFunction.php');
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
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