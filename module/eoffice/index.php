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
  <div class="container-fluid">
    <div class="row">
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3 pl-1">
          <h5>eOffice </h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active inbox" id="list-inbox-list" data-toggle="list" href="#list-inbox" role="tab" aria-controls="inbox"> Inbox </a>
          <a class="list-group-item list-group-item-action compose" id="list-compose-list" data-toggle="list" href="#list-compose" role="tab" aria-controls="compose"> Compose </a>
          <a class="list-group-item list-group-item-action fad" id="list-fad-list" data-toggle="list" href="#list-fad" role="tab" aria-controls="fad"> File a Document </a>
          <a class="list-group-item list-group-item-action fs" id="list-fs-list" data-toggle="list" href="#list-fs" role="tab" aria-controls="fs"> File System </a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-inbox" role="tabpanel" aria-labelledby="list-inbox-list">
          </div>
          <div class="tab-pane fade" id="list-compose" role="tabpanel" aria-labelledby="list-compose-list">
            <p id="noticeId"></p>
            <div class="col-12 p-1">
              <p id="draftList"></p>
            </div>
            <div class="row newNotice" id="newNotice">
              <div class="col-9 p-1">
                <form class="noticeForm" id="noticeForm">
                  <div class="form-group row">
                    <label for="subject" class="col-sm-2 col-form-label">Subject/Title</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="subject" placeholder="Subject">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <textarea class="content" id="content" name="content"></textarea>
                    </div>
                  </div>
                  <button class="btn btn-secondary btn-square-sm saveNotice">Save</button>
                </form>
              </div>
              <div class="col-3 p-1 enclosure" id="enclosure">
                <button class="btn btn-secondary btn-square-sm btn-block enclosureList">Enclosures/Refresh</button>
                <p id="fileLink"></p>
                <button class="btn btn-danger btn-square-sm btn-block upload" id="foreignId">Attach/Enclose</button>
              </div>
            </div>
            <div class="row preview" id="preview">
              <div class="col-7 p-1">
                <button class="btn btn-block btn-secondary btn-square-sm"> Notice/Circular </button>
                <div class="message" id="message"></div>
              </div>
              <div class="col-2 p-1">
                <button class="btn btn-secondary btn-square-sm btn-block">Recipients</button>
                <hr>
                <p id="recipientList"></p>
              </div>
              <div class="col-3 p-1" id="recipient">
                <button class="btn btn-secondary btn-square-sm btn-block">Select Recipient</button>
                <hr>
                <div id="accordion">
                  <div class="card">
                    <div class="card-header">
                      <a class="card-link" data-toggle="collapse" href="#hoi">
                        Deans/Director
                        <i class="fa fa-minus"></i>
                      </a>
                    </div>
                    <div id="hoi" class="collapse show" data-parent="#accordion">
                      <div class="card-body">
                        <?php
                        $sql = "select * from school where school_status='0'";
                        selectList($conn, "Select Institution", array(0, "school_id", "school_name", "", "sel_school"), $sql);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#head">
                        Department
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="head" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <?php
                        $sql = "select * from department where dept_status='0'";
                        selectList($conn, "Select Deaprtment", array(0, "dept_id", "dept_name", "dept_abbri", "sel_dept"), $sql);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#admin">
                        Admin Dept/Section/Centers
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="admin" class="collapse" data-parent="#accordion">
                      <div class="card-body">

                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#class">
                        Classes
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="class" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <?php
                        $sql = "select * from class where session_id='$mySes' and class_status='0'";
                        selectList($conn, "Select Class", array(0, "class_id", "class_name", "class_section", "sel_class"), $sql);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#group">
                        My Groups
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="group" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <?php
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#committee">
                        Committees
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="committee" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <?php
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#staff">
                        Staff
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="staff" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <input type="text" name="staff" id="autoStaff" class="form-control form-control-sm" placeholder="Name of the Staff">
                        <div class='list-group' id="staffAutoList"></div>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <a class="collapsed card-link" data-toggle="collapse" href="#student">
                        Student
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div id="student" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <input type="text" name="student" id="autoStudent" class="form-control form-control-sm" placeholder="Name of the Student">
                        <div class='list-group' id="studentAutoList"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-fs" role="tabpanel" aria-labelledby="list-fs-list">
            <div class="fgList"></div>
            <div class="ftList"></div>
          </div>
        </div>
      </div>
    </div>
</body>

<?php require("../js.php"); ?>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    height: "420",
  });
</script>

