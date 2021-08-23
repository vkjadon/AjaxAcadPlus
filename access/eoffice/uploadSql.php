<?php  
session_start();
include('../../config_database.php');
include('../../config_variable.php');

if(!empty($_FILES["upload_file"]["name"]))
{
  $output = ''; 
  $filename = $_FILES["upload_file"]["name"];
  $foreignId = $_POST['foreignId'];
  $allowed_ext = array("csv", "pdf", "jpg", "mpeg", "bmp", "gif", "png");
  $explodedArray=explode(".",$filename);
  //$file_ext = substr($filename, strripos($filename, '.')); // get file name
  $fileName=$explodedArray[0];
  $fileExtension=$explodedArray[1];
  //echo "$foreignId - $fileExtension";
  $newFile=$fileName.'_'.$foreignId.'.'.$fileExtension;
  //echo "$newFile";
    
  if(in_array(strtolower($fileExtension), $allowed_ext))
  {
    $folder='../../'.$myFolder.'/notice';
    if(!is_dir($folder))mkdir($folder);
    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.'/'.$newFile)) echo "Uploaded Successfully";
    else echo "Upload Unsuccessful!!";
    $sql="insert into notice_attachment (notice_id, na_link) values('$foreignId','$newFile')";
    $conn->query($sql);
  }
}
else echo " Blank ";
