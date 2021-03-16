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
	$pitch=$abp[0];
	$mpt=$abp[1];
	$SigmaDt=100;
	$SigmaDc=125;
	$tauD=50;
	$rivet_hole=6*sqrt($mpt);

//	echo "RH dia $rivet_hole";
	require("../standard/rivet-holes.php");
//	echo "RH dia $rivet_hole";

//	Equal Cover Plates
	$to=0.625*$mpt;
	$ti=0.625*$mpt;
	$nss=0;
	$nds=5;
	$rivet_area=(pi()/4)*$rivet_hole*$rivet_hole;
	$Fs=$nss*$rivet_area*$tauD+1.875*$nds*$rivet_area*$tauD;
	
	$Fc=($nss+$nds)*$rivet_hole*$mpt*$SigmaDc;
	
	$FtI=($pitch-$rivet_hole)*$mpt*$SigmaDt;
	$FtII=($pitch-2*$rivet_hole)*$mpt*$SigmaDt+1.875*$rivet_area*$tauD;
	$Fup=$pitch*$mpt*$SigmaDt;
	
//	echo "$Fs - $Fc - $FtI - $FtII - Fup $Fup";	
	$pcp[0]=ceil(min($Fs, $Fc, $FtI, $FtII)/1000);
	$pcp[2]=round(((min($Fs, $Fc, $FtI, $FtII)/$Fup)*100),1);


// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
		echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length </td><td>'. round($Fs,2).' N</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length </td><td>'. round($Fc,2).' N</td></tr>';
		echo '<tr><td>Tensile Strength of the plate (failure along outer row) in one pitch length</td><td>'. round($FtI,2).' N</td></tr>';
		echo '<tr><td>Tensile Strength of the plate (tensile failure along inner row and shear failre of rivets along outer row) in one pitch length</td><td>'. round($FtII,2).' N</td></tr>';
		echo '<tr><td>Strength of Un punched plate</td><td>'. round($Fup,2).' N</td></tr>';
		echo '<tr><td>Efficiency </td><td>'. $pcp[2].'%</td></tr>';
		echo '</table>';
	}
//	UnEqual Cover Plates
	$to=0.625*$mpt;
	$ti=0.75*$mpt;
	$nss=1;
	$nds=4;

	$Fs=$nss*$rivet_area*$tauD+1.875*$nds*$rivet_area*$tauD;
	
	$Fc=($nss*$ti+$nds*$mpt)*$rivet_hole*$SigmaDc;
	
	$FtI=($pitch-$rivet_hole)*$mpt*$SigmaDt;
	$FtIIS=($pitch-2*$rivet_hole)*$mpt*$SigmaDt+$rivet_area*$tauD;
	$FtIIC=($pitch-2*$rivet_hole)*$mpt*$SigmaDt+$rivet_hole*$ti*$SigmaDc;
	$FtII=min($FtIIS, $FtIIC);
	
	$Fup=$pitch*$mpt*$SigmaDt;
	
//	echo "$Fs - $Fc - $FtI - $FtII - Fup $Fup";	
	$pcp[1]=ceil(min($Fs, $Fc, $FtI, $FtII)/1000);
	$pcp[3]=round(((min($Fs, $Fc, $FtI, $FtII)/$Fup)*100),1);


// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Rivet Hole Diameter Using Unwin Formula after standardization</td><td>'. round($rivet_hole,2).' mm</td></tr>';
		echo '<tr><td>Strength of rivets in Shear mode of failure in one pitch length </td><td>'. round($Fs,2).' N</td></tr>';
		echo '<tr><td>Strength of rivets in Crushing mode of failure in one pitch length </td><td>'. round($Fc,2).' N</td></tr>';
		echo '<tr><td>Tensile Strength of the plate (failure along outer row) in one pitch length</td><td>'. round($FtI,2).' N</td></tr>';
		echo '<tr><td>Tensile Strength of the plate (tensile failure along inner row and shear failre of rivets along outer row) in one pitch length</td><td>'. round($FtII,2).' N</td></tr>';
		echo '<tr><td>Strength of Un punched plate</td><td>'. round($Fup,2).' N</td></tr>';
		echo '<tr><td>Efficiency </td><td>'. $pcp[3].'%</td></tr>';
		echo '</table>';
	}
?>