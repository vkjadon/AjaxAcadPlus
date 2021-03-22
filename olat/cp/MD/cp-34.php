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
	$load=$abp[0]/1000+2*$abp[1];
	$eccentricity=350;
	$SigmaDt=70;
	$TauD=35;
	$N=4;
	
	$Fp=round(($load/$N),2);
	$Couple1=round(($abp[0]/1000)*300,2);
	$Couple2=round((2*$abp[1]*350),2);
	$Constant=round((($Couple1+$Couple2)/(2*75*75+2*425*425)),4);
	$Fs3=$Constant*75;
	$Fs1=$Constant*425;
	$part1=($Fs1)/(2*$SigmaDt);
	$part2=($Fp)/($SigmaDt);
	
	$TSA_MPST=($part1+sqrt(($part1*$part1)+($part2*$part2)))*1000;
	$TSA=round($TSA_MPST,2);

	require("../standard/bolt-dimensions.php");

	$pcp[2]=$nominal_diameter;
	
	$part1=($Fs1)/(2*$TauD);
	$part2=($Fp)/($TauD);

	$TSA_MSST=sqrt(($part1*$part1)+($part2*$part2))*1000;
	$TSA=round($TSA_MSST,2);

	require("../standard/bolt-dimensions.php");

	$pcp[3]=$nominal_diameter;

	$pcp[0]=$Fp;
	$pcp[1]=$Fs1;
	$pcp[4]=max($pcp[2],$pcp[3]);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Primary Force </td><td>'.$Fp.' kN</td></tr>';
		echo '<tr><td>Couple due to '.$abp[0].'</td><td>'.$Couple1.' kN.mm</td></tr>';
		echo '<tr><td>Couple due to '.$abp[1].'</td><td>'.$Couple2.' kN.mm</td></tr>';
		echo '<tr><td>Secondary Force Constant </td><td>'.$Constant.' kN/mm</td></tr>';
		echo '<tr><td>Secondary Force on Bolt 3 nd 4 </td><td>'.$Fs3.' kN</td></tr>';
		echo '<tr><td>Secondary Force on Bolt 1 nd 2 </td><td>'.$Fs1.' kN</td></tr>';
		echo '<tr><td>Tensile Stress Area on the basis of MPST</td><td>'.round($TSA_MPST,2).' mm<sup>2</sup></td></tr>';
		echo '<tr><td>Nominal Diameter on the basis of MPST</td><td>'.$pcp[2].' mm</td></tr>';
		echo '<tr><td>Tensile Stress Area on the basis of MSST</td><td>'.round($TSA_MSST,2).' mm<sup>2</sup></td></tr>';
		echo '<tr><td>Nominal Diameter on the basis of MSST</td><td>'.$pcp[3].' mm</td></tr>';
		echo '<tr><td>Recommended Nominal Diameter </td><td>'.$pcp[4].' mm</td></tr>';
		echo '</table>';
	}
?>