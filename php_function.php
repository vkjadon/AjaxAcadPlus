<?php
function data_check($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars_decode($data);
  //htmlspecialchars_decode
  $data = addcslashes($data, "'");
  return $data;
}
function selectList($conn, $selectTitle, $data, $sql)
{
  //echo "Inst in function $tableName $id $name $where";
  $required = $data[0];
  $id = $data[1];
  $name = $data[2];
  $abbri = $data[3];
  $idName = $data[4];
  if (count($data) > 5) {
    $selectedId = $data[5];
    $selectedName = $data[6];
  }
  //$required=0; Required some value
  //$required>0 The variable need the selection to proceed
  //$required=2 The ALL item does NOT appear in the List
  $result = $conn->query($sql);
  if ($result) {
    if ($required == '0') echo '<select class="mdb-select form-control form-control-sm ' . $name . '" name="' . $idName . '" id="' . $idName . '">';
    else echo '<select class="mdb-select form-control form-control-sm ' . $name . '" name="' . $idName . '" id="' . $idName . '" required>';

    if (strlen($selectTitle) > 2 && count($data) < 6) echo '<option value="">' . $selectTitle . '</option>';
    elseif (count($data) > 5) echo '<option value="' . $selectedId . '">' . $selectedName . '</option>';
    while ($rows = $result->fetch_assoc()) {
      $select_id = $rows[$id];
      $select_name = $rows[$name];
      if ($abbri <> '') {
        $select_abbri = $rows[$abbri];
        echo '<option value="' . $select_id . '">' . $select_name . '(' . $select_abbri . ')</option>';
      } else echo '<option value="' . $select_id . '">' . $select_name . '</option>';
    }
    if ($required <> '2') echo '<option value="ALL">ALL</option>';
    echo '</select>';
  } else echo $conn->error;
  if ($result->num_rows == 0) echo 'No Data Found';
}
function selectInput($conn, $selectTitle, $id, $name, $abbri, $idName, $sql)
{
  //echo "Inst in function $tableName $id $name $where";

  $result = $conn->query($sql);
  if ($result) {
    echo '<select class="form-control form-control-sm' . $name . '" name="' . $idName . '" id="' . $idName . '" required>';
    echo '<option value="">' . $selectTitle . '</option>';
    while ($rows = $result->fetch_assoc()) {
      $select_id = $rows[$id];
      $select_name = $rows[$name];
      if ($abbri <> '') {
        $select_abbri = $rows[$abbri];
        echo '<option value="' . $select_id . '">' . $select_name . '(' . $select_abbri . ')</option>';
      } else echo '<option value="' . $select_id . '">' . $select_name . '</option>';
    }
    echo '<option value="ALL">ALL</option>';
    echo '</select>';
  } else echo $conn->error;
  if ($result->num_rows == 0) echo 'No Data Found';
}
function addData($conn, $table, $id, $fields, $values, $status, $dup, $dup_alert)
{
  // $table - Name of the Table
  // $id - Table AI Id
  // $fields - array of Table fields to be added
  // $values - array of Values corresponding to the array of fields
  // $dup Query to check for existing data (Should use all Unique Key);
  // $status Status Field Name

  $field = $fields[0];
  $value = $values[0];

  $rows_count = '100';

  //echo $dup;
  $result_dup = $conn->query($dup);
  if ($result_dup) $rows_count = $result_dup->num_rows;
  else {
    echo $conn->error;
    die();
  }
  //echo "Dup Found $rows_count";

  if ($rows_count == 0) {
    $sql_in = "insert into $table ($field) values('$value')";
    //  echo $sql_in;
    $result = $conn->query($sql_in);
    if (!$result) echo $conn->error;
    else {
      $insert_id = $conn->insert_id;
      //  echo "dsds $insert_id";
      $fieldsToUpdate = count($fields);
      for ($i = 0; $i < $fieldsToUpdate; $i++) {
        $field = $fields[$i];
        $value = $values[$i];
        $sql = "update $table set $field='$value' where $id='$insert_id'";
        $result = $conn->query($sql);
      }
    }
    if ($dup_alert != "NULL") echo "Values Added Successfuly";
  } else {
    $rows = $result_dup->fetch_assoc();
    $dup_id = $rows[$id];
    if ($dup_alert != "NULL") echo $dup_alert;
    $sql = "update $table set $status='0' where $id='$dup_id'";
    $result = $conn->query($sql);
  }
}

function getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button)
{
  // $tableId=Table Auto Increment ID (to be used for editing data and "deleteData")
  // $fields= Array of fields to fetch from the output of the Query
  // $dataType= Array of data type of the fields, 0 Text 1 Date Format 2 TimeStamp
  // $header= Array of Table Headers - Add Id as first field
  // $sql=Query to be execute
  // $button[0]=>0 Edit Button NOT Required; => 1 Edit Button Required
  // $button[1]=>0 Delete Button NOT Required; => 1 Delete Button Required
  // $button[2]=>0 Retrieve button Not Required; => 1 Required
  // $button[3]=>0 Process button Not Required; => 1 Required
  // statusDecode is an associative array to Decode the Field value by an appropriate Phrase as
  //  Y by Yes M by Male etc. It can aslo be used to align the table cell.
  $columnCount = count($header);
  //echo "In Function  $sql Column Count $columnCount";
  if (isset($statusDecode["align"]) == "center") $align = 'align=' . '"center"';
  else $align = '';
  echo '<table class="table list-table-xs table-striped w-auto">';
  echo '<thead ' . $align . '>';
  if ($button[0] == '1') echo '<th><i class="fa fa-edit"></i></th>';
  for ($j = 0; $j < $columnCount; $j++) echo '<th>' . $header[$j] . '</th>';
  if ($button[1] > 0) echo '<th><i class="fa fa-trash"></i></th>';
  if ($button[2] == '1') echo '<td><i class="fa fa-info-circle"></i></td>';
  if ($button[3] == '1') echo '<td>Process</td>';
  $buttonCount = count($button);
  if ($buttonCount > 4) {
    for ($i = 4; $i < $buttonCount; $i++) {
      echo '<th>' . $button[$i] . '</th>';
    }
  }
  echo '</thead>';
  $fieldCount = count($fields);
  $result = $conn->query($sql);
  if (!$result) {
    echo $conn->error;
    die(" The script could not be Loadded! Please report!");
  }
  while ($rows = $result->fetch_assoc()) {
    $data = "";
    echo '<tr>';
    if ($tableId <> '') $id = $rows[$tableId];
    if ($button[0] == '1') echo '<td><a href="#" class="' . $tableId . 'E" id="' . $id . '"><i class="fa fa-edit"></i></a></td>';
    if ($tableId <> '') echo '<td>' . $id . '</td>';
    for ($j = 0; $j < $fieldCount; $j++) {
      $fieldName = $fields[$j];
      $fieldValue = $rows[$fieldName];
      $data .= ' data-' . $fieldName . '="' . $fieldValue . '"';
      if ($fieldName == $statusDecode["status"]) echo '<td>' . $statusDecode[$fieldValue] . '</td>';
      else {
        if ($dataType[$j] == "0") echo '<td>' . $fieldValue . '</td>';
        elseif ($dataType[$j] == "1") echo '<td>' . date("d-M-Y", strtotime($fieldValue)) . '</td>';
      }
    }
    if ($button[1] == '1') echo '<td><a href="#" class="' . $tableId . 'D" id="' . $id . '"><i class="fa fa-trash"></i></a></td>';
    elseif ($button[1] == '2') echo '<td><a href="#" class="' . $tableId . 'R" id="' . $id . '"><i class="fa fa-trash"></i></a></td>';
    if ($button[2] == '1') echo '<td><a href="#" class="' . $tableId . 'I" id="' . $id . '"><i class="fa fa-info-circle"></i></a></td>';
    if ($button[3] == '1') echo '<td><a href="#" class="' . $tableId . 'P" id="' . $id . '">Process</a></td>';
    if ($buttonCount > 4) {
      for ($i = 4; $i < $buttonCount; $i++) {
        echo '<td><button class="btn btn-secondary btn-square-sm mt-1 ' . $tableId . $button[$i] . '" id="' . $id . '" ' . $data . '>' . $button[$i] . '</button></td>';
      }
    }
    echo '</tr>';
  }
  echo '</table>';
}
function getListCard($conn, $tableId, $fields, $dataType, $sql, $statusDecode, $button)
{
  // $tableId=Table Auto Increment ID (to be used for editing data and "deleteData")
  // $fields= Array of fields to fetch from the output of the Query
  // $dataType= Array of data type of the fields, 0 Text 1 Date Format 2 TimeStamp
  // $header= Array of Table Headers - Add Id as first field
  // $sql=Query to be execute
  // statusDecode is an associative array to Decode the Field value by an appropriate Phrase as
  //  Y by Yes M by Male etc. It can aslo be used to align the table cell.
  //echo "In Function  $sql Column Count $columnCount";
  $buttonCount = count($button);
  $fieldCount = count($fields);
  $result = $conn->query($sql);
  if (!$result) {
    echo $conn->error;
    die(" The script could not be Loadded! Please report!");
  }
  //echo '<div class="card-columns">';
  echo '<div class="row">';
  while ($rows = $result->fetch_assoc()) {
    $data = "";
    echo '<div class="col-sm-4 mb-2">';
    echo '<div class="card">
    <div class="card-body">';
    $id = $rows[$tableId];
    for ($j = 0; $j < $fieldCount; $j++) {
      $fieldName = $fields[$j];
      $fieldValue = $rows[$fieldName];
      $data .= ' data-' . $fieldName . '="' . $fieldValue . '"';
      if ($fieldName == $statusDecode["status"]) echo '<div class="col">' . $statusDecode[$fieldValue] . '</div>';
      else {
        if ($dataType[$j] == "0") {
          if ($j == 0) echo '<div class="col"><div class="card-title"><h3>' . $fieldValue . '</h3></div></div>';
          else echo '<div class="col">' . $fieldValue . '</div>';
        } elseif ($dataType[$j] == "1") echo '<div class="col">' . date("d-M-Y", strtotime($fieldValue)) . '</div>';
      }
    }
    echo '<div class="row"><div class="col">';
    for ($i = 0; $i < $buttonCount; $i++) {
      if ($button[$i] == 'E') echo '<a href="#" class="float-left ' . $tableId . 'E" id="' . $id . '"><i class="fa fa-edit"></i></a>';
      elseif ($button[$i] == 'D') echo '<a href="#" class="float-right ' . $tableId . 'D" id="' . $id . '"><i class="fa fa-trash"></i></a>';
      else echo '<a href="#" class="atag ' . $tableId . $button[$i] . '" data-id="' . $id . '" ' . $data . '>' . $button[$i] . '</a>';
    }
    echo '</div></div></div>';
    echo '</div>';
    echo '</div>';
  }
  echo '</div>';
  //echo '</div>';
}
function updateField($conn, $table, $fields, $values, $echo)
{
  // $table - Name of the Table
  // $fields - array of Table fields to be added - First Id is Key Field
  // $values - array of Values corresponding to the array of fields - Firsr Value is update Key Value
  // $echo = 1 Response shown in alert

  $keyField = $fields[0];
  $keyValue = $values[0];

  $fieldsToUpdate = count($fields);
  for ($i = 1; $i < $fieldsToUpdate; $i++) {
    $field = $fields[$i];
    $value = $values[$i];
    $sql = "update $table set $field='$value' where $keyField='$keyValue'";
    $conn->query($sql);
  }
  if ($echo == '1') echo "Updated Successfully!";
}
function updateData($conn, $table, $fields, $values, $dup, $dup_alert)
{
  // $table - Name of the Table
  // $fields - array of Table fields to be added - First Id is Key Field
  // $values - array of Values corresponding to the array of fields - Firsr Value is update Key Value
  // $dup Query to check for existing data;

  $keyField = $fields[0];
  $keyValue = $values[0];

  //  echo "Update - ".$dup;
  $result_dup = $conn->query($dup);
  if ($result_dup) {
    $fieldsToUpdate = count($fields);
    //echo "Count $fieldsToUpdate";
    for ($i = 1; $i < $fieldsToUpdate; $i++) {
      $field = $fields[$i];
      $value = $values[$i];
      $sql = "update $table set $field='$value' where $keyField='$keyValue'";
      $result = $conn->query($sql);
      if (!$result) {
        echo $dup_alert;
        //echo $conn->error;
        die();
      }
    }
  }
}
function updateUniqueData($conn, $table, $fields, $values, $dup_alert)
{
  // $table - Name of the Table
  // $fields - array of Table fields to be added - First Id is Key Field
  // $values - array of Values corresponding to the array of fields - Firsr Value is update Key Value
  // $dup Query to check for existing data;

  $keyField = $fields[0];
  $keyValue = $values[0];

  //  echo "Update - ".$dup;
  $fieldsToUpdate = count($fields);
  //echo "Count $fieldsToUpdate";
  for ($i = 1; $i < $fieldsToUpdate; $i++) {
    $field = $fields[$i];
    $value = $values[$i];
    $sql = "update $table set $field='$value' where $keyField='$keyValue'";
    $result = $conn->query($sql);
    if (!$result) {
      echo $dup_alert;
      //echo $conn->error;
      die();
    }
  }
  echo "Updated Successfully!";
}

