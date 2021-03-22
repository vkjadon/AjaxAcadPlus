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
	$SigmaDt=80;
	$SigmaDc=$abp[1];
	$tauD=50;
	$rivet_hole=6*sqrt($mpt);
	$to=0.625*$mpt;
	$ti=0.625*$mpt;
	$nss=0;
	$nds=5;
//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
//	echo "RH dia $rivet_hole";

	$min_pitch=2*$rivet_hole;
	$max_pitch=6*$rivet_hole;
	
	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;
	$Fs=$nss*$rivet_area*$tauD+1.875*$nds*$rivet_area*$tauD;
	$Fc=($nss+$nds)*$rivet_hole*$mpt*$SigmaDc;
	if($Fs<$Fc)
	{
		$den=$mpt*$SigmaDt;
		$pitchI=ceil(($Fs/$den)+$rivet_hole);
		$pitchII=ceil((($Fs-1.875*$rivet_area*$tauD+2*$rivet_hole*$SigmaDt*$mpt)/$den));
		if($pitchI>$pitchII)$pitch=$pitchI;
		else $pitch=$pitchII;
//		echo "PI $pitchI - PII $pitchII";
		$pcp[0]=$pitch;
	}
	else
	{
		$den=$mpt*$SigmaDt;
		$pitchI=ceil(($Fc/$den)+$rivet_hole);
		$pitchII=ceil((($Fc-$rivet_hole*$SigmaDc*$mpt+2*$rivet_hole*$SigmaDt*$mpt)/$den));
		if($pitchI>$pitchII)$pitch=$pitchI;
		else $pitch=$pitchII;
		$pcp[0]=$pitch;
	}

	if($pitch<$min_pitch)
	{
		$Mod_pitch=$min_pitch;
		$pcp[0]=$Mod_pitch;
	}
	if($pitch>$max_pitch)
	{
		$Mod_pitch=$max_pitch;
		$pcp[0]=$Mod_pitch;
		$Ft=($pitch-2*$rivet_hole)*$SigmaDt*$mpt+1.875*$rivet_area*$tauD;

	}

	$FtI=($pcp[0]-$rivet_hole)*$mpt*$SigmaDt;
	$FtII=($pcp[0]-2*$rivet_hole)*$mpt*$SigmaDt+1.875*$rivet_area*$tauD;
	$Fup=$pcp[0]*$mpt*$SigmaDt;
	$pcp[1]=ceil($FtII)/1000;
	$pcp[2]=round(((min($Fs, $Fc, $FtI, $FtII)/$Fup)*100),1);

// Solution
/*	echo '<table class="table table-bordered">';
	echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
	echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length </td><td>'. round($Fs,2).' N</td></tr>';
	echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length </td><td>'. round($Fc,2).' N</td></tr>';
	echo '<tr><td>The pitch considering equal Strength of rivets and plate in one pitch ength </td><td>'. $pitch.' mm</td></tr>';	
	echo '<tr><td colspan="2">Maximum Pitch '.$max_pitch.' mm  Minimum Pitch '.$min_pitch.' mm';
	if($pitch<$min_pitch || $pitch>$max_pitch)echo ' <strong>[Modified Pitch '.$pcp[0].' mm]</strong></td></tr>';
	else echo ' <strong>[Pitch lies in Safe Limits]</strong></td></tr>';
	echo '<tr><td>Tensile Strength of the plate (failure along outer row) in one pitch length</td><td>'. round($FtI,2).' N</td></tr>';
	echo '<tr><td>Tensile Strength of the plate (tensile failure along inner row and shear failre of rivets along outer row) in one pitch length</td><td>'. $pcp[1].' N</td></tr>';
	echo '<tr><td>Strength of Un punched plate</td><td>'. round($Fup,2).' N</td></tr>';
	echo '<tr><td>Efficiency </td><td>'. $pcp[2].'%</td></tr>';
	echo '</table>'
*/
?>