    <div class="bg-danger text-white text-center py-1 mt-2">Default Settings</div>
    <?php
    if (isset($myScl)) {
        $name = getField($conn, $myScl, "school", "school_id", "school_abbri");
        $sql = "select * from school where school_status='0'";
        selectList($conn, 'School', array('0', 'school_id', 'school_abbri', '', 'sel_school', $myScl, $name), $sql);
    } else {
        $sql = "select * from school where school_status='0'";
        selectList($conn, 'School', array('0', 'school_id', 'school_abbri', '', 'sel_school'), $sql);
    }
    if (isset($myDept)) {
        $name = getField($conn, $myDept, "department", "dept_id", "dept_abbri");
        $sql = "select * from department where dept_status='0'";
        selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri', '', 'sel_dept', $myDept, $name), $sql);
    } else {
        $sql = "select * from department where dept_status='0'";
        selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri', '', 'sel_dept'), $sql);
    }
    if (isset($myProg)) {
        $name = getField($conn, $myProg, "program", "program_id", "sp_abbri");
        $sql = "select * from program where program_status='0'";
        selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', '', 'sel_program', $myProg, $name), $sql);
    } else {
        $sql = "select * from program where program_status='0'";
        selectList($conn, 'Sel Program', array('0', 'program_id', 'sp_abbri', '', 'sel_program'), $sql);
    }
    if (isset($mySes)) {
        $name = getField($conn, $mySes, "session", "session_id", "session_name");
        $sql = "select * from session where session_status='0'";
        selectList($conn, 'Session', array('1', 'session_id', 'session_name', 'session_id', 'sel_session', $mySes, $name), $sql);
    } else {
        $sql = "select * from session where session_status='0'";
        selectList($conn, 'Session', array('1', 'session_id', 'session_name', '', 'sel_session'), $sql);
    }
    ?>