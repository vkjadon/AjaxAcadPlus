<?php
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
//	echo "Start ";
	$load=$abp[0]*1000;		// Newton
	$eccentricity=$abp[1];
	$TauD=60;
	$N=9;
	
	$Fp=round(($load/$N),2);
//	echo "Primary Force $Fp";
	
	$Couple=round(($load*$eccentricity),2);
	$r1=sqrt((100*100)+(80*80));
	$r2=$r1;
	$r3=$r1;
	$r4=$r1;
	$r5=100;
	$r6=80;
	$r7=100;
	$r8=80;
	$r9=0;
	
//	echo "$r1 - $r5 - $r6 - $r9 ";
	$Constant=($Couple/(4*$r1*$r1+2*$r5*$r5+2*$r6*$r6));

	$Fs=$Constant*$r2;
	
	$pcp[0]=round($Fp,2);
	$pcp[1]=round($Fs,2);
	
	$angle=atan((80/100));	
//	echo "angle $angle"; 
		
	$Fmax=sqrt(($Fs*$Fs)+($Fp*$Fp)+2*$Fp*$Fs*cos($angle));
	$Fmax=round($Fmax,2);
	$TSA=$Fmax/$TauD;

	require("../standard/bolt-dimensions.php");

	$pcp[2]=round($TSA,2);
	$pcp[3]=$nominal_diameter;

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Primary Force on Bolt </td><td>'.$pcp[0].' N</td></tr>';
		echo '<tr><td>Couple due to '.$load.' N load</td><td>'.$Couple.' N.mm</td></tr>';
		echo '<tr><td>Secondary Force Constant </td><td>'.$Constant.' N/mm</td></tr>';
		echo '<tr><td>Maximum Secondary Force on Bolt due to '.$load.' N load</td><td>'.round($Fs,2).' N</td></tr>';
		echo '<tr><td>Maximum Force on Bolt due to '.$load.' N load</td><td>'.round($Fmax,2).' N</td></tr>';
		echo '<tr><td>Tensile Stress Area</td><td>'.$pcp[2].' mm<sup>2</sup></td></tr>';
		echo '<tr><td>Nominal Diameter</td><td>'.$pcp[3].' mm</td></tr>';
		echo '</table>';
	}

?>