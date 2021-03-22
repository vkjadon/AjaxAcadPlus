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
	$mtd=(1000*60*$abp[0]*1000)/(2*pi()*$abp[1]);
	$pcp[0]=ceil($mtd);

//	echo "mtd $mtd";
	$tauDShaft=$abap[0];
	$tauDKey=$abap[1];
	$sigmaDCKey=$abap[2];
	$tauDHub=$abap[3];
	
	$var=(16*$mtd)/(pi()*$tauDShaft);
	$pcp[1]=ceil(pow($var,(1/3)));

	$shaft_diameter=$pcp[1];

	require("../standard/shaft-diameters.php");

//	echo "shaft_diameter $shaft_diameter";

	$pcp[1]=$shaft_diameter;

	require("../standard/key-dimensions.php");

//	echo "width $width";
//	echo "height $height";

	$length=ceil(1.5*$shaft_diameter);

	$mtS=ceil(0.5*$tauDKey*$shaft_diameter*$width*$length);
//	echo "Length $pcp[2]";
	$mtC=ceil(0.25*$sigmaDCKey*$shaft_diameter*$height*$length);
//	echo "MtC $mtC";
	if($mtC<$mtd)
	{
		$length=ceil(4*$mtd/($sigmaDCKey*$shaft_diameter*$height));
		$mtC=ceil(0.25*$sigmaDCKey*$shaft_diameter*$height*$length);
	}
	$pcp[2]=$mtS;
	$pcp[3]=$mtC;
//	echo "length $length";
	$D=2*$shaft_diameter+13;
	$L=3.5*$shaft_diameter;
	$J=(pi()/32)*(pow($D,4)-pow($shaft_diameter,4));
//	echo "J $J";
	$pcp[4]=ceil((2*$tauDHub*$J)/($D));

?>
