<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'sessionClassList') {
    $programId = $_POST['programId'];
    //echo "sddsd $programId";
    $json = get_sessionClass($conn, $mySes, $programId);
    //echo $json;
    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th></th><th>Name</th><th>StdReg</th></tr>';
    for ($i = 0; $i < count($array["data"]); $i++) {

      echo '<tr>';
      echo '<td></td>';
      echo '<td>' . $array["data"][$i]["name"] . '[' . $array["data"][$i]["section"] . ']</td>';
      echo '<td><button class="btn btn-secondary btn-square-sm showScheduleForm" id="ss' . $array["data"][$i]["id"] . '">Schedule Form</button></td>';
      echo '</tr>';
    }
    echo '</table>';
    //echo '<button class="btn btn-success btn-square-sm mt-0 scheduleFormButton">Show Schedule Form</button>';
  } elseif ($_POST['action'] == 'sessionClassListSTT') {
    $programId = $_POST['programId'];
    //echo "sddsd $programId";
    $json = get_sessionClass($conn, $mySes, $programId);
    //echo $json;
    $array = json_decode($json, true);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr>';
    echo '<td><button class="btn btn-secondary btn-square-sm checkAllSTT">Check All</button>';
    echo '<button class="btn btn-danger btn-square-sm uncheckAllSTT">UnCheck All</button></td>';
    for ($i = 0; $i < count($array["data"]); $i++) {
      echo '<td><input type="checkbox" class="sclSTT" id="STT' . $array["data"][$i]["id"] . '" value="' . $array["data"][$i]["id"] . '">' . $array["data"][$i]["name"] . '[' . $array["data"][$i]["section"] . ']</td>';
    }
    echo '</tr>';
    echo '</table>';
    //echo '<button class="btn btn-success btn-square-sm mt-0 scheduleFormButton">Show Schedule Form</button>';
  } elseif ($_POST['action'] == 'showSchedule') {
    $classId = substr($_POST['classId'], 2);
    $from = $_POST['scheduleFrom'];
    $to = $_POST['scheduleTo'];
    //echo "$from - $to";
    $days = (strtotime($to) - strtotime($from)) / (24 * 60 * 60) + 1;

    $day = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    echo '<h5>' . getField($conn, $classId, 'class', 'class_id', 'class_name') . '</h5>';
    for ($k = 0; $k < $days; $k++) {
      $current_ts = strtotime($from) + $k * 24 * 60 * 60;
      $current_date = date("Y-m-d", $current_ts);
      $dayofDate = date("D", $current_ts);

      echo '<h6>' . $dayofDate . '</h6>';
      echo '<table class="table list-table-xxs">';
      echo '<tr><th>#</th><th>Id</th><th>Period</th><th>Load</th><th>Sent on</th><th>Response</th></tr>';
      $sql = "select sas.*, tl.tl_id, tl.tl_group, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg where sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and sas.sas_date='$current_date' and sas_status='0'";
      $result = $conn->query($sql);
      $sno = 0;
      if ($result && $result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
          $sno++;
          echo '<tr><td>' . $sno . '</td><td>' . $rows['sas_id'] . '</td><td>' . $rows['sas_period'] . '</td><td>';
          $sas_id = $rows['sas_id'];
          $tl_id = $rows['tl_id'];
          $tl_group = $rows['tl_group'];
          $subject_id = $rows['subject_id'];
          $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');

          $tlg_id = $rows['tlg_id'];
          $tlg_type = $rows['tlg_type'];

          $staff_id = $rows['staff_id'];
          $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');

          //echo '<span>' . $subject_code . ' <b>[G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';

          echo '<div id="sas' . $sas_id . '">' . $subject_code . ' <b>[' . $tlg_type . 'G-' . $tl_group . ']</b><br>' . $staff_name;
          echo '&nbsp;<a href="#" class="sendLink" data-sas="' . $sas_id . '"><i class="fa fa-send" aria-hidden="true" style="color:black"></i></a>';
          echo '</div>';
          echo '</td><td>';
          $cc_link=getField($conn, $sas_id, $tn_cc, "sas_id", "cc_link");
          if(strlen($cc_link)>5)echo date("d-m-Y h:i", strtotime($cc_link));
          echo '</td><td>';
          echo '</td></tr>';
        }
      }

      echo '</table>';
    }
  } elseif ($_POST['action'] == 'sendLink') {
    $sas_id = $_POST['sasId'];

    $sql="insert into $tn_cc (sas_id) values('$sas_id')";
    $conn->query($sql);
    echo "Link Sent " . $sas_id;
    $sql = "select sas.*, tl.*, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg where sas.sas_id='$sas_id' and sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id";
    $json = getTableRow($conn, $sql, array("sas_period", "staff_id", "class_id", "subject_id", "sas_date"));
    $array = json_decode($json, true);
    echo $json;
    //echo count($array);
    //echo count($array["data"]);
    $staff_id = $array["data"][0]["staff_id"];
    $sas_date = $array["data"][0]["sas_date"];
    $sas_period = $array["data"][0]["sas_period"];
    $class_id = $array["data"][0]["class_id"];
    $subject_id = $array["data"][0]["subject_id"];
    
    echo "Staff " . $staff_id." Class ".$class_id;
    $staff_email = getField($conn, $staff_id, "staff", "staff_id", "staff_email");
    $class_name = getField($conn, $class_id, "class", "class_id", "class_name");
    $class_section = getField($conn, $class_id, "class", "class_id", "class_section");
    
    $subject_name = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
    $subject_code = getField($conn, $subject_id, "subject", "subject_id", "subject_code");

    $subject = "Course Coverage and Lesson Outcome";
    $message = '<html><head><title>HTML email</title></head>
    <body>
    <h4>You have engagged a class as per following schedule</h4>
    <b><table><tr><td>Class </td><td>'.$class_name.' ['.$class_section.']</td></tr>
    <tr><td> Subject Code </td><td>'.$subject_code.'</td></tr>
    <tr><td> Subject Name </td><td>'.$subject_name.'</td></tr>
    <tr><td> Date </td><td>'.date("d-m-Y",strtotime($sas_date)).'</td></tr></b>
    <tr><td> Period </td><td>'.$sas_period.'</td></tr>
    <tr><td colspan="2">    
    You are requested to click on the following link to update the Course Coverage and the expected outcome of the lecture.
    <p><a href="https://classconnect.in/acadplus/module/comm/cc.php?folder=demo&s='.$mySes.'&sasid='.$sas_id.'"> Please click here for the update.</a></p>
    <h4>This is to be done within 30 min of the receipt of the mail. </h4>
    <h4>Regards</h4>
    <h3>Dean</h3>
    <h4>Civil and Mechatronics Engineering</h4>
    </td></tr>
    </table>
    </body>
    </html>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <support@classconnect.in>' . "\r\n";
    mail($staff_email, $subject, $message, $headers);
  }
}
