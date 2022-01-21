<?php
//echo "Check Tables";

function check_tn_atmp($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'atmp_id INT(5) NOT NULL AUTO_INCREMENT,
    ac_id INT(3) NULL,
    at_id INT(3) NULL,
    atmp_template INT(2) NULL,
    atmp_internal VARCHAR(10) NULL,
    atmp_weightage FLOAT NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(1) NULL,
    atmp_status INT(1) NULL,
    PRIMARY KEY (atmp_id),
    UNIQUE(ac_id, at_id, atmp_template)';

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
function check_tn_ee($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'ee_id INT(2) NOT NULL AUTO_INCREMENT,
    inst_id INT(2) NULL,
    sno INT(2) NULL,
    ee_name varchar(20) NULL,
    ee_abbri varchar(6) NULL,
    ee_type VARCHAR(2) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    ee_status INT(1) NULL,
    PRIMARY KEY (ee_id),
    UNIQUE(inst_id, ee_name)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_enrichment_activity($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'ea_id INT(5) NOT NULL AUTO_INCREMENT,
    mn_id INT(3) NULL,
    dept_id INT(3) NULL,
    ea_name VARCHAR(50) NULL,
    ea_from_date date NULL,
    ea_from_time time NULL,
    ea_to_date date NULL,
    ea_to_time time NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    ea_status INT(1) NULL,
    PRIMARY KEY (ea_id),
    UNIQUE(mn_id, dept_id, ea_name, update_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_enrichment_activity_participant($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'ea_id INT(3) NULL,
    participant_code varchar(10) NULL,
    code_id int(5) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    UNIQUE(ea_id, participant_code, code_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feeConcession($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'student_id INT(3) null,
    fee_type int(3) null,
    fee_semester int(3) null,
    fc_amount varchar(6) null,
    fc_dues varchar(6) null,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    fc_status INT(1) NULL,
    UNIQUE(student_id, fee_type, fee_semester)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feeDues($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'fd_id INT(5) not null auto_increment,
    student_id INT(3) null,
    fee_type int(3) null,
    fee_semester int(3) null,
    fd_fee varchar(6) null,
    fd_dues varchar(6) null,
    fd_concession varchar(6) null,
    fd_remarks varchar(100) null,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    fd_status INT(1) NULL,
    primary key(fd_id),
    UNIQUE(student_id, fee_type, fee_semester)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feedback($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'feedback_id INT(5) NOT NULL AUTO_INCREMENT,
    session_id INT(3) NULL,
    template_id INT(3) NULL,
    feedback_name VARCHAR(50) NULL,
    feedback_section int(1) NULL,
    feedback_open date NULL,
    feedback_open_time time NULL,
    feedback_close date NULL,
    feedback_close_time time NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    feedback_status INT(1) NULL,
    PRIMARY KEY (feedback_id),
    UNIQUE(session_id, template_id, feedback_name, update_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feedback_option($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'fq_id INT(3) NOT NULL AUTO_INCREMENT,
    fo_statement text NULL,
    fo_image VARCHAR(50) NULL,
    fo_score int(1) NULL,
    fo_sno int(2) NULL,
    UNIQUE(fq_id, fo_sno)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feedback_question($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'fq_id INT(3) NOT NULL AUTO_INCREMENT,
    fq_statement text NULL,
    fq_image VARCHAR(50) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    fq_status INT(1) NULL,
    PRIMARY KEY (fq_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_feedback_participant($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'feedback_id INT(3) NULL,
    participant_code varchar(10) NULL,
    code_id int(5) NULL,
    feedback_open datetime NULL,
    feedback_close datetime NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    UNIQUE(feedback_id, participant_code, code_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feeReverse($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'frev_id INT(3) AUTO_INCREMENT,
    fr_id int(3) null,
    frev_desc text null,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    frev_status INT(1) NULL,
    PRIMARY KEY (frev_id),
    UNIQUE(fr_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_feeStructure($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'school_id INT(3) null,
    program_id INT(3) null,
    batch_id int(3) null,
    fee_category INT(3) null,
    fee_type int(3) null,
    fee_component varchar(50) null,
    fee_semester int(3) null,
    fc_amount varchar(6) null,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    status INT(1) NULL,
    UNIQUE(school_id, program_id, batch_id, fee_category, fee_type, fee_semester )';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_feeSchedule($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'fsch_id INT(5) not null auto_increment,
      school_id INT(3) null,
    program_id INT(3) null,
    batch_id int(3) null,
    fee_category INT(4) null,
    fee_type int(4) null,
    fee_semester int(2) null,
    fsch_amount varchar(6) null,
    last_date date null,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    fsch_status INT(1) NULL,
    primary key(fsch_id),
    UNIQUE(school_id, program_id, batch_id, fee_category, fee_type, fee_semester)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}


function check_tn_il($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'il_id INT(5) NOT NULL AUTO_INCREMENT,
    il_name varchar(50) NULL,
    il_code varchar(10) NULL,
    il_capacity int(4) NULL,
    il_type int(4) NULL,
    il_block int(4) NULL,
    il_col int(2) NULL,
    il_row int(2) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    il_status INT(1) NULL,
    PRIMARY KEY (il_id),
    UNIQUE(il_name, il_code)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_lc($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'lc_id INT(5) NOT NULL AUTO_INCREMENT,
    staff_id int(4) NULL,
    lc_date date NULL,
    lc_order varchar(50) NULL,
    lc_reason text NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    lc_status INT(1) NULL,
    PRIMARY KEY (lc_id),
    UNIQUE(staff_id, lc_date)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_ld($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'short_leave float NOT NULL AUTO_INCREMENT,
    half_day float NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(4) NULL,
    UNIQUE(short_leave, half_day)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_leave_credit($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'lcr_id INT(5) NOT NULL AUTO_INCREMENT,
    lcr_year int(4) NULL,
    lcr_month int(2) NULL,
    lt_id INT(2) NULL,
    lcr_male INT(2) NULL,
    lcr_female INT(2) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    lcr_status INT(1) NULL,
    PRIMARY KEY (lcr_id),
    UNIQUE(lcr_year, lcr_month, lt_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_ll($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'll_id INT(5) NOT NULL AUTO_INCREMENT,
    staff_id int(4) NULL,
    lt_id int(2) NULL,
    ll_from datetime NULL,
    ll_to datetime NULL,
    ll_days float NULL,
    ll_reason text NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    ll_status INT(1) NULL,
    PRIMARY KEY (ll_id),
    UNIQUE(staff_id, ll_from)';

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

function check_tn_ly($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'ly_id INT(2) NOT NULL AUTO_INCREMENT,
    ly_from date NULL,
    ly_to date NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(4) NULL,
    ly_status INT(1) NULL,
    PRIMARY KEY (ly_id),
    UNIQUE(ly_id, ly_from)';

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
    org_about TEXT NULL,
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
      'mn_id INT(4) NOT NULL AUTO_INCREMENT,
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
function check_tn_pv($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'pv_id INT(5) NOT NULL AUTO_INCREMENT,
    pv_type varchar(6) NULL,
    pv_head int(4) NULL,
    pv_mode int(4) NULL,
    pv_amount int(8) NULL,
    transaction_id varchar(20) NULL,
    transaction_date date NULL,
    pv_bank varchar(50) NULL,
    pv_desc text,
    bill_no varchar(12) NULL,
    bill_date date NULL,
    bill_amount int(8) NULL,
    payee_name varchar(50) NULL,
    payee_mobile varchar(10) NULL,
    payee_id varchar(50) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    pv_status INT(1) NULL,
    PRIMARY KEY (pv_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_pvr($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'pr_id INT(3) AUTO_INCREMENT,
    pv_id int(3) null,
    pr_desc text null,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    pr_status INT(1) NULL,
    PRIMARY KEY (pr_id),
    UNIQUE(pv_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_qb_cp($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'qb_id INT(5) NULL,
    qc_sno int(2) NULL,
    qc_name varchar(50) NULL,
    qc_marks float NULL,
    qc_range float NULL,
    qc_verification int(1),
    UNIQUE(qb_id, qc_name)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_qb_parameter($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'qb_id INT(5) NULL,
    qp_sno int(2) NULL,
    qp_name varchar(50) NULL,
    qp_min float NULL,
    qp_max float NULL,
    qp_step int(1),
    UNIQUE(qb_id, qp_sno)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_question_bank($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'qb_id INT(5) NOT NULL AUTO_INCREMENT,
    qb_level int(1) NULL,
    qb_base int(1) NULL,
    qb_text text NULL,
    qb_image VARCHAR(150) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    qb_status INT(1) NULL,
    PRIMARY KEY (qb_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_question_option($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'qb_id INT(5) not null,
    qo_text text NULL,
    qo_image VARCHAR(150) NULL,
    qo_code int(1) NULL,
    qo_correct int(1) NULL,
    UNIQUE(qb_id, qo_code)';

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
    rc_group INT(2) NULL,
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
    mn_id int(4) NULL,
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
    UNIQUE(mn_id, rs_code, staff_id, unit_id, rs_from_date)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_rl($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'pl_id INT(4) NULL,
    mn_id INT(4) NULL,
    UNIQUE(pl_id, mn_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_sa($conn, $tn_sa)
{
  $sql = "select * from $tn_sa";
  $result = $conn->query($sql);
  if (!$result) {
    $query =
      'sas_id INT(5) NULL,
        student_id int(5) NULL,
        sa_attendance INT(1) NULL,
        UNIQUE(sas_id, student_id)';
    $sql = "CREATE TABLE $tn_sa ($query)";
    $result = $conn->query($sql);
    // if (!$result) echo $conn->error;
  }
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
    staff_id INT(5) NULL,
    sas_mark INT(1) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(4) NULL,
    sas_status INT(1) NULL,
    PRIMARY KEY (sas_id),
    UNIQUE(tl_id, sas_period, sas_date)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}

function check_tn_sat($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sat_id INT(5) NOT NULL AUTO_INCREMENT,
      tl_id INT(3) NULL,
    atmp_template int(2) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    sat_status INT(1) NULL,
    PRIMARY KEY(sat_id),
    UNIQUE(tl_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_sbas($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'tl_id INT(5) NULL,
    atmp_id VARCHAR(100) NULL,
    sbas_assessments INT(2) NULL,
    sbas_consider INT(2) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    UNIQUE(tl_id, atmp_id)';

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
    // echo "Table Missing $table";
    $query =
      'sbt_id INT(5) NOT NULL AUTO_INCREMENT,
    subject_id INT(5) NULL,
    sbt_name VARCHAR(100) NULL,
    sbt_sno INT(2) NULL,
    sbt_weight INT(2) NULL,
    sbt_slot INT(2) NULL,
    sbt_type varchar(1) NULL,
    sbt_syllabus INT(1) NULL,
    sbt_unit INT(2) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    sbt_status INT(1) NULL,
    PRIMARY KEY (sbt_id),
    UNIQUE(subject_id, sbt_name, sbt_type)';

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
function check_tn_sdl($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'schedule_id INT(4) NOT NULL AUTO_INCREMENT,
    schedule_name varchar(100) NULL,
    schedule_venue varchar(20) NULL,
    schedule_date date NULL,
    schedule_time_from time NULL,
    schedule_time_to time NULL,
    registration_link text NULL,
    webinar_link text NULL,
    schedule_remarks text NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    schedule_status INT(1) NULL,
    PRIMARY KEY (schedule_id),
    UNIQUE(schedule_name, schedule_date,schedule_time_from, update_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_sm($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    $query =
      'sms_id INT(5) NULL,
		student_id int(5) NULL,
		sm_marks INT(1) NULL,
		sm_exam_status INT(1) NULL,
		UNIQUE(sms_id, student_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}
function check_tn_sms($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sms_id INT(5) NOT NULL AUTO_INCREMENT,
    tl_id INT(5) NULL,
    ee_id INT(3) NULL,
    sms_max_marks int(3),
    sms_pass_marks int(3),
    sms_mark INT(1) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(4) NULL,
    sms_status INT(1) NULL,
    PRIMARY KEY (sms_id),
    UNIQUE(tl_id, ee_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}

function check_tn_sr($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sr_id INT(5) NOT NULL AUTO_INCREMENT,
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

function check_tn_src($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'sr_id INT(5) NULL,
    class_id INT(4) NULL,
    UNIQUE(sr_id, class_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_stdqual($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    // Auto Increment not Required
    $query =
      'sq_id int(5) NOT NULL AUTO_INCREMENT,
    student_id INT(5) NULL,
    mn_id int(3) NULL,
    sq_institute varchar(100) NULL,
    sq_board varchar(50) NULL,
    sq_year int(4) NULL,
    sq_mo int(4) NULL,
    sq_mm int(4) NULL,
    sq_percentage float NULL,
    sq_cgpa float NULL,
    update_ts timestamp Default current_timestamp,
    update_id int(4) NULL,
    sq_status int(1),
    PRIMARY KEY(sq_id),
    UNIQUE(student_id, mn_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_stdscl($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    // echo "Table Missing $table";
    $query =
      'student_id INT(5) NULL,
    mn_id int(3) NULL,
    semester int(2) NULL,
    sscl_stage int(2) NULL,
    sscl_amount int(6) NULL,
    sscl_date date NULL,
    update_ts timestamp Default current_timestamp,
    update_id int(4) NULL,
    sscl_status int(1),
    UNIQUE(student_id, mn_id, semester, sscl_stage)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_sub($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'subject_id INT(5) NOT NULL AUTO_INCREMENT,
    batch_id int(3) NULL,
    program_id INT(3) NULL,
    subject_semester INT(2) NULL,
    subject_name varchar(75) NULL,
    subject_code varchar(10) NULL,
    subject_type varchar(2) NULL,
    subject_lecture INT(1) NULL,
    subject_tutorial INT(1) NULL,
    subject_practical INT(1) NULL,
    subject_credit float NULL,
    subject_sno int(2) NULL,
    subject_mode varchar(10) NULL,
    subject_category varchar(10) NULL,
    subject_internal int(3) NULL,
    subject_external int(3) NULL,
    subject_vac int(1) NULL,
    subject_emp int(1) NULL,
    subject_entrep int(1) NULL,
    subject_skill int(1) NULL,
    subject_hu int(1) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    subject_status INT(1) NULL,
    PRIMARY KEY (subject_id),
    UNIQUE(subject_code, batch_id, program_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_subelective($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'se_id INT(5) not null auto_increment,
    ep_id int(5) NULL,
    de_id int(5) NULL,
    offered int(1) NULL,
    cbcs int(1) NULL,
    choice_start timestamp Default current_timestamp,
    choice_end timestamp Default current_timestamp,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    primary key (se_id),
    UNIQUE(ep_id, de_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}

function check_tn_test($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'test_id INT(5) not null auto_increment,
    test_name varchar(50) NULL,
    test_section int(1) NULL,
    test_from_date date NULL,
    test_from_time time NULL,
    test_to_date date NULL,
    test_to_time time NULL,
    test_duration int(3) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    test_status INT(1) NULL,
    primary key (test_id),
    UNIQUE(test_name, update_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}
function check_tn_test_participant($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'test_id INT(3) NULL,
    participant_code varchar(10) NULL,
    code_id int(5) NULL,
    update_ts timestamp default current_timestamp(),
    update_id INT(5) NULL,
    UNIQUE(test_id, participant_code, code_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
function check_tn_test_question($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'test_id INT(5) null,
    test_section int(1) NULL,
    qb_id int(5) NULL,
    tq_marks int(2) NULL,
    tq_nmarks int(1) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    tq_status INT(1) NULL,
    UNIQUE(test_id, qb_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}

function check_tn_template($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'template_id INT(3) not null auto_increment,
    mn_id int(3) NULL,
    template_name varchar(50) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    template_status INT(1) NULL,
    primary key (template_id),
    UNIQUE(template_name, mn_id, update_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
}

function check_tn_template_question($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    echo "Table Missing $table";
    $query =
      'template_id INT(3) null,
    fq_id int(3) NULL,
    update_ts timestamp Default current_timestamp,
    update_id INT(5) NULL,
    UNIQUE(template_id, fq_id, update_id)';
    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
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
function check_tn_todo($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'todo_id INT(5) NOT NULL AUTO_INCREMENT,
    staff_id INT(5) NULL,
    todo_name varchar(30) NULL,
    todo_type int(1) NULL,
    todo_target date null,
    update_ts timestamp Default current_timestamp,
    todo_status INT(1) NULL,
    PRIMARY KEY (todo_id),
    UNIQUE(staff_id, todo_name, todo_type)';

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

function check_tn_user($conn, $table)
{
  $sql = "select * from $table";
  $result = $conn->query($sql);
  if (!$result) {
    //echo "Table Missing $table";
    $query =
      'staff_id int(4) NULL,
    student_id INT(5) NULL,
    user_password varchar(150) NULL,
    last_login timestamp DEFAULT CURRENT_TIMESTAMP,
    user_status int(1) NULL,
    UNIQUE(staff_id, student_id)';

    $sql = "CREATE TABLE $table ($query)";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  }
  //else echo "Table Exists";
}