function getFieldValue($conn, $fieldName, $sql)
{
  //$fieldName Field name for Value Sought";
  $result = $conn->query($sql);
  if (!$result) {
    echo $conn->error;
    die("Opps! Some Error occured !! Please contact Administrator !");
  }
  $rows = $result->fetch_assoc();
  $Name = $rows[$fieldName];
  return $Name;
}
function getField($conn, $getId, $tableName, $id, $name)
{
  //echo "In Function  $getId (Value passed)
  //$tableName
  // $id (Field name corresponding to $getId value)
  // Field name to be returen from the table $name";

  $sql = "select * from $tableName where $id='" . $getId . "'";
  $result = $conn->query($sql);
  if (!$result) {
    echo $conn->error;
    die("Opps! Some Error occured !! Please contact Administrator !");
  } else {
    $num_rows = $result->num_rows;
    if ($num_rows > 0) {
      $rows = $result->fetch_assoc();
      $Name = $rows[$name];
    } else $Name = "";
  }
  return $Name;
}

function getFieldArray($conn,  $getId, $tableName, $id, $name)
{

  //Return All the values of the field $name from the Table $tableName against another Field $getId

  $sql = "select * from $tableName where $id='" . $getId . "'";
  $result = $conn->query($sql);
  $i = 0;
  if (!$result) {
    echo $conn->error;
    die("Opps! Some Error occured !! Please contact Administrator !");
  } else {
    $output = array();
    while ($rows = $result->fetch_assoc()) {
      $output[$i] = $rows[$name];
      $i++;
    }
  }
  return $output;
}

