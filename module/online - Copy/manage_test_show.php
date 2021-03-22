<?php 
    session_start();
//  manage_test.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Class Connect LMS </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
include('../config_database.php');
include('index_menu.php');
$id=$_GET['id'];
$card=array("primary", "danger", "warning", "success", "light", "dark", "secondary", "info");
?>
<div class="container-fluid">
<?php  
  $sql="select * from tests where sha1(test_id)='$id'";
  $result=$conn->query($sql); 
  while($row=$result->fetch_assoc())  
  {  
    $test_id=$row["test_id"];
    $test_name=$row["test_name"];
    $test_section=$row["test_section"];
    echo '<h4>'.$test_name;
    for($i=0; $i<$test_section; $i++)
    {
      $section=$i+1;
?>
      <button class="btn btn-light btn-sm select_section" data-section="<?=($i+1);?>" data-test="<?=$test_id;?>">Section - <?=$section;?></button>
<?php
    }
    echo '</h4>';
  }
  $sql="select * from test_questions where test_id='$test_id' and test_section='$section'";
  $result_tq=$conn->query($sql);
  $rows_count=$result_tq->num_rows;
  //echo $rows_count;
?>
    <div class="card border-primary mb-1" style="width:100%">
      <div class="card-header">
        <span id="section"></span>
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
          <span id="list">Select Section Number from the above Panel to Proceed.</span>
        </div>
      </div>
      <div class="card-body">
          <p class="card-text" id="question">Select Question Number from the above Panel to Show Question.</p>
      </div>
    </div>
  </div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>

