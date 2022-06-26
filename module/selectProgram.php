<?php
if (isset($_SESSION['mypid']) && isset($myDept)) {
  //echo $myBatch;
  $name = getField($conn, $myProg, "program", "program_id", "sp_name");
  $sql = "select p.* from program p, dept_program dp where dp.dept_id='$myDept' and dp.program_id=p.program_id and p.program_status='0' order by p.sp_abbri";
  selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', 'sp_name', 'sel_program', $myProg, $name), $sql);
} else {
  $sql = "select * from program where program_status='0' order by sp_abbri";
  selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', 'sp_name', 'sel_program'), $sql);
}
?>
<script>
  /*
$(document).on('change', '#sel_program', function() {
var x = $("#sel_program").val();
// $.alert("Program Changed " + x);
$.post("../../util/session_variable.php", {
  action: "setProgram",
  programId: x
}, function(mydata, mystatus) {
  // $.alert("- Program Updated -" + mydata);
  location.reload();
}).fail(function() {
  $.alert("Error in Program!!");
})
})
*/
</script>