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
	$mtd=1.2*((1000*60*$abp[0]*1000)/(2*pi()*$abp[1]));

//	echo "mtd $mtd";
//	echo "TauD $tauD";

	$var=(16*$mtd)/(pi()*$abap[0]);
	$pcp[0]=ceil(pow($var,(1/3)));

	$shaft_diameter=$pcp[0];

//	echo "shaft_diameter $shaft_diameter";

	require("../standard/shaft-diameters.php");
	$pcp[0]=$shaft_diameter;

	$width=ceil($shaft_diameter/6);
	$pcp[1]=$width;

//	echo "width $width";

	$length=($mtd)/($abap[2]*$pcp[0]*sqrt(2)*$width);
	$length=ceil($length);

	$pcp[2]=$length;

//	echo "length $length";

	$sigmaDC=$abap[1];
	
//	echo "sigmaDC $sigmaDC";

	$mtC=ceil($sigmaDC*$shaft_diameter*($width/sqrt(2))*$length);

//	echo "MtC $mtC";
	if($mtC<$mtd)
	{
		$length=ceil($mtd/($sigmaDC*$shaft_diameter*($width/sqrt(2))));
		$pcp[2]=$length;
	}
//	if($mtkeyinshear>$mtd)
?>
