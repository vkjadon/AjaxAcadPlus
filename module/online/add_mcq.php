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
?>
<div class="container-fluid">
<div class="row">
  <div class="col-md-12">
    <span class="float-right">
     <button class="btn btn-warning" id="question">Show Last Question Added</button>
    </span>
  </div>
</div>
<div class="col-md-12">
<form method="post" action="add_mcq.php" id="myForm" enctype="multipart/form-data"> 
  <div class="form-row">
  <div class="row">
  <div class="col-md-12">
<?php
  $qb_text=$qb_min=$qb_max=$qb_type=$qb_level=$qb_base=$filename=$submit_id=$submit_date=$qb_co=$qb_status='';
  $option1=$option2=$option3=$option4=''; $optionA=$optionB=$optionC=$optionD='';
  $tq_marks=1;

if(isset($_GET['id']) || isset($_POST['id']))
{
  
  if(isset($_GET['id']))$id=$_GET['id'];
  if(isset($_POST['id']))$id=$_POST['id'];
  if(isset($_POST['section']))$section=$_POST['section'];
  else $section=1;
  $sql="select * from tests where sha1(test_id)='$id'";
  $result=$conn->query($sql); 
  while($row = mysqli_fetch_array($result))  
  {  
    $test_id=$row["test_id"];
    $test_name=$row["test_name"];
    $test_section=$row["test_section"];
    echo '<h4>'.$test_name.'&nbsp;';
    for($i=0; $i<$test_section; $i++)
    {
?>
      <div class="form-check form-check-inline">
      <input class="form-check-input" <?php if($section==($i+1))echo 'checked="checked"';?> type="radio" name="section" id="inlineRadio1" value="<?=($i+1);?>">
      <label class="form-check-label" for="inlineRadio1">Section - <?=($i+1);?></label>
      </div>
<?php
    }
    echo '</h4>';
  }
}
require("add_mcqSql.php");
?>
  </div>
  </div>
  <div class="row">
    <div class="form-group col-md-8 bg-light">
      <label><strong>Type/Paste the Text of Question with Options</strong></label>
      <textarea name="qb_text" rows="10" class="form-control"><?=$qb_text;?></textarea>
    </div>
    <div class="form-group col-md-4 bg-info text-white">
    <div class="row">
      <div class="form-group col-md-4">
      <label for="type">Type</label>
        <select name="qb_type" class="form-control form-control-sm" id="type">
		     <option value='1'>MCQ - Multiple Choice Question</option>
		     <option value='2'>MAQ - Multiple Answer Question</option>
		     <option value='3'>NIQ - Numerical Input Question</option>
	      </select>
      </div>
    
      <div class="form-group col-md-4">
      <label for="level">Level</label>
      <select name="qb_level" class="form-control form-control-sm" id="level">
		    <option value='1'>Easy</option>
        <option value='2'>Average</option>
        <option value='3'>Difficult</option>
      </select>
      </div>
      <div class="form-group col-md-4">
      <label for="base">Base</label>
      <select name="qb_base" class="form-control form-control-sm" id="base">
		    <option value='1'>Memory</option>
        <option value='2'>Conceptual</option>
        <option value='3'>Analytical</option>
      </select>
      </div>
    </div>
    
    <div class="row">
      <div class="form-group col-md-4">
      <label for="qb_min">Min Answer</label>
        <input type="text" class="form-control form-control-sm" name="qb_min" id="qb_min">
      </div>
      <div class="form-group col-md-4">
      <label for="qb_max">Max Answer</label>
        <input type="text" class="form-control form-control-sm" name="qb_max" id="qb_max">
      </div>
      <div class="form-group col-md-4">
      <label for="tq_marks">Q Marks</label>
        <input type="text" class="form-control form-control-sm" name="tq_marks" id="tq_marks" value="<?=$tq_marks;?>" required>  
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-4">
      <label for="tq_nmarks">Neg Marks</label>
        <input type="text" class="form-control form-control-sm" name="tq_nmarks" id="tq_nmarks">
      </div>
      <div class="form-group col-md-8">
      <label for="file">Image of the Question</label>
      <input type="file" class="form-control-file" id="file" name="file">
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-group col-md-6 bg-light">
      <label><strong>Option-A</strong></label>
      <textarea class="form-control" name="optionA"><?=$optionA;?></textarea>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="cb1" name="option1" value="1">
        <label class="custom-control-label" for="cb1">Check if Correct</label>
      </div>

      <label><strong>Option-B</strong></label>
      <textarea class="form-control" name="optionB"><?=$optionB;?></textarea>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="cb2" name="option2" value="2">
        <label class="custom-control-label" for="cb2">Check if Correct</label>
      </div>
    </div>

    <div class="form-group col-md-6 bg-light">
      <label><strong>Option-C</strong></label>
      <textarea class="form-control" name="optionC"><?=$optionC;?></textarea>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="cb3" name="option3" value="3">
        <label class="custom-control-label" for="cb3">Check if Correct</label>
      </div>
      <label><strong>Option-D</strong></label>
      <textarea class="form-control" name="optionD"><?=$optionD;?></textarea>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="cb4" name="option4" value="4">
        <label class="custom-control-label" for="cb4">Check if Correct</label>
      </div>
    </div>
    </div>
  </div>
    <div class="row">
    <div class="form-group col-md-4 bg-light">
      <input type="submit" name="submit_question" class="btn btn-primary" value="Add Question">
      <input type="hidden" name="add_mcq" value="true">
      <input type="hidden" name="id" value="<?=$id;?>">
    </div>
  </div>
  </div></div>
</form>
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