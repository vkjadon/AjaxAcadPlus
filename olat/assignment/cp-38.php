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
	$MaxBM=$abp[0]*1000*1000;		// N.mm
	$MaxTM=$abp[1]*1000*1000;		// N.mm
	$TauD=$abap[0];

	$EqTM=sqrt($MaxBM*$MaxBM+$MaxTM*$MaxTM);
	$EqBM=0.5*($MaxBM+sqrt($MaxBM*$MaxBM+$MaxTM*$MaxTM));

//	echo "Max BM $MaxBM Max TM $MaxTM";
	$ke=1; $iteration=0; $psd=0;
	do
	{
		$var=(16*$EqTM)/(pi()*$ke*$TauD);
		$shaft_diameter=pow($var,(1/3));
		require("../standard/shaft-diameters.php");
		require("../standard/key-dimensions.php");
		$ke=1.0-(0.2*$width/$shaft_diameter)-(1.1*$height/$shaft_diameter);
//		echo "$iteration $psd $shaft_diameter Tau $TauD- <br>";
		if($psd>$shaft_diameter)$error=$psd-$shaft_diameter;
		else $error=-($psd-$shaft_diameter);
		if($error<2)break;
		$iteration++;
		$psd=$shaft_diameter;
	}while($iteration<10);
	$pcp[0]=round($ke,3);
	$pcp[1]=$shaft_diameter;
	$pcp[2]=round((16*$MaxTM/(pi()*pow($shaft_diameter,3))),2);
	$pcp[3]=round((32*$MaxBM/(pi()*pow($shaft_diameter,3))),2);
	$pcp[4]=round($EqBM/1000,2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Keyway Factor</td><td>'.round($pcp[0],4).' mm</td></tr>';
		echo '<tr><td>Shaft Diameter</td><td>'.$pcp[1].' mm</td></tr>';
		echo '<tr><td>Maximum Shear Stress</td><td>'.$pcp[2].' MPa</td></tr>';
		echo '<tr><td>Maximum Normal Stress</td><td>'.$pcp[3].' N.m</td></tr>';
		echo '<tr><td>Equivalent Bending Moment</td><td>'.$pcp[4].' N.m</td></tr>';
		echo '<tr><td>Equivalent Twisting Moment</td><td>'.round($EqTM/1000,2).' N.m</td></tr>';
		echo '</table>';
	}

?>