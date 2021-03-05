<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo "Action ".$_POST['action'];
if (isset($_POST["query"])) {
  $output = '';
  $sql = "select * from staff where staff_name LIKE '%" . $_POST["query"] . "%' and staff_status='0'";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action autoListStaff" data-staff="' . $row["staff_id"] . '" >' . $row["staff_name"] . '</li>';
    }
  } else {
    $output .= '<li>Staff Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
} else if ($_POST["action"] == "newNotice") {
  //echo $_POST["action"];
  $sql = "select * from notice where notice_subject='' and submit_id='$myId'";
  $noticeId = getFieldValue($conn, "notice_id", $sql);
  if ($noticeId == "") {
    $sql = "insert into notice (submit_id, notice_status) values('$myId','0')";
    $conn->query($sql);
    $noticeId = $conn->insert_id;
  }
  echo $noticeId;
} else if ($_POST["action"] == "updateNotice") {
  //echo $_POST["action"];
  echo $_POST["subject"];
  echo $_POST["noticeId"];
  echo $_POST["content"];
  $sql = "update notice set notice_subject='" . $_POST['subject'] . "' where notice_id='" . $_POST['noticeId'] . "'";
  $result = $conn->query($sql);
  if (!$result) echo $conn->errno;
  else {
    //echo "Updated";
    $folder = '../../' . $myFolder . '/notice';
    if (!is_dir($folder)) mkdir($folder);
    $fileName = $folder . '/text-' . $_POST["noticeId"] . '.txt';
    if (file_exists($fileName)) {
      $fileHandle = fopen($fileName, 'w+') or die("Cannot open file");
      fwrite($fileHandle, $_POST["content"]);
    } else {
      $header = '<div class="d-flex justify-content-center"><h3>Department of Mechatronics Engineering</h3></div>';
      $header .= '<div class="d-flex justify-content-center"><h4>Chitkara University</h4></div>';
      $header .= '<hr>';
      $fileHandle = fopen($fileName, 'w+') or die("Cannot open file");
      fwrite($fileHandle, $header . $_POST["content"]);
    }
    fclose($fileHandle);
  }
} else if ($_POST["action"] == "draftList") {
  echo '<button class="btn btn-info btn-square-sm newNoticeButton">New</button>';
  echo '<button class="btn btn-warning btn-square-sm draftButton">Draft</button>';
  $sql = "select * from notice where submit_id='$myId' and notice_status='0' order by update_ts desc";
  $result = $conn->query($sql);
  if (!$result) echo $conn->errno;
  else {
    echo '<div class="list-group list-group-mine mt-2">';
    while ($arrayRows = $result->fetch_assoc()) {

      $id = $arrayRows["notice_id"];
      echo '<p class="list-group-item list-group-item-action inbox" href="#inbox">';
      echo $arrayRows["notice_subject"];
      echo '<span class="float-right"> &nbsp; ' . date("h-i", strtotime($arrayRows["update_ts"])) . '</span>';
      echo '<span class="float-right"> ' . date("d-m-Y", strtotime($arrayRows["update_ts"])) . '</span>';
      echo '<button class="btn btn-info btn-square-sm float-right editDraftButton" data-noticeId="' . $id . '">Edit</button>';
      echo '<button class="btn btn-warning btn-square-sm float-right previewButton" data-noticeId="' . $id . '">Preview</button>';
      echo '</p>';
    }
    echo '</div>';
  }
} elseif ($_POST['action'] == 'fetchNotice') {
  $id = $_POST['noticeId'];
  $sql = "SELECT * FROM notice where notice_id='$id'";
  $result = $conn->query($sql);
  if (!$result) die("re");
  else {
    $output = array();
    $arrayRows = $result->fetch_assoc();
    $output["notice_id"] = $arrayRows["notice_id"];
    $output["notice_subject"] = $arrayRows["notice_subject"];

    $folder = '../../' . $myFolder . '/notice';
    $fileName = $folder . '/text-' . $_POST["noticeId"] . '.txt';
    if (file_exists($fileName)) $content = file_get_contents($fileName);
    else $content = "No File Found";
    $output["content"] = $content;
  }
  echo json_encode($output);
} elseif ($_POST['action'] == 'fetchAttachment') {
  $id = $_POST['noticeId'];
  $sql = "SELECT * FROM notice_attachment where notice_id='$id'";
  $result = $conn->query($sql);
  if (!$result) die("re");
  else {
    while($arrayRows=$result->fetch_assoc()){
      echo $arrayRows["na_link"].'<a href="#" class="removeLink" data-link="'.$arrayRows["na_link"].'"><i class="fa fa-remove"></i></a><br>';
    }
  }
  if($result->num_rows==0)echo "No Attachment";
} elseif ($_POST['action'] == 'removeLink') {
  $noticeId=$_POST['noticeId'];
  $na_link=$_POST['link'];
  //echo "$noticeId $na_link";
  $sql="delete from notice_attachment where notice_id='$noticeId' and na_link='$na_link'";
  $conn->query($sql);
} elseif ($_POST['action'] == 'preview') {
  $id = $_POST['noticeId'];
  $output = getNotice($conn, $id, $myFolder);
  echo $output["content"];
} elseif ($_POST['action'] == 'fgList') {
  $sql = "select * from file_group where fg_status='0'";
  $result = $conn->query($sql);
  echo '<div class="row">';
  while ($arrayRows = $result->fetch_assoc()) {
    echo '<div class="card d-flex align-items-center minWidth120">
    <div class="folder" data-fg="' . $arrayRows["fg_id"] . '"><i class="fa fa-folder fa-3x"></i></div>
    <div class="card-body topBarText p-1">';
    echo '<span class="btn btn-warning btn-square-sm editFG" data-fg="' . $arrayRows["fg_id"] . '">' . $arrayRows["fg_name"] . '</span>';
    echo '</div>
  </div>';
  }
  echo '<div class="card d-flex align-items-center">
    <i class="fa fa-folder"></i>
    <div class="card-body p-1">
      <button class="btn btn-primary addFG">+</button>
    </div>
  </div>
  </div>';
} elseif ($_POST['action'] == 'addFG') {
  $fields = ['fg_name', 'fg_code', 'fg_status'];
  $values = [data_check($_POST['fg_name']), data_check($_POST['fg_code']), '0'];
  $status = 'fg_status';
  $dup = "select * from file_group where fg_name='" . data_check($_POST["fg_name"]) . "' and $status='0'";
  $dup_alert = "Duplicate Name Exists";
  addData($conn, 'file_group', 'fg_id', $fields, $values, $status, $dup, $dup_alert);
} elseif ($_POST['action'] == 'fetchFG') {
  $id = $_POST['fgId'];
  $sql = "SELECT * FROM file_group where fg_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
} elseif ($_POST['action'] == 'updateFG') {
  $fields = ['fg_id', 'fg_name', 'fg_code'];
  $values = [$_POST['modalId'], data_check($_POST['fg_name']), data_check($_POST['fg_code'])];
  $dup = "select * from file_group where fg_name='" . $_POST["fg_name"] . "'";
  $dup_alert = "Could Not Update - Duplicate Entry Exists";
  updateData($conn, 'file_group', $fields, $values, $dup, $dup_alert);
} elseif ($_POST['action'] == 'ftList') {
  $fgId = $_POST['fgId'];
  $sql = "select * from file_title where fg_id='$fgId' and ft_status='0'";
  $result = $conn->query($sql);
  echo '<br>';
  echo '<div class="row">';
  while ($arrayRows = $result->fetch_assoc()) {
    echo '<div class="card d-flex align-items-center minWidth100">
    <div class="folderFT" data-ft="' . $arrayRows["ft_id"] . '"><i class="fa fa-folder fa-2x"></i></div>
    <div class="card-body topBarText p-1">';
    echo '<a href="#" class="editFT" data-ft="' . $arrayRows["ft_id"] . '">' . $arrayRows["ft_name"] . '</a>';
    echo '</div>
  </div>';
  }
  echo '<div class="card d-flex align-items-center">
    <i class="fa fa-folder"></i>
    <div class="card-body p-1">
      <button class="btn btn-primary btn-sm addFT">+</button>
    </div>
  </div>
  </div>';
} elseif ($_POST['action'] == 'addFT') {
  $fields = ['fg_id', 'ft_name', 'ft_code', 'ft_status'];
  $values = [$_POST['fg_id'], data_check($_POST['ft_name']), data_check($_POST['ft_code']), '0'];
  $status = 'ft_status';
  $dup = "select * from file_title where fg_id='" . $_POST["fg_id"] . "' and ft_name='" . data_check($_POST["ft_name"]) . "' and $status='0'";
  $dup_alert = "Duplicate Name Exists";
  addData($conn, 'file_title', 'ft_id', $fields, $values, $status, $dup, $dup_alert);
} elseif ($_POST['action'] == 'fetchFT') {
  $id = $_POST['ftId'];
  $sql = "SELECT * FROM file_title where ft_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
} elseif ($_POST['action'] == 'updateFT') {
  $fields = ['ft_id', 'ft_name', 'ft_code'];
  $values = [$_POST['modalId'], data_check($_POST['ft_name']), data_check($_POST['ft_code'])];
  $dup = "select * from file_title where ft_name='" . $_POST["ft_name"] . "'";
  $dup_alert = "Could Not Update - Duplicate Entry Exists";
  updateData($conn, 'file_title', $fields, $values, $dup, $dup_alert);
} elseif ($_POST['action'] == 'addSchool') {
  $schoolId=$_POST['schoolId'];
  $noticeId=$_POST['noticeId'];
  if($schoolId=='ALL')$sql="delete from notice_school where notice_id='$noticeId'";
  else $sql="delete from notice_school where notice_id='$noticeId' and school_id='0'";
  $conn->query($sql);

  $sql = "insert into notice_school (notice_id, school_id, ns_group) values('" . $_POST['noticeId'] . "', '" . $_POST['schoolId'] . "', '0')";
  $conn->query($sql);
} elseif ($_POST['action'] == 'addDept') {
  $deptId=$_POST['deptId'];
  $noticeId=$_POST['noticeId'];
  if($deptId=='ALL')$sql="delete from notice_department where notice_id='$noticeId'";
  else $sql="delete from notice_department where notice_id='$noticeId' and dept_id='0'";
  $conn->query($sql);

  $sql = "insert into notice_department (notice_id, dept_id, nd_group) values('" . $_POST['noticeId'] . "', '" . $_POST['deptId'] . "', '0')";
  $conn->query($sql);
} elseif ($_POST['action'] == 'addClass') {
  $classId=$_POST['classId'];
  $noticeId=$_POST['noticeId'];
  if($classId=='ALL')$sql="delete from notice_class where notice_id='$noticeId'";
  else $sql="delete from notice_class where notice_id='$noticeId' and class_id='0'";
  $conn->query($sql);

  $sql = "insert into notice_class (notice_id, class_id, nc_group) values('" . $_POST['noticeId'] . "', '" . $_POST['classId'] . "', '0')";
  $conn->query($sql);
} else if ($_POST["action"] == "recipientList") {
  echo '<table class="table list-table-xs">';
  $sql = "select * from notice_school where notice_id='" . $_POST['noticeId'] . "'";
  $result = $conn->query($sql);
  if (!$result) echo $conn->errno;
  else {
    if($result->num_rows>0)echo '<tr class="tableRowHead-sm"><td colspan="2"><span>Inst/School</span></td></tr>';
    while ($arrayRows = $result->fetch_assoc()) {
      $schoolId = $arrayRows["school_id"];
      if ($schoolId > 0) {
        $sql = "select * from school where school_id='$schoolId'";
        $school_abbri = getFieldValue($conn, "school_abbri", $sql);
      }else $school_abbri="ALL Inst";
      echo '<tr><td><input type="checkbox" class="cbSchool" data-school="' . $schoolId . '" checked></td>';
      echo '<td>' . $school_abbri.'</td></tr>';
    }
  }
  $sql = "select * from notice_department where notice_id='" . $_POST['noticeId'] . "'";
  $result = $conn->query($sql);
  if (!$result) echo $conn->errno;
  else {
    if($result->num_rows>0)echo '<tr class="tableRowHead-sm"><td colspan="2"><span>Department</span></td></tr>';
    while ($arrayRows = $result->fetch_assoc()) {
      $deptId = $arrayRows["dept_id"];
      if ($deptId > 0) {
        $sql = "select * from department where dept_id='$deptId'";
        $dept_abbri = getFieldValue($conn, "dept_abbri", $sql);
      }else $dept_abbri="ALL Dept";
      echo '<tr><td><input type="checkbox" class="cbDept" data-dept="' . $deptId . '" checked></td>';
      echo '<td>' . $dept_abbri.'</td></tr>';
    }
  }
  $sql = "select * from notice_class where notice_id='" . $_POST['noticeId'] . "'";
  $result = $conn->query($sql);
  if (!$result) echo $conn->errno;
  else {
    if($result->num_rows>0)echo '<tr class="tableRowHead-sm"><td colspan="2"><span>Class</span></td></tr>';
    while ($arrayRows = $result->fetch_assoc()) {
      $classId = $arrayRows["class_id"];
      if ($classId > 0) {
        $sql = "select * from class where class_id='$classId'";
        $class_name = getFieldValue($conn, "class_name", $sql);
        $class_section = getFieldValue($conn, "class_section", $sql);
      }else {
        $class_name="ALL Classes";
        $class_section="All";
      }
      echo '<tr><td><input type="checkbox" class="cbClass" data-class="' . $classId . '" checked></td>';
      echo '<td>' . $class_name.'['.$class_section.']</td></tr>';
    }
  }
  echo '</table>';
} elseif ($_POST['action'] == 'updateRecipient') {
  if(isset($_POST['deptId']))$sql="delete from notice_department where notice_id='".$_POST['noticeId']."' and dept_id='".$_POST['deptId']."'";
  elseif(isset($_POST['schoolId']))$sql="delete from notice_school where notice_id='".$_POST['noticeId']."' and school_id='".$_POST['schoolId']."'";
  elseif(isset($_POST['classId']))$sql="delete from notice_class where notice_id='".$_POST['noticeId']."' and class_id='".$_POST['classId']."'";
  $conn->query($sql);
}
