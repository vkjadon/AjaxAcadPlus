<?php
session_start();
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
include('../../../config_database.php');
$output='';
if(isset($_POST["action"]))
{
//	$output=array("error"=>true, "action"=>"Fetch");
  if($_POST["action"]=="fetch")
  {
    if(isset($_POST["test_id"]))  
    {  
      $sql="SELECT * FROM tests WHERE test_id = '".$_POST["test_id"]."'";  
      $result=$conn->query($sql);
      $joutput=mysqli_fetch_array($result);
      echo json_encode($joutput);
    } 
  }	
  elseif($_POST["action"]=="view")
  {
  	if(isset($_POST["test_id"]))  
  	{  
  		$sql="SELECT * FROM tests WHERE test_id = '".$_POST["test_id"]."'";  
      $result=$conn->query($sql);
      $row=mysqli_fetch_array($result);
      $output.='<table class="table table-bordered"><tr><td>ID</td><td>'.$row["test_id"].'</td></tr>
              <tr><td>test</td><td>'.$row["test_name"].'</td></tr></table>';
      echo $output;
  	} 
  }	
  elseif($_POST["action"]=="section")
  {
  	if(isset($_POST["test_id"]))  
  	{  
      $test_id=$_POST['test_id'];
      $test_section=$_POST["test_section"];
      $test_section++;
      $sql="update tests set test_section='$test_section' where test_id='$test_id'";
      if($test_section<10)$result=$conn->query($sql);
      testList($conn, $myid);
  	} 
  }	
  elseif($_POST["action"]=="minus_section")
  {
  	if(isset($_POST["test_id"]))  
  	{  
      $test_id=$_POST['test_id'];
      $test_section=$_POST["test_section"];
      $test_section--;
      $sql="update tests set test_section='$test_section' where test_id='$test_id'";
      if($test_section>0)$result=$conn->query($sql);
      testList($conn, $myid);
  	} 
  }	
  elseif($_POST["action"]=="Update")
  {
	  $test_name = ''; $test_error = '';	$error = 0; $rows_count=0;
		if(empty($_POST["test_name"]))
		{
			$test_error = 'test is required';
			$error++;
		}
		else
		{
      $test_name = $_POST["test_name"];
      $test_id=$_POST['test_id'];
      $sql="update tests set test_name='".$_POST["test_name"]."' where test_id='".$_POST['test_id']."'";
      $result=$conn->query($sql);
      testList($conn, $myid);
    }
	}
	elseif($_POST["action"] == "Add")
	{
		$test_name = ''; $test_error = '';	$error = 0; $rows_count=0;
		if(empty($_POST["test_name"]))
		{
			$test_error = 'test_name is required';
			$error++;
		}
		else
		{
			$test_name = $_POST["test_name"];
      $sql_dup="select * from tests where test_name='$test_name'";
      $result_dup=$conn->query($sql_dup);

      $rows_count = $result_dup->num_rows;
		  // echo "$rows_count";
	    if($rows_count==0)
    	{
	      $sql="insert into tests (test_name, test_section, submit_id, submit_date, test_status) values('$test_name', '1', '$myid', '$submit_date', 'A')";
    	  $result = $conn->query($sql);
    	}
		}	
    testList($conn, $myid);
	}
}

function testList($conn, $myid)
{
  $sqlList="select * from tests where submit_id='$myid' order by test_id desc";  
  $resultList=$conn->query($sqlList); 
  $list='';
  $count=1;
  while($row = mysqli_fetch_array($resultList))  
  {  
    $id=$row["test_id"];  
    $test_section=$row["test_section"];
    $test_name=$row["test_name"];
    $submit_date=$row["submit_date"];
    $list.='<tr>  
    <td><button class="btn btn-primary btn-sm edit_data" id="'.$id.'"><i class="fa fa-edit"></i></button>
    <button class="btn btn-info btn-sm view_data" id="'.$id.'"><i class="fa fa-eye"></i></button>
    <button class="btn btn-danger btn-sm delete_data" id="'.$id.'"><i class="fa fa-trash"></i></button></td>
    
    <td>'.($count++).'</td><td>'.$id.'</td><td>'.$test_name.'</td><td>'.date("M d,Y",strtotime($submit_date)).'</td> 
      <td>'.$test_section.'<span class="float-right">
            <button class="btn btn-success btn-sm add_section" data-section="'.$test_section.'" data-id="'.$id.'"><i class="fa fa-plus"></i></button>
            <button class="btn btn-danger btn-sm minus_section" data-section="'.$test_section.'" data-id="'.$id.'"><i class="fa fa-minus"></i></button>          </span>
      </td>
        
    </tr>';
  }
  echo $list;  
}
?>