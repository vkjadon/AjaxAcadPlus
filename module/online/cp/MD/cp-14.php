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
	$mtd=(1.25*1000*60*$abp[0]*1000)/(2*pi()*$abp[1]);

//	echo "mtd $mtd";
	
	$pb=7;

	$var=(14.8*$mtd)/(6*$pb);
	$pcp[0]=ceil(pow($var,(1/3)));

	$shaft_diameter=$pcp[0];

	require("../standard/shaft-diameters.php");

//	echo "shaft_diameter $shaft_diameter";

	$width=ceil($shaft_diameter/4);

//	echo "width $width";

	$height=0.1*$shaft_diameter;
	$length=1.5*$shaft_diameter;
	
//	echo "length $length";
//	echo "height $height";

	$pcp[0]=$shaft_diameter;
	$pcp[1]=$pcp[0]-2*$height;

	$pcp[2]=round(((16*$mtd)/(pi()*pow($pcp[1],3))),1);
	$force=((4*$mtd)/($pcp[0]+$pcp[1]))/6;
//	echo "Force $force";
	$bm=$force*0.5*$height;
	$sma=(1/12)*$length*$width*$width*$width;
	$area=$length*$width;
	$pcp[3]=round((($bm/$sma)*0.5*$width),1);
//	echo "BS $pcp[3]";
	$pcp[4]=round(($force/$area),2);
//	echo "IPSS $pcp[4]";
	$pcp[5]=round((6*$force*0.15),1);
	
//	echo "sigmaDC $sigmaDC";

?>
