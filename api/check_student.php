<?php
    include('authenticate.php');
	
    $response=array("script" => "check_student.php", "authentication"=>$userFound, "MyStdId"=>$myStdId);
    
    if($userFound=='1')
    {
        $sql="SELECT * from intra_users where af_id='$myStdId'";
        $result=$conn->query($sql);
	
	    if($result)
	    {
	        $row_count = $result->num_rows;
	        if($row_count==0)$response["student"]='0';
	        else $response["student"]='1';
	    }
	    else echo $conn->error;
    }
    
    $jsonOutput = json_encode($response);
	echo $jsonOutput;
?>
	