<?php
require('../requireSubModule.php');

//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'showSchedule') {

    $day = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    echo '<table class="table list-table-xxs">';
    echo '<tr><th>#</th><th>Id</th><th>Period</th><th>Load</th><th>Sent on</th><th>Response</th></tr>';
    $sql = "select sas.*, tl.tl_id, tl.tl_group, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg, class cl where sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id=cl.class_id and sas_status='0'";
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
        echo '<div id="sas' . $sas_id . '">' . $subject_code . ' <b>[' . $tlg_type . 'G-' . $tl_group . ']</b><br>' . $staff_name;
        echo '&nbsp;<a href="#" class="sendLink" data-sas="' . $sas_id . '"><i class="fa fa-send" aria-hidden="true" style="color:black"></i></a>';
        echo '</div>';
        echo '</td><td>';
        echo '</td></tr>';
      }
      echo '</table>';
    }
  } elseif ($_POST['action'] == 'sendLink') {
    

    $subject = "Course Coverage and Lesson Outcome";
    $message = '<html><head><title>HTML email</title></head>
    <body>
    <h4>You have engagged a class as per following schedule</h4>
    <tr><td colspan="2">    
    You are requested to click on the following link to update the Course Coverage and the expected outcome of the lecture.
    <p><a href="https://classconnect.in/acadplus/module/comm/cc.php?folder=demo&s=' . $mySes . '"> Please click here for the update.</a></p>
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
    $headers .= 'From: <vijay.jadon@chitkara.edu.in>' . '\r\n';
    mail("vijay.jadon@chitkara.edu.in", $subject, $message, $headers);
    echo $message;
  }
}
