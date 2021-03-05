<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo "Action Map " . $_POST['actionMap'];

if (isset($_POST['actionMap'])) {
  if ($_POST['actionMap'] == 'copoScale') {
    //echo "Action Map in copoScale" . $_POST['actionMap'];
    $scale = $_POST['scale'];
    $coId = $_POST['coId'];
    $poId = $_POST['poId'];
    if ($scale == '--') {
      $sql = "delete from copo_map  where co_id='$coId' and po_id='$poId'";
      $res = $conn->query($sql);
    } else {
      if ($scale == 'H') $value = '3';
      elseif ($scale == 'M') $value = '2';
      else $value = '1';
      $sql = "INSERT INTO copo_map (co_id, po_id, copo_scale, copo_value) VALUES('$coId', '$poId', '$scale', '$value')";
      $result = $conn->query($sql);
      if (!$result) {
        $sql = "update copo_map set copo_scale='$scale', copo_value='$value' where co_id='$coId' and po_id='$poId'";
        $res = $conn->query($sql);
        if (!$res) echo $conn->error;
      }
    }
  } elseif ($_POST['actionMap'] == 'copoMap') {
    $subject_id = $_POST['subjectId'];
    //echo $subject_id;
    if ($subject_id > 0) {
      $program_id = getField($conn, $subject_id, 'subject', 'subject_id', 'program_id');
      $batch_id = getField($conn, $subject_id, 'subject', 'subject_id', 'batch_id');
      //    echo "Program Id ".$program_id;
      $sqlPO = "select * from program_outcome where program_id='$program_id' and batch_id='$batch_id' and po_status='0'";
      $resultPO = $conn->query($sqlPO);
      if (!$resultPO) $conn->error;
      else {
        $j = 0;
        //echo $resultPO->num_rows;
        echo '<table class="table list-table-xs" id="tblData">';
        echo '<tr>';
        echo '<td></td>';
        while ($rowsPO = $resultPO->fetch_assoc()) {
          $po_id[$j] = $rowsPO['po_id'];
          echo '<td class="po" id="po' . $po_id[$j] . '" data-toggle="tooltip" title="' . $rowsPO['po_name'] . '">' . $rowsPO['po_code'] . $rowsPO['po_sno'] . '</td>';
          $j++;
        }
        echo '</tr>';
        $sqlCO = "select * from course_outcome where subject_id='$subject_id' and co_status='0'";
        $resultCO = $conn->query($sqlCO);
        $i = 0;
        while ($rowsCO = $resultCO->fetch_assoc()) {
          $co_id[$i] = $rowsCO['co_id'];
          echo '<tr align="center">';
          echo '<td class="co" id="co' . $co_id[$i] . '" data-toggle="tooltip" title="' . $rowsCO['co_name'] . '">' . $rowsCO['co_code'] . $rowsCO['co_sno'] . '</td>';
          for ($j = 0; $j < $resultPO->num_rows; $j++) {
            $cellId = $co_id[$i] . '-' . $po_id[$j];
            $sql = "select * from copo_map where co_id='" . $co_id[$i] . "' and po_id='" . $po_id[$j] . "'";
            $result = $conn->query($sql);
            if (!$result) {
              echo $conn->error;
              die("Opps! Some Error occured !! Please contact Administrator !");
            }
            if ($result->num_rows > 0) {
              $rows = $result->fetch_assoc();
              $cellScale = $rows['copo_scale'];
            } else $cellScale = "--";
            echo '<td class="copoMap" id="' . $cellId . '" data-co="' . $co_id[$i] . '" data-po="' . $po_id[$j] . '"><a href="#" style="display:block;  width:100%; text-decoration: none;">' . $cellScale . '</a></td>';
          }
          $i++;
          echo '</tr>';
        }
        echo '</table>';
      }
    } else echo "Not a Valid Selection. Please select a Subject";
  } elseif ($_POST['actionMap'] == 'poScale') {
    //echo "ActionMap in poScale" . $_POST['actionMap'];
    echo '<table class="table list-table-xs" id="tblData">';
    echo '<tr align="center">';
    $au = '3';
    $program_id = $_POST['programId'];
    $batch_id = $_POST['batchId'];
    echo '<td>' . $program_id . '</td>';
    for ($j = 1; $j <= $au; $j++) echo '<td colspan="2">' . $j . '</td>';
    echo '</tr>';
    $sqlPO = "select * from program_outcome where program_id='$program_id' and batch_id='$batch_id' and po_status='0'";
    $resultPO = $conn->query($sqlPO);
    $i = 0;
    while ($rowsPO = $resultPO->fetch_assoc()) {
      $po_id[$i] = $rowsPO['po_id'];
      echo '<tr align="center">';
      echo '<td class="po" id="po' . $po_id[$i] . '" data-toggle="tooltip" title="' . $rowsPO['po_name'] . '">' . $rowsPO['po_code'] . $rowsPO['po_sno'] . '</td>';
      for ($j = 1; $j <= $au; $j++) {
        $sql = "select * from po_scale where po_id='" . $po_id[$i] . "' and ps_scale='" . $j . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $rows = $result->fetch_assoc();
          $psFrom = $rows['ps_from'];
          $psTo = $rows['ps_to'];
        } else {
          $psFrom = "";
          $psTo = "";
        }
        echo '<td><input type="text" class="poScale" size="4" data-tag="F"  data-poScale="' . $j . '" data-po="' . $po_id[$i] . '" value="' . $psFrom . '"></td>';
        echo '<td><input type="text" class="poScale" size="4" data-tag="T" data-poScale="' . $j . '" data-po="' . $po_id[$i] . '" value="' . $psTo . '"></td>';
      }
      echo '<td><button class="btn btn-info btn-sm poScaleCopy" data-po="' . $po_id[$i] . '">Copy to All</button></td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['actionMap'] == 'poMap') {
    $program_id = $_POST['programId'];
    $batch_id = $_POST['batchId'];
    $poScaleSum = [];
    $sqlPO = "select * from program_outcome where program_id='$program_id' and batch_id='$batch_id' and po_status='0'";
    $resultPO = $conn->query($sqlPO);
    if (!$resultPO) $conn->error;
    else {
      $j = 0;
      $numRowsPO = $resultPO->num_rows;
      //echo $resultPO->num_rows;
      echo '<table class="table list-table-xs" id="tblData">';
      echo '<tr>';
      echo '<td>Course</td><td>CO Att</td>';
      while ($rowsPO = $resultPO->fetch_assoc()) {
        $po_id[$j] = $rowsPO['po_id'];
        echo '<td class="po" id="po' . $po_id[$j] . '" data-toggle="tooltip" title="' . $rowsPO['po_name'] . '">' . $rowsPO['po_code'] . $rowsPO['po_sno'] . '</td>';
        $poScaleSum[$j] = 0;
        $poSub[$j] = 0;
        $j++;
      }
      echo '</tr>';
      $sqlSub = "select * from subject where program_id='$program_id' and batch_id='$batch_id' and subject_status='0' order by subject_semester";
      $resultSub = $conn->query($sqlSub);
      if (!$resultSub) $conn->error;
      else {
        //$j = 0;
        while ($rowsSub = $resultSub->fetch_assoc()) {
          $subject_id = $rowsSub['subject_id'];

          $sql = "select avg(ca.co_attainment) as avgD from co_attainment ca, course_outcome co where ca.co_id=co.co_id and co.subject_id='$subject_id' and ca.am_id='1'";
          $result = $conn->query($sql);
          $rowD = $result->fetch_assoc();

          $sql = "select avg(ca.co_attainment) as avgI from co_attainment ca, course_outcome co where ca.co_id=co.co_id and co.subject_id='$subject_id' and ca.am_id='2'";
          $result = $conn->query($sql);
          $rowI = $result->fetch_assoc();

          //echo round($row['avg'],2);
          //echo $result->num_rows;
          $dw = getField($conn, "Direct", "assessment_method", "am_code", "am_weight");
          $iw = getField($conn, "Indirect", "assessment_method", "am_code", "am_weight");
          $coAtt = ceil(($dw * $rowD['avgD'] + $iw * $rowI['avgI']) / 3.0);
          echo '<tr>';
          echo '<td>' . $rowsSub['subject_code'] . '</td><td>' . $coAtt . '</td>';
          for ($j = 0; $j < $numRowsPO; $j++) {
            $sql = "select cm.* from copo_map cm, course_outcome co where co.subject_id='$subject_id' and cm.co_id=co.co_id and cm.copo_scale='H' and cm.po_id='$po_id[$j]'";
            $result = $conn->query($sql);
            $countH = $result->num_rows;
            $sql = "select cm.* from copo_map cm, course_outcome co where co.subject_id='$subject_id' and cm.co_id=co.co_id and cm.copo_scale='M' and cm.po_id='$po_id[$j]'";
            $result = $conn->query($sql);
            $countM = $result->num_rows;
            $sql = "select cm.* from copo_map cm, course_outcome co where co.subject_id='$subject_id' and cm.co_id=co.co_id and cm.copo_scale='L' and cm.po_id='$po_id[$j]'";
            $result = $conn->query($sql);
            $countL = $result->num_rows;
            //echo '<td>' . $countH . '-'.$countM.'-'.$countL.'</td>';
            if (($countH + $countM + $countL) > 0) {
              $po = round(((3 * $countH + 2 * $countM + $countL) / ($countH + $countM + $countL) / 3)*100, 2);
              // Coverted to Percentage to get PO Scale. PO Scale is given in Percentage
              $sqlMM = "select * from po_scale where po_id='$po_id[$j]' and ps_to>='$po' and ps_from<='$po'";
              $resultMM = $conn->query($sqlMM);
              if (!$resultMM) {
                echo $conn->error;
                die();
              } else {
                $rowsMM = $resultMM->fetch_assoc();
                $scale  = $rowsMM['ps_scale'];
                $poScaleSum[$j] += $po*$scale/100;
                $poSub[$j]++;
              }

              echo '<td align="center">' . round($po*$scale/100,1) . '</td>';
            } else echo '<td align="center">--</td>';
          }
          echo '</tr>';
          $j++;
        }
        echo '<tr>';
        echo '<td></td><td></td>';
        for ($j = 0; $j < $numRowsPO; $j++) echo '<td align="center">' . round($poScaleSum[$j]/$poSub[$j],1) . '</td>';
        echo '</tr>';
      }
      echo '</table>';
    }
  } elseif ($_POST['actionMap'] == 'aucoMap') {
    $ad_id = $_POST['adId'];
    //echo $ad_id;
    $sqlAD = "select * from assessment_design where ad_id='$ad_id'";
    $resultAD = $conn->query($sqlAD);
    if (!$resultAD) $conn->error;
    else {
      //echo $resultPO->num_rows;
      echo '<table class="table list-table-xs" id="tblData">';
      echo '<tr align="center">';
      $rowsAD = $resultAD->fetch_assoc();
      $au = $rowsAD['ad_question'];
      $subject_id = $rowsAD['subject_id'];
      echo '<td>' . $subject_id . '</td>';
      for ($j = 0; $j < $au; $j++) {
        $sno = $j + 1;
        $sqlAUMarks = "select * from au_marks where ad_id='$ad_id' and au_sno='$sno'";

        $resultAUMarks = $conn->query($sqlAUMarks);
        if (!$resultAUMarks) {
          echo $conn->error;
          die("Opps! Some Error occured !! Please contact Administrator !");
        } else {
          $rowsAUM = $resultAUMarks->fetch_assoc();
          $au_marks = $rowsAUM['au_marks'];
          if (!isset($au_marks)) $au_marks = '--';
        }
        //$auMarks=getFieldSql($conn, $sqlAUMarks, "au_marks");    
        echo '<td>AU-' . $sno . '</td>';
        echo '<td class="auMarks" data-sno="' . $sno . '"><a href="#" style="display:block;  width:100%; text-decoration: none;">' . $au_marks . '</a></td>';
      }
      echo '</tr>';
      $sqlCO = "select * from course_outcome where subject_id='$subject_id' and co_status='0'";
      $resultCO = $conn->query($sqlCO);
      $i = 0;
      while ($rowsCO = $resultCO->fetch_assoc()) {
        $co_id[$i] = $rowsCO['co_id'];
        echo '<tr align="center">';
        echo '<td class="co" id="co' . $co_id[$i] . '" data-toggle="tooltip" title="' . $rowsCO['co_name'] . '">' . $rowsCO['co_code'] . $rowsCO['co_sno'] . '</td>';
        $cellScale = '--';
        for ($j = 0; $j < $au; $j++) {
          $sno = $j + 1;
          $sql = "select * from auco_map where ad_id='$ad_id' and co_id='" . $co_id[$i] . "' and au_sno='" . $sno . "'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $cellScale = $rows['auco_weight'];
          } else $cellScale = "--";
          echo '<td colspan="2" class="aucoMap" data-au="' . ($j + 1) . '" data-co="' . $co_id[$i] . '"><a href="#" style="display:block;  width:100%; text-decoration: none;">' . $cellScale . '</a></td>';
        }
        echo '</tr>';
      }
      echo '</table>';
    }
  } elseif ($_POST['actionMap'] == 'uaTable') {
    //if(isset($_POST['action']))echo "uiui".$_POST['action'];
    $ad_id = $_POST['adId'];
    //echo $ad_id;
    $sqlAD = "select * from assessment_design where ad_id='$ad_id'";
    $resultAD = $conn->query($sqlAD);
    if (!$resultAD) $conn->error;
    else {
      //echo $resultPO->num_rows;
      echo '<table class="table list-table-xs" id="tblData">';
      echo '<tr align="center">';
      $rowsAD = $resultAD->fetch_assoc();
      $au = $rowsAD['ad_question'];
      $subject_id = $rowsAD['subject_id'];
      echo '<td>Student Name</td><td>Roll Number</td>';
      for ($j = 0; $j < $au; $j++) {
        $sno = $j + 1;
        $sqlAUMarks = "select * from au_marks where ad_id='$ad_id' and au_sno='$sno'";

        $resultAUMarks = $conn->query($sqlAUMarks);
        if (!$resultAUMarks) {
          echo $conn->error;
          die("Opps! Some Error occured !! Please contact Administrator !");
        } else {
          $rowsAUM = $resultAUMarks->fetch_assoc();
          $au_marks = $rowsAUM['au_marks'];
          if (!isset($au_marks)) $au_marks = '--';
        }
        //$auMarks=getFieldSql($conn, $sqlAUMarks, "au_marks");    
        echo '<td>AU-' . $sno . '(MM:' . $au_marks . ')</td>';
      }
      echo '</tr>';
      $sqlStd = "select * from student where student_status='0'";
      $resultStd = $conn->query($sqlStd);
      $i = 0;
      while ($rowsStd = $resultStd->fetch_assoc()) {
        $student_id[$i] = $rowsStd['student_id'];
        echo '<tr>';
        echo '<td>' . $rowsStd['student_name'] . '</td><td>' . $rowsStd['student_rollno'] . '</td>';
        $cellMarks = '';
        for ($j = 0; $j < $au; $j++) {
          $sno = $j + 1;
          $sql = "select * from assessment_marks where ad_id='$ad_id' and student_id='" . $student_id[$i] . "' and au_sno='" . $sno . "'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $cellMarks = $rows['am_marks'];
          } else $cellMarks = "";

          echo '<td align="center"><input type="text" class="uaTable" size="4" data-ua="' . ($j + 1) . '" data-std="' . $student_id[$i] . '" value="' . $cellMarks . '"></td>';
        }
        echo '</tr>';
      }
      echo '</table>';
    }
  } elseif ($_POST['actionMap'] == 'coScale') {

    echo '<table class="table list-table-xs" id="tblData">';
    echo '<tr align="center">';
    $au = '3';
    $subject_id = $_POST['subjectId'];
    echo '<td>' . $subject_id . '</td>';
    for ($j = 1; $j <= $au; $j++) echo '<td colspan="2">' . $j . '</td>';
    echo '</tr>';
    $sqlCO = "select * from course_outcome where subject_id='$subject_id' and co_status='0'";
    $resultCO = $conn->query($sqlCO);
    $i = 0;
    while ($rowsCO = $resultCO->fetch_assoc()) {
      $co_id[$i] = $rowsCO['co_id'];
      echo '<tr align="center">';
      echo '<td class="co" id="co' . $co_id[$i] . '" data-toggle="tooltip" title="' . $rowsCO['co_name'] . '">' . $rowsCO['co_code'] . $rowsCO['co_sno'] . '</td>';
      for ($j = 1; $j <= $au; $j++) {
        $sql = "select * from co_scale where co_id='" . $co_id[$i] . "' and cs_scale='" . $j . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $rows = $result->fetch_assoc();
          $csFrom = $rows['cs_from'];
          $csTo = $rows['cs_to'];
        } else {
          $csFrom = "";
          $csTo = "";
        }
        echo '<td><input type="text" class="coScale" size="4" data-tag="F"  data-coScale="' . $j . '" data-co="' . $co_id[$i] . '" value="' . $csFrom . '"></td>';
        echo '<td><input type="text" class="coScale" size="4" data-tag="T" data-coScale="' . $j . '" data-co="' . $co_id[$i] . '" value="' . $csTo . '"></td>';
      }
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['actionMap'] == 'coMM') {
    $subject_id = $_POST['subjectId'];
    $coDirect = coAttainment($conn, $subject_id, "Direct");
    $coIndirect = coAttainment($conn, $subject_id, "Indirect");
    echo '<h4>Attainment Table</h4>';
    echo '<table class="table list-table-xs">';
    echo '<tr align="center">';
    echo '<th>Course Outcome</th><th>Direct</th><th>Indirect</th>';
    echo '</tr>';
    echo '<tr align="center"><td>Attainment</td><td>' . $coDirect . '</td><td>' . $coIndirect . '</td></tr>';
    $dw = getField($conn, "Direct", "assessment_method", "am_code", "am_weight");
    $iw = getField($conn, "Indirect", "assessment_method", "am_code", "am_weight");
    echo '<tr align="center"><td>Weightage</td><td>' . $dw . '%</td><td>' . $iw . '%</td></tr>';
    echo '<tr align="center"><td>Attainment Score</td><td>' . round((($coDirect * $dw) / 100), 2) . '</td><td>' . round((($coIndirect * $iw) / 100), 2) . '</td></tr>';
    echo '<tr align="center"><td><h5>Attainment Score</h5></td><td colspan="2"><h4>' . (round((($coDirect * $dw) / 100), 2) + round((($coIndirect * $iw) / 100), 2)) . '</h4></td></tr>';
    echo '</table>';
    coAttainmentTabulation($conn, $subject_id, "Direct");
    coAttainmentTabulation($conn, $subject_id, "Indirect");
  } elseif ($_POST['actionMap'] == 'pofTable') {
    //if(isset($_POST['action']))echo "uiui".$_POST['action'];
    $pf_id = $_POST['pfId'];
    $program_id = $_POST['programId'];
    $batch_id = $_POST['batchId'];
    //echo $pf_id;
    $sql = "select * from program_outcome where program_id='$program_id' and batch_id='$batch_id'";
    $result = $conn->query($sql);
    if (!$result) $conn->error;
    else {
      $numRowsPO = $result->num_rows;
      echo '<table class="table list-table-xs" id="tblData">';
      echo '<tr align="center">';

      echo '<td>Student Name</td><td>Roll Number</td>';
      $i = 0;
      while ($rows = $result->fetch_assoc()) {
        $po_id[$i] = $rows['po_id'];
        echo '<td>' . $rows['po_code'] . '-' . $rows['po_sno'] . '</td>';
        $i++;
      }
      echo '</tr>';

      $sqlStd = "select * from student where student_status='0'";
      $resultStd = $conn->query($sqlStd);
      $i = 0;
      while ($rowsStd = $resultStd->fetch_assoc()) {
        $student_id[$i] = $rowsStd['student_id'];
        echo '<tr>';
        echo '<td>' . $rowsStd['student_name'] . '</td><td>' . $rowsStd['student_rollno'] . '</td>';
        $cellMarks = '';
        for ($j = 0; $j < $numRowsPO; $j++) {
          $sql = "select * from pof_marks where pf_id='$pf_id' and student_id='" . $student_id[$i] . "' and po_id='" . $po_id[$j] . "'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $cellMarks = $rows['pof_marks'];
          } else $cellMarks = "";
          echo '<td align="center"><input type="text" class="pfTable" size="3" data-pf="' . $po_id[$j] . '" data-std="' . $student_id[$i] . '" value="' . $cellMarks . '"></td>';
        }
        echo '</tr>';
      }
      echo '</table>';
    }
  }
}

