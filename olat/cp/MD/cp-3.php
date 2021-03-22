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
	$pcp[1]=round((pi()*$abp[0]*$abp[1]),1);
	$pcp[0]=round(($pcp[1]*0.35),1);
?>