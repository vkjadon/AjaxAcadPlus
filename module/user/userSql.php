<?php
require('../requireSubModule.php');
//echo $_POST['action'];

if (isset($_POST['action'])) {
   if ($_POST['action'] == 'studentDisp') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'fetchUser') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, b.batch, p.program_name from student st, student_detail sd, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_status='0'";
      $result = $conn->query($sql);
      if ($result) {
         $output = $result->fetch_assoc();
      }
      echo json_encode($output);
   } elseif ($_POST['action'] == 'fetchStaff') {
      $id = $_POST['userId'];
      // echo $id;
      $sql = "select s.* from staff s where s.user_id='$id'";
      $result = $conn->query($sql);
      if ($result) {
         $output = $result->fetch_assoc();
      } else echo $conn->error;
      echo json_encode($output);
   }elseif ($_POST['action'] == 'staffDisp') {
      $id = $_POST['userId'];
      $sql = "select s.* from staff s where s.user_id='$id'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   }
}
