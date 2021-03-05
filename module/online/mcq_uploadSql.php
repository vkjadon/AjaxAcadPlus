<?php  
session_start();
if(!isset($_SESSION["user_id"]))
{
  header('location:admin_login_form.php');
}
else 
{
  $myid=$_SESSION['user_id'];
  $submit_date=date("Y-m-d", time());
}
 include('../../../config_database.php');
 $submit_date=date("Y-m-d",time());
 if(!empty($_FILES["mcq_upload"]["name"]))  
 {  
    $output = '';  
    $filename = $_FILES["mcq_upload"]["name"];	

    $allowed_ext = array(".csv");  
    $file_ext = substr($filename, strripos($filename, '.')); // get file name
    echo $file_ext;
    if(in_array($file_ext, $allowed_ext))  
    {  
      $file_data=fopen($_FILES["mcq_upload"]["tmp_name"], 'r');  
      fgetcsv($file_data);  
      $output .= '<table class="table table-bordered"><tr>  
          <th>Question Statement</th><th>Option-A</th><th>Option-B</th>  
          <th>Option-C</th><th>Option-D</th><th>Correct</th></tr>';   
      while($row = fgetcsv($file_data))
      {  
        $qb_text=$conn->real_escape_string($row[0]);  
        $qb_option1=$conn->real_escape_string($row[1]);  
        $qb_option2=$conn->real_escape_string($row[2]);  
        $qb_option3=$conn->real_escape_string($row[3]);  
        $qb_option4=$conn->real_escape_string($row[4]);  
        $qb_co=$conn->real_escape_string($row[5]);  
        $sql="INSERT INTO question_bank (qb_text, qb_option1, qb_option2, qb_option3, qb_option4, qb_co, qb_source, submit_id, submit_date, qb_status) VALUES ('$qb_text', '$qb_option1', '$qb_option2', '$qb_option3', '$qb_option4', '$qb_co', '1', '$myid', '$submit_date', 'S')"; 
        
        $result=$conn->query($sql);
        echo $qb_text;
        $output .= '<tr><td>'.$qb_text.'</td><td>'.$qb_option1.'</td><td>'.$qb_option2.'</td>
          <td>'.$qb_option3.'</td><td>'.$qb_option4.'</td><td>'.$qb_co.'</td></tr>';  
    	}  
      $output .= '</table>';  
      echo $output;  
    }
    else  echo "Error1";  
  }
  else echo "Error2";
 ?>  