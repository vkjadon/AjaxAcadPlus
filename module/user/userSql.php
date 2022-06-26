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
   } elseif ($_POST['action'] == 'staffDisp') {
      $id = data_check($_POST['userId']);
      $sql = "select * from user_privilege where user_id='$id'";
      $result = $conn->query($sql);
      if ($result->num_rows == 0) {
         $sql_insert = "insert into user_privilege (user_id, up_code, up_status) values('$id', '0', '0')";
         $conn->query($sql_insert);
      }
      $sql = "select s.*, upr.* from staff s, user_privilege upr where s.user_id=upr.user_id and s.user_id='$id'";
      // $sql = "select s.* from staff s where s.user_id='$id'";
      $result = $conn->query($sql);
      if ($result) {
         $output = $result->fetch_assoc();
      } else echo $conn->error;
      echo json_encode($output);
   } elseif ($_POST['action'] == 'menuGroupList') {
      $pm_id = $_POST['pm_id'];
      // if ($pm_id == 'ALL') $sql = "select * from portal_group where pg_status='0' order by pg_sno";
      // else $sql = "select * from portal_group where pm_id='$pm_id' and pg_status='0' order by pg_sno";

      if ($pm_id == 'ALL') $sql = "select pg.*, pm.* from portal_group pg, portal_menu pm where pm.pm_id=pg.pm_id and pg.pg_status='0' order by pm.pm_sno, pg.pg_sno";
      else $sql = "select pg.*, pm.* from portal_group pg, portal_menu pm where pm.pm_id=pg.pm_id and pg.pm_id='$pm_id' and pg.pg_status='0' order by pm.pm_sno, pg.pg_sno";
      $result_menu = $conn->query($sql);

      $subArray = array();
      while ($rowGroup = $result_menu->fetch_assoc()) {

         $id = $rowGroup["pg_id"];
         $subArray['pm_name'] = $rowGroup["pm_name"];
         $subArray['pg_id'] = $id;
         $subArray['pg_sno'] = $rowGroup["pg_sno"];
         $subArray['pg_name'] = $rowGroup["pg_name"];
         $subArray['pg_type'] = $rowGroup["pg_type"];

         $text = '';
         $sql_up = "select * from privilege_group where pg_id='$id' and up_code='0'";
         $result_up = $conn->query($sql_up);
         if ($result_up->num_rows == 0) $text .= ' <a href="#" class="updatePriv" data-pg="' . $id . '" data-up="0" data-tag="add"> <i class="fa fa-times"></i></a> Faculty | ';
         else $text .= ' <a href="#" class="updatePriv" data-pg="' . $id . '" data-up="0" data-tag="remove">  <i class="fa fa-check"></i> Faculty | ';

         $sql_up = "select * from privilege_group where pg_id='$id' and up_code='1'";
         $result_up = $conn->query($sql_up);
         if ($result_up->num_rows == 0) $text .= ' <a href="#" class="updatePriv" data-pg="' . $id . '" data-up="1" data-tag="add"> <i class="fa fa-times"></i></a> Staff | ';
         else $text .= ' <a href="#" class="updatePriv" data-pg="' . $id . '" data-up="1" data-tag="remove">  <i class="fa fa-check"></i> Staff | ';

         $sql_up = "select * from privilege_group where pg_id='$id' and up_code='9'";
         $result_up = $conn->query($sql_up);
         if ($result_up->num_rows == 0) $text .= ' <a href="#" class="updatePriv" data-pg="' . $id . '" data-up="9" data-tag="add"> <i class="fa fa-times"></i></a> Admin | ';
         else $text .= ' <a href="#" class="updatePriv" data-pg="' . $id . '" data-up="9" data-tag="remove">  <i class="fa fa-check"></i> Admin | ';

         // $subArray[$mn_id]='1';
         $subArray["pg"] = $text;

         $text = '';

         $sql_rl = "select * from responsibility_group where pg_id='$id' and rs_code='hod'";
         $result_rl = $conn->query($sql_rl);
         if ($result_rl->num_rows == 0) $text .= ' <a href="#" class="updatePR" data-pg="' . $id . '" data-pr="hod" data-tag="add"> <i class="fa fa-times"></i>HOD</a> | ';
         else $text .= ' <a href="#" class="updatePR" data-pg="' . $id . '" data-pr="hod" data-tag="remove">  <i class="fa fa-check"></i>HOD</a> | ';

         $sql_rl = "select * from responsibility_group where pg_id='$id' and rs_code='dir'";
         $result_rl = $conn->query($sql_rl);
         if ($result_rl->num_rows == 0) $text .= ' <a href="#" class="updatePR" data-pg="' . $id . '" data-pr="dir" data-tag="add"> <i class="fa fa-times"></i>DIR</a> | ';
         else $text .= ' <a href="#" class="updatePR" data-pg="' . $id . '" data-pr="dir" data-tag="remove">  <i class="fa fa-check"></i>DIR</a> | ';

         $sql_rl = "select * from responsibility_group where pg_id='$id' and rs_code='gd'";
         $result_rl = $conn->query($sql_rl);
         if ($result_rl->num_rows == 0) $text .= ' <a href="#" class="updatePR" data-pg="' . $id . '" data-pr="gd" data-tag="add"> <i class="fa fa-times"></i>GD</a> | ';
         else $text .= ' <a href="#" class="updatePR" data-pg="' . $id . '" data-pr="gd" data-tag="remove">  <i class="fa fa-check"></i>GD</a> | ';


         $subArray["portalResponsibility"] = $text;

         $text = '';
         $sql = "select * from master_name where mn_code='res' and mn_status='0' order by mn_id";
         $result = $conn->query($sql);
         while ($responsibility = $result->fetch_assoc()) {
            $mn_id = $responsibility["mn_id"];
            $mn_name = $responsibility["mn_name"];
            $mn_abbri = $responsibility["mn_abbri"];
            $sql_rl = "select * from responsibility_group where pg_id='$id' and mn_id='$mn_id'";
            $result_rl = $conn->query($sql_rl);
            if ($result_rl->num_rows == 0) $text .= ' <a href="#" class="updateRL" data-pg="' . $id . '" data-mn="' . $mn_id . '" data-tag="add" title="' . $mn_name . '"> <i class="fa fa-times"></i> ' . $mn_abbri . '</a> | ';
            else $text .= ' <a href="#" class="updateRL" data-pg="' . $id . '" data-mn="' . $mn_id . '" data-tag="remove" title="' . $mn_name . '">  <i class="fa fa-check"></i> ' . $mn_abbri . '</a> | ';
            // $subArray[$mn_id]='1';
         }
         $subArray["text"] = $text;

         $json_array["link"][] = $subArray;
      }
      echo json_encode($json_array);
   } elseif ($_POST['action'] == 'updateDefault') {
      $sql = "update portal_group set pg_type= '" . $_POST['value'] . "' where pg_id='" . $_POST['pg'] . "'";
      $conn->query($sql);
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
   } elseif ($_POST['action'] == 'updatePR') {
      if ($_POST['tag'] == "add") $sql_rl = "insert into responsibility_group (pg_id, rs_code) values ('" . $_POST['pg'] . "', '" . $_POST['pr'] . "')";
      else $sql_rl = "delete from responsibility_group where pg_id='" . $_POST['pg'] . "' and rs_code= '" . $_POST['pr'] . "'";
      $result_rl = $conn->query($sql_rl);
   } elseif ($_POST['action'] == 'updateRL') {
      if ($_POST['tag'] == "add") $sql_rl = "insert into responsibility_group (pg_id, mn_id) values ('" . $_POST['pg'] . "', '" . $_POST['mn'] . "')";
      else $sql_rl = "delete from responsibility_group where pg_id='" . $_POST['pg'] . "' and mn_id= '" . $_POST['mn'] . "'";
      $result_rl = $conn->query($sql_rl);
   } elseif ($_POST['action'] == 'updatePriv') {
      if ($_POST['tag'] == "add") $sql = "insert into privilege_group (pg_id, up_code) values ('" . $_POST['pg'] . "', '" . $_POST['priv'] . "')";
      else $sql = "delete from privilege_group where pg_id='" . $_POST['pg'] . "' and up_code= '" . $_POST['priv'] . "'";
      $result_rl = $conn->query($sql);
   } elseif ($_POST['action'] == 'updateMenu') {
      $curl = curl_init();
      $url = 'https://classconnect.in/api/get_portal_menu.php';
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      $output = json_decode($output, true);

      if ($output['success'] == "True") {
         $masterMenu = count($output['data']);
         $sql = "select * from portal_menu";
         $result = $conn->query($sql);
         $portalMenu = $result->num_rows;
         echo $masterMenu . '-' . $portalMenu;
         if ($masterMenu > $portalMenu) {
            for ($i = 0; $i < $masterMenu; $i++) {
               $sql = "insert into portal_menu (pm_id, pm_name, pm_sno, pm_status) values('" . $output["data"][$i]["pm_id"] . "', '" . $output["data"][$i]["pm_name"] . "', '" . $output["data"][$i]["pm_sno"] . "', '" . $output["data"][$i]["pm_status"] . "')";
               $result = $conn->query($sql);
               if (!$result) {
                  echo "pm_id " . $output["data"][$i]["pm_id"];
                  echo $conn->error;
               }
            }
         }
      }
   } elseif ($_POST['action'] == 'updateGroup') {
      $curl = curl_init();
      $url = 'https://classconnect.in/api/get_portal_group.php';
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      $output = json_decode($output, true);

      if ($output['success'] == "True") {
         $masterGroup = count($output['data']);
         $sql = "select * from portal_group";
         $result = $conn->query($sql);
         $portalGroup = $result->num_rows;
         echo $masterGroup . '-' . $portalGroup;
         for ($i = 0; $i < $masterGroup; $i++) {
            $sql = "insert into portal_group (pg_id, pm_id, pg_name, pg_folder, pg_type, pg_sno, pg_status) values('" . $output["data"][$i]["pg_id"] . "','" . $output["data"][$i]["pm_id"] . "','" . $output["data"][$i]["pg_name"] . "','" . $output["data"][$i]["pg_folder"] . "','" . $output["data"][$i]["pg_type"] . "', '" . $output["data"][$i]["pg_sno"] . "', '" . $output["data"][$i]["pg_status"] . "')";
            $result = $conn->query($sql);
            if (!$result) {
               $sql = "update portal_group set pm_id='" . $output["data"][$i]["pm_id"] . "', pg_name='" . $output["data"][$i]["pg_name"] . "', pg_folder='" . $output["data"][$i]["pg_folder"] . "', pg_sno='" . $output["data"][$i]["pg_sno"] . "', pg_status='" . $output["data"][$i]["pg_status"] . "' where pg_id='" . $output["data"][$i]["pg_id"] . "'";
               $result = $conn->query($sql);
               if (!$result) {
                  echo "<br>pg_id " . $output["data"][$i]["pg_id"];
                  echo "pm_id " . $output["data"][$i]["pm_id"];
                  echo " " . $conn->error;
               }
            }
         }
      }
   } elseif ($_POST['action'] == 'updateUpr') {
      $sql = "update user_privilege set up_code='" . $_POST['value'] . "' where user_id= '" . $_POST['userId'] . "'";
      $result = $conn->query($sql);
   } elseif ($_POST['action'] == 'staffList') {
      $sql = "SELECT s.* from staff s where s.staff_status='0' order by s.staff_name";
      //  echo $count;
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         $subArray = array();
         $count = 0;
         while ($rowsStaff = $result->fetch_assoc()) {
            $count++;
            $subArray["count"] = $count;
            $staff_id = $rowsStaff["staff_id"];
            $user_id = $rowsStaff["user_id"];
            $subArray["user_id"] = $user_id;
            $subArray["staff_name"] = $rowsStaff["staff_name"];
            $subArray["staff_mobile"] = $rowsStaff["staff_mobile"];
            $subArray["staff_status"] = $rowsStaff["staff_status"];

            $sql_user = "select * from user where staff_id='$staff_id'";
            $result_user = $conn->query($sql_user);
            if ($result_user && $result_user->num_rows == 1) {
               $rowsUser = $result_user->fetch_assoc();
               $subArray["user_status"] = $rowsUser["user_status"];
               $subArray["last_login"] = $rowsUser["last_login"];
            } else $subArray["user_status"] = "100";

            $sql_up = "select * from user_privilege where user_id='$user_id'";
            $result_user = $conn->query($sql_up);
            if ($result_user && $result_user->num_rows == 1) {
               $rowsUser = $result_user->fetch_assoc();
               $subArray["up_code"] = $rowsUser["up_code"];
            } else $subArray["up_code"] = "100";

            // $subArray["user_status"]=$result_user->num_rows;
            $json_array[] = $subArray;
         }
         echo json_encode($json_array);
         //   echo '<div class="card">';
         //   echo '<div class="row m-1">';
         //   echo '<div class="col-10"><h7 class="card-title">' . $staff_name . '</h7>[<span class="card-subtitle mb-2 text-muted">' . $user_id . '</span>]</div>';
         //   echo '<div class="col-1 p-0">';
         //   if ($result->num_rows > 0)  echo '<a href="#" class="fa fa-minus removeUser" data-id="' . $staff_id . '"></a></div>';
         //   else echo '<a href="#" class="fa fa-plus addUser" data-id="' . $staff_id . '"></a></div>';
         //   echo '<div class="col-1 p-0"><a href="#" class="fa fa-edit editStaff" data-staff="' . $staff_id . '"></a></div>';
         //   echo '</div>';
         //   echo '</div>';
      }
   } elseif ($_POST['action'] == 'uaLog') {
      $ua_time = $_POST['ua_date'];
      $page = $_POST['page'];
      $page_limit = $_POST['page_limit'];

      $start=($page-1)*$page_limit+1;
      $end=($page)*$page_limit;

      $to_time = date("Y-m-d H:i:s", strtotime($ua_time) + 3600 * 24);

      $json_array = array();

      $sqlAll = "SELECT * from user_activity ua where ua_time>='$ua_time' and ua_time<'$to_time'";
      $totalRecord=$conn->query($sqlAll)->num_rows;
      
      $sql = "SELECT s.staff_id, s.staff_name, s.staff_mobile, s.user_id, ua.* from staff s, user_activity ua where s.staff_id=ua.staff_id and s.staff_status='0' and ua_time>='$ua_time' and ua_time<'$to_time' order by ua.ua_time desc limit $start, $end";

      $json_array["totalRecord"]=$totalRecord;
      //  echo $count;
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {         
         $data = array();
         $subArray = array();
         $count = 0;
         while ($rowsStaff = $result->fetch_assoc()) {
            $count++;
            $subArray["count"] = $count;
            $staff_id = $rowsStaff["staff_id"];
            $user_id = $rowsStaff["user_id"];
            $subArray["user_id"] = $user_id;
            $subArray["staff_name"] = $rowsStaff["staff_name"];
            $subArray["staff_mobile"] = $rowsStaff["staff_mobile"];
            $subArray["ua_name"] = $rowsStaff["ua_name"];
            $ts = strtotime($rowsStaff["ua_time"]);
            $subArray["ua_date"] = date("d-m-Y", $ts);
            $subArray["ua_time"] = date("H:i:s", $ts);

            $sql_up = "select * from user_privilege where user_id='$user_id'";
            $result_user = $conn->query($sql_up);
            if ($result_user && $result_user->num_rows == 1) {
               $rowsUser = $result_user->fetch_assoc();
               $subArray["up_code"] = $rowsUser["up_code"];
            } else $subArray["up_code"] = "100";

            $data[] = $subArray;
         }
         $json_array["data"] = $data;
         echo json_encode($json_array);
      }
   }
}
