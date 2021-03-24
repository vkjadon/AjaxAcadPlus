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
	echo "Start ";
	$loadV=2000*cos(pi()/6);		// Newton
	$loadH=2000*sin(pi()/6);		// Newton
	$eccentricityH=$abp[1];
	$eccentricityV=($abp[0]-305);
	$SigmaDt=85;
	$TauD=60;
	$N=8;
	
	$FpV=round(($loadV/$N),2);
	$FpH=round(($loadH/$N),2);
	$CoupleV=round($loadV*$eccentricityV,2);
	$CoupleH=round($loadH*$eccentricityH,2);
	$l1=80;
	$l2=230;
	$l3=380;
	$l4=530;
//	echo "$l1 - $l2 - $l3 - $l4 ";
	$ConstantV=($CoupleV/(2*($l1*$l1+$l2*$l2+$l3*$l3+$l4*$l4)));
	$ConstantH=($CoupleH/(2*($l1*$l1+$l2*$l2+$l3*$l3+$l4*$l4)));
	$FsV=$ConstantV*$l4;
	$FsH=$ConstantH*$l4;
	
	$pcp[0]=round(($FpV+$FsV+$FsH),2);
	$pcp[1]=$FpH;
	
	$part1=($pcp[0])/(2*$SigmaDt);
	$part2=($pcp[1])/($SigmaDt);
	
	$TSA_MPST=($part1+sqrt(($part1*$part1)+($part2*$part2)));
	$TSA=round($TSA_MPST,2);

	require("../standard/bolt-dimensions.php");

	$nd1=$nominal_diameter;
	
	$part1=($pcp[0])/(2*$TauD);
	$part2=($pcp[1])/($TauD);

	$TSA_MSST=sqrt(($part1*$part1)+($part2*$part2));
	$TSA=round($TSA_MSST,2);

	require("../standard/bolt-dimensions.php");

	$nd2=$nominal_diameter;


	$pcp[2]=max($nd1, $nd2);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Horizontal Force </td><td>'.$loadH.' N</td></tr>';
		echo '<tr><td>Vertical Force </td><td>'.$loadV.' N</td></tr>';
		echo '<tr><td>Couple due to '.$loadH.' N load</td><td>'.$CoupleH.' N.mm</td></tr>';
		echo '<tr><td>Couple due to '.$loadV.' N load</td><td>'.$CoupleV.' N.mm</td></tr>';
		echo '<tr><td>Secondary Horizontal Force Constant </td><td>'.$ConstantH.' N/mm</td></tr>';
		echo '<tr><td>Secondary Vertical Force Constant </td><td>'.$ConstantV.' N/mm</td></tr>';
		echo '<tr><td>Maximum Secondary Force on Bolt due to '.$loadH.' N load</td><td>'.round($FsH,2).' N</td></tr>';
		echo '<tr><td>Maximum Secondary Force on Bolt due to '.$loadV.' N load</td><td>'.round($FsV,2).' N</td></tr>';
		echo '<tr><td>Maximum Tensile Force on Bolt </td><td>'.$pcp[0].' N</td></tr>';
		echo '<tr><td>Maximum Shear Force on Bolt </td><td>'.$pcp[1].' N</td></tr>';
		echo '<tr><td>Nominal Diameter on the basis of MSPT</td><td>'.$nd1.' mm</td></tr>';
		echo '<tr><td>Nominal Diameter on the basis of MSST</td><td>'.$nd2.' mm</td></tr>';
		echo '<tr><td>Nominal Diameter</td><td>'.$pcp[2].' mm</td></tr>';
		echo '</table>';
	}
?>