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
	$Sut=540;
	$SeDash=0.5*$Sut;
	$MaxBM=$abp[0]*$abp[1]*1000;		// N.mm
	$ka=$abap[0];
	$kb=1.0;
	$kc=1.0;
	$kd=1.0;
	$ke=1.0;
	$kf=1.38;

//	echo "Max BM $MaxBM ";
	$iteration=0; $pdia=0;
	do
	{
		$Se=($ka*$kb*$kc*$kd*$ke*$SeDash)/($kf);
		$SeD=$Se/$abp[2];
		$var=(32*$MaxBM)/(pi()*$SeD);
		$diameter=ceil(pow($var,(1/3)));
		$kb=1.1875*(pow(0.37*$diameter, -0.097));
//		echo "<br>$iteration $pdia $diameter SeD $SeD";
		if($pdia>$diameter)$error=$pdia-$diameter;
		else $error=-($pdia-$diameter);
		if($error<2)break;
		$iteration++;
		$pdia=$diameter;
	}while($iteration<10);
	$pcp[0]=round($Se,3);
	$pcp[1]=$diameter;
	$pcp[2]=round($kb,3);
	$pcp[3]=round((32*$MaxBM/(pi()*pow($diameter,3))),2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Endurance Limit </td><td>'.$pcp[0].' MPa</td></tr>';
		echo '<tr><td>Diameter</td><td>'.$pcp[1].' mm</td></tr>';
		echo '<tr><td>Size Factor</td><td>'.$pcp[2].'</td></tr>';
		echo '<tr><td>Maximum Normal Stress</td><td>'.$pcp[3].' MPa</td></tr>';
		
		echo '</table>';
	}
?>