function getTableRow($conn, $sql, $arrayField)
{

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    for ($i = 0; $i < count($arrayField); $i++) {
      $field = $arrayField[$i];
      $sub_array[$field] = $rows[$field];
    }
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}

function getMaxValue($conn, $sql)
{
  // $sql to have order by DESC
  $result = $conn->query($sql);
  if ($result) {
    $row = $result->fetch_assoc();
    return $row["max"];
  } else return FALSE;
}
function getRowCount($conn, $sql)
{
  $result = $conn->query($sql);
  if ($result) {
    return $result->num_rows;
  } else return FALSE;
}
function status_decode($status)
{
  if ($status == 0) return "Saved";
  elseif ($status == 1) return "Forwarded";
  elseif ($status == 2) return "Rejected[F]";
  elseif ($status == 3) return "Approved";
  elseif ($status == 4) return "Rejected[A]";
  else return "Withdrawn";
}
function moveUp($conn, $table, $fields, $values, $sql)
{
  // $table - Name of the Table
  // $fields - array of TWO fields Id and Sno Fields
  // $values - array of Values corresponding to the array of fields
  $fieldId = $fields[0];
  $fieldSno = $fields[1];

  $valueId = $values[0];
  $valueSno = $values[1];

  $sno = $valueSno - 1;
}

