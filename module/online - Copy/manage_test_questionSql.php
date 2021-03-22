<?php
session_start();
$data=array();
if(!isset($_SESSION["user_id"]))
{
  header('location:admin_login_form.php');
}
else 
{
  $myid=$_SESSION['user_id'];
  $submit_date=date("Y-m-d", time());
}
//manage_testSql.php
include('../config_database.php');
$output='';
if(isset($_POST["action"]))
{
  if($_POST["action"] == "increment_question")
	{
    $test_id=$_POST['test_id'];
    $test_section=$_POST['test_section'];
    $sql_dup="select * from test_questions where test_id='$test_id' and test_section='$test_section' and qb_id='0'";
    $result_dup=$conn->query($sql_dup);
    $rows_count = $result_dup->num_rows;
    if($rows_count==0)
    {
	    $sql="insert into test_questions (test_id, test_section, submit_id, submit_date, tq_status) values('$test_id', '$test_section', '$myid', '$submit_date', 'S')";
      $result = $conn->query($sql);
    }
    $message="Inserted";
    echo $message;
  }
  elseif($_POST["action"] == "fetch")
	{
    $qb_id=$_POST['qb_id'];

    $data=array("message"=>"Success in Fetch Block");
    echo json_encode($data);
  }
  elseif($_POST["action"]=="add_marks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $tq_marks=$_POST["tq_marks"];
      $tq_marks++;
      $sql="update test_questions set tq_marks='$tq_marks' where tq_id='$tq_id'";
      $result=$conn->query($sql);
      $output=array("tq_id"=>$tq_id, "marks"=>$tq_marks);
      echo json_encode($output);
  	} 
  }
  elseif($_POST["action"]=="reduce_marks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $tq_marks=$_POST["tq_marks"];
      $tq_marks--;
      $sql="update test_questions set tq_marks='$tq_marks' where tq_id='$tq_id'";
      if($tq_marks>0)
      {
        $result=$conn->query($sql);
        $output=array("tq_id"=>$tq_id, "marks"=>$tq_marks);
        echo json_encode($output);
      }
  	} 
  }    
}
?>