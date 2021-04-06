<?php  
session_start();
include('openTestDb.php');
include('../config_variable.php');

if(!empty($_FILES["upload_file"]["name"]))
{
  $output = ''; 
  $filename = $_FILES["upload_file"]["name"];
  $uploadId = $_POST['uploadId'];
  $uploadTag = $_POST['uploadTag'];
  $uploadCode = $_POST['uploadCode'];
  $allowed_ext = array("csv", "pdf", "jpg", "mpeg", "bmp", "gif", "png", "php");
  $explodedArray=explode(".",$filename);
  //$file_ext = substr($filename, strripos($filename, '.')); // get file name
  $fileName=$explodedArray[0];
  $fileExtension=strtolower($explodedArray[1]);
  //echo "$foreignId - $fileExtension";
  //echo "$newFile";
  if($uploadTag=="questionImage"){
    $newFile='question-'.$uploadId.'.'.$fileExtension;
    $folder='../../olat/img';
    $sql="update question_bank set qb_image='$newFile' where qb_id='$uploadId'";
    $conn->query($sql);
  }
  elseif($uploadTag=="optionImage"){
    $newFile='option-'.$uploadId.'-'.$uploadCode.'.'.$fileExtension;
    $folder='../../olat/img';
    $sql="update question_option set qo_image='$newFile' where qb_id='$uploadId' and qo_code='$uploadCode'";
    $conn->query($sql);
  }
  else {
    $newFile='cp-'.$uploadId.'.'.$fileExtension;
    $folder='../../olat/cp';
  }
  if(in_array(strtolower($fileExtension), $allowed_ext))
  {
    if(!is_dir($folder))mkdir($folder);
    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.'/'.$newFile)) echo "Uploaded Successfully";
    else echo "Upload Unsuccessful!!";
  }
}
else echo " Blank ";
