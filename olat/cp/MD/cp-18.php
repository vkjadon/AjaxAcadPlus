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
	$mtd=3.5*1000000;
	$tauD=0.5*$abp[1];
	$var=($mtd*16)/(pi()*$tauD);
//	echo "A $var";
	$start=pow($var,(1/3));
//	echo "Start $start";
	$check=pow(($abp[0]),4);
	for($icpfile=0; $icpfile<100; $icpfile++)
	{
//		echo "$icpfile <br>";
		$trial=$start+$icpfile;
		$value=pow($trial,4)-$var*$trial;
		if($value>$check)break;
	}	
	$pcp[0]=ceil($trial);

?>
