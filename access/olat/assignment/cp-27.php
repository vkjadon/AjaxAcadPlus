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
	$mpt=$abp[0];
	$load=$abp[1]*1000;
	$SigmaDt=80;
	$SigmaDc=110;
	$tauD=65;
	$rivet_hole=6*sqrt($mpt);
	$nss=0;
	$npd=2;

//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
//	echo "RH dia $rivet_hole";

//	Equal Cover Plates
	$to=0.625*$mpt;
	$ti=0.625*$mpt;

	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;

	$Fs=1.875*$rivet_area*$tauD;
	
	$Fc=$rivet_hole*$mpt*$SigmaDc;
	
	if($Fs<$Fc)$N=ceil($load/$Fs);
	else $N=ceil($load/$Fc);
	
	$pcp[0]=$N;

	$width=2*$rivet_hole+3*$rivet_hole;
	
	$Fup=$width*$mpt*$SigmaDt;
	$FtI=($width-$rivet_hole)*$mpt*$SigmaDt;
	if($Fs<$Fc)$FtII=($width-2*$rivet_hole)*$mpt*$SigmaDt+$Fs;
	else $FtII=($width-2*$rivet_hole)*$mpt*$SigmaDt+$Fc;
//	echo "$Fs - $Fc - $FtI - $FtII - Fup $Fup";	
	if($Fup>0)$pcp[1]=round(((min($npd*$Fs, $npd*$Fc, $FtI, $FtII)/$Fup)*100),1);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
		echo '<tr><td>Strength of rivets in Shear mode of failure of one rivet (double shear)</td><td>'. round($Fs,2).' N</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure of one rivet </td><td>'. round($Fc,2).' N</td></tr>';
		echo '<tr><td>Number of Rivets </td><td>'.$N.' </td></tr>';
		echo '<tr><td>Strength of Un punched plate</td><td>'. round($Fup,2).' N</td></tr>';
		echo '<tr><td>Efficiency </td><td>'. $pcp[1].'%</td></tr>';
		echo '</table>';
	}
?>