$(document).ready(function()
{  
  $(document).on('click', '.select_section', function(){
    var test_id = $(this).attr('data-test');
    var test_section = $(this).attr('data-section');
    $("#question").html("Select the Question Number from the above Panel to Show Question.");  
    //alert("Action " + test_id + test_section + "");     
    $.post("fetch_section_questions.php", 
    {
      test_id:test_id, 
      test_section: test_section, 
      action:"fetch_section_questions"
    }, "text").done(function(data) 
    {
      //alert(data);
      $("#list").html(data);
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.add_question', function(){
      var test_id = $(this).attr('data-test');
      var test_section = $(this).attr('data-section');
    //  alert("Action " + test_id + test_section + "");     
      $.post("fetch_section_questions.php", 
      {
        test_id:test_id, 
        test_section: test_section, 
        action:"add_question"
      }, "text").done(function(data) 
      {
    //    alert("Section Decremented Successfully");
        $("#list").html(data);  
      }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
    });

  $(document).on('click', '.show_question', function(){
    var qb_id = $(this).attr('data-qb');
    var tq_id = $(this).attr('data-tq');
    //alert("Question Id " + qb_id);     
    $.post("fetch_section_questions.php", 
    {
      qb_id:qb_id,
      tq_id:tq_id, 
      action:"fetch_question"
    }, "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data);  
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.qb_type', function(){
    var qb_id=$(this).attr('data-qb');
    var tq_id=$(this).attr('data-tq');
    var qb_type=$(this).attr('data-type');
    //alert("Action " + qb_id + "Type " + qb_type);     
    $.post("fetch_section_questions.php", 
    {
      qb_id:qb_id, 
      tq_id:tq_id, 
      qb_type: qb_type, 
      action:"change_type"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });
  
  $(document).on('click', '.qb_level', function(){
    var qb_id=$(this).attr('data-qb');
    var tq_id=$(this).attr('data-tq');
    var qb_level=$(this).attr('data-level');
    //alert("Action " + qb_id + "Level " + qb_level);     
    $.post("fetch_section_questions.php", 
    {
      qb_id:qb_id, 
      tq_id:tq_id, 
      qb_level: qb_level, 
      action:"change_level"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.qb_base', function(){
    var qb_id=$(this).attr('data-qb');
    var tq_id=$(this).attr('data-tq');
    var qb_base=$(this).attr('data-base');
    //alert("Action " + qb_id + " Base " + qb_base);     
    $.post("fetch_section_questions.php", 
    {
      qb_id:qb_id, 
      tq_id:tq_id, 
      qb_base: qb_base, 
      action:"change_base"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.add_marks', function(){
    var tq_id = $(this).attr('data-tq');
    var qb_id=$(this).attr('data-qb');
    var tq_marks=$(this).attr('data-marks');
    //alert("Action " + tq_id + tq_marks + "QB " + qb_id);     
    $.post("fetch_section_questions.php", 
    {
      tq_id:tq_id, 
      qb_id:qb_id, 
      tq_marks: tq_marks, 
      action:"add_marks"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.reduce_marks', function(){
    var tq_id = $(this).attr('data-tq');
    var qb_id=$(this).attr('data-qb');
    var tq_marks=$(this).attr('data-marks');
    //alert("Action " + tq_id + tq_marks + "QB " + qb_id);     
    $.post("fetch_section_questions.php", 
    {
      tq_id:tq_id, 
      qb_id:qb_id, 
      tq_marks: tq_marks, 
      action:"reduce_marks"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });


  $(document).on('click', '.add_nmarks', function(){
    var tq_id = $(this).attr('data-tq');
    var qb_id=$(this).attr('data-qb');
    var tq_nmarks=$(this).attr('data-nmarks');
    //alert("Action " + tq_id + tq_nmarks + "QB " + qb_id);     
    $.post("fetch_section_questions.php", 
    {
      tq_id:tq_id, 
      qb_id:qb_id, 
      tq_nmarks: tq_nmarks, 
      action:"add_nmarks"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.reduce_nmarks', function(){
    var tq_id = $(this).attr('data-tq');
    var qb_id=$(this).attr('data-qb');
    var tq_nmarks=$(this).attr('data-nmarks');
    //alert("Action " + tq_id + tq_nmarks + "QB " + qb_id);     
    $.post("fetch_section_questions.php", 
    {
      tq_id:tq_id, 
      qb_id:qb_id, 
      tq_nmarks: tq_nmarks, 
      action:"reduce_nmarks"},
     "text").done(function(data) 
    {
      //alert(data);
      $("#question").html(data); 
    }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
  });

  $(document).on('click', '.changeImage', function(){
    var qb_id=$(this).attr('data-qb');
    var tq_id=$(this).attr('data-tq');
    $('#qb_id').val(qb_id);
    $('#tq_id').val(tq_id);
    $('#imageModal').modal("show");
  });

  $('#image_form').submit(function(event){
    event.preventDefault();
    var image_name=$('#image').val();
    if(image_name=='')alert("Please Select Image");
    else
    {
      $.ajax({
        url:"fetch_section_questions.php",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        processData:false,
      }).done(function(data)
      {
        //alert(data);
        $('#imageModal').modal("hide");
      });
    }
  });

  $(document).on('click', '.editQuestion', function(){
    var qb_id=$(this).attr('data-qb');
    //var tq_id=$(this).attr('data-tq');
    $('#qb_id').val(qb_id);
    //$('#tq_id').val(tq_id);
    alert(" qb "+qb_id);
    $.post("fetch_section_questions.php", {qb_id:qb_id, action:"updateText"}, function(mydata, filestatus){ alert(filestatus);
      }, "json").done(function(data) 
      {
        alert("Action " + data.qb_text + "");
        $('#text_form')[0].reset();
        $('#qb_text').val(data.qb_text);
        $('#textModal').modal('show');
      }).fail(function() 
      {
        // the below alert to be removed
        alert("Unable to Process Request.\n Contact Administrator");
      })
  });

});
</script>    
 
<div id="imageModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Select New Image</h4>
   </div>
   <div class="modal-body">
    <form id="image_form" method="post" enctype="multipart/form-data">
     <p><label>Select Image</label>
     <input type="file" name="image" id="image" /></p><br />
     <input type="hidden" name="action" id="action" value="update" />
     <input type="hidden" name="qb_id" id="qb_id" />
     <input type="hidden" name="tq_id" id="tq_id" />
     <input type="submit" name="update" id="update" value="Update" class="btn btn-info" />
      
    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<div id="textModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Select New Image</h4>
   </div>
   <div class="modal-body">
    <form id="text_form" method="post" enctype="multipart/form-data">
     <p><label>Edit the Statement</label>
     <textarea name="qb_text" id="qb_text"></textarea><br />
     <input type="hidden" name="action" id="action" value="update" />
     <input type="hidden" name="qb_id" id="qb_id" />
     <input type="hidden" name="tq_id" id="tq_id" />
     <input type="submit" name="update" id="update" value="Update" class="btn btn-info" />
      
    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>