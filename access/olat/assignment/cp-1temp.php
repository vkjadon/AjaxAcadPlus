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
	$Sut=$abp[0];;
	$SeDash=0.5*$Sut;
	$diameter=$abp[1];
	$SigmaX=$abp[2];		// N.mm
	$ka=0.6;
	$kb=1.1875*(pow(0.37*$diameter, -0.097));
	$kc=0.753;
	$kd=1.0;
	$ke=1.0;
	$kf=1.0;

//	echo "Max BM $MaxBM ";
	$Se=($ka*$kb*$kc*$kd*$ke*$SeDash)/($kf);

	$pcp[0]=round($Se,2);
	
	$b=-(log10(0.9*$Sut/$Se))/3;
	$a1=log10(0.9*$Sut)-3*$b;
	$a=pow(10,$a1);
	$var1=log10($SigmaX)-$a1;
	$var2=$var1/$b;
//	echo "logSn $var1 a $a1 antilog a $a logN $var2";
	$N=pow(10,$var2);
	$pcp[1]=ceil($N);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td> b </td><td>'.$b.' </td></tr>';
		echo '<tr><td> a </td><td>'.$a.' </td></tr>';
		echo '<tr><td>Endurance Limit </td><td>'.$pcp[0].' MPa</td></tr>';
		echo '<tr><td>Number of Cyles</td><td>'.$pcp[1].' cycles</td></tr>';
		
		echo '</table>';
	}
?>