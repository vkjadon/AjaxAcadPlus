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
$sql="select * from tests where submit_id='$myid' order by test_id desc";  
$result=$conn->query($sql); 
?>

<div class="container-fluid">
<span class="float-right"><a href="manage_library.php" class="btn btn-primary btn-sm">My Library</a></span>
<span class="float-right">&nbsp;</span>
<span class="float-right"><a href="mcq_upload.php" class="btn btn-secondary btn-sm"> Upload Questions </a></span>
<span class="float-right">&nbsp;</span>
<span class="float-right"><a href="add_mcq.php" class="btn btn-warning btn-sm"> Add Question </a></span>
<span class="float-right">&nbsp;</span>
<span class="float-right"><button type="button" id="add_button" class="btn btn-info btn-sm">Create a New Test</button></span>

<div >
  <table class="table table-bordered table-striped" style="width:100%"">  
    <thead><th width="15%">Action</th><th>#</th><th>ID</th><th>Name</th><th width="15%">Sections</th></thead>
    <tbody id="testList">
<?php  
      $count=1;
      while($row = mysqli_fetch_array($result))  
      {  
        $id=$row["test_id"];
        $test_name=$row["test_name"];
        $test_section=$row["test_section"];
        $submit_date=$row["submit_date"];
?>  
        <tr>  
          <td><button class="btn btn-primary btn-sm edit_data" id="<?=$id;?>"><i class="fa fa-edit"></i></button>
          <button class="btn btn-info btn-sm view_data" id="<?php echo $id;?>"><i class="fa fa-eye"></i></button>
          <button class="btn btn-danger btn-sm delete_data" id="<?php echo $id;?>"><i class="fa fa-trash"></i></button></td>
          <td><?=$count++;?></td>  
          <td><?=$id;?></td><td><?=$test_name; ?></td><td><?=date("M d, Y", strtotime($submit_date));?></td>
          <td><?=$test_section;?>
          <span class="float-right">
            <button class="btn btn-success btn-sm add_section" data-section="<?=$test_section;?>" data-id="<?=$id;?>"><i class="fa fa-plus"></i></button>
            <button class="btn btn-danger btn-sm minus_section" data-section="<?=$test_section;?>" data-id="<?=$id;?>"><i class="fa fa-minus"></i></button>
          </span>
          </td>
          <td><a href="add_mcq.php?id=<?=sha1($id);?>" class="btn btn-info btn-sm">Add Test Question</button></td>
          <td><a href="mcq_upload.php?id=<?=sha1($id);?>" class="btn btn-warning btn-sm">Upload Test Question</button></td>
          <td><a href="manage_test_show.php?id=<?=sha1($id);?>" class="btn btn-success btn-sm">Show Test</button></td>
        </tr>  
<?php  
      }  
?>      
    </tbody>
  </table> 
  </div>
</div>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function(){
    
    $('#add_button').click(function(){
      $('#modal_title').text('Add Test');
      $('#button_action').val('Add');
      $('#action').val('Add');
      $('#formModal').modal('show');
      clear_field();
    });
    function clear_field()
    {
       $('#test_form')[0].reset();
       $('#test_error').text('');
    }
    
    $(document).on('click', '.edit_data', function(){
      //alert("Update Value is Pressed");
      var test_id = $(this).attr('id');
      alert("Update Value is "+ test_id +"");
      $.post("manage_testSql.php", {test_id:test_id, action:"fetch"}, function(mydata, filestatus){
      }, "json").done(function(data) 
      {
        alert("Action " + data.test_name + "");
        $('#test_form')[0].reset();
        $('#test_name').val(data.test_name);
        $('#test_id').val(data.test_id);       
        $('#modal_title').text('Update test');
        $('#button_action').show().val('Update');
        $('#action').val('Update');              
        $('#formModal').modal('show');
      }).fail(function() 
      {
        // the below alert to be removed
        alert("Unable to Process Request.\n Contact Administrator");
      })
    });
    
    $(document).on('click', '.view_data', function(){
      var test_id = $(this).attr('id');
      $.post("manage_testSql.php", {test_id:test_id, action:"view"}, function(mydata, filestatus){
      }, "text").done(function(data) 
      {
//        alert("Action " + data.test_name + "");     
        $('#viewModal').modal('show');
        $('#viewData').html(data);
      }).fail(function() 
      {
        // the below alert to be removed
        alert("Unable to Process Request.\n Contact Administrator");
      })

    });

    $(document).on('click', '.minus_section', function(){
      var test_id = $(this).attr('data-id');
      var test_section = $(this).attr('data-section');
    //  alert("Action " + test_id + test_section + "");     
      $.post("manage_testSql.php", 
      {
        test_id:test_id, 
        test_section: test_section, 
        action:"minus_section"
      }, "text").done(function(data) 
      {
    //    alert("Section Decremented Successfully");
        $("#testList").html(data);  
      }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
    });
    
    $(document).on('click', '.add_section', function(){
      var test_id = $(this).attr('data-id');
      var test_section = $(this).attr('data-section');
      //alert("Action " + test_id + test_section + "");     
      $.post("manage_testSql.php", 
      {
        test_id:test_id, 
        test_section: test_section, 
        action:"section"
      }, "text").done(function(data) 
      {
       // alert("Section Incermented Successfully");
        $("#testList").html(data);  
      }).fail(function(){ alert("Unable to Process Request.\n Contact Administrator");})
    });

    $('#test_form').submit(function(event){
      event.preventDefault();
      var formData=$(this).serialize();   // action and test_id are passed as hidden
      if($('#test_name').val()=="")  
      {  
        $("#test_error").text("Name is required");  
      }
      else
      {
        $.post("manage_testSql.php", formData, function(mydata, mystatus){
       // the below alert to be removed
        alert(" Status: Updated / Inserted \n Status Output " + mystatus);
        },"text").done(function(data) 
        {
          $("#test_error").text("");
          $('#test_form')[0].reset();
          $('#formModal').modal('hide');
          $("#testList").html(data);
        }).fail(function() 
        {
          // the below alert to be removed
          alert("fail in place of error");
        })
      }
    });      
  });
</script>

<!-- Modal-->

<div class="modal" id="formModal">
  <div class="modal-dialog">
    <form method="post" id="test_form">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Test Name <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="test_name" id="test_name" class="form-control" required />
                <span id="test_error" class="text-danger"></span>
              </div>
            </div>

        </div> <!-- Form Group Closed-->
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="test_id" id="test_id" />
          <input type="hidden" name="action" id="action"/>
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm"/>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->


<!-- Modal-->

<div class="modal" id="viewModal">
  <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title">View Data</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body"><div id="viewData"></div>
          
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">       
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->