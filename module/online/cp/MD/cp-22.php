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
	$mpt=$abp[0];
	$SigmaDt=$abp[1];
	$SigmaDc=$abp[2];
	$tauD=$abp[3];
	$rivet_hole=6*sqrt($mpt);
//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
	echo "RH dia $rivet_hole";
	$min_pitch=2*$rivet_hole;
	$max_pitch=6*$rivet_hole;
	
	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;
	$Fs=$rivet_area*$tauD;
	$Fc=$rivet_hole*$mpt*$SigmaDc;
	if($Fs<$Fc)
	{
		$num=pi()*$rivet_hole*$rivet_hole*$tauD;
		$den=4*$mpt*$SigmaDt;
		$pitch=ceil(($num/$den)+$rivet_hole);
		$pcp[0]=$pitch;
	}
	else
	{
		$num=$rivet_hole*$SigmaDc;
		$den=$SigmaDt;
		$pitch=ceil(($num/$den)+$rivet_hole);
		$pcp[0]=$pitch;
	}
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
// Solution
/*	echo '<table class="table table-bordered">';
	echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
	echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length </td><td>'. round($Fs,2).' N</td></tr>';
	echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length </td><td>'. round($Fc,2).' N</td></tr>';
	echo '<tr><td>The pitch considering equal Strength of rivets and plate in one pitch ength </td><td>'. $pitch.' mm</td></tr>';	
	echo '<tr><td colspan="2">Maximum Pitch '.$max_pitch.' mm  Minimum Pitch '.$min_pitch.' mm</td></tr>';
	if($pitch<$min_pitch || $pitch>$max_pitch)echo '<tr><td colspan="2">Modified Pitch '.$pcp[0].' mm</td></tr>';
	else echo '<tr><td colspan="2">Pitch lies in Safe Limits</td></tr>';
	echo '</table>'
*/
?>
	
