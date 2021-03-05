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
  if($_POST["action"]=="fetch_question")
  {
    $qb_id=$_POST['qb_id'];
    $tq_id=$_POST['tq_id'];
    fetch_question($qb_id, $tq_id, $conn);
  }
  elseif($_POST["action"]=="fetch_section_questions")
  {
    $message='';
    $test_id=$_POST['test_id'];
    $test_section=$_POST['test_section'];
    $sql="select * from test_questions where test_id='$test_id' and test_section='$test_section'";
    $result=$conn->query($sql);
    $count=1;
    $message.='<h6>Section - '.$test_section;
    while($rows=$result->fetch_assoc())
    {
      $qb_id=$rows['qb_id'];
      $tq_id=$rows['tq_id'];
      $message.=' <div class="btn-group mr-1" role="group" aria-label="First group">
                <button type="button" class="btn btn-secondary btn-sm show_question" data-tq="'.$tq_id.'" data-qb="'.$qb_id.'">'.$count++.'</button>
                </div>';
    }
    $message.=' <div class="btn-group mr-1" role="group" aria-label="First group">
    <button type="button" class="btn btn-primary btn-sm add_question" data-test="'.$test_id.'" data-section="'.$test_section.'"><i class="fa fa-plus"></i></button>
    </div>';
echo $message.'</h6>';
  }
  if($_POST["action"] == "add_question")
	{
		$message='';
		$test_id=$_POST['test_id'];
    $test_section=$_POST['test_section'];
    $sql="insert into question_bank (qb_type, qb_level, qb_base, submit_id, submit_date, qb_status) values('1', '1', '1', '$myid', '$submit_date', 'S')";
		$result = $conn->query($sql);
		$qb_id=$conn->insert_id;
		$sql="insert into test_questions (test_id, test_section, qb_id, tq_marks, submit_id, submit_date, tq_status) values('$test_id', '$test_section', '$qb_id', '1', '$myid', '$submit_date', 'S')";
		$result = $conn->query($sql);
	
		$sql="select * from test_questions where test_id='$test_id' and test_section='$test_section'";
    $result=$conn->query($sql);
    $count=1;
    $message.='<h6>Section - '.$test_section;
    while($rows=$result->fetch_assoc())
    {
      $qb_id=$rows['qb_id'];
      $tq_id=$rows['tq_id'];
      $message.=' <div class="btn-group mr-1" role="group" aria-label="First group">
                <button type="button" class="btn btn-secondary btn-sm show_question" data-tq="'.$tq_id.'" data-qb="'.$qb_id.'">'.$count++.'</button>
                </div>';
    }
    $message.=' <div class="btn-group mr-1" role="group" aria-label="First group">
    <button type="button" class="btn btn-primary btn-sm add_question" data-test="'.$test_id.'" data-section="'.$test_section.'"><i class="fa fa-plus"></i></button>
    </div>';
		echo $message.'</h6>';
  }
  elseif($_POST["action"]=="reduce_marks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $qb_id=$_POST['qb_id'];
      $tq_marks=$_POST["tq_marks"];
      $tq_marks--;
      $sql="update test_questions set tq_marks='$tq_marks' where tq_id='$tq_id'";
      if($tq_marks>0)$result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }    

  elseif($_POST["action"]=="change_type")
  {
  	if(isset($_POST["qb_id"]))  
  	{  
      $qb_id=$_POST['qb_id'];
      $tq_id=$_POST['tq_id'];
      $qb_type=$_POST["qb_type"];
      if($qb_type==3)$qb_type=1;
      else $qb_type++;
      $sql="update question_bank set qb_type='$qb_type' where qb_id='$qb_id'";
      $result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }    
  elseif($_POST["action"]=="change_level")
  {
  	if(isset($_POST["qb_id"]))  
  	{  
      $qb_id=$_POST['qb_id'];
      $tq_id=$_POST['tq_id'];
      $qb_level=$_POST["qb_level"];
      if($qb_level==3)$qb_level=1;
      else $qb_level++;
      $sql="update question_bank set qb_level='$qb_level' where qb_id='$qb_id'";
      $result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }
  elseif($_POST["action"]=="change_base")
  {
  	if(isset($_POST["qb_id"]))  
  	{  
      $qb_id=$_POST['qb_id'];
      $tq_id=$_POST['tq_id'];
      $qb_base=$_POST["qb_base"];
      if($qb_base==3)$qb_base=1;
      else $qb_base++;
      $sql="update question_bank set qb_base='$qb_base' where qb_id='$qb_id'";
      $result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }
  elseif($_POST["action"]=="reduce_marks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $qb_id=$_POST['qb_id'];
      $tq_marks=$_POST["tq_marks"];
      $tq_marks--;
      $sql="update test_questions set tq_marks='$tq_marks' where tq_id='$tq_id'";
      if($tq_marks>0)$result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }    
  elseif($_POST["action"]=="add_marks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $qb_id=$_POST['qb_id'];
      $tq_marks=$_POST["tq_marks"];
      $tq_marks++;
      $sql="update test_questions set tq_marks='$tq_marks' where tq_id='$tq_id'";
      $result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }
  elseif($_POST["action"]=="reduce_nmarks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $qb_id=$_POST['qb_id'];
      $tq_nmarks=$_POST["tq_nmarks"];
      $tq_nmarks--;
      $sql="update test_questions set tq_nmarks='$tq_nmarks' where tq_id='$tq_id'";
      if($tq_nmarks>=0)$result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }    
  elseif($_POST["action"]=="add_nmarks")
  {
  	if(isset($_POST["tq_id"]))  
  	{  
      $tq_id=$_POST['tq_id'];
      $qb_id=$_POST['qb_id'];
      $tq_nmarks=$_POST["tq_nmarks"];
      $tq_nmarks++;
      $sql="update test_questions set tq_nmarks='$tq_nmarks' where tq_id='$tq_id'";
      $result=$conn->query($sql);
      fetch_question($qb_id, $tq_id, $conn);
  	} 
  }
  elseif($_POST["action"]=="update")
  {
    $qb_id=$_POST['qb_id'];
    $tq_id=$_POST['tq_id'];
    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"])); 
    echo $_POST['action'].' and '.$qb_id.' tq '.$tq_id;
    $sql="update question_bank set qb_image='$file' where qb_id='$qb_id'";
    $result=$conn->query($sql);
    fetch_question($qb_id, $tq_id, $conn);
  } 
  elseif($_POST["action"]=="updateText")
  {
    $qb_id=$_POST['qb_id'];
    $joutput='';
    $sql="select * from question_bank where qb_id='$qb_id'";
    $result=$conn->query($sql);
    $joutput=mysqli_fetch_array($result);
    //$joutput=array("qb_text"=> "<p>sasas</p>");
    echo json_encode($joutput);
  }   
}

function fetch_question($qb_id, $tq_id, $conn)
{
  $message='';
//  $message.=$qb_id.$tq_id;
  $sql="select * from question_bank where qb_id='$qb_id'";
  $result=$conn->query($sql);
  while($rows=$result->fetch_assoc())
  {
    $qb_text=$rows['qb_text'];
    $qb_image=$rows['qb_image'];

    $qb_level=$rows['qb_level'];
    if($qb_level=='1')$level='Easy';
    elseif($qb_level=='2')$level='Average';
    else $level='Difficult';

    $qb_type=$rows['qb_type'];
    if($qb_type=='1')$type='MCQ';
    elseif($qb_type=='2')$type='MAQ';
    else $type='NIQ';
    
    $qb_base=$rows['qb_base'];
    if($qb_base=='1')$base='Memory';
    elseif($qb_base=='2')$base='Conceptual';
    else $base='Analytical';
    $message.='<div class="row">';
    $message.='<a href="edit_mcq.php?qb_id='.$qb_id.'" target="_blank" class="btn btn-info btn-sm">Edit Question</a> &nbsp;';
    $message.=' <button class="btn btn-warning btn-sm changeImage" data-tq="'.$tq_id.'" data-qb="'.$qb_id.'">Change Image</button>';
    $message.='</div></div>';
    $message.='<div class="row">';
    $message.='<div class="col-md-8 alert alert-light">';
    
    $message.=$qb_text;
    if($qb_image<>NULL)$message.='<br><img src="data:image/jpeg;base64,'.base64_encode($qb_image).'"/>';

    $qb_co=$rows['qb_co'];
    $co_array=str_split(strval($qb_co));
    //print_r($co_array);
    if($rows['qb_option1'])
    {
      $option_array=array("1"=>"qb_option1", "2"=>"qb_option2", "3"=>"qb_option3", "4"=>"qb_option4",);
      $numbers = range(1, 4);
      shuffle($numbers); $counter=0;
      foreach ($numbers as $x) { $number[$counter]=$x; $counter++;}
      
      $firstKey=$number[0]; $secondKey=$number[1]; $thirdKey=$number[2];$fourthKey=$number[3];
  
      $message.='<div class="row"><table class="table table-sm"><tr><td width="10%">(A)</td><td>'.$rows[$option_array[$firstKey]].'</td>';
      if(in_array($firstKey,$co_array))$message.='<td>Correct</td>'; else $message.='<td></td>';
      $message.='</tr>';
      $message.='<tr><td>(B)</td><td>'.$rows[$option_array[$secondKey]].'</td>';
      if(in_array($secondKey,$co_array))$message.='<td>Correct</td>'; else $message.='<td></td>';
      $message.='</tr>';
      $message.='<tr><td>(C)</td><td>'.$rows[$option_array[$thirdKey]].'</td>';
      if(in_array($thirdKey,$co_array))$message.='<td>Correct</td>'; else $message.='<td></td>';
      $message.='</tr>';
      $message.='<tr><td>(D)</td><td>'.$rows[$option_array[$fourthKey]].'</td>';
      if(in_array($fourthKey,$co_array))$message.='<td>Correct</td>'; else $message.='<td></td>';
      $message.='</tr></table></div>';
    }
    $sql="select * from test_questions where tq_id='$tq_id'";
    $result=$conn->query($sql);
    $rows=$result->fetch_assoc();
    $tq_marks=$rows['tq_marks'];
    $tq_nmarks=$rows['tq_nmarks'];
    $message.='</div><div class="col-md-4 alert alert-info">';
    $message.='<p><h6>Question Type  : '.$type.'<span class="float-right"><button class="btn btn-info btn-sm qb_type" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-type="'.$qb_type.'">>></button></span></h6></p>';
    $message.='<p><h6>Question Level  : '.$level.'<span class="float-right"><button class="btn btn-info btn-sm qb_level" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-level="'.$qb_level.'">>></button></span></h6></p>';
    
    $message.='<p><h6>Question Base  : '.$base.'<span class="float-right"><button class="btn btn-info btn-sm qb_base" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-base="'.$qb_base.'">>></button></span></h6></p>';

    $message.='<div class="card-group">
      <div class="card bg-primary text-white">
        <div class="card-body text-center">
          <p class="card-text">Marks<br><button class="btn btn-warning btn-sm add_marks" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-marks="'.$tq_marks.'"><i class="fa fa-plus"></i></button>
       [<span id="'.$tq_id.'">'.$tq_marks.'</span>] <button class="btn btn-warning btn-sm reduce_marks" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-marks="'.$tq_marks.'"><i class="fa fa-minus"></i></button></p>
        </div>
      </div>
      <div class="card bg-warning text-white">
        <div class="card-body text-center">
        <p class="card-text">Neg. Marks<br><button class="btn btn-primary btn-sm add_nmarks" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-nmarks="'.$tq_nmarks.'"><i class="fa fa-plus"></i></button>
        [<span id="'.$tq_id.'">'.$tq_nmarks.'</span>]
       <button class="btn btn-primary btn-sm reduce_nmarks" data-qb="'.$qb_id.'" data-tq="'.$tq_id.'" data-nmarks="'.$tq_nmarks.'"><i class="fa fa-minus"></i></button></p>
        </div>
      </div>
    </div>';
    $message.='</div>';
  }
  echo $message;
}
?>