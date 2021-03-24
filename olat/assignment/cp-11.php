<?php
/*
	use $abp[0] for parameter-1
	use $abp[1] for parameter-2
	...... and so on....

For Design Type Problems

	use $abap[0] for Assumed parameter-1
	use $abap[1] for Assumed parameter-2
	...... and so on....
*/
	$tauD=50;
	$sigmaDC=$abp[2];

//	echo "sigmaDC $sigmaDC";

	$pcp[0]=ceil(0.5*$tauD*$abp[0]*$abp[1]*125);
//	echo "mtd $pcp[0]";
	$pcp[1]=ceil(4*$pcp[0]/($sigmaDC*$abp[0]*125));
//	echo "height $pcp[1]";

//	if($mtkeyinshear>$mtd)
?>
