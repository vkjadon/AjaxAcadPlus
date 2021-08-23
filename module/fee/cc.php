<?php
session_start();
$_SESSION["myFolder"] = $_GET['folder'];
$_SESSION["mysid"] = $_GET['s'];
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
?>

<head>
    <title>Outcome Based Education : ClassConnect</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="../../table.css">
    <link rel="stylesheet" href="../../style.css">
</head>
<div class="container-fluid">
    <h1>&nbsp;</h1>
<?php
$sas_id = $_GET['sasid'];
echo "MyId $myId Ses $mySes SAS $sas_id Folder $myFolder";
//echo "Link Sent " . $sas_id;
if (isset($_GET['submit'])) {
    echo '<h4>Thanks for you Response</h4>';
    $cc_name = $_GET['topic'];
    $cco_question1 = $_GET['question1'];
    $cco_question2 = $_GET['question2'];
    $cco_question3 = $_GET['question3'];

    $cco_answer1 = $_GET['answer1'];
    $cco_answer2 = $_GET['answer2'];
    $cco_answer3 = $_GET['answer3'];
    $sql="update $tn_cc set cc_name='$cc_name' where sas_id='$sas_id'";
    $conn->query($sql);

    echo "$tn_cc - $cc_name - $sas_id ";
} 
    $sql = "select sas.*, tl.*, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg where sas.sas_id='$sas_id' and sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id";

    $json = getTableRow($conn, $sql, array("sas_period", "staff_id", "class_id", "subject_id", "sas_date"));
    $array = json_decode($json, true);
    //echo $json;
    //echo count($array);
    //echo count($array["data"]);
    $staff_id = $array["data"][0]["staff_id"];
    $sas_date = $array["data"][0]["sas_date"];
    $sas_period = $array["data"][0]["sas_period"];
    $class_id = $array["data"][0]["class_id"];
    $subject_id = $array["data"][0]["subject_id"];

    //echo "Staff " . $staff_id." Class ".$class_id;
    $staff_email = getField($conn, $staff_id, "staff", "staff_id", "staff_email");
    $class_name = getField($conn, $class_id, "class", "class_id", "class_name");
    $class_section = getField($conn, $class_id, "class", "class_id", "class_section");

    $subject_name = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
    $subject_code = getField($conn, $subject_id, "subject", "subject_id", "subject_code");

    echo '<div class="col-6 offset-3"><table class="table table-bordered">
<tr><td>Class </td><td colspan="3">' . $class_name . ' [' . $class_section . ']</td></tr>
<tr><td> Subject Code </td><td colspan="3">' . $subject_code . ' : ' . $subject_name . '</td></tr>
<tr><td> Date </td><td>' . date("d-m-Y", strtotime($sas_date)) . '</td><td> Period </td><td>' . $sas_period . '</td></tr>
</table>
<form action="cc.php" method="get">
<table class="table table-bordered">
<tr><td colspan="4">Topic Covered<input type="text" class="form-control form-control-sm" name="topic"></td></tr>
<tr><td>Question</td><td>Answer</td></tr>
<tr>
<td><input type="text" class="form-control form-control-sm" name="question1"></td>
<td><input type="text" class="form-control form-control-sm" name="answer1"></td>
</tr>

<tr>
<td><input type="text" class="form-control form-control-sm" name="question2"></td>
<td><input type="text" class="form-control form-control-sm" name="answer2"></td>
</tr>

<tr>
<td><input type="text" class="form-control form-control-sm" name="question3"></td>
<td><input type="text" class="form-control form-control-sm" name="answer3"></td>
</tr>
<input type="hidden" name="s" value="' . $mySes . '">
<input type="hidden" name="folder" value="' . $myFolder . '">
<input type="hidden" name="sasid" value="' . $sas_id . '">
</table>
<input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
</div>
</body>
</html>';
?>
</div>