<?php
function sessionLoad($conn, $classId, $tn_tlg)
{
  $sno = 1;
  //echo "Classs $classId";
  $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and tlg.class_id='$classId' and tlg.tlg_status='0' group by tlg.subject_id order by tlg.subject_id, tlg.tlg_type";
  $result = $conn->query($sql);
  if (!$result) die("Could not List the Teaching Load!");
  echo '<table  class="list-table-xs table-striped">';
  echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Type-Load</th><th>Groups</th></thead>';
  while ($rows = $result->fetch_assoc()) {
    $tlgType = $rows['tlg_type'];
    $tlgGroup = $rows['tlg_group'];
    echo '<tr>';
    echo '<td>' . $sno++ . '</td>';
    echo '<td>' . $rows['tlg_id'] . '</td>';
    echo '<td>' . $rows['subject_name'] . '</td>';
    if ($tlgType == 'L') echo '<td>' . $tlgType . '-' . $rows['subject_lecture'] . '</td><td>' . $tlgGroup . '</td>';
    else echo '<td>' . $tlgType . '-' . $rows['subject_practical'] . '</td><td>' . $tlgGroup . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}
