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
	$load=$abp[1]*1000*9.81;		// Newton
	$eccentricity=4800;
	$SigmaDt=84;
	$TauD=50;
	$N=8;
	
	$Fp=round(($load/$N),2);
	$Couple1=round($load*4800,2);
	$l1=0.5*$abp[0]+800;
	$l2=0.5*$abp[0]+800*cos(pi()/4);
	$l3=0.5*$abp[0];
	$l4=0.5*$abp[0]-800*cos(pi()/4);
	$l5=0.5*$abp[0]-800;
//	$cos=cos(pi()/4);
//	echo "$l1 - $l2 - $l3 - $l4 - $l5 ";
	$Constant=($Couple1/($l1*$l1+2*($l2*$l2+$l3*$l3+$l4*$l4)+$l5*$l5));
	$Fs1=$Constant*$l1;
	
	$TSA=round(($Fs1/$SigmaDt),2);

	require("../standard/bolt-dimensions.php");

//	echo "-$nominal_diameter-";
	$pcp[3]=$nominal_diameter;

	$pcp[0]=$Fp/1000;
	$pcp[1]=$Fs1;
	$pcp[2]=$TSA;

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Primary Force </td><td>'.($Fp/1000).' kN</td></tr>';
		echo '<tr><td>Couple due to '.$load.' N load</td><td>'.$Couple1.' N.mm</td></tr>';
		echo '<tr><td>Secondary Force Constant </td><td>'.$Constant.' kN/mm</td></tr>';
		echo '<tr><td>Maximum Secondary Force on Bolt </td><td>'.round(($Fs1/1000),2).' kN</td></tr>';
		echo '<tr><td>Tensile Stress Area on the basis of MSST</td><td>'.$pcp[2].' mm<sup>2</sup></td></tr>';
		echo '<tr><td>Nominal Diameter on the basis of MSST</td><td>'.$pcp[3].' mm</td></tr>';
		echo '</table>';
	}
?>