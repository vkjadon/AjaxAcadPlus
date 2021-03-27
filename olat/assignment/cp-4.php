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

	$var1=2000*$abp[0]*$abap[0];
	$var2=pi()*300;
	$pcp[0]=round(sqrt($var1/$var2),1);
?>