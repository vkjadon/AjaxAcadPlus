<p class="mt-4 mr-4">
  <?php
  // echo "My School $myScl My Dept $myDept My Prog $myProg";
  if (isset($myProg)) {
    $name = getField($conn, $myProg, "program", "program_id", "sp_name");
    $sql = "select p.* from program p, dept_program dp where p.program_id=dp.program_id and dp.dept_id='$myDept' and p.program_status='0' order by p.sp_abbri";
    selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', '', 'sel_program', $myProg, $name), $sql);
  }else {
    $sql = "select p.* from program p, dept_program dp where p.program_id=dp.program_id and dp.dept_id='$myDept' and p.program_status='0' order by p.sp_abbri";
    selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', '', 'sel_program'), $sql);
  }
  //$sql = "select * from program where program_status='0' order by sp_abbri";

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