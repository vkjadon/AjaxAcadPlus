<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Class Connect LMS </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'autolink lists media table',
    });
</script>
</head>
<?php
include('../../../config_database.php');
include('../index_menu.php');
?>
		<div class="main">
		<div class="col-sm-12">
		<h4>General Instructions to Upload a csv File</h4>
		<table class="table table-bordered table-condensed">
		<tr><td>1. Please do not leave any blank space in file name<br />
		2. Specity Header Row (may be with dummy headings)
		</td><td colspan="2">
		<h5><b><u>Creating a .csv file</u></b></h5>
		<li>Create Excel File</li>
		<li>Press SAVE AS Button</li>
		<li>Change File Type to csv (comma delimited)</li></td></tr>
		<tr>
		<td><strong>Multiple Choice Question .csv File</strong></td>
		<td><strong>Numerical Input .csv File</strong></td>
		</tr>
		<tr>
		<td>
		<ol>
		<li><span class="label label-primary">Col-A</span> Text of the Question. Use the html code for mathematical symbols and equation </li>
		<li><span class="label label-primary">Col-B</span> Option A</li>
		<li><span class="label label-primary">Col-C</span> Option B</li>
		<li><span class="label label-primary">Col-D</span> Option C</li>
		<li><span class="label label-primary">Col-E</span> Option D</li>
		<li><span class="label label-primary">Col-F</span> Correct Option (1,2,3,4 for A,B,C,D repectively and 24 for B and D both) </li>
    </ol>
    <form id="upload_mcq" method="post" enctype="multipart/form-data">  
      <div class="col-md-4">  
        <input type="file" name="mcq_upload" style="margin-top:15px;" />  
      </div>  
      <div class="col-md-5">  
        <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />  
      </div>  
      <div style="clear:both"></div>  
    </form>  
  </td>
		<td colspan="2">
		<ol>
		<li><span class="label label-primary">Col-A</span> Text of the Question. Use the html code for mathematical symbols and equation </li>
		<li><span class="label label-primary">Col-B</span> Lower Limit of Answer </li>
		<li><span class="label label-primary">Col-C</span> Upper Limit of Answer </li>
		<li><span class="label label-danger"><em>NOTE</em></span> Add equal values in Both Columns B and C equal for Exact Answer </li>
    </ol>
    <form id="upload_niq" method="post" enctype="multipart/form-data">  
      <div class="col-md-4">  
        <input type="file" name="niq_upload" style="margin-top:15px;" />  
      </div>  
      <div class="col-md-5">  
        <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />  
      </div>  
      <div style="clear:both"></div>  
    </form>  
  </td>
    </tr>
    </table>
    
    
    <div class="table-responsive" id="uploaded_data"></div>  
  </div>  
  </body>  
 </html>  
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <script>  
  $(document).ready(function(){  
    $('#upload_mcq').on("submit", function(event){  
      event.preventDefault(); //form will not submitted  
      $.ajax({  
        url:"mcq_uploadSql.php",  
        method:"POST",  
        data:new FormData(this),  
        contentType:false,          // The content type used when sending data to the server.  
        cache:false,                // To unable request pages to be cached  
        processData:false,          // To send DOMDocument or non processed data file it is set to false  
        success: function(data){  
          if(data=='Error1')  
          {  
            alert("Invalid File");  
          }  
         else if(data == "Error2")  
         {  
            alert("Please Select File");  
          }  
          else  
          {  
            $('#uploaded_data').html(data);  
          }  
        }  
     })  
    });  
  });  
 </script> 