<?php
    include('authenticate.php');
	
    $response=array("script" => "check_dept_head.php", "authentication"=>$userFound, "MyId"=>$myId);
    
    if($userFound=='1')
    {
        $sql="SELECT * from department_head where staff_id='$myId'";
        $result=$conn->query($sql);
	
	    if($result)
	    {
	        $row_count = $result->num_rows;
	        if($row_count==0)$response["head"]='0';
	        else $response["head"]='1';
	    }
	    else echo $conn->error;
    }
    
    $jsonOutput = json_encode($response);
	echo $jsonOutput;
?>