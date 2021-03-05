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
      plugins: 'autolink lists media table',
    });
</script>
</head>
<?php
include('../config_database.php');
include('index_menu.php');
if(isset($_GET['qb_id']) || isset($_POST['qb_id']))
{
  
  if(isset($_GET['qb_id']))$qb_id=$_GET['qb_id'];
  if(isset($_POST['qb_id']))$qb_id=$_POST['qb_id'];

  require("edit_mcqSql.php");

  $sql="select * from question_bank where qb_id='$qb_id'";
  $result=$conn->query($sql);
  while($rows=$result->fetch_assoc())
  {
    $qb_text=$rows['qb_text'];
    $optionA=$rows['qb_option1'];
    $optionB=$rows['qb_option2'];
    $optionC=$rows['qb_option3'];
    $optionD=$rows['qb_option4'];
    $qb_co=$rows['qb_co'];
  }
  echo $qb_co;
  $co_array=str_split(strval($qb_co));
  print_r($co_array);
}

?>
<div class="container-fluid">
  <form method="post" action="edit_mcq.php" id="myForm" enctype="multipart/form-data"> 
    <div class="col-md-12">
      <label><strong>Type/Paste the Text of Question with Options</strong></label>
      <textarea name="qb_text" rows="10" class="form-control"><?=$qb_text;?></textarea>
    </div>
    <div class="col-md-12">
    
    <div class="row">
      <div class="form-group col-md-6 bg-light">
        <label><strong>Option-A</strong></label>
        <textarea class="form-control" name="optionA"><?=$optionA;?></textarea>
        <div class="custom-control custom-checkbox">
        <?php if(in_array("1",$co_array))
        echo '<input type="checkbox" class="custom-control-input" id="cb1" checked="checked" name="option1" value="1">';
        else echo '<input type="checkbox" class="custom-control-input" id="cb1" name="option1" value="1">';
        ?>
          <label class="custom-control-label" for="cb1">Check if Correct</label>
        </div>

        <label><strong>Option-B</strong></label>
        <textarea class="form-control" name="optionB"><?=$optionB;?></textarea>
        <div class="custom-control custom-checkbox">
        <?php if(in_array("2",$co_array))
        echo '<input type="checkbox" class="custom-control-input" id="cb2" checked="checked" name="option2" value="2">';
        else echo '<input type="checkbox" class="custom-control-input" id="cb2" name="option2" value="2">';
        ?>
        <label class="custom-control-label" for="cb2">Check if Correct</label>
        </div>
      </div>
      
      <div class="form-group col-md-6 bg-light">
        <label><strong>Option-C</strong></label>
        <textarea class="form-control" name="optionC"><?=$optionC;?></textarea>
        <div class="custom-control custom-checkbox">
        <?php if(in_array("3",$co_array))
        echo '<input type="checkbox" class="custom-control-input" id="cb3" checked="checked" name="option3" value="3">';
        else echo '<input type="checkbox" class="custom-control-input" id="cb3" name="option3" value="3">';
        ?>
        <input type="checkbox" class="custom-control-input" id="cb3" name="option3" value="3">
          <label class="custom-control-label" for="cb3">Check if Correct</label>
        </div>
        <label><strong>Option-D</strong></label>
        <textarea class="form-control" name="optionD"><?=$optionD;?></textarea>
        <div class="custom-control custom-checkbox">
        <?php if(in_array("4",$co_array))
        echo '<input type="checkbox" class="custom-control-input" id="cb4" checked="checked" name="option4" value="4">';
        else echo '<input type="checkbox" class="custom-control-input" id="cb4" name="option4" value="4">';
        ?>
        <label class="custom-control-label" for="cb4">Check if Correct</label>
        </div>
      </div>
    </div>
    <input type="submit" name="update_question" class="btn btn-primary" value="Update Statement">
    <input type="hidden" name="qb_id" value="<?=$qb_id;?>">
</form>
</div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $('#question').submit(function(event){
      event.preventDefault();
  })
});
</script>