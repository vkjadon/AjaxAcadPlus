<?php
session_start();
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
require("../util/config_database.php");
require('../php_function.php');
require('../util/config_variable.php');

if (isset($_POST['action'])) {
   if ($_POST['action'] == 'profile') {
      // $id = $_POST['userId'];
      // echo $myId;
      $sql = "select s.* from staff s where s.staff_id='$myId'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'updateTodo') {
      echo $_POST['action'];
      if ($_POST['todo_id'] == 0) $sql = "insert into todo (todo_name, staff_id, todo_type, todo_target, todo_status) values('" . $_POST['todo_name'] . "', '$myId', '1', '" . $submit_date . "', '0')";
      else $sql = "update todo set todo_name='" . $_POST['todo_name'] . "', todo_status='0' where todo_id='" . $_POST['todo_id'] . "'";
      $result = $conn->query($sql);
      if (!$result) {
         $sql = "update todo set todo_target='" . $submit_date . "', todo_status='0' where todo_name='" . $_POST['todo_name'] . "' and staff_id='" . $myId . "'";
         $result = $conn->query($sql);
         // echo "Already Exists".$conn->error;
      }
   } elseif ($_POST['action'] == 'todoList') {
      // $id = $_POST['userId'];
      // echo $myId;
      $sql = "select * from todo where staff_id='$myId' and todo_status<'2'";
      $result = $conn->query($sql);
      while ($todoRows = $result->fetch_assoc()) {
         $output[] = $todoRows;
      }
      echo json_encode($output);
   } elseif ($_POST['action'] == 'fetchTodo') {
      $sql = "select * from todo where todo_id='" . $_POST['todo_id'] . "'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'markCompleted') {
      $sql = "update todo set todo_status='1', update_ts='" . $submit_ts . "' where todo_id='" . $_POST['todo_id'] . "'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
   } elseif ($_POST['action'] == 'unlist') {
      $sql = "update todo set todo_status='9' where todo_id='" . $_POST['todo_id'] . "'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
   } elseif ($_POST['action'] == 'updateSchedule') {
      echo $_POST['action'];
      if ($_POST['modalId'] == 0) $sql = "insert into schedule (schedule_type, schedule_name, schedule_venue, schedule_date_from, schedule_time_from, schedule_time_to, registration_link, webinar_link, schedule_remarks, update_id, schedule_status) values('" . data_check($_POST['schedule_type']) . "', '" . data_check($_POST['schedule_name']) . "', '" . data_check($_POST['schedule_venue']) . "', '" . $_POST['schedule_date_from'] . "', '" . $_POST['schedule_time_from'] . "', '" . $_POST['schedule_time_to'] . "', '" . $_POST['registration_link'] . "', '" . $_POST['webinar_link'] . "', '" . $_POST['schedule_remarks'] . "', '$myId', '0')";
      else $sql = "update schedule set schedule_type='" . data_check($_POST['schedule_type']) . "', schedule_name='" . data_check($_POST['schedule_name']) . "', schedule_venue='" . data_check($_POST['schedule_venue']) . "', schedule_date_from='" . $_POST['schedule_date_from'] . "', schedule_time_from='" . $_POST['schedule_time_from'] . "', schedule_time_to='" . $_POST['schedule_time_to'] . "', registration_link='" . $_POST['registration_link'] . "', webinar_link='" . $_POST['webinar_link'] . "', schedule_remarks='" . data_check($_POST['schedule_remarks']) . "' where schedule_id='" . $_POST['modalId'] . "'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
   } elseif ($_POST['action'] == 'scheduleList') {
      // $id = $_POST['userId'];
      // echo $myId;
      $sql = "select * from schedule where update_id='$myId' and schedule_status<'2'";
      $result = $conn->query($sql);
      while ($todoRows = $result->fetch_assoc()) {
         $output[] = $todoRows;
      }
      echo json_encode($output);
   } elseif ($_POST['action'] == 'scheduleFetch') {
      $sql = "select * from schedule where schedule_id='" . $_POST['schedule_id'] . "'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'scheduleRemove') {
      $sql = "update schedule set schedule_status='1' where schedule_id='" . $_POST['schedule_id'] . "'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Removed ";
   }elseif ($_POST['action'] == 'scheduleApprove') {
      $sql = "update schedule set schedule_status='0' where schedule_id='" . $_POST['schedule_id'] . "'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Approved ";
   } elseif($_POST['action'] == 'classSchedule'){
      echo '<table class="table table-scheduler">';
      $sql = "select sas.*, tl.tl_id, tl.tl_group, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg where sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and sas.staff_id='$myId' and sas.sas_date='$submit_date' and sas_status='0' order by sas.sas_period";
      $result = $conn->query($sql);
      $sno = 0;
      if ($result && $result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
          $sno++;
          $sas_id = $rows['sas_id'];
          $tl_id = $rows['tl_id'];
          $tl_group = $rows['tl_group'];
          $subject_id = $rows['subject_id'];
          $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');

          $tlg_id = $rows['tlg_id'];
          $tlg_type = $rows['tlg_type'];

          $class_id = $rows['class_id'];
          $class_name = getField($conn, $class_id, 'class', 'class_id', 'class_name');
          $class_section = getField($conn, $class_id, 'class', 'class_id', 'class_section');

          $sas_mark = $rows['sas_mark'];

          $tn_sa = 'student_attendance' . $class_id;
          check_tn_sa($conn, $tn_sa);

          $check = getField($conn, $sas_id, $tn_sa, "sas_id", "student_id");
          if (strlen($check) > 0) $update_ts = getField($conn, $sas_id, $tn_sas, "sas_id", "update_ts");

         //  echo '<div class="card mb-2 p-0">';
         //  echo 'Id:' . $rows['sas_id'];
          echo '<tr><th>P-' . $rows['sas_period'] . '</th>';
          echo '<td>' . $class_name . ' [' . $class_section . ' ]<b>[' . $tlg_type . 'G-' . $tl_group . ']</b>';
          echo '<h6 class="text-muted m-0 pt-2">' . $subject_code . ' [' . $subject_id . ']</h6></td>';
          echo '<td>';
          if ($sas_mark == '0') echo '<h3><i class="fa fa-times" title="Attendance Not Marked"></i></h3>';
          else echo '<h3><i class="fa fa-check" title="Attendance Marked"></i></h3>';
          echo '</td>';
          echo '</tr>';
        }
      }
      echo '</table>';
   }
}
