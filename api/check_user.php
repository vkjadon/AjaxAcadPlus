<?php
	$myUn=$_GET['u'];
	$myPwd=$_GET['p'];
    require("../config_database.php");

    $response=array("script" => "check_dept_head");

	$userFound='1';
    
    $sql="SELECT * from intra_users where username='$myUn'";
    $result=$conn->query($sql);
	
	if($result)
	{
	    $row_count = $result->num_rows;
	    if($row_count==0)
	    {
	        $userFound='0';
	        $response["found"]='no';
	        $response["user"]="0";
        }
        else 
	    {
	        $rows=$result->fetch_assoc();
            $myId=$rows['staff_id'];
            $response["found"]='yes';
            $response["user"]=$rows['staff_id'];
	    }
	    $jsonOutput = json_encode($response);
    	echo $jsonOutput;

	}
	else echo $conn->error;
?>
	