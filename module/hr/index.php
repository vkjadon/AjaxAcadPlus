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
 <?php require("../css.php"); ?>
 <style>
  .collapsible-link::before {
   content: '';
   width: 14px;
   height: 2px;
   background: #333;
   position: absolute;
   top: calc(50% - 1px);
   right: 1rem;
   display: block;
   transition: all 0.3s;
  }

  /* Vertical line */
  .collapsible-link::after {
   content: '';
   width: 2px;
   height: 14px;
   background: #333;
   position: absolute;
   top: calc(50% - 7px);
   right: calc(1rem + 6px);
   display: block;
   transition: all 0.3s;
  }

  .collapsible-link[aria-expanded='true']::after {
   transform: rotate(90deg) translateX(-1px);
  }

  .collapsible-link[aria-expanded='true']::before {
   transform: rotate(180deg);
  }

  .collapseAccordian {
   background-color: #e1f5fe;
  }

  .collapseHeader {
   background-color: #29b6f6;
  }
 </style>
</head>

<body>
 <?php require("../topBar.php"); ?>
 <div class="container-fluid">
  <span id="panelId"></span>
  <div class="row">
   <div class="col-sm-2">
    <div class="list-group list-group-mine" id="list-tab" role="tablist">
     <a class="list-group-item list-group-item-action active as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Add Staff </a>
     <a class="list-group-item list-group-item-action sq" id="list-sq-list" data-toggle="list" href="#list-sq" role="tab" aria-controls="sq"> Staff Qualification </a>
     <a class="list-group-item list-group-item-action sq" id="list-sq-list" data-toggle="list" href="#list-sq" role="tab" aria-controls="sq"> Role/Responsibility </a>
     <em>Add staff not to be assigned designation and department. The staff to be assigned these from Role/Responsibility Tab.</em>
    </div>
   </div>
   <div class="col-sm-10">
    <div class="tab-content" id="nav-tabContent">
     <div class="tab-pane fade show active" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
      <div class="row">
       <div class="col-4">
        <div class="card border-info mb-3">
         <div class="card-header">
          Enter Staff Name to Search
          <button class="btn btn-info btn-sm addStaff">Add</button>
         </div>
         <div class="card-body text-primary">
          <div class="input-group md-form form-sm form-2 pl-0">
           <input name="staffSearch" id="staffSearch" class="form-control my-0 py-1 red-border" type="text" placeholder="Search Staff" aria-label="Search">
           <div class="input-group-append">
            <span class="input-group-text cyan lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
           </div>
          </div>
          <div class='list-group' id="staffAutoList"></div>
         </div>
        </div>
        <p id="staffList"></p>
       </div>
       <div class="col-8">
        <div class="card border-info mb-3 staffProfile">
         <div class="card-header">Staff Profile</div>
         <div class="card-body text-primary">
          <div class="row">
           <div class="col-3">
            <div class="card">
             <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
               <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="100">
              </div>
             </div>
            </div>
           </div>
           <div class="col-9">
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
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
        <div id="accordionStaff" class="accordion shadow">
         <div class="card">
          <div id="headingOne" class="card-header bg-white shadow-sm border-0">
           <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Edit Details</a></h6>
          </div>
          <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionStaff" class="collapse show collapseAccordian">
           <div class="card-body">
            <form class="form-horizontal" id="modalForm">
             <input type="hidden" id="staffIdHidden" name="staffIdHidden">
             <div class="row">
              <div class="col-12 text-center">
              </div>
             </div>
             <div class="row">
              <div class="col-6">
               <div class="form-group">
                Staff Name
                <input type="text" class="form-control form-control-sm staffForm" id="sName" name="sName" placeholder="Staff Name" data-tag="staff_name">
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                Date of Birth
                <input type="date" class="form-control form-control-sm staffForm" id="sDob" name="sDob" placeholder="Date of Birth" data-tag="staff_dob">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-6">
               <div class="form-group">
                Email
                <input type="text" class="form-control form-control-sm staffForm" id="sEmail" name="sEmail" placeholder="Staff Email Id" data-tag="staff_email">
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                Mobile Number
                <input type="text" class="form-control form-control-sm staffForm" id="sMobile" name="sMobile" placeholder="Staff Mobile Number" data-tag="staff_mobile">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-6">
               <div class="form-group">
                Father Name
                <input type="text" class="form-control form-control-sm staffForm" id="fName" name="fName" placeholder="Name of the Father" data-tag="staff_fname">
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                Mother Name
                <input type="text" class="form-control form-control-sm staffForm" id="mName" name="mName" placeholder="Name of the Mother" data-tag="staff_mname">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-6">
               <div class="form-group">
                Date of Joining
                <input type="date" class="form-control form-control-sm staffForm" id="sDoj" name="sDoj" placeholder="Date of Joining" data-tag="staff_doj">
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                Adhaar Number
                <input type="text" class="form-control form-control-sm staffForm" id="sAdhaar" name="sAdhaar" placeholder="12 Digit Adhaar Number" data-tag="staff_adhaar">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-12">
               <div class="form-group">
                Address
                <input type="text" class="form-control form-control-sm staffForm" id="sAddress" name="sAddress" placeholder="Address" data-tag="staff_address">
               </div>
              </div>
             </div>
             <hr>
             <div class="row">
              <div class="col-5">
               <div class="form-check-inline">
                <input type="radio" class="form-check-input staffForm" checked id="male" name="sGender" value="Male" data-tag="staff_gender">Male
               </div>
               <div class="form-check-inline">
                <input type="radio" class="form-check-input staffForm" id="female" name="female" value="sGender" data-tag="staff_gender">Female
               </div>
              </div>
              <div class="col-7">
               <div class="form-check-inline">
                <input type="radio" class="form-check-input staffForm" checked id="Teaching" name="sTeaching" value="Teaching" data-tag="staff_teaching">Teaching
               </div>
               <div class="form-check-inline">
                <input type="radio" class="form-check-input staffForm" id="NonTeaching" name="sTeaching" value="NonTeaching" data-tag="staff_teaching">Non-Teaching
               </div>
              </div>
             </div>
            </form>
           </div>
          </div>
         </div>
         <div class="card">
          <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
           <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Add Qualification</a></h6>
          </div>
          <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionStaff" class="collapse collapseAccordian">
           <div class="card-body">
            <form class="form-horizontal" class="qualificationForm">
             <input type="hidden" id="stqIdHidden" name="stqIdHidden">
             <div class="row">
              <div class="col-6">
               <div class="form-group">
                Qualification
                <div class="row">
                 <div class="col">
                  <?php
                  $sql_qualification = "select * from qualification";
                  $result = $conn->query($sql_qualification);
                  if ($result) {
                   echo '<select class="form-control form-control-sm staffQualificationForm" name="sel_qual" id="sel_qual" data-tag="qualification_id" required>';
                   echo '<option selected disabled>Select Qualification</option>';
                   while ($rows = $result->fetch_assoc()) {
                    $select_id = $rows['qualification_id'];
                    $select_name = $rows['qualification_name'];
                    echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                   }
                   echo '</select>';
                  } else echo $conn->error;
                  if ($result->num_rows == 0) echo 'No Data Found';
                  ?>
                 </div>
                </div>
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                Institute
                <input type="text" class="form-control form-control-sm staffQualificationForm" id="sInst" name="sInst" placeholder="Name of the Institute" data-tag="stq_institute">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-6">
               <div class="form-group">
                Board
                <input type="text" class="form-control form-control-sm staffQualificationForm" id="sBoard" name="sBoard" placeholder="Board" data-tag="stq_board">
               </div>
              </div>
              <div class="col-6">
               <div class="form-group">
                Year of Passing
                <input type="text" class="form-control form-control-sm staffQualificationForm" id="sYear" name="sYear" placeholder="Passing Year" data-tag="stq_year">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-4">
               <div class="form-group">
                Marks Obtained
                <input type="text" class="form-control form-control-sm staffQualificationForm" id="sMarksObt" name="sMarksObt" placeholder="Marks Obtained" data-tag="stq_marksObtained">
               </div>
              </div>
              <div class="col-4">
               <div class="form-group">
                Maximum Marks
                <input type="text" class="form-control form-control-sm staffQualificationForm" id="sMaxMarks" name="sMaxMarks" placeholder="Maximum marks" data-tag="stq_marksMax">
               </div>
              </div>
              <div class="col-4">
               <div class="form-group">
                Percentage/CGPA
                <input type="text" class="form-control form-control-sm staffQualificationForm" id="sCgpa" name="sCgpa" placeholder="Percentage/CGPA" data-tag="stq_percentage">
               </div>
              </div>
             </div>
            </form>

            <div class="row">
             <div class="col-12">
              <p style="text-align:center" id="qualificationShowList"></p>
             </div>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>

