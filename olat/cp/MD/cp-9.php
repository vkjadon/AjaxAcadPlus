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
	$pcp[0]=$abp[0]*2500*0.5;
//	echo "Mt $pcp[0]";
	$tauD=(16*$pcp[0]/(pi()*$abp[1]*$abp[1]*$abp[1]));
	$shaft_diameter=$abp[1];
//	echo "TauD $tauD";

	require("../standard/key-dimensions.php");
//	echo "Width $width Height $height";
	$length=ceil(1.5*$shaft_diameter);

	$pcp[1]=ceil(0.5*$abap[0]*$shaft_diameter*$width*$length);
//	echo "MtS $pcp[1]";
	$pcp[2]=ceil(0.25*$abap[1]*$shaft_diameter*$height*$length);
//	echo "MtC $pcp[2]";
	if($pcp[2]<$pcp[0])
	{
		$length=ceil(4*$pcp[0]/($abap[1]*$shaft_diameter*$height));
		$pcp[1]=ceil(0.5*$abap[0]*$shaft_diameter*$width*$length);
		$pcp[2]=ceil(0.25*$abap[1]*$shaft_diameter*$height*$length);
	}
//	if($mtkeyinshear>$mtd)
?>
