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
	$mtd=$abp[0]*1000;
	$shaft_diameter=25;
	$d1=$abp[1];
	$pcdBolt=80;
	$width=4;
	$height=4;
	$dBolt=10;
	$tFlange=15;
	$NBolts=$abp[2];	
	$length=38;
	
	$pcp[0]=round(((16*$mtd)/(pi()*$shaft_diameter*$shaft_diameter*$shaft_diameter)),1);

	$pcp[1]=round(((2*$mtd)/($shaft_diameter*$width*$length)),1);
	$pcp[2]=2*$pcp[1];
	$pcp[3]=round(((8*$mtd)/($abp[2]*$pcdBolt*pi()*$dBolt*$dBolt)),1);
//	echo "Bolt Stress".$pcp[3];
//	echo "length $length";

?>
