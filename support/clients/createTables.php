<?php
  $db=$_POST['db'];
  $servername = "localhost";  // Host Name
  $username = "root";         // Database User Name
  $password = "";             // Database User Password
  $db = "classcon_".$db;      // Database Name

  // Create connection
  $conn = new mysqli($servername, $username, $password, $db);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //else $output=json_encode("Connected successfully");

  $sql = "select * from staff_service";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'staff_id INT(5) NULL,
    dept_id int(2) NULL,
    designation_id int(2) NULL,
    ss_from date NULL,
    ss_order VARCHAR(100) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(4) NULL,
    ss_status INT(1) NULL,
    UNIQUE (staff_id, dept_id, designation_id)';

    $sql = "CREATE TABLE staff_service ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into staff_service (staff_id, dept_id, designation_id, ss_from, update_id, ss_status) values('1', '1', '1', '2015-07-10', '1', '0')";
      $conn->query($sql);
    }
  }
  
  $sql = "select * from staff";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'staff_id INT(4) NOT NULL AUTO_INCREMENT,
    school_id int(2) NULL,
    staff_name varchar(100) NULL,
    staff_dob date NULL,
    staff_fname VARCHAR(100) NULL,
    staff_mname VARCHAR(100) NULL,
    staff_doj date NULL,
    user_id VARCHAR(10) NULL,
    staff_mobile VARCHAR(10) NULL,
    staff_email VARCHAR(50) NULL,
    staff_adhaar VARCHAR(10) NULL,
    staff_address text NULL,
    staff_gender VARCHAR(1) NULL,
    staff_abbri VARCHAR(4) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(4) NULL,
    staff_status INT(1) NULL,
    PRIMARY KEY (staff_id),

    UNIQUE(staff_name, staff_email)';

    $sql = "CREATE TABLE staff ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into staff (school_id, staff_name, staff_dob, user_id, staff_mobile, staff_email, staff_status) values('1', 'Admin', '2010-07-10', 'CC001', '9872993230', 'vijay.jadon@gmail.com', '0')";
      $conn->query($sql);
    }
  }

  $sql = "select * from school_dept";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'school_id INT(2) NULL,
    dept_id int(2) NULL,
    sd_start date NULL,
    sd_end date NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    UNIQUE(school_id, dept_id)';

    $sql = "CREATE TABLE school_dept ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into school_dept (school_id, dept_id, sd_start, update_id) values('1', '1', '2015-07-10', '1')";
      $conn->query($sql);
    }
  }

  $sql = "select * from batch";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'batch_id INT(2) NOT NULL AUTO_INCREMENT,
    batch int(4) NULL,
    academic_year varchar(10) NULL,
    batch_start date NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(4) NULL,
    batch_status INT(1) NULL,
    PRIMARY KEY (batch_id),
    UNIQUE(batch)';

    $sql = "CREATE TABLE batch ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into batch (batch, academic_year, update_id, batch_status) values('2015', '2015-16', '1', '0')";
      $conn->query($sql);
    }
  }

  $sql = "select * from dept_program";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'dept_id INT(5) NULL,
    program_id int(3) NULL,
    dp_start date NULL,
    dp_end date NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    UNIQUE(dept_id, program_id)';

    $sql = "CREATE TABLE dept_program ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into dept_program (dept_id, program_id, dp_start, update_id) values('1', '1', '2015-07-10', '1')";
      $conn->query($sql);
    }
  }

  $sql = "select * from session";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'session_id INT(5) NOT NULL AUTO_INCREMENT,
    ay_id int(3) NULL,
    school_id int(2) NULL,
    session_name varchar(20) NULL,
    session_remarks text NULL,
    session_start date NULL,
    session_end date NULL,
    sno int(2) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    session_status INT(1) NULL,
    PRIMARY KEY (session_id),
    UNIQUE(session_name, school_id, ay_id)';

    $sql = "CREATE TABLE session ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into session (session_name, ay_id, school_id, session_remarks, session_start, update_id, session_status) values('ODD', '1', '1','Please Change', '2015-07-10', '1', '0')";
      $conn->query($sql);
    }
  }

  $sql = "select * from program";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'program_id INT(5) NOT NULL AUTO_INCREMENT,
    program_name varchar(100) NULL,
    program_abbri VARCHAR(10) NULL,
    program_code varchar(5) NULL,
    sp_name varchar(100) NULL,
    sp_abbri varchar(10) NULL,
    sp_code varchar(5) NULL,
    program_seat int(4) NULL,
    program_duration int(2) NULL,
    program_semester int(2) NULL,
    program_start int(4) NULL,
    sno int(2) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    program_status INT(1) NULL,
    PRIMARY KEY (program_id),
    UNIQUE(program_name, sp_name)';

    $sql = "CREATE TABLE program ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into program (sno, program_name, program_abbri, sp_name, sp_abbri, program_seat, program_start, update_id, program_status) values('1', 'Default Program- Please Change', 'NProg', 'Specialization', 'NSp', '60', '2010', '1', '0')";
      $conn->query($sql);
    }
  }

  $sql = "select * from department";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'dept_id INT(5) NOT NULL AUTO_INCREMENT,
    sno INT(2) NULL,
    dept_name varchar(100) NULL,
    dept_abbri VARCHAR(10) NULL,
    dept_type int(1) NULL,
    dept_logo blob NULL,
    dept_url varchar(100) NULL,
    dept_doi date NULL,
    dept_email VARCHAR(50) NULL,
    dept_mobile VARCHAR(10) NULL,
    dept_contact text NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    dept_status INT(1) NULL,
    PRIMARY KEY (dept_id)';

    $sql = "CREATE TABLE department ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into department (sno, dept_name, dept_abbri, dept_type, dept_url, dept_email, dept_mobile, update_id, dept_status) values('1','Default School- Please Change', 'NDept', '0', 'https://classconnect.in', 'eisoftech.in@gmail.com', '9872993230', '1', '0')";
      $conn->query($sql);
    }
  }

  $sql = "select * from school";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'school_id INT(5) NOT NULL AUTO_INCREMENT,
    school_name varchar(100) NULL,
    school_abbri VARCHAR(10) NULL,
    school_logo blob NULL,
    school_url varchar(100) NULL,
    school_doi date NULL,
    school_email VARCHAR(50) NULL,
    school_mobile VARCHAR(10) NULL,
    school_contact text NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    school_status INT(1) NULL,
    PRIMARY KEY (school_id)';

    $sql = "CREATE TABLE school ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into school (school_name, school_abbri, school_url, school_email, school_mobile, update_id, school_status) values('Default School- Please Change', 'Sch', 'https://classconnect.in', 'eisoftech.in@gmail.com', '9872993230', '1', '0')";
      $conn->query($sql);
    }
  }

  $sql = "select * from institution";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
    'inst_id INT(5) NOT NULL AUTO_INCREMENT,
    inst_name varchar(100) NULL,
    inst_approval VARCHAR(100) NULL,
    inst_affiliation VARCHAR(100) NULL,
    inst_abbri VARCHAR(10) NULL,
    inst_logo blob NULL,
    inst_address VARCHAR(100) NULL,
    inst_city VARCHAR(20) NULL,
    inst_pincode int(6) NULL,
    inst_state varchar(50) NULL,
    inst_type varchar(10) NULL,
    inst_url varchar(100) NULL,
    inst_doi date NULL,
    inst_email VARCHAR(50) NULL,
    inst_phone_1 VARCHAR(10) NULL,
    inst_phone_2 VARCHAR(10) NULL,
    inst_contact text NULL,
    update_ts timestamp default current_timestamp(),
    submit_id INT(5) NULL,
    inst_status INT(1) NULL,
    PRIMARY KEY (inst_id)';

    $sql = "CREATE TABLE institution ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else{
      $sql="insert into institution (inst_name, inst_abbri, inst_url, inst_email, inst_phone_1, submit_id, inst_status) values('Default Instition- Please Change', 'NI', 'https://classconnect.in', 'eisoftech.in@gmail.com', '9872993230', '1', '0')";
      $conn->query($sql);
    }
  }