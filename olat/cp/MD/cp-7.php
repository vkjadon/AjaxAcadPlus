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
	$tauD=$abap[1]*($abp[2]/$abp[1]);
	$sigmaDC=$abap[2]*($abp[2]/$abp[1]);
	$mtd=1000*$abp[0]*$abap[0];
//	echo "TauD $tauD";
//	echo "singmaC $sigmaDC";
	$var=(16*$mtd/(pi()*$tauD));
	$pcp[0]=round(pow($var,(1/3)),1);
	echo "dia $pcp[0]";
	
	$shaft_diameter=$pcp[0];
	require("../standard/shaft-diameters.php");
	$pcp[0]=$shaft_diameter;
	require("../standard/key-dimensions.php");
	echo "Width $width Height $height";
	$pcp[1]=$width;
	$length=round((1.5*$pcp[0]),0);
	$pcp[2]=0.5*$tauD*$pcp[0]*$pcp[1]*$length;
	$pcp[3]=0.25*$sigmaDC*$pcp[0]*$height*$length;
	if($pcp[3]<$mtd)
	{
		$length=ceil(4*$mtd/($sigmaDC*$pcp[0]*$height));
		echo 'Length '.$length;
		$pcp[2]=ceil(0.5*$tauD*$pcp[0]*$width*$length);
		$pcp[3]=ceil(0.25*$sigmaDC*$pcp[0]*$height*$length);
	}

	echo 'MtS '.$pcp[2];
	echo 'MtC '.$pcp[3];
//	if($mtkeyinshear>$mtd)
?>
