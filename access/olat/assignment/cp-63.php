<?php
//	echo "Start ";
/*
	use $abp[0] for parameter-1
	use $abp[1] for parameter-2
	...... and so on....

For Design Type Problems

	use $abap[0] for Assumed parameter-1
	use $abap[1] for Assumed parameter-2
	...... and so on....

To inclue standard file
	require("../standard/shaft-diameters.php");
*/
	$Fc=$abp[0];		// kN
	$theta=atan(4/6);

	$pcp[1]=-round((($Fc)/sin($theta)),2);		//AE

	$Ax=$pcp[1]*cos($theta);

	$Ay=0;
	$F_A=sqrt(pow($Ax,2)+pow($Ay,2));
	$pcp[0]=round($F_A,2);
	$pcp[2]=-round(($Fc/sin($theta)),2);		//AE
	$pcp[3]=0;		//AE
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Ax</td><td>'.$Ax.' kN</td></tr>';
		echo '<tr><td>Ay</td><td>'.$Ay.' kN</td></tr>';
		echo '<tr><td>By</td><td>'.$By.' kN</td></tr>';
		echo '<tr><td>F_A</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>F_ED</td><td>'.$pcp[1].' kN</td></tr>';
		echo '<tr><td>F_CD</td><td>'.$pcp[2].' kN</td></tr>';
		echo '<tr><td>F_BD</td><td>'.$pcp[3].' kN</td></tr>';
		echo '</table>';
	}
?>