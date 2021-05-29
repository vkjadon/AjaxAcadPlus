<?php
function sessionLoad($conn, $classId, $tn_tlg)
{
  $sno = 1;
  //echo "Classs $classId";
  $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and tlg.class_id='$classId' and tlg.tlg_status='0' group by tlg.subject_id order by tlg.subject_id, tlg.tlg_type";
  $result = $conn->query($sql);
  if (!$result) die("Could not List the Teaching Load!");
  echo '<table  class="list-table-xs table-striped">';
  echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Type-Load</th><th>Groups</th><th>Department</th><th>Update</th></thead>';
  while ($rows = $result->fetch_assoc()) {
    $tlgId = $rows['tlg_id'];
    $tlgType = $rows['tlg_type'];
    $tlgGroup = $rows['tlg_group'];
    $dept_id = $rows['dept_id'];
    echo '<tr>';
    echo '<td>' . $sno++ . '</td>';
    echo '<td>' . $rows['tlg_id'] . '</td>';
    echo '<td>' . $rows['subject_name'] . '</td>';
    if ($tlgType == 'L') echo '<td>' . $tlgType . '-' . $rows['subject_lecture'] . '</td><td>' . $tlgGroup . '</td>';
    else echo '<td>' . $tlgType . '-' . $rows['subject_practical'] . '</td><td>' . $tlgGroup . '</td>';
    echo '<td><div id="dept'.$tlgId.'">';
    echo getField($conn, $dept_id, "department", "dept_id", "dept_abbri");
    echo '</div></td>';
    echo '<td><a href="#" class="modalFormUpdateDept" id="updateDept" data-tlg="'.$tlgId.'"><i class="fa fa-edit"></i></a></td>';
    

    echo '</tr>';
  }
  echo '</table>';
}
function subjectChoice($conn, $tn_tlg, $myDept)
{
  $sno = 1;
  //echo "Classs $classId";
  $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and dept_id='$myDept' and tlg.tlg_type='L' and tlg.tlg_status='0' order by tlg.subject_id, tlg.tlg_type";
  $result = $conn->query($sql);
  if (!$result) die("Could not List the Teaching Load!");
  echo '<table  class="list-table-xs table-striped">';
  echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Class</th><th>Weekly Load</th><th>Groups</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th></thead>';
  while ($rows = $result->fetch_assoc()) {
    $tlgId = $rows['tlg_id'];
    $tlgGroup = $rows['tlg_group'];
    $class_id = $rows['class_id'];
    echo '<tr>';
    echo '<td>' . $sno++ . '</td>';
    echo '<td>' . $rows['tlg_id'] . '</td>';
    echo '<td>' . $rows['subject_name'] . '</td>';
    echo '<td><div id="dept'.$tlgId.'">';
    echo getField($conn, $class_id, "class", "class_id", "class_name");
    echo '</div></td>';
    echo '<td>' . $rows['subject_lecture'] . '</td><td>' . $tlgGroup . '</td>';
    echo '<td class="click"><a href="#" class="setChoice" data-choice="1" data-tlg="'.$tlgId.'"><div id="c1tlg'.$tlgId.'" >&nbsp;</div></a></td>';
    echo '<td class="click"><a href="#" class="setChoice" data-choice="2" data-tlg="'.$tlgId.'"><div id="c2tlg'.$tlgId.'" >&nbsp;</div></a></td>';
    echo '<td class="click"><a href="#" class="setChoice" data-choice="3" data-tlg="'.$tlgId.'"><div id="c3tlg'.$tlgId.'" >&nbsp;</div></a></td>';
    echo '<td class="click"><a href="#" class="setChoice" data-choice="4" data-tlg="'.$tlgId.'"><div id="c4tlg'.$tlgId.'" >&nbsp;</div></a></td>';
    echo '<td class="click"><a href="#" class="setChoice" data-choice="5" data-tlg="'.$tlgId.'"><div id="c5tlg'.$tlgId.'" >&nbsp;</div></a></td>';
    echo '</tr>';
  }
  echo '</table>';
}
