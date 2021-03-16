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
	$Force=$abp[0]*1000;
	$SigmaDt=$abp[1];
	$SigmaDc=100;
	$tauD=48;
	$rivet_hole=6*sqrt($mpt);
	$np=2;
//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
//	echo "RH dia $rivet_hole";
	$min_pitch=2*$rivet_hole;
	$max_pitch=6*$rivet_hole;
	
	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;
	$Fs=$np*$rivet_area*$tauD;
	$Fc=$np*$rivet_hole*$mpt*$SigmaDc;
	if($Fs<$Fc)
	{
		$den=$mpt*$SigmaDt;
		$pitch=ceil(($Fs/$den)+$rivet_hole);
		$pcp[0]=$pitch;
	}
	else
	{
		$den=$mpt*$SigmaDt;
		$pitch=ceil(($Fc/$den)+$rivet_hole);
		$pcp[0]=$pitch;
	}

	if($Fs<$Fc)$N=ceil($np*$Force/$Fs);
	else $N=ceil($np*$Force/$Fc);
	$NperRow=ceil($N/2);
	if($pitch<$min_pitch)
	{
		$Mod_pitch=$min_pitch;
		$pcp[0]=$Mod_pitch;
	}
	if($pitch1>$max_pitch)
	{
		$pitch=$max_pitch;
		$pcp[0]=$Mod_pitch;
	}
	$Ft=($pcp[0]-$rivet_hole)*$mpt*$SigmaDt;
	$Fup=$pcp[0]*$mpt*$SigmaDt;
	$pcp[1]=round(((min($Fs, $Fc, $Ft)/$Fup)*100),1);
	$pcp[2]=ceil(($NperRow-1)*$pcp[0]+3*$rivet_hole);
	$pcp[3]=ceil(0.33*$pcp[0]+0.67*$rivet_hole);
	echo "Rivets per Row $NperRow";

// Solution
//	$solution='Y';
	if($solution=='Y')
	{
		echo "Solution";
		echo '<table class="table table-bordered">';
		echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
		echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length </td><td>'. round($Fs,2).' N</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length </td><td>'. round($Fc,2).' N</td></tr>';
		echo '<tr><td>The pitch considering equal Strength of rivets and plate in one pitch ength </td><td>'. $pitch.' mm</td></tr>';	
		echo '<tr><td colspan="2">Maximum Pitch '.$max_pitch.' mm  Minimum Pitch '.$min_pitch.' mm';
		if($pitch<$min_pitch || $pitch>$max_pitch)echo ' <strong>[Modified Pitch '.$pcp[0].' mm]</strong></td></tr>';
		else echo ' <strong>[Pitch lies in Safe Limits]</strong></td></tr>';
		echo '<tr><td>Number of Rivets Required </td><td>'. $N.' N</td></tr>';
		echo '<tr><td>Number of Rivets in outer row </td><td>'. $NperRow.' </td></tr>';
		echo '<tr><td>Width pf plate </td><td>'. $pcp[2].' mm</td></tr>';
		echo '</table>';
	}

?>
	
