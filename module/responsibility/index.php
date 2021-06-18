<?php
require('../requireSubModule.php');

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="responsibility.css">

<head>
 <title>Admin Login : ClassConnect</title>
 <?php
 require("../css.php");
 ?>


</head>

<body>
 <?php require("../topBar.php"); ?>

 <div class="container-fluid moduleBody">
  <div class="row">
  <div class="col-2 p-0 m-0 pl-2 full-height">
    <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
     <a class="list-group-item list-group-item-action active r" id="list-r-list" data-toggle="list" href="#list-r" role="tab" aria-controls="lt">Responsibility</a>
    </div>
   </div>

   <div class="col-10 leftLinkBody">
    <div class="tab-content" id="nav-tabContent">

     <div class="tab-pane fade show active" id="list-r" role="tabpanel" aria-labelledby="list-r-list">
      <div class="row">
       <div class="col-8">
        <div class="container card shadow d-flex justify-content-center mt-2" id="card_responsibility">
         <!-- nav options -->
         <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
          <li class="nav-item">
           <a class="nav-link active" id="pills_deptHead" data-toggle="pill" href="#pills_head" role="tab" aria-controls="pills_head" aria-selected="true">Department Head</a>
          </li>
          <li class="nav-item">
           <a class="nav-link" id="pills_programIncharge" data-toggle="pill" href="#pills_programIncharge" role="tab" aria-controls="pills_programIncharge" aria-selected="false">Program In-charge</a>
          </li>
          <li class="nav-item">
           <a class="nav-link" id="pills_classIncharge" data-toggle="pill" href="#pills_incharge" role="tab" aria-controls="pills_incharge" aria-selected="false">Class Incharge</a>
          </li>
          <li class="nav-item">
           <a class="nav-link" id="pills_academicAssistant" data-toggle="pill" href="#pills_assistant" role="tab" aria-controls="pills_assistant" aria-selected="false">Academic Assistant</a>
          </li>
          <li class="nav-item">
           <a class="nav-link" id="pills_subjectCoordinator" data-toggle="pill" href="#pills_subjectCoordinator" role="tab" aria-controls="pills_subjectCoordinator" aria-selected="false">Subject Coordinator</a>
          </li>
          
         </ul>
         <div class="tab-content" id="pills-tabContent p-3">
          <div class="tab-pane fade show active" id="pills_head" role="tabpanel" aria-labelledby="pills_deptHead">
           <form class="form-horizontal" id="addLeaveSetup">
            <div class="form-group">
             <div class="row">
              <div class="col-6">
               <?php
               $sql_dh = "select * from department where dept_status='0'";
               $result = $conn->query($sql_dh);
               if ($result) {
                echo '<select class="form-control form-control-sm" name="sql_dh" id="sql_dh" required>';
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
              <div class="col-6">
               <?php
               $sql_staff = "select * from staff where staff_status='0'";
               $result = $conn->query($sql_staff);
               if ($result) {
                echo '<select class="form-control form-control-sm" name="sql_staff" id="sql_staff" required>';
                echo '<option selected disabled>Select Staff</option>';
                while ($rows = $result->fetch_assoc()) {
                 $select_id = $rows['staff_id'];
                 $select_name = $rows['staff_name'];
                 echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                }
                echo '</select>';
               } else echo $conn->error;
               if ($result->num_rows == 0) echo 'No Data Found';
               ?>
              </div>
             </div>
            </div>
           </form>
          </div>
          <div class="tab-pane fade" id="pills_incharge" role="tabpanel" aria-labelledby="pills_classIncharge">

          </div>
          <div class="tab-pane fade" id="pills_assistant" role="tabpanel" aria-labelledby="pills_academicAssistant">


          </div>
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
  var un = "<?php echo $myUn; ?>";
  $('.leaveList').hide();
  ccfList();
  $('#action').val("add");


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

  function GetMonthName(monthNumber) {
   var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
   return months[monthNumber - 1];
  }

 });
</script>



</html>