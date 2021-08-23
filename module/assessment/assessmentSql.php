<?php
require('../requireSubModule.php');
include('../../phpFunction/teachingLoadFunction.php');

//echo $_POST['action'];

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'addTemplate') {
    $sql = "insert into $tn_atmp (ac_id, at_id, atmp_template, atmp_weightage, atmp_internal, update_id, atmp_status) values('" . data_check($_POST['sel_ac']) . "', '" . data_check($_POST['sel_at']) . "', '" . data_check($_POST['sel_template']) . "', '" . data_check($_POST['weightage']) . "', '" . data_check($_POST['internal']) . "', '$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['action'] == 'selectTemplate') {
    $sql = "select * from $tn_atmp where atmp_status='0' group by atmp_template order by atmp_template";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $i = 1;
    echo '<select class="form-control form-control-sm" id="sel_template" name="sel_template" required>';
    //echo '<option>Select a Template</option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray["atmp_template"];
      echo '<option value="' . $id . '">Template-' . $i++ . '</option>';
    }
    echo '<option value="' . $i . '">New Template</option>';
    echo '</select>';
  } elseif ($_POST['action'] == 'atmpList') {
    $totalTemplates = getMaxField($conn, $tn_atmp, "atmp_template");
    //echo $totalTemplates;
    for ($i = 1; $i <= $totalTemplates; $i++) {
      $sql = "select * from $tn_atmp where atmp_template='$i' order by ac_id";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      echo '<div class="row">';
      echo '<div class="col-sm-2 m-0 p-1">';
      echo '<div class="card myCard m-2 text-center">';
      echo '<h4">Template-' . $i . '</h4>';
      echo '</div>';
      echo '</div>';
      while ($rowsArray = $result->fetch_assoc()) {
        $status = $rowsArray["atmp_status"];
        $internal = $rowsArray["atmp_internal"];
        $ac = getField($conn, $rowsArray["ac_id"], "master_name", "mn_id", "mn_name");
        $at = getField($conn, $rowsArray["at_id"], "master_name", "mn_id", "mn_name");
        //echo $ac.'-'.$at;
        echo '<div class="col m-1 p-0">';
        echo '<div class="card myCard">';
        echo '<div class="row p-1">';
        echo '<div class="col-8 xsText">' . $ac . '</div>';
        echo '<div class="col-4 smallText m-0">' . $rowsArray["atmp_weightage"] . '</div>';
        echo '</div>';
        echo '<div class="row p-1">';
        echo '<div class="col-8 xsText">' . $at . '</div>';
        if ($internal == 'internal') echo '<div class="col-4 smallText m-0">I</div>';
        else echo '<div class="col-4 smallText m-0">E</div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col ml-2">';
        echo '<a href="#" class="float-left rp_idE" data-id="' . $rowsArray["ac_id"] . '"><i class="fa fa-edit"></i></a>';
        if ($status == "9") echo '<a href="#" class="float-right rp_idR" data-id="' . $rowsArray["ac_id"] . '"><i class="fa fa-refresh" aria-hidden="true"></i></a>';
        else echo '<a href="#" class="float-right rp_idD" data-id="' . $rowsArray["ac_id"] . '"><i class="fa fa-trash"></i></a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
    }
  } elseif ($_POST['action'] == 'myLoadList') {
    $data = staffTeachingLoad($conn, $myId, $tn_tl, $tn_tlg);
    $jsonOutput = json_encode($data);
    echo $jsonOutput;
  } elseif ($_POST['action'] == 'fetchSubjectTemplate') {
    $sql = "update $tn_sat set sat_status='1' where update_id='$myId'";
    $result = $conn->query($sql);
    $sql = "insert into $tn_sat (tl_id, update_id, sat_status) values('" . $_POST['id'] . "', '$myId', '0')";
    $result = $conn->query($sql);

    $sql = "update $tn_sat set sat_status='0' where tl_id='" . $_POST['id'] . "'";
    $result = $conn->query($sql);

    $sql = "select * from $tn_atmp where atmp_status='0' group by atmp_template order by atmp_template";
    $result = $conn->query($sql);
    $data = array();
    while ($rowsArray = $result->fetch_assoc()) {
      $subarray = array();
      $atmp_template = $rowsArray["atmp_template"];
      $sql_atmp = "select atmp.*, mn.mn_name from $tn_atmp atmp, master_name mn where atmp.atmp_template='$atmp_template' and atmp.ac_id=mn.mn_id order by atmp.atmp_internal, mn.mn_id";
      $result_atmp = $conn->query($sql_atmp);
      $text = '';
      while ($rowsAtmp = $result_atmp->fetch_assoc()) {
        $text .= $rowsAtmp["mn_name"];
        $text .= ' [' . $rowsAtmp["atmp_weightage"] . '], ';
      }
      $subarray["atmp_template"] = $atmp_template;
      $subarray["atmp_id"] = $rowsArray["atmp_id"];
      $subarray["text"] = $text;
      $sql_check = "select * from $tn_sat where tl_id='" . $_POST['id'] . "' and atmp_template='$atmp_template'";
      $result_check = $conn->query($sql_check);
      if ($result_check) $subarray["check"] = $result_check->num_rows;
      else $subarray["check"] = '0';
      $data[] = $subarray;
    }
    $jsonOutput = json_encode($data);
    echo $jsonOutput;
  } elseif ($_POST['action'] == 'setSubjectTemplate') {
    $sql = "select * from $tn_sat where sat_status='0' and update_id='$myId'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $row = $result->fetch_assoc();
      $tl_id = $row['tl_id'];
      $sql = "update $tn_sat set atmp_template='" . $_POST['id'] . "' where tl_id='$tl_id'";
      $result = $conn->query($sql);
    }

    // Deleting Assessment Components of Previous Template for this Teaching Load

    $sql = "delete from $tn_sbas where  tl_id='$tl_id'";
    $result = $conn->query($sql);

    $sql_atmp = "select atmp.* from $tn_atmp atmp where atmp.atmp_template='" . $_POST['id'] . "'";
    $result_atmp = $conn->query($sql_atmp);
    while ($rowAtmp = $result_atmp->fetch_assoc()) {
      $atmp_id = $rowAtmp["atmp_id"];
      $sql = "insert into $tn_sbas (tl_id, atmp_id, sbas_assessments, sbas_consider, update_id) values('$tl_id','$atmp_id','1', '1', '$myId')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'fetchAssessmentComponent') {
    $sql = "select * from $tn_sat where sat_status='0' and update_id='$myId'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $row = $result->fetch_assoc();
      $tl_id = $row['tl_id'];
      $atmp_template = $row['atmp_template'];
      $data = array();
      $sql_ac = "select atmp.*, sbas.sbas_consider, sbas.sbas_assessments, mn.mn_name from $tn_atmp atmp, $tn_sbas sbas, master_name mn where sbas.tl_id='$tl_id' and sbas.atmp_id=atmp.atmp_id and atmp.ac_id=mn.mn_id";
      $result_ac = $conn->query($sql_ac);
      while ($rowAC = $result_ac->fetch_assoc()) {
        $subArray = array();
        $subArray["mn_name"] = $rowAC["mn_name"];
        $subArray["atmp_id"] = $rowAC["atmp_id"];
        $subArray["sbas_assessments"] = $rowAC["sbas_assessments"];
        $subArray["sbas_consider"] = $rowAC["sbas_consider"];
        $subArray["atmp_weightage"] = $rowAC["atmp_weightage"];
        $data[] = $subArray;
      }
      $jsonOutput = json_encode($data);
      echo $jsonOutput;
    }
  }elseif ($_POST['action'] == 'updateAssessmentNumber') {
    $sql = "select * from $tn_sat where sat_status='0' and update_id='$myId'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $row = $result->fetch_assoc();
      $tl_id = $row['tl_id'];

      if($_POST['tag']=='assessment')$sql_ac = "update $tn_sbas set sbas_assessments='".$_POST['value']."' where tl_id='$tl_id' and atmp_id='".$_POST['id']."'";
      else $sql_ac = "update $tn_sbas set sbas_consider='".$_POST['value']."' where tl_id='$tl_id' and atmp_id='".$_POST['id']."'";
      $result_ac = $conn->query($sql_ac);
      if(!$result_ac)echo $conn->error;
    }
  }
}
