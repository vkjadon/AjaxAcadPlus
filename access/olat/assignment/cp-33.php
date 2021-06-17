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
	$mpt=18;
	$width=300;
	$SigmaDt=$abp[0];
	$SigmaDc=$abp[1];
	$tauD=$abp[2];
	$rivet_hole=6*sqrt($mpt);

//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
//	echo "RH dia $rivet_hole";

//	Equal Cover Plates
	$to=0.625*$mpt;
	$ti=0.625*$mpt;

	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;

	$Fs=1.875*$rivet_area*$tauD;
	
	$Fc=$rivet_hole*$mpt*$SigmaDc;
	
	$FtI=($width-$rivet_hole)*$mpt*$SigmaDt;

	if($Fs<$Fc)$N=ceil($FtI/$Fs);
	else $N=ceil($FtI/$Fc);
	if($N==7)$N=8;

	$pcp[0]=$N;

	$Fup=$width*$mpt*$SigmaDt;

	$pcp[1]=2*9*$rivet_hole/10;
	$pcp[2]=min($N*$Fs, $N*$Fc, $FtI)/1000;
	$pcp[3]=round((($FtI/$Fup)*100),1);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
		echo '<tr><td>Strength of rivets in Shear mode of failure of one rivet (double shear)</td><td>'. round($Fs,2).' N</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure of one rivet </td><td>'. round($Fc,2).' N</td></tr>';
		echo '<tr><td>Strength of plate along outer most row</td><td>'. $FtI.' N</td></tr>';
		echo '<tr><td>Number of Rivets </td><td>'.$N.' </td></tr>';
		echo '<tr><td>Width of Strap/Cover plate</td><td>'.$pcp[1].' cm</td></tr>';
		echo '<tr><td>Load Capacity</td><td>'.$pcp[2].' kN</td></tr>';
		echo '<tr><td>Strength of Un punched plate</td><td>'. round($Fup,2).' N</td></tr>';
		echo '<tr><td>Efficiency </td><td>'. $pcp[3].'%</td></tr>';
		echo '</table>';
	}
?>