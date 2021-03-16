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
//	echo "TauD $tauD";

	$shaft_diameter=$abp[0];
	
	$width=ceil($shaft_diameter/4);

	$pcp[0]=$width;

//	echo "width $width";

	$t1=0.3*$shaft_diameter;
	$t2=0.2*$shaft_diameter;
	
	$theta=acos(($t2)/($t1+$t2));

	$length=round((2*($t1+$t2)*sin($theta)),1);
	
//	echo "t1 $t1 t2 $t2 Theta $theta Length $length";

	$pcp[1]=$t1;
	$pcp[2]=$t2;

	$tauDkey=50;
	$sigmaDC=90;

	$mtS=ceil(0.5*$tauDkey*$shaft_diameter*$width*$length);
	$pcp[3]=$mtS;
	
//	echo "mtS $mtS";
	$area_of_key=0.5*pi()*(($t1+$t2)*($t1+$t2));
	
//	echo "area_of_key $area_of_key";

	$area_of_sector=($area_of_key*2*$theta)/pi();
//	echo "area_of_sector $area_of_sector";
	$t1_area=$area_of_sector-0.5*$t2*$length;
	$t2_area=$area_of_key-$t1_area;
//	echo "t1_area $t1_area";
//	echo "t2_area $t2_area";
	
	$mtC_shaft=ceil(0.5*$sigmaDC*$shaft_diameter*$t1_area);
	$mtC_hub=ceil(0.5*$sigmaDC*$shaft_diameter*$t2_area);
	$mtC=min($mtC_shaft, $mtC_hub);
	$pcp[4]=$mtC;
//	echo "MtC $mtC";
	
//	echo "sigmaDC $sigmaDC";

?>
