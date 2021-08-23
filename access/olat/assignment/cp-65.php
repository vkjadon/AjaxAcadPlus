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
	$Fe=$abp[1];		// kN
	$theta=pi()/6;
//	echo "1";
	$Ax=0;
	$Ay=(3*$Fc+$Fe)/4;
	$By=($Fc+3*$Fe)/4;
//	echo "2";
	$F_A=sqrt(pow($Ax,2)+pow($Ay,2));
	$pcp[0]=round($F_A,2);
	$pcp[1]=-round(($By/sin($theta)),2);		//AE
	$pcp[2]=$Fe;		//AE
	$pcp[3]=-round(($pcp[1]*cos($theta)),2);		//AE
	
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Ax</td><td>'.$Ax.' kN</td></tr>';
		echo '<tr><td>Ay</td><td>'.$Ay.' kN</td></tr>';
		echo '<tr><td>By</td><td>'.$By.' kN</td></tr>';
		echo '<tr><td>F_A</td><td>'.$pcp[0].' kN</td></tr>';
		echo '<tr><td>F_BG</td><td>'.$pcp[1].' kN</td></tr>';
		echo '<tr><td>F_EG</td><td>'.$pcp[2].' kN</td></tr>';
		echo '<tr><td>F_DE</td><td>'.$pcp[3].' kN</td></tr>';
		echo '</table>';
	}
?>