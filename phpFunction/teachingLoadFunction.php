<?php
function sessionLoad($conn, $classId, $tn_tlg)
{
  $sno = 1;
  //echo "Classs $classId";
  //$batch_id=getField($conn, $classId, "class", "class_id", "batch_id");
  //The subjects are populated from Load Groups not from the Subjects for selected Class

  $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and tlg.class_id='$classId' and tlg.tlg_status='0' and sb.subject_type<>'DE' group by tlg.subject_id order by tlg.subject_id, tlg.tlg_type";
  $result = $conn->query($sql);
  if (!$result) die("Could not List the Teaching Load!");
  echo '<table  class="list-table-xs table-striped">';
  echo '<thead><th>#</th><th>TlgId</th><th>Code</th><td>Type</td><th>Subject</th><th>Type-Load</th><th>Groups</th><th>Department</th><th>Update</th></thead>';
  while ($rows = $result->fetch_assoc()) {
    $tlgId = $rows['tlg_id'];
    $tlgType = $rows['tlg_type'];
    $tlgGroup = $rows['tlg_group'];
    $dept_id = $rows['dept_id'];
    $subject_type = $rows['subject_type'];
    echo '<tr>';
    echo '<td>' . $sno++ . '</td>';
    echo '<td>' . $rows['tlg_id'] . '</td>';
    echo '<td>' . $rows['subject_code'] . '</td>';
    echo '<td>' . $subject_type . '</td>';
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
  echo 'The subjects are populated from "Load Groups" not from the Subjects for selected Class. So, remove the subjects from here if any extra subjects are shown in the "Load Group"';
  // Use Subject Id and Class Id to delete so that all Lecture, Tutorial and Practical Groups are deleted for that Class 
}
function subjectChoice($conn, $tn_tlg, $myDept)
{
  $sno = 1;
  //echo "Classs $classId";
  $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and dept_id='$myDept' and tlg.tlg_type='L' and tlg.tlg_status='0' and sb.subject_type<>'DE'  order by tlg.subject_id, tlg.tlg_type";
  $result = $conn->query($sql);
  if (!$result) die("Could not List the Teaching Load!");
  echo '<table  class="list-table-xs table-striped">';
  echo '<thead><th>#</th><th>TlgId</th><th>Code</th><td>Type</td><th>Subject</th><th>Class</th><th>Weekly Load</th><th>Groups</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th></thead>';
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
function staffTeachingLoad($conn, $staff_id, $tn_tl, $tn_tlg)
{
  $sql = "select tlg.*, tl.*, cl.class_name, class_section, sb.subject_code, sb.subject_name from $tn_tlg tlg, $tn_tl tl, class cl, subject sb where tl.tlg_id=tlg.tlg_id and tl.staff_id='$staff_id' and tlg.class_id=cl.class_id and tlg.subject_id=sb.subject_id and tlg.tlg_status='0' and tl.tl_status='0' order by tlg.class_id, tlg.subject_id, tlg.tlg_type, tl.tl_group";

  $result = $conn->query($sql);
  if (!$result) die(" Unable to process the Request of Teaching Load! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array['tlg_id'] = $rows['tlg_id'];
    $sub_array['tl_id'] = $rows['tl_id'];
    $sub_array['class_id'] = $rows['class_id'];
    $sub_array['class_name'] = $rows['class_name'];
    $sub_array['class_section'] = $rows['class_section'];
    $sub_array['subject_id'] = $rows['subject_id'];
    $sub_array['subject_code'] = $rows['subject_code'];
    $sub_array['subject_name'] = $rows['subject_name'];
    $sub_array['load_type'] = $rows['tlg_type'];
    $sub_array['tl_group'] = $rows['tl_group'];
    $data[] = $sub_array;
  }
  return $data;
}