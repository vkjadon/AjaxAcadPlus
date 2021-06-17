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
	$mtd=1000000*$abp[1]*$abap[0];
//	echo "TauD $tauD";
	$var=((pi()*$abp[0]*$abp[0]*$abp[0]*150)/(16*$mtd));
	$pcp[0]=round($var,1);
//	echo "dia $pcp[0]";
	
	$tauD=(150/$pcp[0]);
	$singmadC=270/$pcp[0];
	
	$shaft_diameter=$abp[0];
	require("../standard/key-dimensions.php");
//	echo "Width $pcp[1] Height $pcp[2]";
	$pcp[1]=$width;
	$pcp[2]=$height;
	$pcp[3]=round((1.5*$abp[0]),0);
	$pcp[4]=round((0.5*$tauD*$abp[0]*$width*$pcp[3]),1);
//	echo "MtS $pcp[4]";
	$pcp[5]=round((0.25*$singmadC*$abp[0]*$height*$pcp[3]),0);
//	echo "MtC $pcp[5]";
	if($pcp[5]<$mtd)
	{
		$pcp[3]=ceil(4*$mtd/($singmadC*$abp[0]*$height));
		$pcp[4]=ceil(0.5*$tauD*$abp[0]*$width*$pcp[3]);
		$pcp[5]=ceil(0.25*$singmadC*$abp[0]*$height*$pcp[3]);
	}
//	if($mtkeyinshear>$mtd)
?>
