<?php
//echo "Check Tables";
function check_tn_rs($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'rs_id INT(5) NOT NULL AUTO_INCREMENT,
    student_id INT(5) NULL,
    tl_id INT(4) NULL,
    rs_date DATE,
    update_ts timestamp,
    update_id INT(5) NULL,
    rs_status INT(1) NULL,
    PRIMARY KEY (rs_id),
    UNIQUE(student_id, tl_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_rc($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'rc_id INT(5) NOT NULL AUTO_INCREMENT,
    student_id INT(5) NULL,
    class_id INT(4) NULL,
    rc_date DATE,
    submit_id INT(5) NULL,
    submit_ts timestamp NOT NULL,
    rc_status INT(1) NULL,
    PRIMARY KEY (rc_id),
    UNIQUE(student_id, class_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_sc($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'tlg_id INT(4) NULL, 
    staff_id INT(5) NULL,
    choice INT(1) NULL,
    UNIQUE(tlg_id, staff_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_sbt($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sbt_id INT(5) NOT NULL AUTO_INCREMENT,
    subject_id INT(5) NULL,
    sbt_name TEXT NULL,
    sbt_sno INT(2) NULL,
    sbt_weight INT(2) NULL,
    sbt_slot INT(2) NULL,
    sbt_type INT(2) NULL,
    sbt_syllabus INT(1) NULL,
    update_ts timestamp,
    update_id INT(5) NULL,
    sbt_status INT(1) NULL,
    PRIMARY KEY (sbt_id),
    UNIQUE(subject_id, sbt_name)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_sas($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sas_id INT(5) NOT NULL AUTO_INCREMENT,
    tl_id INT(5) NULL,
    sas_period INT(2) NULL,
    sas_date DATE,
    update_ts timestamp NULL,
    staff_id INT(5) NULL,
    sas_mark INT(1) NULL,
    sas_status INT(1) NULL,
    PRIMARY KEY (sas_id),
    UNIQUE(tl_id, sas_period, sas_date)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}
function check_tn_sa($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'sas_id INT(5) NULL,
    student_id INT(5) NULL,
    sa_attendance INT(1) NULL,
    UNIQUE(sas_id, student_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_tl($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'tl_id INT(5) NOT NULL AUTO_INCREMENT,
    tlg_id INT(5) NULL,
    tl_group INT(5) NULL,
    staff_id INT(5) NULL,
    submit_id INT(5) NULL,
    submit_ts timestamp NULL,
    tl_status INT(1) NULL,
    PRIMARY KEY (tl_id),
    UNIQUE(tlg_id, tl_group, staff_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_tlg($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'tlg_id INT(5) NOT NULL AUTO_INCREMENT,
    subject_id INT(5) NULL,
    class_id INT(4) NULL,
    tlg_type VARCHAR(1) NULL,
    tlg_group INT(1) NULL,
    dept_id INT(1) NULL,
    submit_id INT(5) NULL,
    submit_ts timestamp NULL,
    tlg_status INT(1) NULL,
    PRIMARY KEY (tlg_id),
    UNIQUE(subject_id, class_id, tlg_type)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_tt($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'tl_id INT(5) NULL,
    tt_day VARCHAR(10) NULL,
    tt_period INT(1) NULL,
    il_id INT(4) NULL,
    tt_clash INT(1) NULL,
    update_id INT(5) NULL,
    update_ts timestamp Default current_timestamp,
    UNIQUE(tl_id, tt_day, tt_period)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_ttp($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'class_id INT(5) NULL,
    ttp_day VARCHAR(10) NULL,
    ttp_period INT(1) NULL,
    ttp_start TIME NULL,
    update_id INT(5) NULL,
    update_ts timestamp DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(class_id, ttp_day, ttp_period)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}