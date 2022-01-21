<p class="mt-4 mr-4">
  <?php
  // echo "My School $myScl";
  if (isset($myScl)) $sql = "select d.* from department d, school_dept sd where d.dept_id=sd.dept_id and sd.school_id='$myScl' and d.dept_status='0' order by dept_name";
  else $sql = "select * from department where dept_status='0' order by dept_name";
  selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept'), $sql);

  if (isset($myDept)) $sql = "select p.* from program p, dept_program dp where p.program_id=dp.program_id and dp.dept_id='$myDept' and p.program_status='0' order by p.sp_abbri";
  else $sql = "select * from program where program_status='0' order by sp_abbri";
  selectList($conn, 'Sel Program', array('0', 'program_id', 'sp_abbri', '', 'sel_program'), $sql);

  if (isset($myBatch)) {
    //echo $myBatch;
    $name = getField($conn, $myBatch, "batch", "batch_id", "batch");
    $sql = "select * from batch where batch_status='0' order by batch desc";
    selectList($conn, 'Batch', array('1', 'batch_id', 'batch', '', 'sel_batch', $myBatch, $name), $sql);
  } else {
    $sql = "select * from batch where batch_status='0' order by batch desc";
    selectList($conn, 'Batch', array('1', 'batch_id', 'batch', '', 'sel_batch'), $sql);
  }
  ?>
</p>