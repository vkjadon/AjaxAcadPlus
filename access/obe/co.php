<?php
// session_start();
$subject_id=$_GET['subject'];
$myDb=$_GET['inst'];
echo "Subject $subject_id DB $myDb";
include('openObeDb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
	
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-4 mt-4 pt-2">
				<div class="card myCard">
					<h3 class="text-center">OBE Portal</h1>
						<div class="card-body">

						</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>