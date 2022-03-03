<?php
require('../requireSubModule.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <h5 class="pt-3">Staff Profile</h5>
        <div class="list-group list-group-mine" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active bi" id="list-bi-list" data-toggle="list" href="#list-bi" role="tab" aria-controls="bi"> Basic Information </a>
          <a class="list-group-item list-group-item-action qual" id="list-qual-list" data-toggle="list" href="#list-qual" role="tab" aria-controls="qual"> Qualification </a>
          <a class="list-group-item list-group-item-action exp" id="list-exp-list" data-toggle="list" href="#list-exp" role="tab" aria-controls="exp"> Experience </a>
        </div>
      </div>
      <div class="col-sm-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="card border-info mb-3">
            <div class="card-body text-primary">
              <div class="row">
                <div class="col-2">
                  <span class="staffImage"><img src="../../images/upload.jpg"></span>
                  <form class="form-horizontal" id="uploadModalForm">
                    <div class="form-group">
                      <input type="file" name="upload_file">
                      <input type="hidden" name="action" value="uploadImage"><br>
                      <button type="submit" class="btn btn-sm btn-block">Upload Image</button>
                    </div>
                  </form>
                </div>
                <div class="col-6">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-3">
                          <h7 class="mb-0 ">Full Name</h7>
                        </div>
                        <div class="col-9 text-secondary staff_name">
                          Kenneth Valdez
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-3">
                          <h7 class="mb-0 ">DOJ</h7>
                        </div>
                        <div class="col-9 text-secondary staff_doj">
                          Kenneth Valdez
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-3">
                          <h7 class="mb-0 ">Email</h7>
                        </div>
                        <div class="col-9 text-secondary staff_email">
                          Kenneth Valdez
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-3">
                          <h7 class="mb-0 ">Mobile</h7>
                        </div>
                        <div class="col-9 text-secondary staff_mobile">
                          Kenneth Valdez
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-3">
                          <h7 class="mb-0 ">User ID</h7>
                        </div>
                        <div class="col-9 text-secondary staff_userId">
                          Kenneth Valdez
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card myCard">
                    <form class="formChange" method="post" action="" onSubmit="return validatePassword()">
                      <div class="row m-1">
                        <div class="col-4 pr-0 pl-1">
                          <div class="form-group"><label>Current Pwd</label>
                            <input type="password" name="currentPassword" class="form-control form-control-sm" />
                            <span id="currentPassword" class="required"></span>
                          </div>
                        </div>
                        <div class="col-4 pl-1 pr-0">
                          <div class="form-group"><label>New Pwd</label>
                            <input type="password" name="newPassword" class="form-control form-control-sm" />
                            <span id="newPassword" class="required"></span>
                          </div>
                        </div>
                        <div class="col-4 pl-1 pr-1">
                          <div class="form-group"><label>Confirm Pwd</label>
                            <input type="password" name="confirmPassword" class="form-control form-control-sm" />
                            <span id="confirmPassword" class="required"></span>
                          </div>
                        </div>
                      </div>
                      <div class="row m-1">
                        <div class="col-12 p-0">
                          <input type="hidden" id="actionPwd" name="action" value="changePassword">
                          <button class="btn btn-sm">Change Password</button>
                        </div>
                      </div>
                      <span class="xsText float-right m-1">min 8 letters, 1 Special, 1 Cap, 1 Number</span>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade show active" id="list-bi" role="tabpanel" aria-labelledby="list-bi-list">
            <div class="row">
              <div class="col-6">
                <div class="card">
                  <div class="card-body">
                    <form class="form-horizontal">
                      <input type="hidden" id="staffIdHidden" name="staffIdHidden" value="0">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            Staff Name
                            <input type="text" class="form-control form-control-sm staffForm" id="staff_name" name="staff_name" placeholder="Staff Name" data-tag="staff_name">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            Date of Birth
                            <input type="date" class="form-control form-control-sm staffForm" id="staff_dob" name="staff_dob" value="<?php echo $submit_date;?>" data-tag="staff_dob">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            Email
                            <input type="text" class="form-control form-control-sm staffForm" id="staff_email" name="staff_email" placeholder="Staff Email Id" data-tag="staff_email">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            Mobile Number
                            <input type="text" class="form-control form-control-sm staffForm" id="staff_mobile" name="staff_mobile" placeholder="Staff Mobile Number" data-tag="staff_mobile">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            Father Name
                            <input type="text" class="form-control form-control-sm staffForm" id="staff_fname" name="staff_fname" placeholder="Name of the Father" data-tag="staff_fname">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            Mother Name
                            <input type="text" class="form-control form-control-sm staffForm" id="staff_mname" name="staff_mname" placeholder="Name of the Mother" data-tag="staff_mname">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            Date of Joining
                            <input type="date" class="form-control form-control-sm staffForm" id="staff_doj" name="staff_doj" value="<?php echo $submit_date;?>" data-tag="staff_doj">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            Adhaar Number
                            <input type="text" class="form-control form-control-sm staffForm" id="staff_adhaar" name="staff_adhaar" placeholder="12 Digit Adhaar Number" data-tag="staff_adhaar">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            Address
                            <textarea class="form-control form-control-sm staffForm" rows="3" id="staff_address" name="staff_address"></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-3 pr-1 text-center">
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

</html>
<script>
  function resetForm() {
    document.getElementById("formStaff").reset();
  }

  $(document).ready(function() {

    profile();

    function profile() {
      $.post("profileSql.php", {
        action: "fetchStaff"
      }, () => {}, "json").done(function(data) {
        // $.alert("hello" + data.staff_name);
        $("#staffIdHidden").val(data.staff_id);
        $("#staff_email").val(data.staff_email);
        $("#staff_name").val(data.staff_name);
        $("#staff_mobile").val(data.staff_mobile);
        $("#staff_dob").val(data.staff_dob);
        $("#staff_fname").val(data.staff_fname);
        $("#staff_mname").val(data.staff_mname);
        $("#staff_adhaar").val(data.staff_adhaar);
        $("#staff_address").val(data.staff_address);
        $("#staff_doj").val(data.staff_doj);
        $(".staff_email").text(data.staff_email);
        $(".staff_name").text(data.staff_name);
        $(".staff_mobile").text(data.staff_mobile);
        $(".staff_doj").text(data.staff_doj);
        $(".staff_userId").text(data.user_id);
        if (data.staff_image === null) $(".staffImage").html('<img  src="../../images/upload.jpg" width="100%">');
        else $(".staffImage").html('<img  src="<?php echo '../../' . $myFolder . '/staffImages/'; ?>' + data.staff_image + '" width="100%">');
        $('.staffProfile').show();
      }).fail(function() {
        $.alert("fail in place of error");
      });
      $(document).on('blur', '.salaryUpdateForm', function() {
        var staff_id = $("#staffIdHidden").val();
        if (staff_id > 0) {
          var mn_id = $(this).attr("data-id")
          var tag = $(this).attr("data-tag")
          var value = $(this).val()
          // $.alert("Tag " + tag + " Value " + value + " Staff " + staff_id + " mn_id " + mn_id);
          $.post("hr_progSql.php", {
            userId: staff_id,
            mn_id: mn_id,
            tag: tag,
            value: value,
            action: "staffSalary"
          }, function() {}, "text").done(function(data, status) {
            // $.alert(data);
          }).fail(function() {
            $.alert("fail in place of error");
          })
        } else $.alert("Please select a Staff !!")
      });
    }

    $(document).on('blur', '.staffForm', function() {
      var staff_id = $("#staffIdHidden").val();
      if (staff_id > 0) {
        var tag = $(this).attr("data-tag")
        var value = $(this).val()
        // $.alert("Tag " + tag + " Value " + value + " Staff " + staff_id);
        $.post("profileSql.php", {
          staff_id: staff_id,
          tag: tag,
          value: value,
          action: "staffUpdate"
        }, function() {}, "text").done(function(data, status) {
          // $.alert(data);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else $.alert("Please select a Staff !!")
    });

    $(document).on('submit', '#uploadModalForm', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $.alert(formData);
      // action and test_id are passed as hidden
      $.ajax({
        url: "uploadSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          $.alert("List " + data);
          $('#uploadModal').modal('hide');
        }
      })
    });
    $(document).on('submit', '.formChange', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $.alert(formData);
      $.post("profileSql.php", formData, () => {}, "text").done(function(data) {
        $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
  });
</script>

</html>