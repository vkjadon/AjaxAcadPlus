    <?php
    if (isset($myDept) && isset($myScl)) {
      $name = getField($conn, $myDept, "department", "dept_id", "dept_name");
      $sql = "select d.* from department d, school_dept sd where sd.school_id='$myScl' and sd.dept_id=d.dept_id and d.dept_status='0' order by d.dept_name";
      // $sql = "select * from department where dept_status='0' order by dept_name";
      selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept', $myDept, $name), $sql);
    } elseif (isset($myScl)) {
      $sql = "select d.* from department d, school_dept sd where sd.school_id='$myScl' and sd.dept_id=d.dept_id and d.dept_status='0' order by d.dept_name";
      selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept'), $sql);
    } else {
      $sql = "select * from department where dept_status='0' order by dept_name";
      selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept'), $sql);
    }
    ?>

<script>
  /*
  $(document).on('change', '#sel_dept', function() {
    var x = $("#sel_dept").val();
    //$.alert("Session  Changed " + x);
    $.post("../../util/session_variable.php", {
      deptId: x,
      action: "setDept"
    }, function(mydata, mystatus) {
      //alert("- Session Updated -" + mydata);
      location.reload();
    }, "text").fail(function() {
      $.alert("Erro Dept !!");
    })
  })
  */
</script>