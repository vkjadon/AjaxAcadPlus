<?php  
require('../requireSubModule.php');

if(!empty($_FILES["upload_file"]["name"]))
{
  $output = ''; 
  $filename = $_FILES["upload_file"]["name"];
  $studentId = $_POST['studentId'];
  $allowed_ext = array(".jpg", ".JPG", ".bmp", ".BMP", ".gif", ".GIF", ".jpeg", ".JPEG", ".tiff", ".TIFF");
  $file_ext = substr($filename, strripos($filename, '.')); // get file name
  echo $filename=$studentId.$file_ext;
  if(in_array($file_ext, $allowed_ext))
  {
    $folder='../../'.$myFolder.'/studentImages/';
    echo $folder;
    if(!is_dir($folder))mkdir($folder);
    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.$filename )){
      echo "Uploaded Successfully";
      $sql="update student set student_image='$filename' where student_id='$studentId'";
      $conn->query($sql);
    } 
    else echo "Upload Unsuccessful!!";
  }
}
else echo " Blank ";
