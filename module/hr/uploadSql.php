<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');

if (!empty($_FILES["upload_file"]["name"])) {
    $output = '';
    $stq_id = $_POST['stqIdM'];
    $filename = $_FILES["upload_file"]["name"];
    $allowed_ext = array(".csv", ".pdf", ".PDF");
    $file_ext = substr($filename, strripos($filename, '.')); // get file extension
    if (in_array($file_ext, $allowed_ext)) {
        $folder = '../../' . $myFolder . '/qualification';
        if (!is_dir($folder)) mkdir($folder);
        if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder . '/' . $stq_id.$file_ext)) {
            $file = $folder . '/' . $stq_id.$file_ext;
            $sql = "update staff_qualification set stq_fn='$file' where stq_id='$stq_id'";
            $result = $conn->query($sql);
            if (!$result) echo $conn->error;
            else echo " Success";
            echo "Uploaded Successfully";
        } else echo "Upload Unsuccessful!!";
    }
} else echo " Blank ";
