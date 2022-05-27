	<div class="card mb-2">
		<div class="card-body m-0 p-1">
			<div class="text-center">Set Default</div>
			<div class="row">
				<div class="col-6 pr-0" title="Institution/School">
					<?php
					// echo $myScl.'-'.$myDept.'-'.$myProg;
					if (isset($myScl)) {
						$name = getField($conn, $myScl, "school", "school_id", "school_abbri");
						$sql = "select * from school where school_status='0' order by school_name";
						selectList($conn, 'Sel School', array('1', 'school_id', 'school_name', 'school_abbri', 'sel_school', $myScl, $name), $sql);
					} else {
						$sql = "select * from school where school_status='0' order by school_name";
						selectList($conn, 'Sel School', array('1', 'school_id', 'school_name', 'school_abbri', 'sel_school'), $sql);
					}
					?>
				</div>
				<div class="col-md-6 pl-0" title="Department">
					<?php
					if (isset($myDept) && isset($myScl)) {
						$name = getField($conn, $myDept, "department", "dept_id", "dept_abbri");
						$sql = "select * from department where dept_status='0' order by dept_name";

						selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept', $myDept, $name), $sql);
					} elseif (isset($myScl)) {
						$sql = "select * from department where dept_status='0' order by dept_name";
						selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept'), $sql);
					} else {
						$sql = "select * from department where dept_status='0' order by dept_name";
						selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept'), $sql);
					}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 pr-0" title="Programs/Specialization/Branch">
					<?php
					if (isset($_SESSION['mypid']) && isset($myDept)){
						//echo $myBatch;
						$name = getField($conn, $myProg, "program", "program_id", "sp_abbri");
						$sql = "select p.* from program p, dept_program dp where dp.dept_id='$myDept' and dp.program_id=p.program_id and p.program_status='0' order by p.sp_abbri";
						selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', 'sp_name', 'sel_program', $myProg, $name), $sql);
					} else {
						$sql = "select * from program where program_status='0' order by sp_abbri";
						selectList($conn, 'Program', array('1', 'program_id', 'sp_abbri', 'sp_name', 'sel_program'), $sql);
					}
					?>

				</div>
				<div class="col-md-4 pl-0 pr-0" title="Academic Session">
					<?php
					//echo "My School in SetDefault $myScl";
					if (isset($mySes)) {
						$name = getField($conn, $mySes, "session", "session_id", "session_name");
						$sql = "select * from session where session_status='0' order by session_id desc";
						selectList($conn, 'Session', array('1', 'session_id', 'session_name', 'session_id', 'sel_session', $mySes, $name), $sql);
					} else {
						$sql = "select * from session where session_status='0' order by session_id desc";
						selectList($conn, 'Session', array('1', 'session_id', 'session_name', 'session_id', 'sel_session'), $sql);
					}
					?>
				</div>
				<div class="col-md-2 pl-0" title="Batch">
					<?php
					if (isset($_SESSION['myBatch'])) {
						//echo $myBatch;
						$name = getField($conn, $myBatch, "batch", "batch_id", "batch");
						$sql = "select * from batch where batch_status='0' order by batch desc";
						selectList($conn, 'Batch', array('1', 'batch_id', 'batch', 'batch_id', 'sel_batch', $myBatch, $name), $sql);
					} else {
						$sql = "select * from batch where batch_status='0' order by batch desc";
						selectList($conn, 'Batch', array('1', 'batch_id', 'batch', '', 'sel_batch'), $sql);
					}
					?>
				</div>
			</div>
			Logged in as 
			<?php if($privilege=="9")echo "Admin"; 
			elseif($privilege=="1")echo "Staff";
			elseif($privilege=="0")echo "Faculty";
			else echo "Not Set";
			?> 
		</div>
	</div>