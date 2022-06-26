    <?php
    // echo $myScl.'-'.$myDept.'-'.$myProg;
    if (isset($myScl)) {
      $name = getField($conn, $myScl, "school", "school_id", "school_name");
      $sql = "select * from school where school_status='0' order by school_name";
      selectList($conn, 'Sel School', array('1', 'school_id', 'school_name', 'school_abbri', 'sel_school', $myScl, $name), $sql);
    } else {
      $sql = "select * from school where school_status='0' order by school_name";
      selectList($conn, 'Sel School', array('1', 'school_id', 'school_name', 'school_abbri', 'sel_school'), $sql);
    }
    ?>

<script>
  /*
  $(document).on('change', '#sel_school', function() {
    var x = $("#sel_school").val();
    //$.alert("Session  Changed " + x);
    $.post("../../util/session_variable.php", {
      schoolId: x,
      action: "setSchool",
    }, function(mydata, mystatus) {
      //alert("- School Updated -" + mydata);
      location.reload();
      $("#sel_dept").val("0")
    }, "text").fail(function() {
      $.alert("Error in School!!");
    })
  })
  */
</script>