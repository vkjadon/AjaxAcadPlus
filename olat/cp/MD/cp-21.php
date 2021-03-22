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
	$rpm=$abp[0];
	$pcdBolt=$abp[1];
	$pbBF=0.5;
	$pbSB=1.5;
	$NBolts=6;	
	
	$mtd=(50*30*0.5*$pcdBolt*6)/(2000);
	$pcp[0]=round(((2*pi()*$rpm*$mtd)/(60)),2);	
	
//	echo "length $length";

?>
