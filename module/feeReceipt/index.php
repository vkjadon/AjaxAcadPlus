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
    </div>
    <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
     <a class="list-group-item list-group-item-action fr" id="list-fr-list" data-toggle="list" href="#list-fr" role="tab" aria-controls="fr">Fee Receipt</a>
    </div>
   </div>
   <div class="col-10 leftLinkBody">
    <div class="tab-content" id="nav-tabContent">
     <div class="tab-pane show active" id="list-fr" role="tabpanel" aria-labelledby="list-fr-list">
      <div class="row">
       <div class="col-3">
        <div class="card border-info mt-2">
         <div class="card-header">
          ENTER USER ID TO SEARCH
         </div>
         <div class="card-body text-primary">
          <input name="studentSearch" id="studentSearch" class="form-control my-0 py-1 red-border" type="text" placeholder="Search Student" aria-label="Search">
          <button type="button" class="btn btn-primary" id="searchStudent">
           <i class="fas fa-search"></i>
          </button>
         </div>
        </div>
       </div>
       <div class="col-3">
        <div class="card border-info mt-2">
         <div class="card-header">
          ENTER NAME TO SEARCH
         </div>
         <div class="card-body text-primary">
          <input name="studentNameSearch" id="studentNameSearch" class="form-control my-0 py-1 red-border" type="text" placeholder="Search Student" aria-label="Search">
          <button type="button" class="btn btn-primary" id="studentNameSearchBtn">
           <i class="fas fa-search"></i>
          </button>
         </div>
        </div>
       </div>
       <div class="col-6">
        <div class="container card mt-2 myCard">
         <div class="row p-1">
          <div class="col-3 m-0 p-0">
           <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="100">
          </div>
          <div class="col-9 m-0 p-0">
           <div class="row p-1">
            <div class="col-3 m-0 p-0">
             <h7 class="mb-0 ">Name</h7>
            </div>
            <div class="col-9 text-secondary student_name">
             Enter Valid Data
            </div>
           </div>
           <div class="row p-1">
            <div class="col-3 m-0 p-0">
             <h7 class="mb-0 ">Roll Number</h7>
            </div>
            <div class="col-9 text-secondary student_rollno">
             Enter Valid Data
            </div>
           </div>
           <div class="row p-1">
            <div class="col-3 m-0 p-0">
             <h7 class="mb-0 ">Mobile</h7>
            </div>
            <div class="col-9 text-secondary student_mobile">
             Enter Valid Data
            </div>
           </div>
           <div class="row p-1">
            <div class="col-3 m-0 p-0">
             <h7 class="mb-0 ">Program</h7>
            </div>
            <div class="col-9 text-secondary student_program">
             Enter Valid Data
            </div>
           </div>
           <div class="row p-1">
            <div class="col-3 m-0 p-0">
             <h7 class="mb-0 ">Batch</h7>
            </div>
            <div class="col-9 text-secondary student_batch">
             Enter Valid Data
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-6">
        <div class="container card mt-2 myCard">
         <!-- nav options -->
         <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
          <li class="nav-item">
           <a class="nav-link active" id="pills_tablePersonalInfo" data-toggle="pill" href="#pills_personalInfo" role="tab" aria-controls="pills_personalInfo" aria-selected="true">Fee Details</a>
          </li>
         </ul>
         <div class="tab-content" id="pills-tabContent p-3">
          <!-- <h4> New Id <span class="newId"> - Not Created </span></h4> -->
          <div class="tab-pane fade show active" id="pills_personalInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
           <input type="hidden" id="studentIdHidden" name="studentIdHidden">
           <div class="row">
            <div class="col-12">
             <div class="row">
              <div class="col-4 pr-1">
               <div class="form-group">
                <label>Type</label>
                <p id="feeType"></p>
               </div>
              </div>
              <div class="col-4 pr-1 pl-1">
               <div class="form-group">
                <label>Mode</label>
                <p id="feeMode"></p>
               </div>
              </div>
              <div class="col-4 pl-1">
               <div class="form-group">
                <label>Semester</label>
                <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-4 pr-1">
               <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control form-control-sm" id="feeAmount" name="feeAmount" placeholder="" data-tag="fee_amount">
               </div>
              </div>
              <div class="col-4 pr-1 pl-1">
               <div class="form-group">
                <label>Transaction ID</label>
                <input type="number" class="form-control form-control-sm" id="tId" name="tId" placeholder="Transaction ID" data-tag="transaction_id">
               </div>
              </div>
              <div class="col-4 pl-1">
               <div class="form-group">
                <label>Deposit Date</label>
                <input type="date" class="form-control form-control-sm" id="feeDate" name="feeDate" placeholder="" data-tag="feeDate">
               </div>
              </div>
             </div>
             <div class="row">
              <div class="col-12">
               <div class="form-group">
                <label>Description</label>
                <textarea class="form-control form-control-sm" id="fee_desc" name="fee_desc" rows="3" data-tag="fee_description"></textarea>
               </div>
              </div>
             </div>
             <input type="hidden" id="action" name="action" value="addFeeReceipt">
             <button class="btn btn-sm" id="addFeeReceipt">Generate</button>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>
       <div class="col-6">
        <div class="container card mt-2 myCard" id="print" style="overflow: scroll;">
         <table class="table table-bordered table-striped list-table-xs mt-3" id="feeReceiptList">
          <th class="text-center"><i class="fa fa-trash"></i></th>
          <th class="text-center">Fee Receipt ID</th>
          <th class="text-center">Mode</th>
          <th class="text-center">Fee Type</th>
          <th class="text-center">Amount</th>
          <th class="text-center"><i class="fa fa-print"></i></th>
         </table>
        </div>
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
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <?php require("../bottom_bar.php"); ?>
 </div>
