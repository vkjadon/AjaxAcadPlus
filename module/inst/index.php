<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
<<<<<<< HEAD
||||||| merged common ancestors
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
=======
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
>>>>>>> df090e8b21e39c0f50b3bac44dcab832d928620c
  <link rel="stylesheet" href="../../table.css">
  <link rel="stylesheet" href="../../style.css">
<<<<<<< HEAD
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
||||||| merged common ancestors
=======

>>>>>>> df090e8b21e39c0f50b3bac44dcab832d928620c
</head>

<body>

  <?php require("../topBar.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2">
        <div class="card text-center selectPanel">
          <span id="panelId"></span>
          <span class="m-1 p-0" id="selectPanelTitle"></span>
          <div class="col">
            <form>
              <div class="selectSchool">
                <?php
                $sql = "select * from school where school_status='0'";
                selectList($conn, "Select School", array(0, "school_id", "school_name", "school_abbri", "school_name"), $sql);
                ?>
                <div class="form-check-inline teaching">
                  <label class="form-check-label">Teaching
                    <input type="radio" class="form-check-input" checked id="dept_type" name="dept_type" value="0">Yes
                  </label>
                </div>
                <div class="form-check-inline nonTeaching">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" id="dept_type" name="dept_type" value="1">No
                  </label>
                </div>
              </div>
            </form>
            <p class="selectDept">
              <?php
              $sql = "select * from department where dept_status='0'";
              selectList($conn, "Select Department", array(0, "dept_id", "dept_name", "dept_abbri", "sel_dept"), $sql);
              ?>
            </p>
          </div>
        </div>
        <?php
        $url = $setUrl . '/acadplus/api/check_dept_head.php?u=' . $myUn . '&&p=' . $myPwd;
        $dept_head = check_dept_head($url);
        //echo $dept_head;
        ?>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active si" id="list-si-list" data-toggle="list" href="#list-si" role="tab" aria-controls="si"> Setup Institute </a>
          <a class="list-group-item list-group-item-action mis" id="list-mis-list" data-toggle="list" href="#list-mis" role="tab" aria-controls="mis"> Manage School </a>

          <a class="list-group-item list-group-item-action mid" id="list-mid-list" data-toggle="list" href="#list-mid" role="tab" aria-controls="mid"> Manage Department </a>
          <a class="list-group-item list-group-item-action mip" id="list-mip-list" data-toggle="list" href="#list-mip" role="tab" aria-controls="mip"> Manage Programme </a>
        </div>
      </div>

      <div class="col-3">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-si" role="tabpanel" aria-labelledby="list-si-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addInst">New</button>
                <p id="instShowList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade show" id="list-mis" role="tabpanel" aria-labelledby="list-mis-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addSchool">New</button>
                <p id="schoolShowList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade show" id="list-mid" role="tabpanel" aria-labelledby="list-mid-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addDept">New</button>
                <p id="deptShowList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade show" id="list-mip" role="tabpanel" aria-labelledby="list-mip-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addProgram">New</button>
                <p id="programShowList"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-7">
        <div class="row">
          <form class="text-center border border-light p-4 shadow w-75" id="basicInfoForm">
            <p class="h4 mb-2">Basic Information</p>
            <hr>
            <p class="h6 align-left">Name and Address of the Institution</p>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <div class="md-form md-outline">
                    <input type="text" id="instName" class="form-control">
                    <label for="instName">Instituton Name</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <div class="md-form md-outline">
                    <textarea id="instAddress" class="md-textarea form-control" rows="3"></textarea>
                    <label for="instAddress">Address</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <div class="md-form md-outline">
                    <input type="text" id="instCity" class="form-control">
                    <label for="instCity">City</label>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <div class="md-form md-outline">
                  <input type="text" id="instPIN" class="form-control">
                    <label for="instPIN">PIN Code</label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>



</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<<<<<<< HEAD
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

||||||| merged common ancestors
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
=======
>>>>>>> df090e8b21e39c0f50b3bac44dcab832d928620c

<script>
  $(document).ready(function() {
    $(".topBarTitle").text("Institution");
    instList();
    $('.selectPanel').hide();

    $(document).on('click', '.mis', function() {
      schoolList();
      $('.selectPanel').hide();

    });

    $(document).on('click', '.si', function() {
      $('.selectPanel').hide();

    });

    $(document).on('click', '.mid', function() {
      $("#selectPanelTitle").text("Select School");
      deptList();
      $('.selectPanel').show();
      $('.selectSchool').show();
      $('.selectDept').hide();
      $('.teaching').show();
      $('.nonTeaching').show();

    });
    $(document).on('click', '.mip', function() {
      $("#selectPanelTitle").text("Select Department");
      programList();
      $('.selectPanel').show();
      $('.selectSchool').hide();
      $('.teaching').hide();
      $('.nonTeaching').hide();
      $('.selectDept').show();
    });

    $(document).on('change', '#school_name', function() {
      // $.alert("Changes");
      deptList();

    });

    $(document).on('change', '#dept_type', function() {
      //x=$('form input[type=radio]:checked').val();
      //$.alert("Changes " + x);
      deptList();

    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var x = $("#inst_name").val();
      var sn = $("#school_nameModal").val();
      var dn = $("#dept_name").val();
      var pn = $("#program_name").val();
      var seldn = $("#sel_dept").val();
      var action = $("#action").val();
      if (x === "" && (action == "addInst" || action == "updateInst")) $.alert("Institute Name cannot be blank!!");
      else if (sn === "" && action == "addSchool") $.alert("School Name cannot be blank!!" + sn);
      else if (dn === "" && action == "addDept") $.alert("Department Name cannot be blank!!");
      else if (action == "addProgram" && (pn === "" || seldn === "")) $.alert("Program Name/Department cannot be blank!! " + dn);
      else {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        //$.alert(x + " Pressed" + formData);
        $.post("instSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List " + data);
          if (action == "addInst" || action == "updateInst") instList();
          else if (action == "addSchool" || action == "updateSchool") schoolList();
          else if (action == "addDept" || action == "updateDept") deptList();
          else if (action == "addProgram" || action == "updateProgram") programList();
          $('#modalForm')[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.inst_idD', function() {
      $.alert(" Disabled ");
    });

    $(document).on('click', '.inst_idE', function() {
      $('.deptForm').hide();
      $('.schoolForm').hide();
      $('.programForm').hide();

      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("instSql.php", {
        instId: id,
        action: "fetchInst"
      }, () => {}, "json").done(function(data) {
        $.alert("List " + data.inst_name);
        console.log("Error ", data);
        $('#modal_title').text("Update Institution [" + id + "]");
        $('#inst_name').val(data.inst_name);
        $('#inst_abbri').val(data.inst_abbri);
        $('#inst_url').val(data.inst_url);
        $('#inst_doi').val(data.inst_doi);

        $('#action').val("updateInst");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.instForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addInst', function() {
      $('.deptForm').hide();
      $('.schoolForm').hide();
      $('.programForm').hide();
      //$.alert("Add Inst");
      $('#modal_title').text("Add Institute");
      $('#action').val("addInst");
      $('#firstModal').modal('show');
      $('.instForm').show();
    });

    $(document).on('click', '.school_idD', function() {
      $.alert(" Disabled ");
    });

    $(document).on('click', '.school_idE', function() {
      $('.deptForm').hide();
      $('.instForm').hide();
      $('.programForm').hide();

      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("instSql.php", {
        schoolId: id,
        action: "fetchSchool"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update School [" + id + data.school_name + "]");
        $('#school_nameModal').val(data.school_name);
        $('#school_abbri').val(data.school_abbri);
        $('#school_url').val(data.school_url);
        $('#school_doi').val(data.school_doi);

        $('#action').val("updateSchool");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.schoolForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addSchool', function() {

      $('.deptForm').hide();
      $('.instForm').hide();
      $('.programForm').hide();
      //$.alert("Add School");
      $('#modal_title').text("Add School");
      $('#action').val("addSchool");
      $('#firstModal').modal('show');
      $('.schoolForm').show();
    });

    $(document).on('click', '.dept_idD', function() {
      $.alert(" Disabled ");
    });

    $(document).on('click', '.dept_idE', function() {
      $('.schoolForm').hide();
      $('.instForm').hide();
      $('.programForm').hide();

      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("instSql.php", {
        deptId: id,
        action: "fetchDept"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Department [" + id + "]");
        $('#dept_name').val(data.dept_name);
        $('#dept_abbri').val(data.dept_abbri);
        $('#dept_type').val(data.dept_type);
        $('#dept_doi').val(data.dept_doi);
        $('#school_id').val(data.school_id);

        $('#action').val("updateDept");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.deptForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addDept', function() {
      var x = $("#school_name").val();
      var y = $("#dept_type").val();
      if (x === "") $.alert("You have NOT Selected a School for this Department !!");
      else {
        $('.schoolForm').hide();
        $('.instForm').hide();
        $('.programForm').hide();
        $.alert("Add Department");
        $('#modal_title').text("Add Department " + x);
        $('#action').val("addDept");
        $('#schoolIdModal').val(x);
        $('#deptTypeModal').val(y);
        $('#firstModal').modal('show');
        $('.deptForm').show();
      }
    });

    $(document).on('click', '.program_idE', function() {
      $('.schoolForm').hide();
      $('.instForm').hide();
      $('.deptForm').hide();

      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("instSql.php", {
        programId: id,
        action: "fetchProgram"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Program [" + id + "]");
        $('#program_name').val(data.program_name);
        $('#program_abbri').val(data.program_abbri);
        $('#program_duration').val(data.program_duration);
        $('#program_semester').val(data.program_semester);
        $('#program_year').val(data.program_year);
        $('#program_seat').val(data.program_seat);
        $('#program_code').val(data.program_mode);
        $('#sp_name').val(data.sp_name);
        $('#sp_abbri').val(data.sp_abbri);
        $('#deptIdModal').val(data.dept_id);

        $('#action').val("updateProgram");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.programForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addProgram', function() {
      x = $('#sel_dept').val();
      if (x === "") $.alert("Please Select a Department to Proceed!!");
      else {
        $('.schoolForm').hide();
        $('.instForm').hide();
        $('.deptForm').hide();
        //$.alert("Add Program");
        $('#modal_title').text("Add Program");
        $('#deptIdModal').val(x);
        $('#action').val("addProgram");
        $('#firstModal').modal('show');
        $('.programForm').show();
      }
    });

    $(document).on('click', '.basicInfoUni', function() {
      $('.basicInfoForm').hide();
    });



    function instList() {
      //$.alert("In List Function");
      $.post("instSql.php", {
        action: "instList"
      }, function(mydata, mystatus) {
        $("#instShowList").show();
        //$.alert("List " + mydata);
        $("#instShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function schoolList() {
      //$.alert("In List Function");
      $.post("instSql.php", {
        action: "schoolList"
      }, function(mydata, mystatus) {
        $("#schoolShowList").show();
        //$.alert("List " + mydata);
        $("#schoolShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function deptList() {
      var x = $("#school_name").val();
      var y = $('form input[type=radio]:checked').val();
      //$.alert("In List Function"+ x + y);

      $.post("instSql.php", {
        action: "deptList",
        schoolId: x,
        deptType: y
      }, function(mydata, mystatus) {
        $("#deptShowList").show();
        //$.alert("List " + mydata);
        $("#deptShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function programList() {
      //$.alert("In List Function");
      var x = $("#dept_name").val();

      $.post("instSql.php", {
        action: "programList",
        deptId: x,
      }, function(mydata, mystatus) {
        $("#programShowList").show();
        //$.alert("List " + mydata);
        $("#programShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function getFormattedDate(ts, fmt) {
      var a = new Date(ts);
      var day = a.getDate();
      var month = a.getMonth() + 1;
      var year = a.getFullYear();
      var date = day + '-' + month + '-' + year;
      var dateYmd = year + '-' + month + '-' + day;
      if (fmt == "dmY") return date;
      else return dateYmd;
    }

  });
</script>
<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="instForm">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  Institute Name
                  <input type="text" class="form-control form-control-sm" id="inst_name" name="inst_name" placeholder="Institute Name">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Institute Abbri
                  <input type="text" class="form-control form-control-sm" id="inst_abbri" name="inst_abbri" placeholder="Institute Abbri">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  Institute URL
                  <input type="url" class="form-control form-control-sm" id="inst_url" name="inst_url" placeholder="Institute URL">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Date of Inception
                  <input type="date" class="form-control form-control-sm" id="inst_doi" name="inst_doi" value="<?php echo date("Y-m-d", time()); ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <i>Top level in the campus. It could be name of the University, Campus, Group of Institution, Institution.</i>
            </div>
          </div>

          <div class="schoolForm">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  School Name
                  <input type="text" class="form-control form-control-sm" id="school_nameModal" name="school_name" placeholder="School Name">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  School Abbri
                  <input type="text" class="form-control form-control-sm" id="school_abbri" name="school_abbri" placeholder="School Abbri">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  School URL
                  <input type="url" class="form-control form-control-sm" id="school_url" name="school_url" placeholder="School URL">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Date of Inception
                  <input type="date" class="form-control form-control-sm" id="school_doi" name="school_doi" value="<?php echo date("Y-m-d", time()); ?>">
                </div>
              </div>
            </div>

            <div class="form-group">
              <i>School is the academic unit of top level. It has to attached to Top Level.</i>
            </div>
          </div>

          <div class="deptForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Department Name
                  <input type="text" class="form-control form-control-sm" id="dept_name" name="dept_name" placeholder="Department Name">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Department Abbri
                  <input type="text" class="form-control form-control-sm" id="dept_abbri" name="dept_abbri" placeholder="Department Abbri">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Date of Inception
                  <input type="date" class="form-control form-control-sm" id="dept_doi" name="dept_doi" value="<?php echo date("Y-m-d", time()); ?>">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>Department is essentially attached to Top Level of the Campus. It may or may not be associated with School/College</i>
            </div>
          </div>

          <div class="programForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Program Name
                  <input type="text" class="form-control form-control-sm" id="program_name" name="program_name" placeholder="Program Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Prg Abbri
                  <input type="text" class="form-control form-control-sm" id="program_abbri" name="program_abbri" placeholder="Program Abbri">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Prg Code
                  <input type="text" class="form-control form-control-sm" id="program_code" name="program_code" placeholder="Program Code">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Specialization Name
                  <input type="text" class="form-control form-control-sm" id="sp_name" name="sp_name" placeholder="Specialization Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Sp Abbri
                  <input type="text" class="form-control form-control-sm" id="sp_abbri" name="sp_abbri" placeholder="Sp Abbri">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Sp Code
                  <input type="text" class="form-control form-control-sm" id="sp_code" name="sp_code" placeholder="Sp code">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Duration
                  <input type="number" class="form-control form-control-sm" id="program_duration" name="program_duration" placeholder="Program Duration">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="program_semester" name="program_semester" placeholder="Semester">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Start Year
                  <input type="number" class="form-control form-control-sm" id="program_start" name="program_start">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Seats
                  <input type="number" class="form-control form-control-sm" id="program_seat" name="program_seat" placeholder="Seats">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="schoolIdModal" name="schoolIdModal">
          <input type="hidden" id="deptTypeModal" name="deptTypeModal">
          <input type="hidden" id="deptIdModal" name="deptIdModal">
          <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>