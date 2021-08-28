<?php
require('../requireSubModule.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-3">
          <h5>Fee Management</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action feeStructure" id="list-feeStructure-list" data-toggle="list" href="#feeStructure" role="tab" aria-controls="feeStructure"> Fee Structure </a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="feeStructure" role="tabpanel" aria-labelledby="list-feeStructure-list">
            <div class="container card mt-2 myCard">
              <form id="newFee">
                <div class="row">
                <div class="col-md-1 pr-0">
                    <label>Batch</label>
                    <p id="batchOption"></p>
                  </div>
                  <div class="col-md-2 pl-1 pr-0">
                    <label>Institute/School</label>
                    <p id="schoolOption"></p>
                  </div>
                  <div class="col-md-2 pl-1 pr-0">
                    <label>Programme</label>
                    <p id="programOption">
                    <input type="text" class="form-control form-control-sm" disabled placeholder="Program">
                    </p>
                  </div>
                  <div class="col-md-2 pl-1 pr-0">
                    <label>Category</label>
                    <p id="feeCategory"></p>
                  </div>
                  <div class="col-md-1 pl-1 pr-0">
                    <label>Type</label>
                    <p id="feeType"></p>
                  </div>
                  <div class="col-md-2 pl-1 pr-0">
                    <label>Fee Component</label>
                    <input type="text" class="form-control form-control-sm" id="fee_component" name="fee_component" placeholder="Fee Component">
                  </div>
                  <div class="col-md-1 pl-1 pr-0">
                    <div class="form-group">
                      <label>Semester</label>
                      <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
                    </div>
                  </div>
                  <div class="col-md-1 pl-1">
                    <div class="form-group">
                      <label>Fee</label>
                      <input type="number" class="form-control form-control-sm" id="fee" min="0" name="fee" placeholder="Fee" value="0">
                    </div>
                  </div>
                </div>
                <input type="hidden" id="action" name="action" value="addNew">
                <button class="btn btn-sm">Add/Update</button>
              </form>
            </div>
          </div>
          <div class="tab-pane fade" id="list-cs" role="tabpanel" aria-labelledby="list-cs-list">
            <div class="row">
              <div class="col-9 mt-1 mb-1">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <?php require("../bottom_bar.php"); ?>
  </div>
</body>
<?php require("../js.php"); ?>


<script>
  $(document).ready(function() {
    batchOption();
    schoolOption();
    feeCategory();
    feeType();

    $(document).on('submit', '#newFee', function(event) {
      event.preventDefault(this);
      // $.alert("Name");
      var error = "NO";
      var error_msg = "";
      if ($('#sel_prog').val() === "0" || $('#sel_school').val() === "0" || $('#fee').val()==="0") {
        error = "YES";
        error_msg = "Please check Department, Program and Fee are added.";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        // alert(" Pressed" + formData);
        $.post("feeSql.php", formData, () => {}, "text").done(function(data) {
          $.alert(data);
          feeStructure();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    function feeType() {
      // $.alert("Department ");
      $.post("feeSql.php", {
        action: "feeType"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_ft" id="sel_ft" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#feeType").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }
    function feeCategory() {
      // $.alert("Department ");
      $.post("feeSql.php", {
        action: "feeCategory"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_fcg" id="sel_fcg" required>';
        list += '<option value="0">ALL</option>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_abbri + '</option>';
        });
        list += '</select>';
        $("#feeCategory").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function batchOption() {
      // $.alert("Department ");
      $.post("feeSql.php", {
        action: "batchOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_batch" id="sel_batch" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.batch_id + '>' + value.batch + '</option>';
        });
        list += '</select>';
        $("#batchOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }
    function schoolOption() {
      // $.alert("Department ");
      $.post("feeSql.php", {
        action: "schoolOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_school" id="sel_school" required>';
        list += '<option value="0">Select Institution/School</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.school_id + '>' + value.school_name + '</option>';
        });
        list += '</select>';
        $("#schoolOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }
    function programOption() {
      var schoolId = $("#sel_school").val()
      // $.alert("Dept " + schoolId);
      $.post("feeSql.php", {
        schoolId: schoolId,
        action: "progOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("List " + data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_prog" id="sel_prog">';
        $.each(data, function(key, value) {
          list += '<option value=' + value.program_id + '>' + value.program_name + '</option>';
        });
        list += '</select>';
        $("#programOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })

    }
    $(document).on('change', '#sel_school', function() {
      programOption();
    });


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

</html>