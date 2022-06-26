<?php
if (isset($_SESSION['myBatch'])) {
  //echo $myBatch;
  $name = getField($conn, $myBatch, "batch", "batch_id", "batch");
  $sql = "select * from batch where batch_status='0' order by batch desc";
  selectList($conn, 'Batch', array('1', 'batch_id', 'batch', 'batch_id', 'sel_batch', $myBatch, $name), $sql);
} else {
  $sql = "select * from batch where batch_status='0' order by batch desc";
  selectList($conn, 'Batch', array('1', 'batch_id', 'batch', '', 'sel_batch'), $sql);
}
?>
<script>
  /*
$(document).on('change', '#sel_batch', function() {
var x = $("#sel_batch").val();
//$.alert("Batch Changed " + x);
$.post("../../util/session_variable.php", {
  action: "setBatch",
  batchId: x
}, function(mydata, mystatus) {
  //$.alert("- Batch Updated -" + mydata);
  location.reload();
}, "text").fail(function() {
  $.alert("Error in Natch !!");
})
})
*/
</script>