</html>

<?php require("../js.php"); ?>
<script>
 function resetForm() {
  document.getElementById("formStaff").reset();
 }

 $(document).ready(function() {
  $('#list-as').show();
  $('#list-sq').hide();
  $('#accordionStaff').hide();
  $('.staffProfile').hide();

  var z = $("#sel_dept").val();
  staffList();
  $('#deptIdModal').val(z);

  $('#staffSearch').keyup(function() {
   var query = $(this).val();
   // alert(query);
   if (query != '') {
    $.ajax({
     url: "hrSql.php",
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

  $(document).on('click', '.autoList', function() {
   $('#staffSearch').val($(this).text());
   var stfId = $(this).attr("data-std");
   staffQualificationList(stfId);
   $('#staffAutoList').fadeOut();
   $.post("hrSql.php", {
    staffId: stfId,
    action: "fetchStaff"
   }, () => {}, "json").done(function(data) {
    // $.alert("hello" + data.staff_name);
    $(".staff_email").text(data.staff_email);
    $(".staff_name").text(data.staff_name);
    $(".staff_mobile").text(data.staff_mobile);
    $(".staff_doj").text(data.staff_doj);
    $("#sEmail").val(data.staff_email);
    $("#sName").val(data.staff_name);
    $("#sMobile").val(data.staff_mobile);
    $("#sDob").val(data.staff_dob);
    $("#fName").val(data.staff_fname);
    $("#mName").val(data.staff_mname);
    $("#sAdhaar").val(data.staff_adhaar);
    $("#sAddress").val(data.staff_address);
    $("#sGender").val(data.staff_gender);
    $("#sTeaching").val(data.staff_teaching);
    $("#sDoj").val(data.staff_doj);
    $('.staffProfile').show();
    $('#accordionStaff').show();



   }, "text").fail(function() {
    $.alert("fail in place of error");
   })


  });

  $(document).on('click', '.sq', function() {
   $(".selectPanel").show();
   $('#list-sq').show();
   $('#list-as').hide();
   $('#staffShowList').show();
  });

  $(document).on('click', '.as', function() {
   $(".selectPanel").show();
   $('#list-as').show();
   $('#list-sq').hide();
  });

  $(document).on('click', '.addStaff', function() {
   $('#modal_title').text("Add Staff");
   $('#action').val("addStaff");
   $('#firstModal').modal('show');
   $('.staffForm').show();
   $('.selectPanel').show();
   $(".staffDetailForm").hide();
   $(".staffQualificationForm").hide();
  });

  $(document).on('blur', '.staffForm', function() {
   var staffId = $("#staffIdHidden").val()
   var tag = $(this).attr("data-tag")
   var value = $(this).val()
   // $.alert("Changes " + tag + " Value " + value + " Staff " + staffId);
   $.post("hrSql.php", {
    id_name: "staff_id",
    id: staffId,
    tag: tag,
    value: value,
    action: "updateStaff"
   }, function(data) {
    // $.alert("List " + data);
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  });

  $(document).on('blur', '.staffQualificationForm', function() {
   var staffId = $("#staffIdHidden").val()
   var qId = $('#sel_qual').val()
   var tag = $(this).attr("data-tag")
   var value = $(this).val()
   // $.alert("Changes " + tag + " Value " + value + " Staff " + staffId + "q" + qId);
   if (qId === null) {
    $.alert("Select a Qualification first" + qId);
   } else {
    $.post("hrSql.php", {
     id_name: "qualification_id",
     id: qId,
     staff_id: staffId,
     tag: tag,
     value: value,
     action: "updateStaffQualification"
    }, function(data) {
     // $.alert(data);
    }, "text").fail(function() {
     $.alert("fail in place of error");
    })
   }
  });

  $(document).on('click', '.editStaff', function() {
   $('#accordionStaff').show();
   var id = $(this).attr("data-staff");
   $('#staffIdHidden').val(id);
   staffQualificationList(id);
   $.post("hrSql.php", {
    staffId: id,
    action: "fetchStaff"
   }, () => {}, "json").done(function(data) {
    // $.alert("hello" + data.staff_name);
    $("#sEmail").val(data.staff_email);
    $("#sName").val(data.staff_name);
    $("#sMobile").val(data.staff_mobile);
    $("#sDob").val(data.staff_dob);
    $("#fName").val(data.staff_fname);
    $("#mName").val(data.staff_mname);
    $("#sAdhaar").val(data.staff_adhaar);
    $("#sAddress").val(data.staff_address);
    $("#sGender").val(data.staff_gender);
    $("#sTeaching").val(data.staff_teaching);
    $("#sDoj").val(data.staff_doj);
    $("#staff_title").text(data.staff_name);
    $(".staff_email").text(data.staff_email);
    $(".staff_name").text(data.staff_name);
    $(".staff_mobile").text(data.staff_mobile);
    $(".staff_doj").text(data.staff_doj);
    $('.staffProfile').show();


   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  });

  $(document).on('click', '.staff_idE', function() {
   var id = $(this).attr('id');
   //  $.alert("Id " + id);
   $.post("hrSql.php", {
    action: "fetchStaff",
    staffId: id
   }, () => {}, "json").done(function(data) {
    // $.alert("List ");
    $('#modal_title').text("Update Staff  [" + id + "]");
    $("#sName").val(data.staff_name);
    var desig = data.designation_id;
    $("#sel_desig option[value='" + desig + "']").attr("selected", "selected");
    $("#sEmail").val(data.staff_email);
    $("#sMobile").val(data.staff_mobile);
    $("#action").val("updateStaff");
    $('#modalId').val(id);
    $('#firstModal').modal('show');
    $(".staffDetailForm").hide();
    $(".staffForm").show();
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  });

  $(document).on('click', '.staff_idDetails', function() {
   var id = $(this).attr('id');
   // $.alert("id" + id);
   $.post("hrSql.php", {
     studentId: id,
     action: "fetchStaffDetails"
    }, function(data, status) {
     // $.alert("data " + data)
    },
    "json").done(function(data) {
    $("#fName").val(data.sd_fname);
    $("#mName").val(data.sd_mname);
    $("#sDob").val(data.sd_dob);
   }).fail(function() {
    $.alert("fail in place of error");
   })
   $('#modal_title').text("Add Staff Details");
   $('#firstModal').modal('show');
   $(".staffDetailForm").show();
   $(".staffForm").hide();
   $('#modalId').val(id);
   $('#action').val("addDetails");
  });

  $(document).on('click', '.stq_idView', function() {
   var id = $(this).attr('id');
   $.alert("id" + id);
   $('#stqIdM').val(id);
   $("#viewModal").modal('show');
  });

  $(document).on('click', '.stq_idUpload', function() {
   var id = $(this).attr('id');
   //$.alert("id" + id);
   $('#stqIdM').val(id);
   $("#uploadModal").modal('show');
  });

  $(document).on('submit', '#uploadModalForm', function(event) {
   event.preventDefault();
   var formData = $(this).serialize();
   //$.alert(formData);
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

  $(document).on('click', '.addStaffQualification', function() {
   $('#modal_title').text("Add Staff Qualifications");
   $('#firstModal').modal('show');
   var stfId = $('#panelId').val();
   $('#stfIdModal').val(stfId);
   $('.studentForm').hide();
   $('.selectPanel').show();
   $(".staffDetailForm").hide();
   $(".staffForm").hide();
   $('#action').val("addStaffQualification");
  });

  $(document).on('click', '.stq_idE', function() {
   var id = $(this).attr('id');
   $('#stqIdHidden').val(id);
   var stfId = $('#panelId').val();
   //  $.alert("Id " + id + "std" + stdId);
   $.post("hrSql.php", {
    action: "fetchStaffQualification",
    stqId: id,
    stf_id: stfId
   }, () => {}, "json").done(function(data) {
    // $.alert("List " + data.student_id + "sq " + data.qualification_id);
    $("#sInst").val(data.stq_institute);
    $("#sBoard").val(data.stq_board);
    $("#sYear").val(data.stq_year);
    $("#sMarksObt").val(data.stq_marksObtained);
    $("#sMaxMarks").val(data.stq_marksMax);
    $("#sCgpa").val(data.stq_percentage);
    $("#modalId").val(id);
    $("#action").val("updateStaffQualification");
    var qual = data.qualification_id;
    $("#sel_qual option[value='" + qual + "']").attr("selected", "selected");
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  });

  $(document).on('submit', '#modalForm', function(event) {
   event.preventDefault(this);
   var action = $("#action").val();
   var selDept = $("#sel_dept").val();
   var sName = $("#sName").val();
   var stfId = $("#panelId").val();


   var error = "NO";
   var error_msg = "";
   if (action == "addStaff" || action == "updateStaff") {
    if ($('#sName').val() === "") {
     error = "YES";
     error_msg = "Staff Name cannot be blank";
    }
   }

   if (error == "NO") {
    var formData = $(this).serialize();
    $('#firstModal').modal('hide');
    alert(" Pressed" + formData);
    $.post("hrSql.php", formData, () => {}, "text").done(function(data) {
     $.alert("List Updtaed" + data);
     if (action == "addStaff" || action == "updateStaff") {
      staffList();
     }
     if (action == "addStaffQualification" || action == "updateStaffQualification") {
      staffQualificationList(stfId);
     }
     $("#modalForm")[0].reset();
    }, "text").fail(function() {
     $.alert("fail in place of error");
    })
   } else {
    $.alert(error_msg);
   }
  });

  function staffList() {
   $.post("hrSql.php", {
    action: "staffList"
   }, function(mydata, mystatus) {
    $("#staffList").show();
    //	alert("List ");
    $("#staffList").html(mydata);
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  }

  function staffQualificationList(x) {
   // $.alert("In List Function" + x);
   $.post("hrSql.php", {
    action: "staffQualificationList",
    stfId: x
   }, function(mydata, mystatus) {
    $("#qualificationShowList").show();
    // $.alert("List qulai" + mydata);

    $("#qualificationShowList").html(mydata);
   }, "text").fail(function() {
    $.alert("Error !!");
   })

  }
 });
</script>

<div class="modal" id="firstModal">
 <div class="modal-dialog modal-md">
  <form class="form-horizontal" id="modalForm">
   <div class="modal-content">

    <!-- Modal body -->
    <div class="modal-body">
     <div class="staffForm">
      <div class="row">
       <div class="col-12 text-center">
        <h4 class="modal-title" id="modal_title"></h4>
       </div>
      </div>
      <div class="row">
       <div class="col-6">
        <div class="form-group">
         Staff Name
         <input type="text" class="form-control form-control-sm" id="sName" name="sName" placeholder="Staff Name">
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
         Date of Joining
         <input type="date" class="form-control form-control-sm" id="sDoj" name="sDoj" placeholder="Date of Joining">
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-6">
        <div class="form-group">
         Email
         <input type="text" class="form-control form-control-sm" id="sEmail" name="sEmail" placeholder="Staff Email Id">
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
         Mobile Number
         <input type="text" class="form-control form-control-sm" id="sMobile" name="sMobile" placeholder="Staff Mobile Number">
        </div>
       </div>
      </div>
     </div>
     <input type="hidden" id="modalId" name="modalId">
     <input type="hidden" id="action" name="action">
     <input type="hidden" id="deptIdModal" name="deptIdModal">
     <input type="hidden" id="stfIdModal" name="stfIdModal">
     <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
     <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
    </div> <!-- Modal Footer Closed-->
   </div> <!-- Modal Conent Closed-->
  </form>
 </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="uploadModal">
 <div class="modal-dialog modal-md">
  <form class="form-horizontal" id="uploadModalForm">
   <div class="modal-content">

    <!-- Modal body -->
    <div class="modal-body">
     <div class="uploadForm">
      <div class="row">
       <div class="col-12">
        <h4 class="modal-title text-primary pb-2">Upload Document</h4>
        </hr>
       </div>
      </div>
      <div class="row">
       <div class="col-12">
        <div class="form-group">
         <input type="file" name="upload_file">
        </div>
       </div>
      </div>
     </div>
     <input type="hidden" name="action" value="upload">
     <input type="hidden" id="stqIdM" name="stqIdM">
     <button type="submit" class="btn btn-success btn-sm">Submit</button>
     <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
    </div> <!-- Modal Footer Closed-->
   </div> <!-- Modal Conent Closed-->
  </form>
 </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="viewModal">
 <div class="modal-dialog modal-md">
  <form class="form-horizontal" id="viewModalForm">
   <div class="modal-content bg-secondary text-white">

    <!-- Modal Header -->
    <div class="modal-header">
     <h4 class="modal-title">Document Uploaded</h4>
     <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div> <!-- Modal Header Closed-->

    <!-- Modal body -->
    <div class="modal-body">
     <?php
     $stq_id = $_POST['stqIdM'];
     $sql = "select stq.* from staff_qualification stq where stq.stq_id='$stq_id'";
     $conn->query($sql);
     $folder = '../../' . $myFolder . '/qualification';
     $file = $folder . '/' . $stq_id;
     ?>
     <embed src="<?php echo $file; ?>" width="100%" height="600" alt=”pdf” pluginspage=”http://www.adobe.com/products/acrobat/readstep2.html”></embed>
    </div> <!-- Modal Body Closed-->
    <!-- Modal footer -->
    <div class="modal-footer">
     <input type="hidden" name="action" value="view">
     <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
    </div> <!-- Modal Footer Closed-->
   </div> <!-- Modal Conent Closed-->
  </form>
 </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>