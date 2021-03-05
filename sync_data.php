<?php
require("../session_start.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Class Connect LMS </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
  <?php
  include('../../config_database.php');
  include('index_menu.php');
?>
  <div class="container-fluid">
    <div class="main">
      <div class="row">
      <div class="col-md-3 bg-light">
      <?php
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://instituteerp.net/api/get_session.php?ic=17");      
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);      
        $session=json_decode($output, true);
        echo 'Select a Session <select class="form-control form-control-sm" name="sel_session" id="sel_session" required>';
        for($i=0; $i<count($session["data"]); $i++)
        {
          echo '<option value="'.$session["data"][$i]["id"].'">'.$session["data"][$i]["id"].'-'.$session["data"][$i]["name"].'</option>';
        }
        echo '</select>';
        curl_close($curl);
      ?>
      </div>

      <div class="col-md-3 bg-light">
      <?php
        $curl = curl_init();
        $sel_session='45';
        $url='https://instituteerp.net/api/get_class.php?ic=17&&session='.$sel_session;
        
        curl_setopt($curl, CURLOPT_URL, $url);      
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        //echo $output;      
        $session=json_decode($output, true);
        echo 'Select a Session <select class="form-control form-control-sm" name="sel_session" id="sel_session" required>';
        for($i=0; $i<count($session["data"]); $i++)
        {
          echo '<option value="'.$session["data"][$i]["id"].'">'.$session["data"][$i]["id"].'-'.$session["data"][$i]["name"].'</option>';
        }
        echo '</select>';
        curl_close($curl);
      ?>
      </div>

    </div>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </div>
</body>

</html>