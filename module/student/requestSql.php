<?php
session_start();
include('../../config_database.php');
include('config_variable.php');
include('php_function.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'addEAClaim') {
    $ea_date = $_POST['ea_date'];
    $eac_claim = $_POST['ea_claim'];
    $eac_remarks = $_POST['ea_remarks'];
    $eae_id = $_POST['sel_eae'];
    //echo "Claim $eac_claim Date $ea_date Id $eae_id ";
    $sql = "insert into ea_claim (student_id, eac_date, eae_id, eac_claim, eac_remarks) values('$myStdId','$ea_date','$eae_id','$eac_claim', '$eac_remarks')";
    $result = $conn->query($sql);
    if ($result) echo "Successfully Submitted";
    else echo "Could Not be Added ! ";
  } elseif ($_POST['action'] == 'eaClaimList') {

    $sql = "select eac.*, eae.* from ea_claim eac, ea_event eae where eae.eae_id=eac.eae_id and eac.student_id='$myStdId' order by eac.eac_date";

    $fields = array("eac_date", "eae_name", "eac_claim", "eac_remarks", "eac_approved", "eac_status");
    $header = array("Id", "Date", "Event", "Claim", "Remarks", "Approved", "Status");
    $statusDecode = array("status" => "eac_status", "0" => "Submitted", "3" => "Approved", "4" => "Rejected", "9" => "Withdrawn");
    $dataType = array("1", "0", "0", "0", "0", "0");
    $button = array("0", "0", "0", "0", "Edit");
    getList($conn, "student_id", $fields, $dataType, $header, $sql, $statusDecode, $button);
    //echo "sddsd";
  } elseif ($_POST['action'] == 'fetchEAC') {
    $id = $_POST['student_id'];
    $date = $_POST['eac_date'];
    $sql = "SELECT * FROM ea_claim where student_id='$id' and eac_date='$date'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "updateEAC") {
    $date = $_POST['eac_dateM'];
    //$sql = "update ea_claim set eac_date='".data_check($_POST['eac_dateM'])."', eae_id='".$_POST['sel_eae']."', eac_claim='".data_check($_POST['ea_claim'])."', eac_remarks='".data_check($_POST['ea_remarks'])."', update_ts='$today_ts' where student_id='".$_POST['student_id']."' and eac_date='".$_POST['eac_dateM']."'";
    $sql = "update ea_claim set  eac_date='" . data_check($_POST['ea_date']) . "', eac_claim='" . data_check($_POST['ea_claim']) . "', eae_id='" . $_POST['sel_eae'] . "', submit_ts='$today_ts' where  student_id='" . $_POST['student_id'] . "' and eac_date='$date'";
    $result = $conn->query($sql);
    if (!$result) $conn->error;
  } elseif ($_POST['action'] == "getSchedule") {
    $student_id = $_POST['student_id'];
    $date = $_POST['claim_date'];
    //echo $student_id.' Date '.$date;
    $curl = curl_init();
    $url = 'https://instituteerp.net/acadplus/api/getStudentSchedule.php?student_id=' . $student_id . '&&sas_date=' . $date;

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    //echo $output;
    //$output=json_encode($output, true);
    $output = json_decode($output, true);
    $sql = "select * from subject";
    $result = $conn->query($sql);
    if ($result) {
      $subTable = "subject";
      $subCode = "subject_code";
      $subId = "subject_id";
    } else {
      $subTable = "program_course";
      $subCode = "pc_code";
      $subId = "pc_id";
    }
    echo '<table class="table list-table-xs">';
    echo '<tr><th>Id</th><th>Period</th><th>Subject</th><th>Action</th></tr>';
    if ($output["data"]) {
      $rowsX = count($output["data"]);
      for ($i = 0; $i < $rowsX; $i++) {
        $subject_id = $output["data"][$i]["pc_id"];
        $id = $output["data"][$i]["sas_id"];
        echo '<tr>';
        echo '<td>' . $id . '</td>';
        echo '<td>' . $output["data"][$i]["sas_period"] . '</td>';
        echo '<td>' . getField($conn, $subject_id, $subTable, $subId, $subCode) . '</td>';
        echo '<td><button class="btn btn-info btn-square-sm btn-block applyButton" id="' . $id . '">Apply</button></td>';
        echo '</tr>';
      }
    } else echo '<tr><td colspan="5" align="center"> No Classes Found </td></tr>';
    echo '</table>';
  } elseif ($_POST['action'] == 'addClaim') {
    $ea_date = $_POST['eac_dateM'];
    $sas_id = $_POST['sas_idM'];
    $eac_remarks = $_POST['ea_remarks'];
    $eae_id = $_POST['sel_eae'];
    //echo "Claim $eac_claim Date $ea_date Id $eae_id ";
    $sql = "insert into ea_claim (student_id, eac_date, eae_id, sas_id, eac_remarks) values('$myStdId','$ea_date','$eae_id','$sas_id', '$eac_remarks')";
    $result = $conn->query($sql);
    if ($result) echo "Successfully Submitted";
    else echo "Could Not be Added ! ";
  } elseif ($_POST['action'] == 'sasClaimList') {
    echo "Table " . $tn_sas;
    $sql = "select eac.*, eae.*, sas.sas_period from ea_claim eac, ea_event eae, $tn_sas sas where sas.sas_id=eac.sas_id and eae.eae_id=eac.eae_id and eac.student_id='$myStdId' order by eac.eac_date";

    $fields = array("eac_date", "eae_name", "sas_id", "eac_remarks", "eac_approved", "eac_status");
    $header = array("Std-Id", "Date", "Event", "Period", "Remarks", "Approved", "Status");
    $statusDecode = array("status" => "eac_status", "0" => "Submitted", "3" => "Approved", "4" => "Rejected", "9" => "Withdrawn");
    $dataType = array("1", "0", "0", "0", "0", "0");
    $button = array("0", "1", "0", "0");
    getList($conn, "sas_id", $fields, $dataType, $header, $sql, $statusDecode, $button);
    //echo "sddsd";
  } elseif ($_POST['action'] == 'removeSasEAC') {
    $sas_id = $_POST['sas_id'];
    $sql = "delete from ea_claim where student_id='$myStdId' and sas_id='$sas_id'";
    $result = $conn->query($sql);
    if ($result) echo "Successfully Removed";
    else echo $conn->error;
  }
}
