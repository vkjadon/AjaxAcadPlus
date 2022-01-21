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
   } elseif ($_POST['action'] == 'staffDisp') {
      $id = $_POST['userId'];
      $sql = "select s.* from staff s where s.user_id='$id'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'groupLinkList') {
      // $respArray = array();
      // $sql = "select * from master_name where mn_code='res' and mn_status='0' order by mn_id";
      // $result = $conn->query($sql);
      // while ($responsibility = $result->fetch_assoc()) {
      //    $respArray = $responsibility;
      //    $json_array["resp"][] = $respArray;
      // }

      $curl = curl_init();
      $url = 'https://classconnect.in/api/get_portal_link.php?pg=' . $_POST['pg_id'];

      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      $output = json_decode($output, true);

      if ($output['success'] == "True") {
         $links = count($output['data']);
         $subArray = array();
         for ($i = 0; $i < $links; $i++) {
            $text = '';
            $id = $output["data"][$i]["pl_id"];
            $subArray['pl_id'] = $id;
            $subArray['pl_sno'] = $output["data"][$i]["pl_sno"];
            $subArray['pl_name'] = $output["data"][$i]["pl_name"];
            $subArray['pl_type'] = $output["data"][$i]["pl_type"];
            $sql = "select * from master_name where mn_code='res' and mn_status='0' order by mn_id";
            $result = $conn->query($sql);
            while ($responsibility = $result->fetch_assoc()) {
               $mn_id = $responsibility["mn_id"];
               $mn_name = $responsibility["mn_name"];
               $sql_rl = "select * from responsibility_link where pl_id='$id' and mn_id='$mn_id'";
               $result_rl = $conn->query($sql_rl);
               if ($result_rl->num_rows == 0) $text .= ' <a href="#" class="updateRL" data-pl="' . $id . '" data-mn="' . $mn_id . '" data-tag="add"> <i class="fa fa-times"></i></a> ' . $mn_name . ' | ';
               else $text .= ' <a href="#" class="updateRL" data-pl="' . $id . '" data-mn="' . $mn_id . '" data-tag="remove">  <i class="fa fa-check"></i> ' . $mn_name . ' | ';
               // $subArray[$mn_id]='1';
            }
            $subArray["text"] = $text;
            $json_array["link"][] = $subArray;
         }
         echo json_encode($json_array);
      } else $links = 0;
   } elseif ($_POST['action'] == 'updateRL') {
      if($_POST['tag']=="add")$sql_rl = "insert into responsibility_link (pl_id, mn_id) values ('".$_POST['pl']."', '".$_POST['mn']."')";
      else $sql_rl = "delete from responsibility_link where pl_id='".$_POST['pl']."' and mn_id= '".$_POST['mn']."'";
      $result_rl = $conn->query($sql_rl);
   }
}