function coAttainmentTabulation($conn, $subject_id, $method)
{
  echo '<h4>' . $method . ' Method Tabulation </h4>';
  $sqlCO = "select * from course_outcome where subject_id='$subject_id' and co_status='0'";
  $resultCO = $conn->query($sqlCO);
  $i = 0;
  while ($rowsCO = $resultCO->fetch_assoc()) {
    $co_id[$i] = $rowsCO['co_id'];
    $i++;
  }
  $rowsCO = $resultCO->num_rows;
  for ($j = 0; $j < $rowsCO; $j++) {
    $current_coId = $co_id[$j];
    $sql = "select acm.* from auco_map acm, assessment_design ad, assessment_technique at, assessment_method am where acm.co_id='$current_coId' and acm.ad_id=ad.ad_id and ad.at_id=at.at_id and at.am_id=am.am_id and am.am_code='$method'";
    $result = $conn->query($sql);
    $sumCOMarks = 0;
    while ($rowAU = $result->fetch_assoc()) {
      $current_adId = $rowAU['ad_id'];
      $current_auSno = $rowAU['au_sno'];
      $sqlMM = "select * from au_marks where au_sno='$current_auSno' and ad_id='$current_adId'";
      $resultMM = $conn->query($sqlMM);
      $rowsMM = $resultMM->fetch_assoc();
      $sumCOMarks += $rowAU['auco_weight'] * $rowsMM['au_marks'] * 0.01;
    }
    $co_marks[$j] = $sumCOMarks;
  }
  echo '<table class="table list-table-xs">';
  echo '<tr align="center"><th>Student Name</th><th>Roll Numner</th>';
  for ($j = 0; $j < $rowsCO; $j++) {
    echo '<th>MO</th><th>%</th><th>Scale</th>';
    $coScaleSum[$j] = 0;
  }
  echo '</tr>';
  $sqlStd = "select * from student where student_status='0'";
  $resultStd = $conn->query($sqlStd);
  $students = $resultStd->num_rows;
  $i = 0;
  while ($rowsStd = $resultStd->fetch_assoc()) {
    $student_id = $rowsStd['student_id'];
    echo '<tr>';
    echo '<td>' . $rowsStd['student_name'] . '</td><td align="center">' . $rowsStd['student_rollno'] . '</td>';
    //$cellMarks = '';
    for ($j = 0; $j < $rowsCO; $j++) {
      //$sql = "select * from auco_map where co_id='$co_id[$j]'";

      $sql = "select acm.* from auco_map acm, assessment_design ad, assessment_technique at, assessment_method am where acm.co_id='$co_id[$j]' and acm.ad_id=ad.ad_id and ad.at_id=at.at_id and at.am_id=am.am_id and am.am_code='$method'";

      $result = $conn->query($sql);

      $sumCOMarks = 0;
      $sum = 0;
      echo '<td align="center">';
      //echo '<table class="table">';
      while ($rowAU = $result->fetch_assoc()) {
        $current_adId = $rowAU['ad_id'];
        $current_auSno = $rowAU['au_sno'];
        $sqlMM = "select * from assessment_marks where au_sno='$current_auSno' and ad_id='$current_adId' and student_id='$student_id'";
        $resultMM = $conn->query($sqlMM);
        $rowsMM = $resultMM->fetch_assoc();
        /*echo '<tr>';
          echo '<td>'.$rowAU['auco_weight']*$rowsMM['au_marks']*0.01.'</td>';
          echo '</tr>';*/
        $sumCOMarks += $rowAU['auco_weight'] * $rowsMM['am_marks'] * 0.01;
      }
      echo $sumCOMarks;
      echo '</td>';
      echo '<td align="center">';
      if ($co_marks[$j] > 0) $sum = ceil(($sumCOMarks / $co_marks[$j]) * 100);
      echo $sum;
      echo '</td>';
      echo '<td align="center">';
      $sqlMM = "select * from co_scale where co_id='$co_id[$j]' and cs_to>='$sum' and cs_from<='$sum'";
      $resultMM = $conn->query($sqlMM);
      if (!$resultMM) {
        echo $conn->error;
      } else {
        $rowsMM = $resultMM->fetch_assoc();
        echo $scale = $rowsMM['cs_scale'];
        $coScaleSum[$j] += $scale;
      }
      echo '</td>';
    }
    echo '</tr>';
  }
  echo '<tr>';
  $outcome = 0;
  echo '<th colspan="2">Average CO Attainment </th>';
  for ($j = 0; $j < $rowsCO; $j++) {
    $outcome += round($coScaleSum[$j] / $students, 2);
    echo '<th colspan="3" align="center">' . round($coScaleSum[$j] / $students, 2) . '</th>';
  }
  echo '</tr>';
  echo '</table>';
}

