<?php
session_start();
require("config_database.php");
if ($_POST['action'] == 'setSchool') $_SESSION['mysclid'] = $_POST['schoolId'];
elseif ($_POST['action'] == 'setDept') $_SESSION['mydeptid'] = $_POST['deptId'];
elseif ($_POST['action'] == 'setProgram') $_SESSION['mypid'] = $_POST['programId'];
elseif ($_POST['action'] == 'setSession') $_SESSION['mysid'] = $_POST['sessionId'];
elseif ($_POST['action'] == 'setBatch') $_SESSION['myBatch'] = $_POST['batchId'];

