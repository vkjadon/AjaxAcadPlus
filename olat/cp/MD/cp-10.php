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
	$mtd=$abap[0]*((1000*60*$abp[0]*1000)/(2*pi()*$abp[1]));

	$tauD=(150/$abap[1]);
	$sigmaDC=(270/$abap[1]);

//	echo "mtd $mtd";
//	echo "TauD $tauD";

	$var=(16*$mtd)/(pi()*$tauD);
	$pcp[0]=ceil(pow($var,(1/3)));

	$shaft_diameter=$pcp[0];

//	echo "shaft_diameter $shaft_diameter";

	require("../standard/shaft-diameters.php");
	$pcp[0]=$shaft_diameter;

//	echo "TauD $tauD";

	require("../standard/key-dimensions.php");
//	echo "Width $width Height $height";
	$length=ceil(1.5*$shaft_diameter);
	$pcp[1]=$width;
	$pcp[2]=$length;
	$mtS=ceil(0.5*$tauD*$shaft_diameter*$width*$length);
//	echo "Length $pcp[2]";
	$mtC=ceil(0.25*$sigmaDC*$shaft_diameter*$height*$length);
//	echo "MtC $mtC";
	if($mtC<$mtd)
	{
		$length=ceil(4*$mtd/($sigmaDC*$shaft_diameter*$height));
		$pcp[2]=$length;
	}
//	if($mtkeyinshear>$mtd)
?>
