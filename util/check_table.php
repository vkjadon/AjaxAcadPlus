<?php
//echo "Check Tables";

function check_tn_amap($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'ac_id INT(5) NULL,
    at_id INT(5) NULL,
    amap_grid INT(2) NULL,
    amap_internal VARCHAR(10) NULL,
    amap_weightage FLOAT NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(1) NULL,
    amap_status INT(1) NULL,
    UNIQUE(ac_id, at_id, amap_grid)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_ccd($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sas_id INT(5) NULL,
    sbt_id INT(5) NULL,
    UNIQUE(sas_id, sbt_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_class($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'class_id INT(5) NOT NULL AUTO_INCREMENT,
    session_id INT(3) NULL,
    program_id INT(3) NULL,
    batch_id INT(3) NULL,
    dept_id INT(3) NULL,
    class_name VARCHAR(18) NULL,
    class_section VARCHAR(2) NULL,
    class_shift VARCHAR(10) NULL,
    class_semester INT(2) NULL,
    class_group INT(1) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    class_status INT(1) NULL,
    PRIMARY KEY (class_id),
    UNIQUE(session_id, program_id, batch_id, class_name, class_section, class_shift)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_lt($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'lt_id INT(2) NOT NULL AUTO_INCREMENT,
    lt_name VARCHAR(50) NULL,
    lt_abbri VARCHAR(4) NULL,
    lt_male INT(3) NULL,
    lt_female INT(3) NULL,
    lt_monthly INT(2) NULL,
    lt_check INT(1) NULL,
    lt_carry INT(1) NULL,
    lt_max INT(3) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    lt_status INT(1) NULL,
    PRIMARY KEY (lt_id),
    UNIQUE(lt_name)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_org($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'org_id INT(5) NOT NULL AUTO_INCREMENT,
    org_name VARCHAR(50) NULL,
    org_url VARCHAR(50) NULL,
    org_mobile VARCHAR(10) NULL,
    org_email VARCHAR(50) NULL,
    org_address TEXT NULL,
    org_contact TEXT NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    org_status INT(1) NULL,
    PRIMARY KEY (org_id),
    UNIQUE(org_name, org_url)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_mn($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'mn_id INT(3) NOT NULL AUTO_INCREMENT,
    mn_code VARCHAR(3) NULL,
    mn_name VARCHAR(50) NULL,
    mn_remarks VARCHAR(150) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    mn_status INT(1) NULL,
    PRIMARY KEY (mn_id),
    UNIQUE(mn_code, mn_name)';

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
    update_id INT(5) NULL,
    update_ts timestamp Default current_timestamp,
    rc_status INT(1) NULL,
    PRIMARY KEY (rc_id),
    UNIQUE(student_id, class_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_rp($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'rp_id INT(5) NOT NULL AUTO_INCREMENT,
    rp_name VARCHAR(50) NULL,
    rp_designation VARCHAR(20) NULL,
    rp_mobile VARCHAR(10) NULL,
    rp_email VARCHAR(50) NULL,
    rp_address TEXT NULL,
    rp_about TEXT NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    rp_status INT(1) NULL,
    PRIMARY KEY (rp_id),
    UNIQUE(rp_mobile, rp_email)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

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
    update_ts timestamp Default current_timestamp,
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

function check_tn_respStaff($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'rs_id INT(5) NOT NULL AUTO_INCREMENT,
    rs_code VARCHAR(20) NULL,
    staff_id INT(4) NULL,
    unit_id INT(4) NULL,
    rs_from_date DATE,
    rs_to_date DATE,
    rs_remarks TEXT NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    rs_status INT(1) NULL,
    PRIMARY KEY (rs_id),
    UNIQUE(rs_code, staff_id, unit_id, rs_from_date)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
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
    update_ts timestamp Default current_timestamp,
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

function check_tn_std($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'student_id INT(5) NOT NULL AUTO_INCREMENT,
    batch_id int(3) NULL,
    program_id int(3) NULL,
    student_name varchar(50) NULL,
    student_rollno varchar(20) NULL,
    student_mobile varchar(10) NULL,
    student_email varchar(50) NULL,
    student_dob date NULL,
    update_ts timestamp Default current_timestamp,
    update_id int(4) NULL,
    student_status int(1) NULL,
    PRIMARY KEY (student_id),
    UNIQUE(student_rollno)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_si($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'si_id INT(5) not null auto_increment ,
    student_id INT(5) NULL,
    si_fname varchar(100) NULL,
    si_mname varchar(100) NULL,
    si_address text NULL,
    update_ts timestamp Default current_timestamp,
    update_id int(4) NULL,
    si_status int(1) NULL,
    PRIMARY KEY (si_id),
    UNIQUE(student_id)';
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
    echo "Table Missing $table";
    $query =
      'sbt_id INT(5) NOT NULL AUTO_INCREMENT,
    subject_id INT(5) NULL,
    sbt_name VARCHAR(100) NULL,
    sbt_sno INT(2) NULL,
    sbt_weight INT(2) NULL,
    sbt_slot INT(2) NULL,
    sbt_type INT(2) NULL,
    sbt_syllabus INT(1) NULL,
    update_ts timestamp Default current_timestamp,
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

function check_tn_sr($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sr_id INT(5) NULL AUTO_INCREMENT,
    subject_id INT(5) NULL,
    rt_id INT(2) NULL,
    sr_name VARCHAR(100) NULL,
    sr_type VARCHAR(10) NULL,
    sr_url TINYTEXT NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    sr_status INT(1) NULL,
    PRIMARY KEY (sr_id),
    UNIQUE(subject_id, rt_id, sr_name)';

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
    update_id INT(5) NULL,
    update_ts timestamp Default current_timestamp,
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
    update_id INT(5) NULL,
    update_ts timestamp Default current_timestamp,
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
