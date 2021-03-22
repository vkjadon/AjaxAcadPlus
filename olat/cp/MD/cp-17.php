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
	$P=$abp[0];
	$N=$abp[1];
	$mtd=(60*$P*1000000*$abap[0])/(2*pi()*$N);
	$pcp[0]=ceil($mtd);

//	echo "mtd $mtd";

	$tauDShaft=$abp[2];
	$tauDKey=0.5*$abp[3];
	$sigmaDKeyC=1.25*$abp[3];
	$sigmaDBoltT=$abp[3];
	$sigmaDBoltC=1.25*$abp[3];
	$tauDBolt=0.5*$abp[3];
	$tauDHub=12.5;
	
	$var=(16*$mtd)/(pi()*$tauDShaft);
	$shaft_diameter=pow($var,(1/3));

	require("../standard/shaft-diameters.php");

//	echo "shaft_diameter $shaft_diameter";

	require("../standard/key-dimensions.php");

//	echo "width $width";
//	echo "height $height";

	$length=ceil(1.5*$shaft_diameter);
	
	$d1=ceil(1.75*$shaft_diameter+20);

	$J=(pi()/32)*(pow($d1,4)-pow($shaft_diameter,4));

//	echo "J $J";

	$tauHub=round((($mtd*0.5*$d1)/($J)),2);

	$pcp[0]=$tauHub;
	$tFlange=ceil(0.35*$shaft_diameter+9);
	$pcp[1]=ceil(pi()*$d1*$tFlange*$tauDHub*$d1*0.5);

	$tauDKey=ceil((2*$mtd)/($shaft_diameter*$width*$length));
	
	$pcp[2]=$tauDKey;

//	echo "mtS $pcp[2]";
	$sigmaKeyC=(4*$mtd)/($shaft_diameter*$height*$length);
//	echo "First MtC $mtC";
	if($sigmaDKeyC<$sigmaKeyC)
	{
		$length=ceil(4*$mtd/($sigmaDKeyC*$shaft_diameter*$height));
		$sigmaKeyC=(4*$mtd)/($shaft_diameter*$height*$length);
	}
	$pcp[3]=round($sigmaKeyC,2);
	$NBolts=ceil(($shaft_diameter/50)+3);
	$dBolt=ceil(0.5*$shaft_diameter/(sqrt($NBolts)));
	$pcdBolt=$d1+3.2*$dBolt;
	$pcp[4]=ceil((pi()*$dBolt*$dBolt*$tauDBolt*$pcdBolt*$NBolts)/(8));
//	echo "length $length";

?>
