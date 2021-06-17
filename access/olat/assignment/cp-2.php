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

	$var1=round(($abp[0]*0.1),1);
	$var2=round(($abp[1]*0.4),1);
	$var3=round(($abp[2]*0.1),1);
	$pcp[0]=min($var1,$var2,$var3);
?>