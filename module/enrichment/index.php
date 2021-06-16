<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <title>Outcome Based Education : ClassConnect</title>
 <?php require('../css.php'); ?>

</head>

<body>
 <?php require("../topBar.php"); ?>

 <div class="container-fluid moduleBody">
  <div class="row">
   <div class="col-sm-2">
    <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
     <a class="list-group-item list-group-item-action active rp" id="list-rp-list" data-toggle="list" href="#list-rp" role="tab" aria-controls="rp"> Resource Person </a>
     <a class="list-group-item list-group-item-action org" id="list-org-list" data-toggle="list" href="#list-org" role="tab" aria-controls="org"> Organization </a>
     <a class="list-group-item list-group-item-action cce" id="list-cce-list" data-toggle="list" href="#list-cce" role="tab" aria-controls="cce"> Co-curricular Activity </a>

     <a class="list-group-item list-group-item-action po" id="list-po-list" data-toggle="list" href="#list-po" role="tab" aria-controls="po"> Collaborative Event </a>

    </div>
   </div>
   <div class="col-10">
    <div class="tab-content" id="nav-tabContent">
     <div class="tab-pane show active" id="list-rp" role="tabpanel">
      <div class="row">
       <div class="col-7 mt-1 mb-1">
        <div class="container card mt-2 myCard">
         <h5 class="card-title p-2 mb-0">Manage Resource Person Form</h5>
         <form class="form-horizontal" id="resourcePersonForm">
          <div class="row mt-2">
           <div class="col-6">
            <div class="form-group">
             <label>Name</label>
             <input type="text" class="form-control form-control-sm" id="rp_name" name="rp_name" required>
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>Designation</label>
             <input type="text" class="form-control form-control-sm" id="rp_designation" name="rp_designation" required>
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col-6">
            <div class="form-group">
             <label>Contact</label>
             <input type="text" class="form-control form-control-sm" id="rp_mobile" name="rp_mobile" placeholder="10 Digits only">
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>Email</label>
             <input type="text" class="form-control form-control-sm" id="rp_email" name="rp_email" required>
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col-6">
            <div class="form-group">
             <label>Affiliation and Address</label>
             <textarea class="form-control form-control-sm" rows="5" id="rp_address" name="rp_address" required></textarea>
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>About</label>
             <textarea class="form-control form-control-sm" rows="5" id="rp_about" name="rp_about"></textarea>
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col">
            <a class="atag basicInfoShowForm">Basic Info</a>
           </div>
           <div class="col">
            <input type="hidden" id="rpAction" name="rpAction">
            <button type="submit" class="btn btn-sm">Next</button>
           </div>
          </div>
         </form>
        </div>
       </div>
       <div class="col-5 mt-1 mb-1">
        <p id="resourcePersonList"></p>
       </div>
      </div>
     </div>
     <div class="tab-pane" id="list-org" role="tabpanel">
      <div class="row">
       <div class="col-7">
        <div class="container card mt-2 myCard">
         <h5 class="card-title p-2 mb-0">Manage Organization Form</h5>
         <form class="form-horizontal" id="organizationForm">
          <div class="row mt-2">
           <div class="col-6">
            <div class="form-group">
             <label>Organization Name</label>
             <input type="text" class="form-control form-control-sm" id="org_name" name="org_name">
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>URL</label>
             <input type="text" class="form-control form-control-sm" id="org_url" name="org_url">
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col-6">
            <div class="form-group">
             <label>Contact Number</label>
             <input type="text" class="form-control form-control-sm" id="org_mobile" name="org_mobile" placeholder="10 Digits only">
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>Email</label>
             <input type="text" class="form-control form-control-sm" id="org_email" name="org_email">
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col-6">
            <div class="form-group">
             <label>Affiliation and Address</label>
             <textarea class="form-control form-control-sm" rows="5" id="org_address" name="org_address" required></textarea>
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>About</label>
             <textarea class="form-control form-control-sm" rows="5" id="orf_about" name="org_about"></textarea>
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col">
           </div>
           <div class="col">
            <input type="hidden" id="orgAction" name="orgAction">
            <button type="submit" class="btn btn-sm">Next</button>
           </div>
          </div>
         </form>
        </div>
       </div>
       <div class="col-5 container card shadow m-0 myCard">
        <table class="table table-bordered table-striped list-table-xs mt-3" id="organList">
         <th>Org Name</th>
        </table>
       </div>
      </div>
     </div>
     <div class="tab-pane" id="list-cce" role="tabpanel">
      <div class="row">
       <div class="col-7 mt-1 mb-1">
        <div class="container card mt-2 myCard">
         <h5 class="card-title p-2 mb-0"> Co-Curricular Activity Form</h5>
         <form class="form-horizontal" id="basicInfoForm">
          <div class="row mt-2">
           <div class="col pr-1">
            <div class="form-group">
             <input type="radio" checked class="actName" id="rp" name="actName" value="rp">
             Guest Lecture
            </div>
           </div>
           <div class="col pr-1">
            <div class="form-group">
             <input type="radio" class="actName" id="org" name="actName" value="org">
             Industrial Visit
            </div>
           </div>
          </div>
          <div class="row mt-2">
           <div class="col-6">
            <div class="form-group">
             <label class="selectLabel"></label>
             <p class="selectList"></p>
            </div>
           </div>
           <div class="col-6">
            <div class="form-group">
             <label>Activity Name</label>
             <input type="text" class="form-control form-control-sm" id="cca_name" name="cca_name">
            </div>
           </div>
          </div>
          <div class="row mt-2">
           <div class="col-4 pr-1">
            <div class="form-group">
             <label>From</label>
             <input type="date" class="form-control form-control-sm" id="cca_from_date" name="cca_from_date" value="<?php echo $submit_date; ?>">
            </div>
           </div>
           <div class="col-2 pl-0">
            <div class="form-group">
             <label>&nbsp;</label>
             <input type="time" class="form-control form-control-sm" id="cca_from_time" name="cca_from_time">
            </div>
           </div>
           <div class="col-4 pr-1">
            <div class="form-group">
             <label>To</label>
             <input type="date" class="form-control form-control-sm" id="cca_to_date" name="cca_to_date" value="<?php echo $submit_date; ?>">
            </div>
           </div>
           <div class="col-2 pl-0">
            <div class="form-group">
             <label>&nbsp;</label>
             <input type="time" class="form-control form-control-sm" id="cca_to_time" name="cca_to_time">
            </div>
           </div>
          </div>
          <div class="row">
           <div class="col">
            <button type="submit" class="btn btn-sm">Next <i class="fa fa-angle-double-right"></i></button>
           </div>
          </div>
         </form>
        </div>
       </div>
       <div class="col-5 mt-1 mb-1" role="tabpanel">
        <p id="tabList"></p>
       </div>
      </div>
     </div>
     <div class="tab-pane fade show" id="list-po" role="tabpanel">fdf
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
 $(document).ready(function() {

  $('[data-toggle="tooltip"]').tooltip();
  $(".topBarTitle").text("Academics");
  $("#rpAction").val("addRP")
  $("#orgAction").val("addOrg")
  resourcePersonList();
  organizationList();
  $(".selectLabel").text("Resource Person");
  selectList("rp");


  // Resource Person Block
  $(document).on('submit', '#resourcePersonForm', function(event) {
   event.preventDefault(this);
   var formData = $(this).serialize();
   $.alert(formData);
   $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
    $.alert("List Updtaed" + data);
    resourcePersonList();
   })
  });

  function resourcePersonList(x) {
   // $.alert("In List Function" + x);
   $.post("enrichmentSql.php", {
    rpAction: "resourcePersonList"
   }, function(mydata, mystatus) {
    // $.alert("List qulai" + mydata);
    $("#resourcePersonList").html(mydata);
   }, "text").fail(function() {
    $.alert("Error !!");
   })
  }

  // Organization Block
  $(document).on('submit', '#organizationForm', function(event) {
   event.preventDefault(this);
   var formData = $(this).serialize();
   $.alert(formData);
   $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
    $.alert("List Updtaed" + data);
    organizationList();
   })
  });

  function organizationList() {
   // $.alert('hello');
   $.post("enrichmentSql.php", {
    orgAction: "orgList",
   }, () => {}, "json").done(function(data) {
    var table = '';
    // $.alert(data);
    $.each(data, function(key, value) {
     table += '<tr>';
     table += '<td>' + value.org_name + '</td>';
     table += '</tr>';
    });
    $("#organList").find("tr:gt(0)").remove()
    $("#organList").append(table);
   }).fail(function() {
    $.alert("fail in place of error");
   })
  }

  //Co cur Block
  $(document).on('click', '.actName', function(event) {
   var actName = $("input[name='actName']:checked").val();
   if (actName=='rp') $(".selectLabel").text("Resource Person");
   else $(".selectLabel").text("Organization");
   // $.alert("Pressed" + actName);

   $.post("enrichmentSql.php", {
    actName: actName,
   }, function() {}, "text").done(function(data, status) {
    // respNameList();
    selectList(actName);
    //$.alert("List " + data);
   }).fail(function() {
    $.alert("fail in place of error");
   })
  });

  function selectList(tag) {
   //$.alert("In List Function");
   // if (tag == "department") tag = "dept";
   $.post("enrichmentSql.php", {
    tag: tag,
    action: "selectList"
   }, function() {}, "text").done(function(data, status) {
    //$.alert(data);
    $(".selectList").html(data);
   }).fail(function() {
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

</html>