<div class="row">
  <div class="col-md-3 pr-0" title="Institution/School">
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
  </div>
  <div class="col-md-3 pl-1 pr-0" title="Department">
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
  </div>
  <div class="col-md-3 pl-1 pr-0" title="Programs/Specialization/Branch">
    <?php
    if (isset($_SESSION['mypid']) && isset($myDept)) {
      //echo $myBatch;
      $name = getField($conn, $myProg, "program", "program_id", "sp_abbri");
      $sql = "select p.* from program p, dept_program dp where dp.dept_id='$myDept' and dp.program_id=p.program_id and p.program_status='0' order by p.sp_abbri";
      selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', 'sp_name', 'sel_program', $myProg, $name), $sql);
    } else {
      $sql = "select * from program where program_status='0' order by sp_abbri";
      selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', 'sp_name', 'sel_program'), $sql);
    }
    ?>
  </div>
  <div class="col-md-2 pl-1" title="Batch">
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
  </div>
</div>

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