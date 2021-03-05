<?php
	$myinstcode=$_GET['ic'];
	$session_id=$_GET['session'];
	require_once("db.php");
	if($success=='1') 
	{
		if(!mysql_select_db($sql_database)) die("Not Connected. Try Again!!");

 	$vk=mysql_query("select * from classes where session_id='$session_id' and class_status='A' order by class_name")or die(mysql_error());
    for($ii=0; $ii<mysql_num_rows($vk); $ii++) 
	{
	    $name=mysql_result($vk, $ii, 'class_name');
		$id=mysql_result($vk, $ii, 'class_id');
		$response["data"][] = array( 					
		    'id'   => $id,
            'name'   => $name,
					);
	}
		
    $response["success"] = True;
	$someJSON = json_encode($response);
	echo $someJSON;
}

    
	
?>
	