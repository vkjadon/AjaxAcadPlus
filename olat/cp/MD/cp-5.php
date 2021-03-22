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

	$var1=round((4*15000/(pi()*$abp[1]*$abp[1])),1);
	$var2=round((32*3000*$abp[0]/(pi()*$abp[1]*$abp[1]*$abp[1])),1);
//	echo "Axial Stress $var1";
//	echo "Bending Stress $var2";
	$pcp[0]=$var1+$var2;
	$pcp[1]=$var2-$var1;
?>