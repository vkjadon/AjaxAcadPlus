<?php
require('../requireSubModule.php');
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
 </style>

</head>

<body>

 <?php require("../topBar.php"); ?>
 <div class="container-fluid">
  <div class="row">
   <div class="col-2">
    <?php
    $url = $setUrl . '/acadplus/api/check_dept_head.php?u=' . $myUn . '&&p=' . $myPwd;
    $dept_head = check_dept_head($url);
    //echo $dept_head;
    ?>
    <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
     <a class="list-group-item list-group-item-action active il" id="list-il-list" data-toggle="list" href="#list-il" role="tab" aria-controls="il">Institute Locations</a>
    </div>
   </div>

   <div class="col-10">
    <div class="tab-content" id="nav-tabContent">
     <div class="tab-pane show active" id="list-il" role="tabpanel" aria-labelledby="list-il-list">
      <div class="row">
       <div class="col-4">
        <div class="mt-1 mb-1">
        <button class="btn btn-primary btn-sm mt-1 addLocation">New Location</button>
        <button class="btn btn-secondary btn-sm mt-1 uploadLocation">Upload Locations</button>
         <p id="locationShowList"></p>
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


</body>

<?php require("../js.php"); ?>


<script>
 $(document).ready(function() {
  $(".topBarTitle").text("Institution");
  locationList();

  $(document).on('click', '.il', function() {

  });

  $(document).on('click', '.addLocation', function() {
   $('#modal_title').text("Add Location");
   $('#action').val("addLocation");
   $('#firstModal').modal('show');
   $('.locationForm').show();
  });

  $(document).on('click', '.editLocation', function() {
   var id = $(this).attr("data-loc");
   // $.alert("Id " + id);

   $.post("infraSql.php", {
    locationId: id,
    action: "fetchLocation"
   }, () => {}, "json").done(function(data) {
    //$.alert("List " + data.inst_name);
    $('#modal_title').text("Update Location [" + id + "]");
    $('#loc_name').val(data.location_name);
    $('#loc_code').val(data.location_code);
    $('#loc_rows').val(data.location_rows);
    $('#loc_cols').val(data.location_columns);
    $('#loc_type').val(data.location_type);
    $('#loc_cap').val(data.location_capacity);
    $('#loc_floor').val(data.location_floor);
    $('#action').val("updateLocation");
    $('#locationIdHidden').val(id);
    $('#firstModal').modal('show');
    $('.locationForm').show();
   }, "text").fail(function() {
    $.alert("fail in place of error");
   })
  });

  $(document).on('submit', '#modalForm', function(event) {
   event.preventDefault(this);
   var x = $("#loc_code").val();
   var y = $("#loc_name").val();
   // $.alert("x"+x+"y"+y);
   if (x === " " && y === " " && (action == "addLocation" || action == "updateLocation")) $.alert("Location Name cannot be blank!!");
   else {
    var formData = $(this).serialize();
    $('#firstModal').modal('hide');
    // $.alert(x + " Pressed" + action);
    $.post("infraSql.php", formData, () => {}, "text").done(function(data) {
     $.alert("List " + data);
     if (action == "addLocation" || action == "updateLocation") locationList();
     $('#modalForm')[0].reset();
    }, "text").fail(function() {
     $.alert("fail in place of error");
    })
   }
  });

  function locationList() {
   // $.alert("In List Function");
   $.post("infraSql.php", {
    action: "locationList"
   }, function(mydata, mystatus) {
    $("#locationShowList").show();
    // $.alert("List " + mydata);
    $("#locationShowList").html(mydata);
   }, "text").fail(function() {
    $.alert("Error !!");
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
     <div class="locationForm">
      <div class="row">
       <div class="col-6">
        <div class="form-group">
         Location Name
         <input type="text" class="form-control form-control-sm" id="loc_name" name="loc_name" placeholder="location Name">
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
         Location Code
         <input type="text" class="form-control form-control-sm" id="loc_code" name="loc_code" placeholder="Location Code">
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-6">
        <div class="form-group">
         Capacity
         <input type="text" class="form-control form-control-sm" id="loc_cap" name="loc_cap" placeholder="Location Capacity">
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
         Floor
         <input type="text" class="form-control form-control-sm" id="loc_floor" name="loc_floor" placeholder="Location Floor">
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-6">
        <div class="form-group">
         Columns
         <input type="text" class="form-control form-control-sm" id="loc_cols" name="loc_cols" placeholder="Location Columns">
        </div>
       </div>
       <div class="col-6">
        <div class="form-group">
         Rows
         <input type="text" class="form-control form-control-sm" id="loc_rows" name="loc_rows" placeholder="Location Rows">
        </div>
       </div>
      </div>
     <div class="row">
      <div class="col-6">
       <div class="form-group">
        Location Type
        <div class="form-check">
         <input type="checkbox" class="form-check-input filled-in" id="examHall">
         <label class="form-check-label small text-uppercase card-link-secondary" for="examHall">Exam Hall</label>
        </div>
        <div class="form-check">
         <input type="checkbox" class="form-check-input filled-in" id="lectureHall">
         <label class="form-check-label small text-uppercase card-link-secondary" for="lectureHall">Lecture Hall</label>
        </div>
        <div class="form-check">
         <input type="checkbox" class="form-check-input filled-in" id="lab">
         <label class="form-check-label small text-uppercase card-link-secondary" for="lab">Laboratory</label>
        </div>
       </div>
      </div>

     </div>
    </div>
   </div> <!-- Modal Body Closed-->

   <!-- Modal footer -->
   <div class="modal-footer">
    <input type="hidden" id="modalId" name="modalId">
    <input type="hidden" id="action" name="action">
    <input type="hidden" id="locationIdHidden" name="locationIdHidden">
    <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
   </div> <!-- Modal Footer Closed-->
 </div> <!-- Modal Conent Closed-->

 </form>
</div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->


</html>