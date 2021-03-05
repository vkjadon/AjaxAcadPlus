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
 if(!empty($_FILES["staff_upload"]["name"]))  
 {  
    $output = '';  
    $filename = $_FILES["staff_upload"]["name"];	
    $inst_id = $_POST['inst_id'];	
    $dept_id = $_POST['dept_id'];	

    $allowed_ext = array(".csv");  
    $file_ext = substr($filename, strripos($filename, '.')); // get file name
    echo $file_ext;
    if(in_array($file_ext, $allowed_ext))  
    {  
      $file_data=fopen($_FILES["staff_upload"]["tmp_name"], 'r');  
      fgetcsv($file_data);  
      $output .= '<table class="table table-bordered"><tr><th>Inst</th><th>Dept</th><th>Name</th><th>Father</th><th>Mother</th><th>Mobile</th><th>Email</th></tr>';   
      while($row = fgetcsv($file_data))
      {  
        $staff_id=$conn->real_escape_string($row[0]);  // Sno
        $name=$conn->real_escape_string($row[1]); // staff_name 
        $fname=$conn->real_escape_string($row[2]);  // fname
        $mname=$conn->real_escape_string($row[3]);  //mname
        $mobile=$conn->real_escape_string($row[4]);  //mobile
        $email=$conn->real_escape_string($row[5]);  //email
        
        $dob=$conn->real_escape_string($row[6]);  //dob
        if($dob==NULL)$dob=$submit_date;
        $dob=date("Y-m-d",strtotime($dob));

        $doj=$conn->real_escape_string($row[7]);  //doj
        if($doj==NULL)$doj=$submit_date;
        $doj=date("Y-m-d",strtotime($doj));

        $adhaar=$conn->real_escape_string($row[8]);  
        $address=$conn->real_escape_string($row[9]);
        $type=$conn->real_escape_string($row[10]);
        $teaching=$conn->real_escape_string($row[11]);
        $gender=$conn->real_escape_string($row[12]);
   
        $sql="select * from staff where staff_email='$email'";
        $result=$conn->query($sql);
        if(!$result)echo $conn->error;
        $records=$result->num_rows;

        if($records==0)
        {
          $sql="INSERT INTO staff (inst_id, dept_id, staff_name, staff_fname, staff_mname, staff_mobile, staff_email, staff_dob, staff_doj, staff_adhaar, staff_address, staff_type, staff_teaching, staff_gender, submit_id, submit_date, staff_status) VALUES ('$inst_id', '$dept_id', '$name', '$fname', '$mname', '$mobile', '$email', '$dob', '$doj', '$adhaar', '$address', '$type', '$teaching', '$gender', '$myid', '$submit_date', 'A')";
          $result=$conn->query($sql);
          $status="Inserted";
        }
        else $status="Exists";
        $output .= '<tr><td>'.$inst_id.'</td><td>'.$dept_id.'</td><td>'.$name.'</td><td>'.$fname.'</td><td>'.$mname.'</td><td>'.$mobile.'</td><td>'.$email.'</td><td>'.$dob.'</td><td>'.$doj.'</td><td>'.$dob.'</td><td>'.$status.'</td></tr>';  
    	}  
      $output .= '</table>';  
    }
    else $output='1';
  }
  else $output='0';
  echo $output;  
  ?>  