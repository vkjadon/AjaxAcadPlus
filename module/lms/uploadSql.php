<?php  
session_start();
include('../../config_database.php');
include('../../config_variable.php');

if(!empty($_FILES["upload_file"]["name"]))
{
  $output = ''; 
  $filename = $_FILES["upload_file"]["name"];
  $rsb_id = $_POST['rsbId'];
  $allowed_ext = array(".pdf", ".PDF");
  $file_ext = substr($filename, strripos($filename, '.')); // get file name
  echo $file_ext;
  if(in_array($file_ext, $allowed_ext))
  {
    $folder='../../'.$myFolder.'/resourse';
    if(!is_dir($folder))mkdir($folder);
    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.'/'.$filename )) echo "Uploaded Successfully";
    else echo "Upload Unsuccessful!!";
  }
}
else echo " Blank ";
