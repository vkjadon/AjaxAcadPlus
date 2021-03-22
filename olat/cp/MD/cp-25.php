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
	$mpt=12;
	$to=$abp[0];
	$ti=$abp[1];
	$SigmaDt=80;
	$SigmaDc=100;
	$tauD=$abp[2];
	$rivet_hole=6*sqrt($mpt);
//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
//	echo "RH dia $rivet_hole";
	$min_pitch=2*$rivet_hole;
	$max_pitch=6*$rivet_hole;
	$pitch=3*$rivet_hole;
	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;
	
//	Single Row
	$np=1;

	$FsSR=$np*1.875*$rivet_area*$tauD*0.001;
	if($mpt<($to+$ti))$FcSR=$np*$rivet_hole*$mpt*$SigmaDc*0.001;
	else $FcSR=$np*$rivet_hole*($to+$ti)*$SigmaDc*0.001;
	$FtSR=($pitch-$rivet_hole)*$SigmaDt*$mpt*0.001;

	$Fup=$pitch*$mpt*$SigmaDt*0.001;

	$pcp[0]=min($FsSR, $FcSR, $FtSR);
	$pcp[2]=round((($pcp[0]/$Fup)*100),1);
	
//	Double Row
	$np=2;

	$FsDR=$np*1.875*$rivet_area*$tauD*0.001;
	if($mpt<($to+$ti))$FcDR=$np*$rivet_hole*$mpt*$SigmaDc*0.001;
	else $FcDR=$np*$rivet_hole*($to+$ti)*$SigmaDc*0.001;
	$FtDR=($pitch-$rivet_hole)*$SigmaDt*$mpt*0.001;
	
	$pcp[1]=min($FsDR, $FcDR, $FtDR);
	$pcp[3]=round((($pcp[1]/$Fup)*100),1);

// Solution
	if($solution=='Y')
	{
		echo "Solution";
		echo '<table class="table table-bordered">';
		echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
		echo '<tr><td>Strength of Un punched plate</td><td>'. round($Fup,2).' N</td></tr>';
		echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length for Single Row</td><td>'. round($FsSR,2).' kN</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length for Single Row</td><td>'. round($FcSR,2).' kN</td></tr>';
		echo '<tr><td>Strength of plate in Tearing mode of failure in one pitch length for Single Row</td><td>'. round($FtSR,2).' kN</td></tr>';
		echo '<tr><td>Efficiency for Single Row</td><td>'. $pcp[2].'%</td></tr>';
	
		echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length for Double Row</td><td>'. round($FsDR,2).' kN</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length for Double Row</td><td>'. round($FcDR,2).' kN</td></tr>';
		echo '<tr><td>Strength of plate in Tearing mode of failure in one pitch length for Double Row</td><td>'. round($FtDR,2).' kN</td></tr>';
		echo '<tr><td>Efficiency for Double Row</td><td>'. $pcp[3].'%</td></tr>';
	
		echo '</table>';
	}
?>
	