function writeToFile($folder, $fileName, $content)
{
  echo $folder;
  if (!is_dir($folder)) mkdir($folder);
  $fileHandle = fopen($folder . '/' . $fileName, 'w+') or die("Cannot open file");
  fwrite($fileHandle, $content);
  fclose($fileHandle);
}

function dayList($dummy1, $dummy2)
{
  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Mon" value="1">
  <label class="form-check-label" for="Mon">Monday</label>
  </div>';

  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Tue" value="2">
  <label class="form-check-label" for="Tue">Tuesday</label>
  </div>';

  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Wed" value="3">
  <label class="form-check-label" for="Wed">Wednesday</label>
  </div>';

  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Thu" value="4">
  <label class="form-check-label" for="Thu">Thursday</label>
  </div>';

  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Fri" value="5">
  <label class="form-check-label" for="Fri">Friday</label>
  </div>';

  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Sat" value="6">
  <label class="form-check-label" for="Sat">Saturday</label>
  </div>';

  echo '<div class="form-check form-check-inline">
  <input class="form-check-input dayName" type="checkbox" id="Sun" value="7">
  <label class="form-check-label" for="Sun">Sunday</label>
  </div>';
}
function paginationBar($conn, $sqlAll, $rpp, $id, $tag)
{
  $result = $conn->query($sqlAll);
  $num_rows = $result->num_rows;
  $page = ceil($num_rows / $rpp);
  echo '<div class="row"><div class="col-10"><ul class="pagination">';

  for ($i = 1; $i <= $page; $i++) {
    $startRecord = ($i - 1) * $rpp;
    echo '<li class="page-item pageLink" id="page' . $tag . $i . '" data-start="' . $startRecord . '" data-tag="' . $tag . '"><a class="page-link" href="#"><span class="btn btn-info btn-square-sm">' . $i . '</span></a></li>';
  }
  echo '</ul></div>';
  echo '<div class="col-2"><select class="form-control form-control-sm ' . $id . '" id="' . $id . '" data-tag="' . $tag . '" name="rpp">
  <option value="' . $rpp . '">' . $rpp . '</option>
  <option value="5">5</option>
  <option value="15">15</option>
  <option value="25">25</option>
  <option value="50">50</option>
  <option value="75">75</option>
  </select></div></div>';
}
function check_dept_head($url)
{
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $output = json_decode(curl_exec($curl), true);
  curl_close($curl);
  return $output["head"];
}
function get_schoolJson($conn)
{
  $sql = "select * from school where school_status='0' order by school_name";
  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  else {
    $data = array();
    while ($row = $result->fetch_assoc()) {
      $sub_array = array();
      $sub_array[] = $row['school_id'];
      $sub_array[] = $row['school_name'];
      $sub_array[] = $row['school_abbri'];
      $data[] = $sub_array;
    }
    $output = array(
      "data" => $data
    );
    return json_encode($output);
  }
}
function get_departmentJson($conn, $school)
{
  $sql = "SELECT * FROM department where school_id='$school' and dept_status='0' order by dept_name";
  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($row = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array[] = $row['dept_id'];
    $sub_array[] = $row['dept_name'];
    $sub_array[] = $row['dept_abbri'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_batchJson($conn)
{
  $sql = "SELECT * FROM batch where batch_status='0' order by batch desc";
  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($row = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array[] = $row['batch_id'];
    $sub_array[] = $row['batch'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_classSubject($conn, $class_id)
{
  $batch_id = getField($conn, $class_id, "class", "class_id", "batch_id");
  $class_semester = getField($conn, $class_id, "class", "class_id", "class_semester");
  $program_id = getField($conn, $class_id, "class", "class_id", "program_id");

  $sql = "select * from subject where program_id='$program_id' and batch_id='$batch_id' and subject_semester='$class_semester'";
  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["id"] = $rows['subject_id'];
    $sub_array["name"] = $rows['subject_name'];
    $sub_array["code"] = $rows['subject_code'];
    $sub_array["credit"] = $rows['subject_credit'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_tlList($conn, $class_id)
{
  $batch_id = getField($conn, $class_id, "class", "class_id", "batch_id");
  $class_semester = getField($conn, $class_id, "class", "class_id", "class_semester");
  $program_id = getField($conn, $class_id, "class", "class_id", "program_id");

  $sql = "select * from subject where program_id='$program_id' and batch_id='$batch_id' and subject_semester='$class_semester'";
  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["id"] = $rows['subject_id'];
    $sub_array["name"] = $rows['subject_name'];
    $sub_array["code"] = $rows['subject_code'];
    $sub_array["credit"] = $rows['subject_credit'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_sessionClass($conn, $ses, $dept)
{
  $sql = "select cl.*, b.* from class cl, batch b where cl.batch_id=b.batch_id and cl.session_id='$ses' and dept_id='$dept' order by cl.class_semester";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["id"] = $rows['class_id'];
    $sub_array["name"] = $rows['class_name'];
    $sub_array["section"] = $rows['class_section'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_schoolSession($conn, $ay_id)
{

  $sql = "select s.* from session s where ay_id='$ay_id' order by session_id desc";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["id"] = $rows['session_id'];
    $sub_array["ay_id"] = $rows['ay_id'];
    $sub_array["name"] = $rows['session_name'];
    $sub_array["start"] = $rows['session_start'];
    $sub_array["end"] = $rows['session_end'];
    $sub_array["school_id"] = $rows['school_id'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_classTimeTableJson($conn, $classId, $tn_tt, $tn_tl, $tn_tlg, $dayofDate)
{
  if ($dayofDate == "") $sql = "select tlg.*, tl.*, tt.* from $tn_tlg tlg, $tn_tl tl, $tn_tt tt where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tlg.tlg_status='0'";

  else $sql = "select tlg.*, tl.*, tt.* from $tn_tlg tlg, $tn_tl tl, $tn_tt tt where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tt.tt_day='$dayofDate' and tlg.tlg_status='0'";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded ClassTimeTableJson! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["tlgId"] = $rows['tlg_id'];
    $sub_array["tlId"] = $rows['tl_id'];
    $sub_array["day"] = $rows['tt_day'];
    $sub_array["period"] = $rows['tt_period'];
    $sub_array["subject"] = $rows['subject_id'];
    $sub_array["type"] = $rows['tlg_type'];
    $sub_array["group"] = $rows['tl_group'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_staffClass($conn, $staff_id, $tn_tl, $tn_tlg)
{
  $sql = "select tlg.*, tl.* from $tn_tlg tlg, $tn_tl tl where tl.tlg_id=tlg.tlg_id and tl.staff_id='$staff_id' and tlg.tlg_status='0' and tl.tl_status='0' group by tlg.class_id order by tlg.class_id";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["class_id"] = $rows['class_id'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_staffTeachingLoad($conn, $staff_id, $tn_tl, $tn_tlg)
{
  $sql = "select tlg.*, tl.* from $tn_tlg tlg, $tn_tl tl where tl.tlg_id=tlg.tlg_id and tl.staff_id='$staff_id' and tlg.tlg_status='0' and tl.tl_status='0' order by tlg.class_id, tlg.subject_id";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["tlgId"] = $rows['tlg_id'];
    $sub_array["tlId"] = $rows['tl_id'];
    $sub_array["class_id"] = $rows['class_id'];
    $sub_array["subject_id"] = $rows['subject_id'];
    $sub_array["type"] = $rows['tlg_type'];
    $sub_array["group"] = $rows['tl_group'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_staffTeachingSubject($conn, $staff_id, $tn_tl, $tn_tlg)
{
  $sql = "select tlg.*, tl.* from $tn_tlg tlg, $tn_tl tl where tl.tlg_id=tlg.tlg_id and tl.staff_id='$staff_id' and tlg.tlg_status='0' and tl.tl_status='0' group by tlg.subject_id order by tlg.class_id, tlg.subject_id";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["tlgId"] = $rows['tlg_id'];
    $sub_array["tlId"] = $rows['tl_id'];
    $sub_array["subject_id"] = $rows['subject_id'];
    $sub_array["type"] = $rows['tlg_type'];
    $sub_array["group"] = $rows['tl_group'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_subjectAssessmentList($conn, $subjectId, $tn_ad)
{
  $sql = "select ad.* from $tn_ad where ad.subject_id='$subjectId' and ad.ad_status='0' order by ad.ad_id";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["ad_id"] = $rows['ad_id'];
    $sub_array["at_id"] = $rows['at_id'];
    $sub_array["subject_id"] = $rows['subject_id'];
    $sub_array["submit_id"] = $rows['submit_id'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_studentClassSubjectList($conn, $tn_rs, $subjectId, $classId, $tlGroup)
{
  $sql = "select * from $tn_rs where class_id='$classId' and subject_id='$subjectId' and tl_group='$tlGroup' and rs_status='0'";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["id"] = $rows['rs_id'];
    $sub_array["student"] = $rows['student_id'];
    $sub_array["date"] = $rows['rs_date'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_subjectAttendance($conn, $tn_sa, $tn_sas, $tlId, $studentId)
{
  $sql = "select * from $tn_sa sa, $tn_sas sas where sas.tl_id='$tlId' and sa.sas_id=sas.sas_id and sa.student_id='$studentId' and sa.sa_attendance='0'";
  $result = $conn->query($sql);
  $present = $result->num_rows;

  $sql = "select * from $tn_sa sa, $tn_sas sas where sas.tl_id='$tlId' and sa.sas_id=sas.sas_id and sa.student_id='$studentId'";
  $result = $conn->query($sql);

  $delivered = $result->num_rows;

  $output = array($delivered, $present);
  return $output;
}
function get_subjectResource($conn, $tn_res, $subject_id)
{
  $sql = "select * from $tn_res where subject_id='$subject_id' and rsb_status='0'";

  $result = $conn->query($sql);
  if (!$result) die(" The script could not be Loadded! Please report!");
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["id"] = $rows['rsb_id'];
    $sub_array["name"] = $rows['rsb_name'];
    $sub_array["type"] = $rows['rsb_type'];
    $sub_array["url"] = $rows['rsb_url'];
    $sub_array["rtId"] = $rows['rsb_id'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function getNotice($conn, $id, $myFolder)
{
  $sql = "SELECT * FROM notice where notice_id='$id'";
  $result = $conn->query($sql);
  if (!$result) die("re");
  else {
    $output = array();
    $arrayRows = $result->fetch_assoc();
    $output["notice_id"] = $arrayRows["notice_id"];
    $output["notice_subject"] = $arrayRows["notice_subject"];

    $folder = '../../' . $myFolder . '/notice';
    $fileName = $folder . '/text-' . $_POST["noticeId"] . '.txt';
    if (file_exists($fileName)) $content = file_get_contents($fileName);
    else $content = "No File Found";
    $output["content"] = $content;
  }
  return $output;
}
