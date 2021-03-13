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
  <script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name'
    });
</script>
<?php
include('../config_database.php');
include('index_menu.php');
$sql="select * from tests where submit_id='$myid' order by test_id desc";  
$result=$conn->query($sql); 
?>

<div class="container-fluid">
<div class="col-md-12">
    <form action="manage_library.php" method="post">
        <span><button type="submit" name="add_mcq" id="add_mcq" class="btn btn-info btn-sm">Add MCQ/MAQ/NIQ</button></span>
        <span><button type="submit" name="add_vdq" id="add_vdq" class="btn btn-warning btn-sm">Add VDQ/SUB</button></span>
    </form>
</div>
<div class="col-md-12">
<?php
  if(isset($_POST['add_mcq']))require("add_mcq.php");
?>    
</div>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>