<script>
  $(document).ready(function() {
    $(".topBarTitle").text("e-Office");
    $('[data-toggle="tooltip"]').tooltip();
    //$("#noticeId").hide()
    $("#newNotice").hide()
    draftList()

    $(".fs").click(function() {
      fgList()
      $(".ftList").hide();
    })

    $(document).on("click", ".folderFT", function() {
      var ft = $(this).attr("data-ft")
      //$.alert("folder")
      if ($(this).find("i.fa").hasClass("fa-folder")) {
        $(this).find("i.fa").removeClass("fa-folder")
        $(this).find("i.fa").addClass("fa-folder-open-o")
        var action = "open"
      } else if ($(this).find("i.fa").hasClass("fa-folder-open-o")) {
        $(this).find("i.fa").removeClass("fa-folder-open-o")
        $(this).find("i.fa").addClass("fa-folder")
        var action = "close"
      }
      //$.alert("Clicked to " + action + " the Folder Id " + ft)
      //if (action == "open") fileList(ft)
      $(this).parents(".card").siblings().find("i.fa").removeClass("fa-folder-open-o")
      $(this).parents(".card").siblings().find("i.fa").addClass("fa-folder")
    })

    $(document).on("click", ".folder", function() {
      var fg = $(this).attr("data-fg")
      //$.alert("folder")
      if ($(this).find("i.fa").hasClass("fa-folder")) {
        $(this).find("i.fa").removeClass("fa-folder")
        $(this).find("i.fa").addClass("fa-folder-open-o")
        var action = "open"
      } else if ($(this).find("i.fa").hasClass("fa-folder-open-o")) {
        $(this).find("i.fa").removeClass("fa-folder-open-o")
        $(this).find("i.fa").addClass("fa-folder")
        var action = "close"
      }
      //$.alert("Clicked to " + action + " the Folder Id " + fg)
      if (action == "open") ftList(fg)
      else $(".ftList").hide();
      $("#fg_id").val(fg)
      $(this).parents(".card").siblings().find("i.fa").removeClass("fa-folder-open-o")
      $(this).parents(".card").siblings().find("i.fa").addClass("fa-folder")
    })
    $("#accordion .card .card-link").click(function() {
      if ($(this).find("i.fa").hasClass("fa-minus")) {
        $(this).find("i.fa").removeClass("fa-minus")
        $(this).find("i.fa").addClass("fa-plus")
      } else if ($(this).find("i.fa").hasClass("fa-plus")) {
        $(this).find("i.fa").removeClass("fa-plus")
        $(this).find("i.fa").addClass("fa-minus")
      }
      $(this).parents(".card").siblings().find("i.fa").removeClass("fa-minus")
      $(this).parents(".card").siblings().find("i.fa").addClass("fa-plus")

    })

    $("#autoStaff").keyup(function() {
      var query = $(this).val();
      //$.alert(query);
      if (query != '') {
        $.ajax({
          url: "eoSql.php",
          method: "POST",
          data: {
            query: query
          },
          success: function(data) {
            $('#staffAutoList').fadeIn();
            $('#staffAutoList').html(data);
          }
        });
      } else {
        $('#staffAutoList').fadeOut();
        $('#staffAutoList').html("");
      }
    });

    $(document).on('click', '.autoListStaff', function() {
      $('#autoStaff').val($(this).text());
      var staffId = $(this).attr("data-staff");
      // $.alert('hello'+stdId);
      $('#staffAutoList').fadeOut();
      $.post("eoSql.php", {
        action: "addStaff",
        staffId: staffId
      }, function(data, status) {
        //$.alert(data);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.cbSchool, .cbDept, .cbClass', function() {
      var noticeId = $("#noticeId").val()
      var schoolId = $(this).attr('data-school');
      var deptId = $(this).attr('data-dept');
      var classId = $(this).attr('data-class');
      //$.alert("SchoolId " + schoolId + " Notice " + noticeId);
      //$.alert("ClassId " + classId + " Notice " + noticeId);
      $.post("eoSql.php", {
        noticeId: noticeId,
        schoolId: schoolId,
        deptId: deptId,
        classId: classId,
        action: "updateRecipient"
      }, function() {
        recipientList(noticeId);
      }, "text")
    });

    $(document).on('change', '#sel_class', function() {
      var classId = $("#sel_class").val()
      var noticeId = $("#noticeId").val()
      //$.alert("Class Changed " + classId + " Notice Id" + noticeId);
      $.post("eoSql.php", {
        noticeId: noticeId,
        classId: classId,
        action: "addClass"
      }, function(mydata, mystatus) {
        //$.alert("Data added - " + mydata);
        recipientList(noticeId);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('change', '#sel_dept', function() {
      var deptId = $("#sel_dept").val()
      var noticeId = $("#noticeId").val()
      //$.alert("Dept Changed " + deptId + " Notice Id" + noticeId);
      $.post("eoSql.php", {
        noticeId: noticeId,
        deptId: deptId,
        action: "addDept"
      }, function(mydata, mystatus) {
        //$.alert("Data added - " + mydata);
        recipientList(noticeId);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('change', '#sel_school', function() {
      var schoolId = $("#sel_school").val()
      var noticeId = $("#noticeId").val()
      //$.alert("School Changed " + schoolId + " Notice Id" + noticeId);
      $.post("eoSql.php", {
        noticeId: noticeId,
        schoolId: schoolId,
        action: "addSchool"
      }, function(mydata, mystatus) {
        //$.alert("Data added - "+mydata);
        recipientList(noticeId);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.addFT', function() {
      //$.alert("Add File Group");
      var fgId = $("#fg_id").val()
      $('#modal_title').text("Add File Title [" + fgId + "]");
      $('#action').val("addFT");
      $('#firstModal').modal('show');
      $('.ftForm').show();
      $('.fgForm').hide();
    });
    $(document).on('click', '.editFT', function() {
      var id = $(this).attr("data-ft");
      $.alert("Id " + id);

      $.post("eoSql.php", {
        ftId: id,
        action: "fetchFT"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.fg_name);
        //console.log("Error ", data);
        $('#modal_title').text("Update File Title [" + id + "]");
        $('#ft_name').val(data.ft_name);
        $('#ft_code').val(data.ft_code);
        $('#action').val("updateFT");
        $('#modalId').val(id);
        $('#firstModal').modal('show');
        $(".fgForm").hide();
        $('.ftForm').show();

      }, "text").fail(function(data) {
        $.alert("fail in place of error" + data);
      })
    });
    $(document).on('click', '.editFG', function() {
      var id = $(this).attr("data-fg");
      $.alert("Id " + id);

      $.post("eoSql.php", {
        fgId: id,
        action: "fetchFG"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.fg_name);
        //console.log("Error ", data);
        $('#modal_title').text("Update File Group [" + id + "]");
        $('#fg_name').val(data.fg_name);
        $('#fg_code').val(data.fg_code);
        $('#action').val("updateFG");
        $('#modalId').val(id);
        $('#firstModal').modal('show');
        $(".fgForm").show();
        $('.ftForm').hide();

      }, "text").fail(function(data) {
        $.alert("fail in place of error" + data);
      })
    });
    $(document).on('click', '.addFG', function() {
      //$.alert("Add File Group");
      $('#modal_title').text("Add File Group");
      $('#action').val("addFG");
      $('#firstModal').modal('show');
      $('.ftForm').hide();
      $('.fgForm').show();
    });

    $(document).on('click', '.upload', function() {
      var x = $("#noticeId").val();
      $.alert("Modal Foreign Id" + x);
      $('#foreignIdM').val(x);
      $('#uploadModal').modal('show');
    });

    $(document).on('submit', '#uploadModalForm', function(event) {
      var noticeId = $("#noticeId").val();
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
      attachmentList(noticeId)
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var fg_name = $("#fg_name").val();
      var fg_code = $("#fg_code").val();
      var action = $("#action").val();

      if (fg_name === "" && (action == "addFG" || action == "updateFG")) $.alert("Folder Group cannot be blank!!");
      else if (ft_name === "" && (action == "addFT" || action == "updateFT")) $.alert("File Title cannot be blank!!");
      else {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        $.alert(" Pressed" + formData);
        $.post("eoSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert(data);
          if (action == "addFG" || action == "updateFG") fgList();
          else if (action == "addFT" || action == "updateFT") ftList($("#fg_id").val());
          $('#modalForm')[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.draftButton, .compose', function(event) {
      $(".newNotice").hide()
      $("#recipient").hide()
      draftList()
    })
    $(document).on('click', '.previewButton', function(event) {
      var noticeId = $(this).attr("data-noticeId")
      //$.alert("Id " + noticeId)
      $.post("eoSql.php", {
        noticeId: noticeId,
        action: "preview"
      }, function(mydata, mystatus) {
        //$.alert("Fecth" + mydata.notice_subject);
        $("#preview").show()
        $("#message").html(mydata)

      }, "html").fail(function() {
        $.alert("Error !!");
      })
      $("#draftList").hide();
      $(".newNotice").hide()
      $("#preview").show()
      $("#recipient").show()
      $("#noticeId").val(noticeId)
      recipientList(noticeId);
    })
    $(document).on('click', '.editDraftButton', function(event) {
      $("#newNotice").show()
      var noticeId = $(this).attr("data-noticeId")
      $.alert("Id " + noticeId)
      $.post("eoSql.php", {
        noticeId: noticeId,
        action: "fetchNotice"
      }, function(mydata, mystatus) {
        //$.alert("Fecth" + mydata);
        $("#subject").val(mydata.notice_subject)
        $("#noticeId").val(noticeId)
        tinyMCE.get('content').setContent(mydata.content)
      }, "json").fail(function() {
        $.alert("Error !!");
      })
      $("#draftList").hide();
      $(".newNotice").show()
      attachmentList(noticeId)
    })

    $(document).on('click', '.enclosureList', function(event) {
      var noticeId = $("#noticeId").val()
      attachmentList(noticeId)
    })

    $(document).on('click', '.removeLink', function(event) {
      var noticeId = $("#noticeId").val()
      var link = $(this).attr("data-link")
      $.alert("Link " + link)
      $.post("eoSql.php", {
        noticeId: noticeId,
        link: link,
        action: "removeLink"
      }, function(mydata, mystatus) {}, "text").done(function() {
        attachmentList(noticeId)
      })
    })

    $(document).on('click', '.newNoticeButton', function(event) {
      $("#newNotice").show()
      $("#draftList").hide()
      $("#preview").hide()
      $('#noticeForm')[0].reset();
      $.post("eoSql.php", {
        action: "newNotice"
      }, function(data, status) {
        $.alert(data);
        $("#noticeId").text(data)
      }, "text").fail(function() {
        $.alert("Fail");
      })

    })
    $(document).on('submit', '.noticeForm', function(event) {
      event.preventDefault(this);
      var subject = $("#subject").val()
      var content = $("#content").val()
      var noticeId = $("#noticeId").text()
      if (subject === "") $.alert("Subject is mandatory");
      else {
        $.alert("Subject  " + subject + "Content " + content + "Notice" + noticeId);
        $.post("eoSql.php", {
          subject: subject,
          content: content,
          noticeId: noticeId,
          action: "updateNotice"
        }, function(data, status) {
          $.alert(data);
        }, "text").fail(function() {
          $.alert("Fail");
        })
      }
    })

    function attachmentList(noticeId) {
      $.post("eoSql.php", {
        noticeId: noticeId,
        action: "fetchAttachment"
      }, function(mydata, mystatus) {
        $.alert("Length " + mydata)
        $("#fileLink").html(mydata);
      }, "text")
    }

    function draftList() {
      $('#noticeForm')[0].reset();
      $.post("eoSql.php", {
        action: "draftList"
      }, function(mydata, mystatus) {
        $("#draftList").show();
        $("#preview").hide();
        //$.alert("List " + mydata);
        $("#draftList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function recipientList(noticeId) {
      $.post("eoSql.php", {
        noticeId: noticeId,
        action: "recipientList"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#recipientList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function fgList() {
      //$.alert("FG List")
      $.post("eoSql.php", {
        action: "fgList"
      }, function(mydata, mystatus) {
        $(".fgList").show();
        //$.alert("List " + mydata);
        $(".fgList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function ftList(x) {
      //$.alert("FT List " + x)
      $.post("eoSql.php", {
        fgId: x,
        action: "ftList"
      }, function(mydata, mystatus) {
        $(".ftList").show();
        //$.alert("List " + mydata);
        $(".ftList").html(mydata);
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
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="fgForm">
            <div class="row">
              <div class="col-8">
                File Group Name
                <input type="text" class="form-control form-control-sm" id="fg_name" name="fg_name">
              </div>
              <div class="col-4">
                Group Code
                <input type="text" class="form-control form-control-sm" id="fg_code" name="fg_code">
              </div>
            </div>
          </div>
          <div class="ftForm">
            <div class="row">
              <div class="col-8">
                File Title
                <input type="text" class="form-control form-control-sm" id="ft_name" name="ft_name">
              </div>
              <div class="col-4">
                File Code
                <input type="text" class="form-control form-control-sm" id="ft_code" name="ft_code">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="fg_id" name="fg_id">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
<div class="modal" id="uploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="uploadModalForm">
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="uploadForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <input type="file" name="upload_file">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" value="upload">
          <input type="hidden" id="foreignIdM" name="foreignId">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>