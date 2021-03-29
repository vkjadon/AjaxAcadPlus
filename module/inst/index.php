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
 </style>

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

   <div class="col-10">
    <div class="tab-content" id="nav-tabContent">
     <div class="tab-pane fade show active" id="list-si" role="tabpanel" aria-labelledby="list-si-list">
      <div class="row">
       <div class="col-4">
        <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addInst">New</button>
         <p id="instShowList"></p>
        </div>
       </div>
       <div class="col-8">
        <div class="container">
         <!-- For demo purpose -->
         <div class="row">
          <div class="col-lg-12 mx-auto">
           <!-- Accordion -->
           <div id="accordionInfo" class="accordion shadow">

            <div class="card">
             <div id="headingOne" class="card-header bg-white shadow-sm border-0">
              <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Basic Information</a></h6>
             </div>
             <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionInfo" class="collapse show">
              <div class="card-body">
               <form class="text w-100 p-0" id="basicInfoForm">
                <p>Name and Address of the University</p>
                <div class="row">
                 <div class="col-12">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instName" class="form-control">
                    <label for="instName">Instituton Name</label>
                   </div>
                  </div>
                 </div>
                </div>
                <div class="row">
                 <div class="col-12">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <textarea id="instAddress" class="md-textarea form-control" rows="3"></textarea>
                    <label for="instAddress">Address</label>
                   </div>
                  </div>
                 </div>
                </div>
                <div class="row">
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instCity" class="form-control">
                    <label for="instCity">City</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instPIN" class="form-control">
                    <label for="instPIN">PIN Code</label>
                   </div>
                  </div>
                 </div>
                </div>
                <div class="row">
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instState" class="form-control">
                    <label for="instState">State</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instWebsite" class="form-control">
                    <label for="instWebsite">Website</label>
                   </div>
                  </div>
                 </div>
                </div>
                <p>Nature of University</p>
                <div class="row">
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instStatus" class="form-control">
                    <label for="instStatus">Institution Status</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instType" class="form-control">
                    <label for="instType">Type of University</label>
                   </div>
                  </div>
                 </div>
                </div>
                <p>Establishment Details</p>
                <div class="row">
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="date" id="instEstDateUni" class="form-control">
                    <label for="instEstDateUni">Establishment Date of the University</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="date" id="instEstDate" class="form-control">
                    <label for="instEstDate">Establishment Date</label>
                   </div>
                  </div>
                 </div>
                </div>
                <div class="row">
                 <div class="col-12">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="instStatusEst" class="form-control">
                    <label for="instStatusEst">Status Prior to Establishment</label>
                   </div>
                  </div>
                 </div>
                </div>
                <p class="m-0">Recognition Details</p>
                <p>Date of Recognition as a University by UGC or Any Other National Agency</p>
                <div class="row">
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="date" id="underSection2f" class="form-control">
                    <label for="underSection2f">Under Section 2f of UGC</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="date" id="underSection12b" class="form-control">
                    <label for="underSection12b">Under Section 12B of UGC</label>
                   </div>
                  </div>
                 </div>
                </div>
                <p>Is the University Recognised as a 'University with Potential for Excellence Yes No (UPE)' by the UGC?</p>
                <div class="custom-control custom-radio">
                 <input type="radio" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios">
                 <label class="custom-control-label" for="defaultUnchecked">Yes</label>
                </div>

                <div class="custom-control custom-radio">
                 <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios" checked>
                 <label class="custom-control-label" for="defaultChecked">No</label>
                </div>
               </form>
              </div>
             </div>
            </div>
            <div class="card">
             <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
              <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Geographical Information</a></h6>
             </div>
             <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionInfo" class="collapse">
              <div class="card-body">
               <form class="text w-100 p-0" id="basicInfoForm">
                <p>Location, Area and Activity of Campus</p>
                <div class="row">
                 <div class="col-12">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <textarea id="instAddress" class="md-textarea form-control" rows="3"></textarea>
                    <label for="instAddress">Address</label>
                   </div>
                  </div>
                 </div>
                </div>
                <div class="row">
                 <div class="col-4">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="campusType" class="form-control">
                    <label for="campusType">Campus Type</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-4">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="campusArea" class="form-control">
                    <label for="campusArea">Campus Area in acres</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-4">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="campusBuiltupArea" class="form-control">
                    <label for="campusBuiltupArea">BuiltUp Area in sq.mts.</label>
                   </div>
                  </div>
                 </div>
                </div>
                <div class="row">
                 <div class="col-3">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="text" id="campusProgrammes" class="form-control">
                    <label for="campusProgrammes">Programmes Offered</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-3">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="date" id="campusDate" class="form-control">
                    <label for="campusDate">Date of Establishment</label>
                   </div>
                  </div>
                 </div>
                 <div class="col-6">
                  <div class="form-group">
                   <div class="md-form md-outline m-0">
                    <input type="date" id="Date" class="form-control">
                    <label for="Date">Date of Recognition by UGC/MHRD</label>
                   </div>
                  </div>
                 </div>
                </div>
                <p>Location</p>
                <div class="row">
                 <div class="col-2">
                  <div class="custom-control custom-radio">
                   <input type="radio" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios">
                   <label class="custom-control-label" for="defaultUnchecked">Urban</label>
                  </div>
                 </div>
                 <div class="col-2">
                  <div class="custom-control custom-radio">
                   <input type="radio" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios">
                   <label class="custom-control-label" for="defaultUnchecked">Rural</label>
                  </div>
                 </div>
                 <div class="col-2">
                  <div class="custom-control custom-radio">
                   <input type="radio" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios">
                   <label class="custom-control-label" for="defaultUnchecked">Tribal</label>
                  </div>
                 </div>
                 <div class="col-2">
                  <div class="custom-control custom-radio">
                   <input type="radio" class="custom-control-input" id="defaultUnchecked" name="defaultExampleRadios">
                   <label class="custom-control-label" for="defaultUnchecked">Hill</label>
                  </div>
                 </div>
                 <div class="col-4">
                  <div class="custom-control custom-radio">
                   <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios" checked>
                   <label class="custom-control-label" for="defaultChecked">Semi Urban</label>
                  </div>
                 </div>
                </div>
               </form>
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

     <div class="tab-pane fade" id="list-mis" role="tabpanel" aria-labelledby="list-mis-list">
      <div class="row">
       <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addSchool">New</button>
        <p id="schoolShowList"></p>
       </div>
      </div>
     </div>

     <div class="tab-pane fade " id="list-mid" role="tabpanel" aria-labelledby="list-mid-list">
      <div class="row">
       <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addDept">New</button>
        <p id="deptShowList"></p>
       </div>
      </div>
     </div>

     <div class="tab-pane fade " id="list-mip" role="tabpanel" aria-labelledby="list-mip-list">
      <div class="row">
       <div class="mt-1 mb-1"><button class="btn btn-secondary btn-sm mt-1 addProgram">New</button>
        <p id="programShowList"></p>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>



</body>

<?php require("../js.php"); ?>


<script>
 $(document).ready(function() {
  $(".topBarTitle").text("Institution");
  instList();
  $('.selectPanel').hide();
  $('#accordionInfo').hide();


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
   $('#accordionInfo').show();
   var id = $(this).attr("data-inst");
   $.post("instSql.php", {
    instId: id,
    action: "fetchInst"
   }, () => {}, "json").done(function(data) {
    $('#instName').val(data.inst_name);
    $('#instWebsite').val(data.inst_url);
    $('#instAddress').val(data.inst_address);
    $('#inst_doi').val(data.inst_doi);
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
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