function coAttainment($conn, $subject_id, $method)
{
  $id = getField($conn, $method, "assessment_method", "am_code", "am_id");
  $submit_ts = date("Y-m-d h:i:s", time());

  echo '<h5>' . $method . ' Method Calculation (' . $id . ')</h5>';
  echo '<table class="table list-table-xs">';
  $sqlCO = "select * from course_outcome where subject_id='$subject_id' and co_status='0'";
  $resultCO = $conn->query($sqlCO);
  $i = 0;
  echo '<tr align="center"><td>Course Outcome</td>';
  while ($rowsCO = $resultCO->fetch_assoc()) {
    $co_id[$i] = $rowsCO['co_id'];
    echo '<td>CO-' . $rowsCO['co_sno'] . '</td>';
    $i++;
  }
  echo '</tr>';
  echo '<tr align="center"><td>Assessment Marks</td>';
  $rowsCO = $resultCO->num_rows;
  //echo $rowsCO;
  for ($j = 0; $j < $rowsCO; $j++) {
    $current_coId = $co_id[$j];
    $sql = "select acm.* from auco_map acm, assessment_design ad, assessment_technique at, assessment_method am where acm.co_id='$current_coId' and acm.ad_id=ad.ad_id and ad.at_id=at.at_id and at.am_id=am.am_id and am.am_code='$method'";
    $result = $conn->query($sql);
    if (!$result) $conn->error;
    $sumCOMarks = 0;
    echo '<td>';
    while ($rowAU = $result->fetch_assoc()) {
      $current_adId = $rowAU['ad_id'];
      $current_auSno = $rowAU['au_sno'];
      $sqlMM = "select * from au_marks where au_sno='$current_auSno' and ad_id='$current_adId'";
      $resultMM = $conn->query($sqlMM);
      $rowsMM = $resultMM->fetch_assoc();
      $sumCOMarks += $rowAU['auco_weight'] * $rowsMM['au_marks'] * 0.01;
    }
    echo $co_marks[$j] = $sumCOMarks;
    echo '</td>';
  }
  echo '</tr>';
  for ($j = 0; $j < $rowsCO; $j++) {
    $coScaleSum[$j] = 0;
  }
  echo '</tr>';
  $sqlStd = "select * from student where student_status='0'";
  $resultStd = $conn->query($sqlStd);
  $students = $resultStd->num_rows;
  $i = 0;
  while ($rowsStd = $resultStd->fetch_assoc()) {
    $student_id = $rowsStd['student_id'];
    echo '<tr>';
    for ($j = 0; $j < $rowsCO; $j++) {
      $sql = "select acm.* from auco_map acm, assessment_design ad, assessment_technique at, assessment_method am where acm.co_id='$co_id[$j]' and acm.ad_id=ad.ad_id and ad.at_id=at.at_id and at.am_id=am.am_id and am.am_code='$method'";
      $result = $conn->query($sql);
      $sumCOMarks = 0;
      $sum = 0;
      while ($rowAU = $result->fetch_assoc()) {
        $current_adId = $rowAU['ad_id'];
        $current_auSno = $rowAU['au_sno'];
        $sqlMM = "select * from assessment_marks where au_sno='$current_auSno' and ad_id='$current_adId' and student_id='$student_id'";
        $resultMM = $conn->query($sqlMM);
        $rowsMM = $resultMM->fetch_assoc();
        $sumCOMarks += $rowAU['auco_weight'] * $rowsMM['am_marks'] * 0.01;
      }
      if ($co_marks[$j] > 0) $sum = ceil(($sumCOMarks / $co_marks[$j]) * 100);
      $sqlMM = "select * from co_scale where co_id='$co_id[$j]' and cs_to>='$sum' and cs_from<='$sum'";
      $resultMM = $conn->query($sqlMM);
      if (!$resultMM) {
        echo $conn->error;
      } else {
        $rowsMM = $resultMM->fetch_assoc();
        $scale = $rowsMM['cs_scale'];
        $coScaleSum[$j] += $scale;
      }
    }
  }
  echo '<tr>';
  $outcome = 0;
  echo '<td align="right"><b>Average CO Attainment</b> </td>';
  for ($j = 0; $j < $rowsCO; $j++) {
    $coa = round($coScaleSum[$j] / $students, 2);
    $outcome += $coa;
    echo '<td align="center"><b>' . $coa . '</b></td>';
    $sql = "insert into co_attainment (co_id, am_id, co_attainment, update_ts) values('$co_id[$j]','$id','$coa','$submit_ts')";
    $res = $conn->query($sql);
    if (!$res) {
      $sql = "update co_attainment set co_attainment='$coa', update_ts='$submit_ts' where co_id='$co_id[$j]' and am_id='$id'";
      $res = $conn->query($sql);
      if (!$res) echo $conn->error;
      //echo $submit_ts;
    }
  }
  echo '</tr>';
  echo '</table>';
  if ($rowsCO > 0) return round($outcome / $rowsCO, 2);
  else return 0;
}
?>
<script>
  $('[data-toggle="popover"]').popover();
  $('[data-toggle="tooltip"]').tooltip();
</script>