<?php  
require('../requireSubModule.php');

if(!empty($_FILES["upload_file"]["name"]))
{
  $output = ''; 
  $filename = $_FILES["upload_file"]["name"];
  // $staffId = $_POST['staffId'];
  $allowed_ext = array(".jpg", ".JPG", ".bmp", ".BMP", ".gif", ".GIF", ".jpeg", ".JPEG", ".tiff", ".TIFF", ".png", ".PNG");
  $file_ext = substr($filename, strripos($filename, '.')); // get file name
  echo $filename=$myId.$file_ext;
  if(in_array($file_ext, $allowed_ext))
  {
    $folder='../../'.$myFolder.'staffImages/';
    echo $folder;
    if(!is_dir($folder))mkdir($folder);
    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.$filename )){
      echo "Uploaded Successfully";
      $sql="update staff set staff_image='$filename' where staff_id='$myId'";
      $conn->query($sql);
    } 
    else echo "Upload Unsuccessful!!";
  }
}
else echo " Blank ";