</body>
<?php require("../js.php"); ?>


<script>
 $(document).ready(function() {

  feeType();
  feeMode();
  $(document).on('click', '#searchStudent', function(event) {
   var data = $("#studentSearch").val();
   $.alert(data);
   $.post("feeReceiptSql.php", {
    action: "fetchStudent",
    userId: data,
   }, () => {}, "json").done(function(data) {
    $(".student_name").text(data.student_name);
    $(".student_rollno").text(data.student_rollno);
    $(".student_mobile").text(data.student_mobile);
    $(".student_batch").text(data.batch);
    $(".student_program").text(data.program_name);
    $("#studentIdHidden").val(data.student_id);
    feeReceiptList();
    // $.alert(data);
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  });

  $(document).on('click', '#addFeeReceipt', function(event) {
   var studentId = $("#studentIdHidden").val();
   var feeType = $("#sel_ft").val();
   var feeMode = $("#sel_fm").val();
   var sem = $("#semester").val();
   var feeAmount = $("#feeAmount").val();
   var tId = $("#tId").val();
   var feeDesc = $("#fee_desc").val();
   var feeDate = $("#feeDate").val();

   // $.alert(feeAmount);
   $.post("feeReceiptSql.php", {
    id: studentId,
    feeType: feeType,
    feeMode: feeMode,
    sem: sem,
    feeAmount: feeAmount,
    tId: tId,
    feeDesc: feeDesc,
    feeDate: feeDate,
    action: "addFeeReceipt"
   }, function(data) {
    $.alert("List " + data);
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })

  });

  function feeReceiptList() {
   // $.alert("Batch");
   $.post("feeReceiptSql.php", {
    action: "feeReceiptList"
   }, function() {}, "json").done(function(data, status) {
    // $.alert(data);
    // console.log(data);
    var card = '';
    $.each(data, function(key, value) {
     card += '<tr>';
     card += '<td class="text-center"><a href="#" class="dropFeeReceipt" data-fee="' + value.fr_id + '"><i class="fas fa-trash"></i></a></td>';
     card += '<td class="text-center">' + value.fr_id + '</td>';
     card += '<td class="text-center">' + value.fee_mode + '</td>';
     card += '<td class="text-center">' + value.fee_type + '</td>';
     card += '<td class="text-center">' + value.fee_amount + '</td>';
     card += '<td class="text-center"><a href="#" class="printFeeReceipt" data-fee="' + value.fr_id + '"><i class="fas fa-print"></i></a></td>';
     card += '</tr>';
    });
    $("#feeReceiptList").find("tr:gt(0)").remove();
    $("#feeReceiptList").append(card);

   }).fail(function() {
    $.alert("Error !!");
   })

  }

  function feeType() {
   // $.alert("Department ");
   $.post("feeReceiptSql.php", {
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

  function feeMode() {
   // $.alert("Department ");
   $.post("feeReceiptSql.php", {
    action: "feeMode"
   }, function() {}, "json").done(function(data, status) {
    // $.alert(data);
    var list = '';
    list += '<select class="form-control form-control-sm" name="sel_fm" id="sel_fm" required>';
    $.each(data, function(key, value) {
     list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
    });
    list += '</select>';
    $("#feeMode").html(list);

   }).fail(function() {
    $.alert("Error !!");
   })
  }
 });
</script>

</html>