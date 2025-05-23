<?php
require('../requireSubModule.php');

//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == "mtlList") {
    //echo "$myId - $tn_tl - $tn_tlg";
    $jsonTL = get_staffTeachingLoad($conn, $myId, $tn_tl, $tn_tlg);
    //echo $jsonTL;
    echo '<div class="row">';

    $array = json_decode($jsonTL, true);
    for ($i = 0; $i < count($array["data"]); $i++) {
      $tlId = $array["data"][$i]["tlId"];
      $class_id = $array["data"][$i]["class_id"];
      $type = $array["data"][$i]["type"];
      $group = $array["data"][$i]["group"];
      $class = getField($conn, $class_id, "class", "class_id", "class_name");
      $section = getField($conn, $class_id, "class", "class_id", "class_section");
      $subject_id = $array["data"][$i]["subject_id"];
      $subject = getField($conn, $subject_id, "subject", "subject_id", "subject_code");
      echo '<div class="col-2">';
      if ($i == 0) echo '<input type="radio" class="sel_subject" checked id="cl' . $tlId . '" name="subject" value="' . $tlId . '">';
      else echo '<input type="radio" class="sel_subject"  id="cl' . $tlId . '" name="subject" value="' . $tlId . '">';
      echo '<span class="smallerText"> ' . $subject . ' ' . $class . '[' . $section . '] ' . $type . 'G-' . $group . '</span>';
      echo '</div>';
    }
    echo '</div>';
  } elseif ($_POST['action'] == "stList") {
    $tlId = $_POST['tlId'];
    //echo "TL Id - $tlId";
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $subject_id = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $sno = 1;
    $sql = "select * from $tn_sbt where subject_id='$subject_id' and sbt_status='0' order by sbt_syllabus, sbt_sno";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>Id</th><th class="text-center" width="5%"><i class="fa fa-pencil-alt"></i></th><th width="50%">Topic</th><th>Unit</th><th>Wt</th><th>Slot(s)</th><th>Coverage</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $sbtId = $rows["sbt_id"];
      echo '<tr>';
      echo '<td>' . $sno++ . '</td>';
      echo '<td>[' . $rows["sbt_id"] . '] </td>';
      echo '<td class="text-center">';
      // if ($sno > 2) echo '<a href="#" class="btn btn-success btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="UP"><i class="fa fa-arrow-up"></i></a>';
      // if ($sno <= $result->num_rows) echo '<a href="#" class="btn btn-danger btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="DN"><i class="fa fa-arrow-down"></i></a>';
      echo '<a href="#" class="fa fa-pencil-alt editButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '"></a>';
      echo '</td>';
      echo '<td>' . $rows["sbt_name"] . '</td>';
      echo '<td>' . $rows["sbt_unit"] . '</td>';
      echo '<td>' . $rows["sbt_weight"] . '</td>';
      echo '<td>' . $rows["sbt_slot"] . '</td>';
      if($rows["sbt_syllabus"]=='0')echo '<td>S</td>';
      else echo '<td>A</td>';
      echo '<td>';
      $output = getFieldArray($conn, $sbtId, $tn_ccd, "sbt_id", "sas_id");
      for ($i = 0; $i < count($output); $i++) {
        if ($i > 0) echo '<br>';
        echo getField($conn, $output[$i], $tn_sas, "sas_id", "sas_date");;
      }
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == "addST") {
    $tlId = $_POST['tlId'];
    $sbt_name = $_POST['sbt_name'];
    $sbt_weight = $_POST['sbt_weight'];
    $sbt_slot = $_POST['sbt_slot'];
    $sbt_unit = $_POST['sbt_unit'];
    $sbt_syllabus = $_POST['sbt_syllabus'];

    // echo "TL Id - $tlId";
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $subject_id = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $tlg_type = getField($conn, $tlgId, $tn_tlg, "tlg_id", "tlg_type");

    $sql = "select max(sbt_sno) as max from $tn_sbt where subject_id='$subject_id' and sbt_type='$tlg_type' and sbt_status='0'";
    $max_sno = getMaxValue($conn, $sql) + 1;
    // echo "Max $max_sno | Type $tlg_type";
    $dup = "select * from $tn_sbt where subject_id='$subject_id' and sbt_type='$tlg_type' and sbt_name='$sbt_name'";
    $result = $conn->query($dup);
    if ($result->num_rows == 0) {
      $sql = "insert into $tn_sbt (subject_id, sbt_name, sbt_weight, sbt_slot, sbt_type, sbt_sno, sbt_unit, sbt_syllabus, update_id, sbt_status) values('$subject_id', '$sbt_name', '$sbt_weight', '$sbt_slot', '$tlg_type', '$max_sno', '$sbt_unit', '$sbt_syllabus', '$myId', '0')";
    } else {
      $sql = "update  $tn_sbt set sbt_status='0' where subject_id='$subject_id' and sbt_type='$tlg_type' and sbt_name='$sbt_name'";
    }
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  } elseif ($_POST['action'] == "swap") {
    $selectedId = $_POST['sbtId'];
    $swap = $_POST['swap'];
    $sql = "select * from $tn_sbt where sbt_id='$selectedId'";
    $json = getTableRow($conn, $sql, array("subject_id", "tlg_type", "sbt_sno"));
    echo $json;
    $array = json_decode($json, true);

    $selectedSno = $array["data"][0]["sbt_sno"];
    if ($swap == "UP") $swapSno = $selectedSno - 1;
    elseif ($swap == "DN") $swapSno = $selectedSno + 1;

    $subject_id = $array["data"][0]["subject_id"];
    $tlg_type = $array["data"][0]["tlg_type"];

    $sql = "update $tn_sbt set sbt_sno='$selectedSno' where subject_id='$subject_id' and tlg_type='$tlg_type' and sbt_sno='$swapSno'";
    $result = $conn->query($sql);

    $sql = "update $tn_sbt set sbt_sno='$swapSno' where sbt_id='$selectedId'";
    $result = $conn->query($sql);
  } else if ($_POST['action'] == 'addRes') {
    $tlId = $_POST['tlId'];
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $subject_id = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");

    // echo "Subject $subject_id Id $myId";

    $dup = "select * from $tn_sr where sr_name='" . data_check($_POST["sbr_name"]) . "' and subject_id='$subject_id' and rt_id='" . data_check($_POST['mn_id']) . "' and update_id='$myId'";
    $result = $conn->query($dup);
    if ($result) {
      if ($result->num_rows == 0) {
        $sql = "insert into $tn_sr (subject_id, rt_id, sr_name, sr_type, sr_url, update_id, sr_status) values('$subject_id', '" . $_POST['mn_id'] . "', '" . data_check($_POST["sbr_name"]) . "', '" . data_check($_POST["sbr_type"]) . "', '" . data_check($_POST["sbr_url"]) . "', '$myId', '0')";
      } else {
        $sql = "update  $tn_sr set sr_status='0' where sr_name='" . data_check($_POST["sbr_name"]) . "' and subject_id='$subject_id' and rt_id='" . data_check($_POST['mn_id']) . "' and update_id='$myId'";
      }
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
    } else echo $conn->error;



    //echo "OK";
  } elseif ($_POST['action'] == "resList") {
    $tl_id = $_POST['tlId'];
    //echo "Sub $subject_id";
    $sql = "select subject_id from $tn_tl tl, $tn_tlg tlg where tl.tl_id='$tl_id' and tl.tlg_id=tlg.tlg_id";
    $subject_id = getFieldValue($conn, "subject_id", $sql);
    $subject = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
    $json = get_subjectResource($conn, $tn_sr, $subject_id);
    //echo $json;
    $array = json_decode($json, true);

    echo '<table class="table list-table-xs">';
    echo '<tr><th>Id</th><th>Title</th><th>Type</th><th>Link</th><th><i class="fa fa-upload"></i></th><th>Class</th></tr>';
    for ($i = 0; $i < count($array["data"]); $i++) {
      $srId = $array["data"][$i]["id"];
      $sr_name = $array["data"][$i]["name"];
      $mn_name = $array["data"][$i]["mn_name"];
      $sr_url = $array["data"][$i]["url"];

      echo '<tr>';
      echo '<td>' . $srId . '</td><td>' . $sr_name . '</td><td>' . $mn_name . '</td><td><a href="' . $sr_url . '" target="_blank">' . $sr_url . '</a></td>';
      echo '<td><h5><a href="#" class="fa fa-arrow-circle-up upload" data-sr="' . $srId . '"></a></td>';
      $filelink = '../../' . $myFolder . 'resourse/' . $srId . '.pdf';
      if (!file_exists($filelink)) {
        $filelink = '#';
        $filename = '#';
      } else $filename = $srId . '.pdf';
      echo '<td><a href="' . $filelink . '" class="fa fa-eye show" target="_blank" data-sr="' . $srId . '">' . $filename . '</a></td>';
      echo '<td>';
      $jsonTL = get_staffClass($conn, $myId, $tn_tl, $tn_tlg);
      //echo $jsonTL;
      $arrayTL = json_decode($jsonTL, true);
      for ($j = 0; $j < count($arrayTL["data"]); $j++) {
        $class_id = $arrayTL["data"][$j]["class_id"];
        $sql = "select * from $tn_src where class_id='$class_id' and sr_id='$srId'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        $class = getField($conn, $class_id, "class", "class_id", "class_name");
        $class_section = getField($conn, $class_id, "class", "class_id", "class_section");
        if ($result->num_rows == 0) echo ' <input type="checkbox" class="resClass" name="res_class" data-resCl="' . $class_id . '" data-sr="' . $srId . '"> ' . $class . '[' . $class_id . ']';
        else echo ' <input type="checkbox" class="resClass" checked name="res_class" data-resCl="' . $class_id . '" data-sr="' . $srId . '"> ' . $class . ' [' . $class_section . ']';
      }
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '';
  } elseif ($_POST['action'] == "resClass") {
    $classId = $_POST['classId'];
    $srId = $_POST['srId'];
    $checkboxStatus = $_POST['checkboxStatus'];
    // echo "Class $classId RSB $srId";
    if ($checkboxStatus == 'true') $sql = "insert into $tn_src (class_id, sr_id) values('$classId', '$srId')";
    else $sql = "delete from $tn_src where class_id='$classId' and sr_id='$srId'";
    $conn->query($sql);
    echo $conn->error;
  } elseif ($_POST['action'] == "coverage") {
    $tlId = $_POST['tlId'];
    //echo "TL Id - $tlId";
    $sno = 1;
    $sql = "select * from $tn_sas where tl_id='$tlId' and sas_status='0' order by sas_date, sas_period";
    $result = $conn->query($sql);
    echo '<label>Course Coverage Details</label>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>SasId</th><th>Date</th><th>Period</th><th width="50%">Topic</th><th>Wt</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $sasId = $rows["sas_id"];
      echo '<tr>';
      echo '<td>' . $sno++ . '</td><td>' . $rows["sas_id"] . '</td>';
      echo '<td>' . date("d-M", strtotime($rows["sas_date"])) . '</td>';
      echo '<td>' . $rows["sas_period"] . '</td>';
      echo '<td>';
      $output = getFieldArray($conn, $sasId, $tn_ccd, "sas_id", "sbt_id");
      for ($i = 0; $i < count($output); $i++) {
        if ($i > 0) echo '<br>';
        echo getField($conn, $output[$i], $tn_sbt, "sbt_id", "sbt_name");;
        echo '[#' . getField($conn, $output[$i], $tn_sbt, "sbt_id", "sbt_sno") . ']';
      }
      echo '</td>';
      echo '<td>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == "fetchSbt") {
    $sbtId = $_POST['sbtId'];
    //echo "TL Id - $sbtId";
    $sql = "select * from $tn_sbt where sbt_id='$sbtId'";
    $result = $conn->query($sql);
    $rows = $result->fetch_assoc();
    echo json_encode($rows);
  }
}
