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
        <div class="row">
          <div class="container card mt-2 myCard ml-4">
            <div class="row">
              <div class="col-md-3 pr-0">
                <label>Batch</label>
                <p id="batchOption"></p>
              </div>
              <div class="col-md-3 pl-1 pr-0">
                <label>Institute/School</label>
                <p id="schoolOption"></p>
              </div>
              <div class="col-md-3 pl-1 pr-0">
                <label>Programme</label>
                <p id="programOption">
                  <input type="text" class="form-control form-control-sm" disabled placeholder="Program">
                </p>
              </div>
              <div class="col-md-3 pl-1">
                <label>Type</label>
                <p id="feeType"></p>
              </div>
            </div>
          </div>
        </div>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="feeStructure" role="tabpanel" aria-labelledby="list-feeStructure-list">
              <form id="newFee">
                <div class="row">
                  <div class="col-md-12">
                    <div class="container card mt-2 myCard ml-4">
                      <div class="row">
                        <div class="col-md-3 pr-0">
                          <label>Category</label>
                          <p id="feeCategory"></p>
                        </div>
                        <div class="col-md-3 pl-1 pr-0">
                          <label>Component</label>
                          <p id="feeComponent"></p>
                        </div>
                        <div class="col-md-3 pl-1 pr-0">
                          <div class="form-group">
                            <label>Semester</label>
                            <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
                          </div>
                        </div>
                        <div class="col-md-3 pl-1">
                          <div class="form-group">
                            <label>Fee</label>
                            <input type="number" class="form-control form-control-sm" id="fee" min="0" name="fee" placeholder="Fee" value="0">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="action" name="action" value="addFee">
                  <button class="btn btn-sm">Add/Update</button>
              </form>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="container card mt-2 myCard ml-4" id="print" style="overflow: scroll;">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="feeStructureList">
                    <th class="text-center"><i class="fa fa-trash"></i></th>
                    <th>Batch</th>
                    <th>Institute</th>
                    <th>Programme</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Component</th>
                    <th>Semester</th>
                    <th>Fee</th>
                  </table>
                </div>
              </div>
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
    feeComponent();
    feeType();
    feeStructureList();

    $(document).on('submit', '#newFee', function(event) {
      event.preventDefault(this);
      // $.alert("Name");
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_prog").val()
      var feeTypeId = $("#sel_ft").val()
      var schoolId = $("#sel_school").val()
      var error = "NO";
      var error_msg = "";
      if ($('#sel_prog').val() === "0" || $('#sel_school').val() === "0" || $('#fee').val() === "0") {
        error = "YES";
        error_msg = "Please check Department, Program and Fee are added.";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        alert(" Pressed" + formData);
        $.post("feeSql.php", formData, () => {}, "text").done(function(data) {
          $.alert(data);
          feeStructureList()
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
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#feeCategory").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function feeComponent() {
      // $.alert("Department ");
      $.post("feeSql.php", {
        action: "feeComponent"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_fc" id="sel_fc" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#feeComponent").html(list);

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

    function feeStructureList() {
      // $.alert("Batch");
      $.post("feeSql.php", {
        action: "feeStructureList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center"><a href="#" class="dropFee" data-fee="' + value.fs_id + '"><i class="fas fa-trash"></i></a></td>';
          card += '<td>' + value.batch + '</td>';
          card += '<td>' + value.school_name + '</td>';
          card += '<td>' + value.program_name + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td>' + value.fee_type + '</td>';
          card += '<td>' + value.fee_component + '</td>';
          card += '<td>' + value.fee_semester + '</td>';
          card += '<td>' + value.fs_amount + '</td>';
          card += '</tr>';
        });
        $("#feeStructureList").find("tr:gt(0)").remove();
        $("#feeStructureList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on('change', '#sel_school', function() {
      programOption();
    });

    $(document).on("click", ".dropFee", function() {
      var fs_id = $(this).attr("data-fee");
      // $.alert('fs' + fs_id);
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>The Selected Fee Structure will be removed !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("feeSql.php", {
                fs_id: fs_id,
                action: "deleteFee"
              }, () => {}, "text").done(function(data, status) {
                $.alert(data);
              })
              feeStructureList()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
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