<?php
//echo "Check Tables";
function check_tn_sas($conn, $table){
  $sql="select * from $table";  
  $result=$conn->query($sql);
  if(!$result)
  {
    //echo "Table Missing $table";
    $query=
    'sas_id INT(5) NOT NULL AUTO_INCREMENT,
    tl_id INT(5) NOT NULL,
    sas_period INT(2) NOT NULL,
    sas_date DATE,
    update_ts timestamp NOT NULL,
    staff_id INT(5) NOT NULL,
    sas_mark INT(1) NOT NULL,
    sas_status INT(1) NOT NULL,
    PRIMARY KEY (sas_id),
    UNIQUE(tl_id, sas_period, sas_date)';
    $sql="CREATE TABLE $table ($query)";
    $result=$conn->query($sql);
    if(!$result)echo $conn->error;
  }
}
function check_tn_sa($conn, $table){
  $sql="select * from $table";  
  $result=$conn->query($sql);
  if(!$result)
  {
    echo "Table Missing $table";
    $query=
    'sas_id INT(5) NOT NULL,
    student_id INT(5) NOT NULL,
    sa_attendance INT(1) NOT NULL,
    UNIQUE(sas_id, student_id)';    
    $sql="CREATE TABLE $table ($query)";
    $result=$conn->query($sql);
    if(!$result)echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_tl($conn, $table){
  $sql="select * from $table";  
  $result=$conn->query($sql);
  if(!$result)
  {
    echo "Table Missing $table";
    $query=
    'tl_id INT(5) NOT NULL AUTO_INCREMENT,
    tlg_id INT(5) NOT NULL,
    tl_group INT(5) NOT NULL,
    staff_id INT(5) NOT NULL,
    submit_id INT(5) NOT NULL,
    submit_ts timestamp NOT NULL,
    tl_status INT(1) NOT NULL,
    PRIMARY KEY (tl_id),
    UNIQUE(tlg_id, tl_group, staff_id)';
    
    $sql="CREATE TABLE $table ($query)";
    $result=$conn->query($sql);
    if(!$result)echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_tlg($conn, $table){
  $sql="select * from $table";  
  $result=$conn->query($sql);
  if(!$result)
  {
    //echo "Table Missing $table";
    $query=
    'tlg_id INT(5) NOT NULL AUTO_INCREMENT,
    subject_id INT(5) NOT NULL,
    class_id INT(4) NOT NULL,
    tlg_type VARCHAR(1) NOT NULL,
    tlg_group INT(1) NOT NULL,
    submit_id INT(5) NOT NULL,
    submit_ts timestamp NOT NULL,
    tlg_status INT(1) NOT NULL,
    PRIMARY KEY (tlg_id),
    UNIQUE(subject_id, class_id, tlg_type)';
    
    $sql="CREATE TABLE $table ($query)";
    $result=$conn->query($sql);
    if(!$result)echo $conn->error;
  }
  //else echo "Table Exists";
}
