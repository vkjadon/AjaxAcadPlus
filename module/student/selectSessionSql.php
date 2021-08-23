<?php
session_start();
include('../../config_database.php');
include('php_function.php');
//echo $_POST['action'];
$sql = "select * from session order by session_id desc";
$result = $conn->query($sql);
  if ($result) {
		echo '<select class="form-control form-control-sm" name="sel_session" id="sel_session">';
    if(isset($_SESSION['msd']))
		{
			$sel_session=$_SESSION['msd'];
			$name=getField($conn, $sel_session, "session", "session_id", "session_name");
			echo '<option value="' . $sel_select . '">' . $name . '</option>';
		}
		while ($rows = $result->fetch_assoc()) {
        $select_id = $rows['session_id'];
        $select_name = $rows["session_name"];
          echo '<option value="' . $select_id . '">' . $select_name . '</option>';
      }
  }
