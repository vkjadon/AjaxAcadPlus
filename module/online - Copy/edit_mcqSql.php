<?php 
if(isset($_POST['update_question'])) 
{
  $qb_text=$option1=$option2=$option3=$option4=''; $optionA=$optionB=$optionC=$optionD='';
  $error=0; $message='';
  $submit_date=date("Y-m-d");
  $time=time();
	$qb_text=$_POST['qb_text'];
  
  if(isset($_POST['optionA']))$optionA=$_POST['optionA'];
  if(isset($_POST['optionB']))$optionB=$_POST['optionB'];
  if(isset($_POST['optionC']))$optionC=$_POST['optionC'];
  if(isset($_POST['optionD']))$optionD=$_POST['optionD'];
  $optionE='None of these';

  if(isset($_POST['option1']))$option1=$_POST['option1'];
  if(isset($_POST['option2']))$option2=$_POST['option2'];
  if(isset($_POST['option3']))$option3=$_POST['option3'];
  if(isset($_POST['option4']))$option4=$_POST['option4'];
  $qb_co=$option1.$option2.$option3.$option4;

  // echo "Correct $qb_co";
	//echo "qb_text   $qb_text";

  if(strlen($qb_co)==0)
  {
    $message.='Atleast one correct option to be selected<br>';
    $error=1;
  }
  if($error==0)
  {
    $sql="update question_bank set qb_text='$qb_text', qb_option1='$optionA', qb_option2='$optionB', qb_option3='$optionC', qb_option4='$optionD', qb_co='$qb_co', submit_date='$submit_date' where qb_id='$qb_id'";
    $reqult=$conn->query($sql);
    $message.=" Updated Test Question";
    echo '<div class="alert alert-success">Message - '.$message.'</div>';
  }
  else echo '<div class="alert alert-danger">Message - '.$message.'</div>';
}
?>