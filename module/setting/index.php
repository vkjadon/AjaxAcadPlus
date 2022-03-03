<?php
require('../requireSubModule.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>OBCon | AcadPlus | ClassConnect | EISOFTECH </title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <h5 class="pt-3">Settings</h5>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active inst" id="list-inst-list" data-toggle="list" href="#list-inst" role="tab" aria-controls="inst"> Group </a>
          <a class="list-group-item list-group-item-action sch" id="list-sch-list" data-toggle="list" href="#list-sch" role="tab" aria-controls="sch"> Institution </a>
          <a class="list-group-item list-group-item-action dept" id="list-dept-list" data-toggle="list" href="#list-dept" role="tab" aria-controls="dept"> Department </a>
          <a class="list-group-item list-group-item-action mip" id="list-mip-list" data-toggle="list" href="#list-mip" role="tab" aria-controls="mip"> Programme </a>
          <a class="list-group-item list-group-item-action is" id="list-is-list" data-toggle="list" href="#list-is" role="tab" aria-controls="is"> Structure </a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-inst" role="tabpanel" aria-labelledby="list-inst-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addInst"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs"><a href="#" class="fa fa-pencil-alt editInst" id="instId"></a> University/Group</div>
                  <div class="row mt-1">
                    <div class="col-12">
                      <p class="xlText" id="instName"></p>
                      <p class="largeText" id="instURL"></p>
                      <p class="largeText" id="instAddress"></p>
                      <p class="largeText" id="instLogo"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sch" role="tabpanel" aria-labelledby="list-sch-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addSchool"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">School/Institution List</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="schoolTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>Name</th>
                          <th>Abbri</th>
                          <th>Code</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-dept" role="tabpanel" aria-labelledby="list-dept-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addDept"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">Department List</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="deptTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Abbri</th>
                          <th>Type</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-mip" role="tabpanel" aria-labelledby="list-mip-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addProgram"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">Program List</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="programTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>Code</th>
                          <th>Program Name</th>
                          <th> Abbri</th>
                          <th> Sp Name</th>
                          <th> Sp Abbri</th>
                          <th> Duration </th>
                          <th> Sem/Tri</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade " id="list-is" role="tabpanel" aria-labelledby="list-is-list">
            <div class="row">
              <div class="col-6">
                <div class="card border-info mb-3">
                  <div class="card-header">
                    Attach Department to School
                  </div>
                  <div class="card-body text-primary">
                    <form class="form-horizontal" id="schoolDeptForm">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>School/Institution</label>
                          <?php
                          $sql_school = "select * from school where school_status='0'";
                          $result = $conn->query($sql_school);
                          if ($result) {
                            echo '<select class="form-control form-control-sm attachSchoolForm" name="sel_school" id="sel_school" data-tag="school_id" required>';
                            echo '<option selected disabled>Select School</option>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['school_id'];
                              $select_name = $rows['school_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                            }
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                        <div class="col-sm-6">
                          <label>Department</label>
                          <div class="input-group">
                            <?php
                            $sql_department = "select * from department where dept_status='0'";
                            $result = $conn->query($sql_department);
                            if ($result) {
                              echo '<select class="form-control form-control-sm" name="sel_dept" id="sel_dept" required>';
                              echo '<option selected disabled>Select Department</option>';
                              while ($rows = $result->fetch_assoc()) {
                                $select_id = $rows['dept_id'];
                                $select_name = $rows['dept_name'];
                                echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                              }
                              echo '</select>';
                            } else echo $conn->error;
                            if ($result->num_rows == 0) echo 'No Data Found';
                            ?>
                            <div class="input-group-append">
                              <!-- <input type="hidden" id="action" name="action"> -->
                              <input type="hidden" id="schoolIdHidden" name="schoolIdHidden">
                              <input type="hidden" id="deptIdHidden" name="deptIdHidden">
                              <button class="btn btn-primary btn-sm m-0" type="submit">Submit</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card border-info mb-3">
                  <div class="card-header">
                    Attach Program to Department
                  </div>
                  <div class="card-body text-primary">
                    <form class="form-horizontal" id="deptProgramForm">
                      <div class="row">
                        <div class="col-sm-6">
                          <label>Department</label>
                          <?php
                          $sql_department = "select * from department where dept_status='0'";
                          $result = $conn->query($sql_department);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_deptProgram" id="sel_deptProgram" required>';
                            echo '<option selected disabled>Select Department</option>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['dept_id'];
                              $select_name = $rows['dept_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                            }
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                        <div class="col-sm-6">
                          <label>Program/Specialization</label>
                          <div class="input-group">
                            <?php
                            $sql_program = "select * from program where program_status='0' order by sp_name";
                            $result = $conn->query($sql_program);
                            if ($result) {
                              echo '<select class="form-control form-control-sm" name="sel_program" id="sel_program" data-tag="program_id" required>';
                              echo '<option selected disabled>Select Program</option>';
                              while ($rows = $result->fetch_assoc()) {
                                $select_id = $rows['program_id'];
                                $select_name = $rows['sp_name'];
                                echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                              }
                              echo '</select>';
                            } else echo $conn->error;
                            if ($result->num_rows == 0) echo 'No Data Found';
                            ?>
                            <div class="input-group-append">
                              <input type="hidden" id="actionDeptProgram" name="actionDeptProgram">
                              <input type="hidden" id="programIdHidden" name="programIdHidden">
                              <input type="hidden" id="deptIdHidden2" name="deptIdHidden2">
                              <button class="btn btn-primary btn-sm m-0" type="submit">Submit</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="container card myCard mb-3">
                  <p class="mt-3" id="schoolDeptShowList"></p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="container card myCard mb-3">
                  <p class="mt-3" id="deptProgramShowList"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
  </div>
  <?php require("../bottom_bar.php"); ?>
</body>
<script>
  $(document).ready(function() {
    instList();
    deptList();
    schoolList();
    programList();

    $(document).on('click', '.is', function() {
      deptSchoolList();
      deptProgramList();
    });
    $(document).on('submit', '#schoolDeptForm', function() {
      event.preventDefault(this);
      var deptId = $("#sel_dept").val()
      var schoolId = $("#sel_school").val()
      // $.alert("Form Submitted " + formData)
      $.post("instSql.php", {
        deptId: deptId,
        schoolId: schoolId,
        action: "attachSchoolDept"
      }, function() {}, "text").done(function(data, success) {
        //$.alert(data)
      })
      deptSchoolList();
    });
    $(document).on('submit', '#deptProgramForm', function() {
      event.preventDefault(this);
      var deptId = $("#sel_deptProgram").val()
      var programId = $("#sel_program").val()
      $('#programIdHidden').val(programId)
      $('#deptIdHidden2').val(deptId)
      $("#actionDeptProgram").val("attachDeptProgram")
      var formData = $(this).serialize();
      // $.alert("Form Submitted " + formData)
      $.post("instSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
      })
      deptProgramList()
    });
    $(document).on('click', '.deleteSchoolDept', function() {
      var dept_id = $(this).attr("data-dept");
      var school_id = $(this).attr("data-school");
      // $.alert("Disabled "+school_id+dept_id);
      $.post("instSql.php", {
        deptId: dept_id,
        schoolId: school_id,
        action: "removeSchoolDept"
      }, function(data, status) {
        // $.alert("Data" + data)
        deptSchoolList();
      }, "text").fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('click', '.deleteDeptProgram', function() {
      var dept_id = $(this).attr("data-dept");
      var prog_id = $(this).attr("data-program");
      $.post("instSql.php", {
        deptId: dept_id,
        progId: prog_id,
        action: "removeDeptProgram"
      }, function(data, status) {
        // $.alert("Data" + data)
        deptProgramList();
      }, "text").fail(function() {
        $.alert("Error");
      })
    });

    function deptSchoolList() {
      //$.alert("In List Function");
      var x = $("#sel_dept").val();
      var y = $("#sel_school").val();
      $.post("instSql.php", {
        action: "deptSchoolList",
        deptId: x,
        schoolId: y
      }, function(mydata, mystatus) {
        $("#schoolDeptShowList").show();
        //$.alert("List " + mydata);
        $("#schoolDeptShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function deptProgramList() {
      //$.alert("In List Function");
      var x = $("#sel_deptProgram").val();
      var y = $("#sel_program").val();
      $.post("instSql.php", {
        action: "deptProgramList",
        deptId: x,
        programId: y
      }, function(mydata, mystatus) {
        $("#deptProgramShowList").show();
        //$.alert("List " + mydata);
        $("#deptProgramShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
    // Manage Program
    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var instName = $("#inst_name").val();
      var pn = $("#program_name").val();
      var school_name = $("#school_name").val();
      var action = $("#action").val();
      // $.alert(" Action " + action );
      if (action == "addInst" && instName === "") $.alert("Group/University Name cannot be blank!! ");
      else if (action == "addProgram" && pn === "") $.alert("Program Name cannot be blank!! ");
      else if (action == "addSchool" && school_name === "") $.alert("School Name cannot be blank!! ");
      else if (action == "addDept" && dept_name === "") $.alert("Department Name cannot be blank!! ");
      else {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        // $.alert(formData);
        $.post("instSql.php", formData, () => {}, "text").done(function(data, status) {
          // $.alert(data);
          if (action == "addProgram" || action == "updateProgram") programList();
          else if (action == "addSchool" || action == "updateSchool") schoolList();
          else if (action == "addDept" || action == "updateDept") deptList();
          $('#modalId').val("0");

          $('#modalForm')[0].reset();
        }).fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.editInst', function() {
      // var id = $(this).attr("data-id");
      var id=1;
      //$.alert("Id " + id);
      $.post("instSql.php", {
        instId: id,
        action: "fetchInst"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Institute [" + id + "]");
        $('#inst_name').val(data.inst_name);
        $('#inst_abbri').val(data.inst_abbri);
        $('#inst_address').val(data.inst_address);
        $('#inst_logo').val(data.inst_logo);
        $('#inst_url').val(data.inst_url);

        $('#action').val("updateInst");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.programForm').hide();
        $('.instForm').show();
        $('.schoolForm').hide();
        $('.departmentForm').hide();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.editProgram', function() {
      var id = $(this).attr("data-id");
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
        $('#sp_code').val(data.sp_code);
        $('#sp_name').val(data.sp_name);
        $('#sp_abbri').val(data.sp_abbri);
        $('#deptIdModal').val(data.dept_id);

        $('#action').val("updateProgram");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.programForm').show();
        $('.instForm').hide();
        $('.schoolForm').hide();
        $('.departmentForm').hide();

        //$("#ccform").html(mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.addProgram', function() {
      //$.alert("Add Program");
      $('#modal_title').text("Add Program");
      $('#action').val("addProgram");
      $('#firstModal').modal('show');
      $('.instForm').hide();
      $('.schoolForm').hide();
      $('.departmentForm').hide();
      $(".programForm").show();
    });

    $(document).on('click', '.resetProgram', function() {
      var prog_id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        progId: prog_id,
        action: "resetProgram"
      }, function() {}, "text").done(function(data,status){
        // $.alert("Data" + data)
        programList();
      }).fail(function() {
        $.alert("Error");
      })
    });
    $(document).on('click', '.trashProgram', function() {
      var prog_id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        progId: prog_id,
        action: "removeProgram"
      }, function() {}, "text").done(function(data,status){
        // $.alert("Data" + data)
        programList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    function programList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "programList"
      }, function(mydata, mystatus) {
        $("#programShowList").show();
        //$.alert("List " + mydata);
      }, "json").done(function(data, status) {
        if (data.success == "0") {
          var success = '<tr><td colspan="10">No Program Found. Please add Program only if you are Head of Institution or Department</td></tr>';
          $("#programTable").find("tr:gt(0)").remove();
          $("#programTable").append(success);

        } else {
          // $("#feedbackTable").html("Found")
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.program_status
            if (status != null) {
              card += '<tr>';
              card += '<td><a href="#" class="editProgram fa fa-pencil-alt" data-id="' + value.program_id + '"></td>';
              card += '<td>' + count++ + '</td>';
              card += '<td>' + value.sp_code + '</td>';
              card += '<td>' + value.program_name + '</td>';
              card += '<td>' + value.program_abbri + '</td>';
              card += '<td>' + value.sp_name + '</td>';
              card += '<td>' + value.sp_abbri + '</td>';
              card += '<td>' + value.program_duration + '</td>';
              card += '<td>' + value.program_semester + '</td>';
              if(status==0)card += '<td><a href="#" class="fa fa-trash trashProgram" data-id="' + value.program_id + '"></td>';
              else card += '<td><a href="#" class="fa fa-refresh resetProgram" data-id="' + value.program_id + '"></td>';
              card += '</tr>';
            }
          })
          $("#programTable").find("tr:gt(0)").remove();
          $("#programTable").append(card);
        }
      })
    }

    $(document).on('click', '.addSchool', function() {
      //$.alert("Add Program");
      $('#modal_title').text("Add School/Institution");
      $('#action').val("addSchool");
      $('#firstModal').modal('show');
      $('.instForm').hide();
      $('.schoolForm').show();
      $('.departmentForm').hide();
      $(".programForm").hide();
    });
    $(document).on('click', '.editSchool', function() {
      var id = $(this).attr("data-id");
      // $.alert("Id " + id);

      $.post("instSql.php", {
        schoolId: id,
        action: "fetchSchool"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update School/Institution [" + id + "]");
        $('#school_name').val(data.school_name);
        $('#school_abbri').val(data.school_abbri);
        $('#school_code').val(data.school_code);

        $('#action').val("addSchool");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.instForm').hide();
        $('.schoolForm').show();
        $('.departmentForm').hide();
        $(".programForm").hide();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.resetSchool', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        sclId: id,
        action: "resetSchool"
      }, function() {}, "text").done(function(data,status){
        // $.alert("Data" + data)
        schoolList();
      }).fail(function() {
        $.alert("Error");
      })
    });
    $(document).on('click', '.trashSchool', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        sclId: id,
        action: "removeSchool"
      }, function() {}, "text").done(function(data,status){
        // $.alert("Data" + data)
        schoolList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    function schoolList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "schoolList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var status = value.school_status
          if (status != null) {
            card += '<tr>';
            card += '<td><a href="#" class="editSchool fa fa-pencil-alt" data-id="' + value.school_id + '"></td>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.school_name + '</td>';
            card += '<td>' + value.school_abbri + '</td>';
            card += '<td>' + value.school_code + '</td>';
            if(status==0)card += '<td><a href="#" class="fa fa-trash trashSchool" data-id="' + value.school_id + '"></td>';
            else card += '<td><a href="#" class="fa fa-refresh resetSchool" data-id="' + value.school_id + '"></td>';
            card += '</tr>';
          }
        })
        $("#schoolTable").find("tr:gt(0)").remove();
        $("#schoolTable").append(card);

      })
    }

    $(document).on('click', '.addDept', function() {
      //$.alert("Add Program");
      $('#modal_title').text("Add Department");
      $('#action').val("addDept");
      $('#firstModal').modal('show');
      $('.instForm').hide();
      $('.schoolForm').hide();
      $('.departmentForm').show();
      $(".programForm").hide();
    });
    $(document).on('click', '.editDept', function() {
      var id = $(this).attr("data-id");
      // $.alert("Id " + id);
      $.post("instSql.php", {
        deptId: id,
        action: "fetchDept"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Department [" + id + "]");
        $('#dept_name').val(data.dept_name);
        $('#dept_abbri').val(data.dept_abbri);
        $('#dept_type').val(data.dept_type);

        $('#action').val("addDept");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.instForm').hide();
        $('.schoolForm').hide();
        $('.departmentForm').show();
        $(".programForm").hide();

        //$("#ccform").html(mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.resetDept', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        deptId: id,
        action: "resetDept"
      }, function() {}, "text").done(function(data,status){
        // $.alert("Data" + data)
        deptList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('click', '.trashDept', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        deptId: id,
        action: "removeDept"
      }, function() {}, "text").done(function(data,status){
        // $.alert("Data" + data)
        deptList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    function deptList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "deptList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var status = value.dept_status
          if (status != null) {
            card += '<tr>';
            card += '<td><a href="#" class="editDept fa fa-pencil-alt" data-id="' + value.dept_id + '"></td>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.dept_id + '</td>';
            card += '<td>' + value.dept_name + '</td>';
            card += '<td>' + value.dept_abbri + '</td>';
            if(value.dept_type==0)card += '<td>Teaching</td>';
            else card += '<td>Non Teaching</td>';
            if(status==0)card += '<td><a href="#" class="fa fa-trash trashDept" data-id="' + value.dept_id + '"></td>';
            else card += '<td><a href="#" class="fa fa-refresh resetDept" data-id="' + value.dept_id + '"></td>';
            card += '</tr>';
          }
        })
        $("#deptTable").find("tr:gt(0)").remove();
        $("#deptTable").append(card);

      })
    }

    function instList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "fetchInst"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        $("#instName").html(data.inst_name)
        $("#instURL").html(data.inst_url)
        $("#instLogo").html(data.inst_logo )
        $("#instAddress").html(data.inst_address)
      })
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
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>Group/University</label>
                  <input type="text" class="form-control form-control-sm" id="inst_name" name="inst_name" placeholder="Name">
                </div>
              </div>
              <div class="col-3 pl-1 pr-0">
                <div class="form-group">
                  <label>Abbri</label>
                  <input type="text" class="form-control form-control-sm" id="inst_abbri" name="inst_abbri" placeholder="Abbri">
                </div>
              </div>
              <div class="col-3 pl-1">
                <div class="form-group">
                  <label> Logo </label>
                  <input type="text" class="form-control form-control-sm" id="inst_logo" name="inst_logo" placeholder="Logo">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-7 pr-0">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control form-control-sm" id="inst_address" name="inst_address" placeholder="Address">
                </div>
              </div>
              <div class="col-5 pl-1">
                <div class="form-group">
                  <label>URL</label>
                  <input type="text" class="form-control form-control-sm" id="inst_url" name="inst_url" placeholder="Abbri">
                </div>
              </div>
            </div>
          </div>
          <div class="schoolForm">
            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>School/Institution Name</label>
                  <input type="text" class="form-control form-control-sm" id="school_name" name="school_name" placeholder="Name">
                </div>
              </div>
              <div class="col-3 pl-1 pr-0">
                <div class="form-group">
                  <label>Abbri</label>
                  <input type="text" class="form-control form-control-sm" id="school_abbri" name="school_abbri" placeholder="Abbri">
                </div>
              </div>
              <div class="col-3 pl-1">
                <div class="form-group">
                  <label> Code</label>
                  <input type="text" class="form-control form-control-sm" id="school_code" name="school_code" placeholder="Code">
                </div>
              </div>
            </div>
          </div>
          <div class="departmentForm">
            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>Department Name</label>
                  <input type="text" class="form-control form-control-sm" id="dept_name" name="dept_name" placeholder="Name">
                </div>
              </div>
              <div class="col-3 pl-1 pr-0">
                <div class="form-group">
                  <label>Abbri</label>
                  <input type="text" class="form-control form-control-sm" id="dept_abbri" name="dept_abbri" placeholder="Abbri">
                </div>
              </div>
              <div class="col-3 pl-1">
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control form-control-sm" id="dept_type" name="dept_type">
                    <option value="0">Teaching</option>
                    <option value="1">Non Teaching</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="programForm">
            <div class="row">
              <div class="col-9">
                <div class="form-group">
                  Program Name
                  <input type="text" class="form-control form-control-sm" id="program_name" name="program_name" placeholder="Program Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Prog Abbri
                  <input type="text" class="form-control form-control-sm" id="program_abbri" name="program_abbri" placeholder="Program Abbri">
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
                  <input type="text" class="form-control form-control-sm" id="sp_code" name="sp_code" placeholder="Sp code" value="00">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Duration
                  <input type="number" class="form-control form-control-sm" id="program_duration" name="program_duration" placeholder="Program Duration" value="1">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="program_semester" name="program_semester" placeholder="Semester" value="2">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Start Year
                  <input type="number" class="form-control form-control-sm" id="program_start" name="program_start" value="2000">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Seats
                  <input type="number" class="form-control form-control-sm" id="program_seat" name="program_seat" placeholder="Seats" value="60">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <button type="submit" class="btn btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>