<?php 
	$sql="select * from user_privilege where user_id='$myUn'";
	$result=$conn->query($sql);
	if($result && $result->num_rows>0){
		$rowsUp=$result->fetch_assoc();
		$privilege=$rowsUp["up_code"];
	} else $privilege=100;
	if($privilege==9)require("topBarAdmin.php"); 
	elseif($privilege==1)require("topBarStaff.php");
	elseif($privilege==0)require("topBarFaculty.php");
	else require("topBarMin.php");
	?>