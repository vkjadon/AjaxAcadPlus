<?php 
if(isset($_POST['submit_question'])) 
{
  $qb_text=$qb_min=$qb_max=$qb_type=$qb_level=$qb_base=$filename=$submit_id=$submit_date=$qb_co=$qb_status='';
  $option1=$option2=$option3=$option4=''; $optionA=$optionB=$optionC=$optionD='';
  $error=$image_error=0; $message='';
  $submit_date=date("Y-m-d");
  $time=time();
	$qb_text=$_POST['qb_text'];

  $qb_min=$_POST['qb_min'];
	$qb_max=$_POST['qb_max'];
	$qb_type=$_POST['qb_type'];
	$qb_level=$_POST['qb_level'];
	$qb_base=$_POST['qb_base'];
	$tq_marks=$_POST['tq_marks'];
  $tq_nmarks=$_POST['tq_nmarks'];
  $filename = $_FILES["file"]["name"];
  
  //foreach ($_POST['qb_co'] as $x)$qb_co.=$x;
  if(isset($_POST['optionA']))$optionA=$_POST['optionA'];
  if(isset($_POST['optionB']))$optionB=$_POST['optionB'];
  if(isset($_POST['optionC']))$optionC=$_POST['optionC'];
  if(isset($_POST['optionD']))$optionD=$_POST['optionD'];
 // if(isset($_POST['optionE']))$optionE=$_POST['optionE'];
  $optionE='None of these';

  if(isset($_POST['option1']))$option1=$_POST['option1'];
  if(isset($_POST['option2']))$option2=$_POST['option2'];
  if(isset($_POST['option3']))$option3=$_POST['option3'];
  if(isset($_POST['option4']))$option4=$_POST['option4'];
  $qb_co=$option1.$option2.$option3.$option4;
// echo "Correct $qb_co";
//	echo "qb_text   $qb_text Section $section";
	//echo "File : $filename<br>";

  $dirname='../question_bank';
	if(!is_dir("$dirname"))mkdir("$dirname");	
  
  $dirname='../question_bank/'.$myid;
	if(!is_dir("$dirname"))mkdir("$dirname");	

  $path='../question_bank/'.$myid.'/';

	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
  $allowed_file_types = array('.gif','.GIF','.png','.PNG','.jpg','.JPG','.jpeg','.JPEG');
  if(strlen($filename)==0)$image_error=1;
  if(!in_array($file_ext, $allowed_file_types) && strlen($filename)>0)
  {
    $message.='Only gif, png, jpg, jpeg Allowed<br>';
    $image_error=1;
  }
  if($filesize>2000000 && strlen($filename)>0)
  {
    $message.='Image upto 2Mb Allowed<br>';
    $image_error=1;
  }
  
  if(strlen($qb_co)==0 && $qb_type<3)
  {
    $message.='Atleast one correct option to be selected<br>';
    $error=1;
  }
  if(!strlen($qb_text) && !strlen($filename))
  {
    $message.='No quetion statement or question image Found<br>';
    $error=1;
  }
  if($error==0)
  {
    $sql="insert into question_bank (qb_type, qb_level, qb_base, qb_text, qb_option1, qb_option2, qb_option3, qb_option4, qb_option5, qb_co, qb_min, qb_max, submit_id, submit_date, qb_status) values('$qb_type', '$qb_level', '$qb_base', '$qb_text', '$optionA', '$optionB', '$optionC', '$optionD', '$optionE', '$qb_co', '$qb_min', '$qb_max', '$myid', '$submit_date', 'A')";
    $reqult=$conn->query($sql);
    $qbank_id=$conn->insert_id;

    if($image_error==0)
    {
        $filename='img-'.$qbank_id.$file_ext;
        move_uploaded_file($_FILES["file"]["tmp_name"], $path.$filename);
        $sql="update question_bank set qb_image='$filename' where qb_id='$qbank_id'";
        $conn->query($sql);
    }
  
     if(strlen($qb_text))
	  {
      $qfileName = $path.'text-'.$qbank_id.'.txt';
	  	$fileHandle = fopen($qfileName, 'w+') or die("Cannot open file");
	  	fwrite($fileHandle, $qb_text);
	  	fclose($fileHandle);
    }
  
    if(strlen($optionA))
    {
      $qfileName = $path.'option1-'.$qbank_id.'.txt';
      $fileHandle = fopen($qfileName, 'w+') or die("Cannot open file");
      fwrite($fileHandle, $optionA);
      fclose($fileHandle);
    }
    
    if(strlen($optionB))
    {
      $qfileName = $path.'option2-'.$qbank_id.'.txt';
      $fileHandle = fopen($qfileName, 'w+') or die("Cannot open file");
      fwrite($fileHandle, $optionB);
      fclose($fileHandle);
    }
    if(strlen($optionC))
    {
      $qfileName = $path.'option3-'.$qbank_id.'.txt';
      $fileHandle = fopen($qfileName, 'w+') or die("Cannot open file");
      fwrite($fileHandle, $optionC);
      fclose($fileHandle);
    }
    if(strlen($optionD))
    {
      $qfileName = $path.'option4-'.$qbank_id.'.txt';
      $fileHandle = fopen($qfileName, 'w+') or die("Cannot open file");
      fwrite($fileHandle, $optionD);
      fclose($fileHandle);
    }
    $sql="select * from test_questions where test_id='$test_id' and test_section='$section' and qb_id='$qbank_id'";
    $result=$conn->query($sql);
    $rows_count = $result->num_rows;
    //echo "Rows Found $rows_count";
    if($rows_count==0)
    {
	    $sql="insert into test_questions (test_id, test_section, qb_id, tq_marks, tq_nmarks, submit_id, submit_date, tq_status) values('$test_id', '$section', '$qbank_id', '$tq_marks', '$tq_nmarks', '$myid', '$submit_date', 'S')";
      $result = $conn->query($sql);
    }
    $message.=" Inserted Test Question";
  }
  echo '<div class="alert alert-danger">'.$message.'</div>';
}
?>