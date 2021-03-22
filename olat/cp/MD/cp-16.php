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
	$fos=(200*pi()*$abp[1]*$abp[1]*$abp[1])/(16*$abp[2]*1000000);
	$pcp[1]=round($fos,2);

//	echo "mtd $mtd";

	$shaft_diameter=$abp[1];

	require("../standard/key-dimensions.php");

//	echo "width $width";
//	echo "height $height";

	$J=(pi()/32)*(pow($abp[0],4)-pow($abp[1],4));

//	echo "J $J ";
	$fos=(200*$J)/($abp[0]*$abp[2]*1000000);
	$pcp[0]=round($fos,2);

	$length=ceil(1.5*$abp[1]);
	
	$force=(2*$abp[2])*1000000/($abp[1]);
	$shear_area=$width*$length;
	$tauMax=$force/$shear_area;
	$fosShear=round((200/$tauMax),2);

	$crushing_area=0.5*$height*$length;
	
	$SigmaMax=$force/$crushing_area;
	$fosCrushing=round((400/$SigmaMax),2);
	$pcp[2]=max($fosShear, $fosCrushing);
?>
