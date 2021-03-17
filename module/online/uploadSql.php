<?php  
session_start();
include('../../config_database.php');
include('../../config_variable.php');

if(!empty($_FILES["upload_file"]["name"]))
{
  $output = ''; 
  $filename = $_FILES["upload_file"]["name"];
  $uploadId = $_POST['uploadId'];
  $allowed_ext = array("csv", "pdf", "jpg", "mpeg", "bmp", "gif", "png", "php");
  $explodedArray=explode(".",$filename);
  //$file_ext = substr($filename, strripos($filename, '.')); // get file name
  $fileName=$explodedArray[0];
  $fileExtension=$explodedArray[1];
  //echo "$foreignId - $fileExtension";
  $newFile='cp-'.$uploadId.'.'.$fileExtension;
  //echo "$newFile";
    
  if(in_array(strtolower($fileExtension), $allowed_ext))
  {
    $folder='cp';
    if(!is_dir($folder))mkdir($folder);
    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.'/'.$newFile)) echo "Uploaded Successfully";
    else echo "Upload Unsuccessful!!";
  }
}
else echo " Blank ";
