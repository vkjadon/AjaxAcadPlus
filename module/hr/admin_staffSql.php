<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');

echo "action ".$_POST["action"];
if($_POST["action"]=="addStaff")
{
  $sql="select * from staff where staff_email='$staff_email'";
  $result=$conn->query($sql);
  if(!$result)echo $conn->error;
  $rows_found=$result->num_rows;
  echo 'Rows Found '.$rows_found=0;
  if($rows_found==0)
  {
    $sql="insert into staff (dept_id, designation_id, staff_name, staff_mobile, staff_email, staff_fname, staff_mname, staff_dob, staff_doj, staff_adhaar, staff_address, staff_type, staff_teaching, staff_gender, submit_id, submit_date, staff_status) values('".$_POST["dept_id"]."', '".$_POST["designation_id"]."', '".$_POST["staff_name"]."', '".$_POST["staff_mobile"]."', '".$_POST["staff_email"]."', '".$_POST["staff_fname"]."', '".$_POST["staff_mname"]."', '".$_POST["staff_dob"]."', '".$_POST["staff_doj"]."', '".$_POST["staff_adhaar"]."', '".$_POST["staff_address"]."', '".$_POST["staff_type"]."', '".$_POST["staff_teaching"]."', '".$_POST["staff_gender"]."', '$myId', '$submit_date', 'A')";
    $result=$conn->query($sql);
    if(!$result)echo "Could Not Insert";
  }
}
elseif($_POST["action"]=="addUser")
{
  $id=$_POST['staffId'];
  $staff_mobile=getField($conn, $id, "staff", "staff_id", "staff_mobile");
  echo "In Add User $id $staff_mobile";
  $sql="select user_id from user where staff_id='".$id."'";
  $result=$conn->query($sql);
  if($result->num_rows>0)
  {
    $sqlUser="update user set user_status='A' where staff_id='".$id."'";
    $resultUser=$conn->query($sqlUser);
  }
  else 
  {
    $pwd=sha1($staff_mobile);
    $sqlUser="insert into user (user_name, user_password, staff_id, user_type, user_status) values('$staff_mobile', '$pwd', '$id', '2', 'A')";
    $resultUser=$conn->query($sqlUser);
  }
}
elseif($_POST["action"]=="removeUser")
{
  $id=$_POST['staffId'];
  $staff_mobile=getField($conn, $id, "staff", "staff_id", "staff_mobile");
  echo "In Remove User $id $staff_mobile";
  $sql="update user set user_status='D' where staff_id='".$id."'";
  $result=$conn->query($sql);
}
elseif($_POST["action"]=="updateStaff")
{
  echo 'Rows Found '.$_POST['staff_id'];
  if(!empty($_POST['staff_name']))
  {
    $sql="update staff set staff_name='".$_POST["staff_name"]."', staff_mobile='".$_POST["staff_mobile"]."', staff_email='".$_POST["staff_email"]."', staff_fname='".$_POST["staff_fname"]."', staff_mname='".$_POST["staff_mname"]."', staff_dob='".$_POST["staff_dob"]."', staff_doj='".$_POST["staff_doj"]."', staff_adhaar='".$_POST["staff_adhaar"]."', staff_address='".$_POST["staff_address"]."', staff_type='".$_POST["staff_type"]."', staff_teaching='".$_POST["staff_teaching"]."', staff_gender='".$_POST["staff_gender"]."', submit_id='$myId', submit_date='$submit_date', staff_status='A' where staff_id='".$_POST['staff_id']."'";
    $result=$conn->query($sql);
    if(!$result)echo "Could Not Update";
  }
}
elseif($_POST["action"]=="staffList")
{
  $dept_id=$_POST['deptId'];
  $sql="select * from staff where dept_id='$dept_id' order by staff_name";
  $result=$conn->query($sql);
  if(!$result)echo $conn->error;
  $rows_found=$result->num_rows;
  echo 'Record Found : '.$rows_found;
  echo '<table class="list-table-xs">';
  echo '<thead><th><i class="fa fa-edit"></i></th><th>Name</th><th>Designation</th><th>Mobile</th><th>Email</th><th>User</th></thead>';
  while($rows_staff=$result->fetch_assoc())
  {
    $id=$rows_staff['staff_id'];
    $designation_id=$rows_staff['designation_id'];
    if($designation_id>0)$designation_name=getField($conn, $designation_id, "designation", "designation_id", "designation_name");
    else $designation_name='Not Defined';
    $sqlUser="select user_id from user where staff_id='".$id."' and user_status='A'";
    $resultUser=$conn->query($sqlUser);
    echo '<tr>';
    echo '<td><a href="#" class="editData" id="'.$id.'"><i class="fa fa-edit"></i></a></td>';
    echo '<td>'.$rows_staff['staff_name'].'</td><td>'.$designation_name.'</td><td>'.$rows_staff['staff_mobile'].'</td><td>'.$rows_staff['staff_email'].'</td>';
    if($resultUser->num_rows==1)echo '<td><a href="#" class="removeUser" id="'.$id.'"><i class="fa fa-check" style="color:green"></i></a></td>';
    else echo '<td><a href="#" class="addUser" id="'.$id.'"><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a></td>';
    echo '</tr>';
  }
  echo '</table>';
}
elseif($_POST["action"]=="staffEditForm")
{
  $staff_id=$_POST["staff_id"];
  $sql="select * from staff where staff_id='$staff_id'";
  $result=$conn->query($sql);
  if(!$result)echo $conn->error;
  $rows_found=$result->num_rows;
  $staff=$result->fetch_assoc();
  echo '<div class="card">
	  <div class="card-header bg-warning"><h4 class="mb-0">Staff Form - Basic Information</h4></div>
	    <div class="card-body bg-light">
    		<form method="post" id="formStaffUpdate">
			    <div class="form-group row">
				    <div class="col-lg-4">
					    Name<input type="text" class="form-control form-control-sm" id="staffName" name="staff_name" value="'.$staff['staff_name'].'" required>
					    Father Name<input type="text" class="form-control form-control-sm" name="staff_fname" value="'.$staff['staff_fname'].'">
					Mothers Name<input type="text" class="form-control form-control-sm" name="staff_mname" value="'.$staff['staff_mname'].'">
					Mobile<input type="text" class="form-control form-control-sm" name="staff_mobile" value="'.$staff['staff_mobile'].'">
				</div>
				<div class="col-lg-4">
          Email<input type="email" class="form-control form-control-sm" name="staff_email" value="'.$staff['staff_email'].'">
					Date of Birth<input type="date" class="form-control form-control-sm" name="staff_dob" value="'.$staff['staff_dob'].'">
          Date of Joining<input class="form-control form-control-sm" type="date" name="staff_doj" value="'.$staff['staff_doj'].'">	
          Adhaar Number<input class="form-control form-control-sm" name="staff_adhaar" type="text" value="'.$staff['staff_adhaar'].'">								
				</div>
				<div class="col-lg-4">
          Address<textarea class="form-control form-control-sm" rows="3" cols="30" name="staff_address">'.$staff['staff_address'].'</textarea>';

          $type=$staff['staff_type'];
					if($type=='C')echo '<input type="radio" checked name="staff_type" value="C">Core
					<input type="radio" name="staff_type" value="V">Visiting';
          else echo '<input type="radio" name="staff_type" value="C">Core
					<input type="radio" checked name="staff_type" value="V">Visiting';
          
          $teaching=$staff['staff_teaching'];
          if($teaching=='Y')echo '<br><input type="radio" checked name="staff_teaching" value="Y">Teaching
					<input type="radio" name="staff_teaching" value="N">Non Teaching';
					else echo '<br><input type="radio" name="staff_teaching" value="Y">Teaching
					<input type="radio" checked name="staff_teaching" value="N">Non Teaching';
          
          $designation_id=$staff['designation_id'];
          //selectList($conn, "Select Degisna" $designation_id);
          $gender=$staff['staff_gender'];
          if($gender=='M')echo '<input type="radio" name="staff_gender" value="M" checked>Male 
          <input type="radio" name="staff_gender" value="F">Female';
          else echo '<input type="radio" name="staff_gender" value="M">Male 
          <input type="radio" checked name="staff_gender" value="F">Female';

        echo'</div>
			</div>
		<div class="form-group row">
			<div class="col-lg-4">
				<input type="hidden" name="dept_id" id="dept_id" value="'.$staff['dept_id'].'">
				<input type="hidden" name="staff_id" id="staff_id" value="'.$staff['staff_id'].'">
				<input type="hidden" name="action" value="updateStaff">
				<input type="submit" class="btn btn-primary btn-block" value="Update">
			</div>
		</div>
	</form>
	</div>
	</div> 
	</div>';
}
?>