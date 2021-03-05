<?php
	$myId=$_GET['id'];
	$myUn=$_GET['u'];
	$myPwd=$_GET['p'];
    $servername = 'instituteerp.net';
    $sql_user = 'instituteerp';
    $sql_password = 'prity@72';
    $sql_db = 'institut_kj';
    
    $conn = new mysqli($servername, $sql_user, $sql_password, $sql_db);
    if($conn->connect_error)die("Connection failed: " . $conn->connect_error);
	
	$userFound='1';
    
    $sql="SELECT * from intra_users where username='$myUn'";
    $result=$conn->query($sql);
	
	if($result)
	{
	    $row_count = $result->num_rows;
	    if($row_count==0)$userFound='0';
	    else 
	    {
	        $rows=$result->fetch_assoc();
            $myId=$rows['staff_id'];
            $myStdId=$rows['af_id'];
	    }
	}
	else echo $conn->error;
?>
	