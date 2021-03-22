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

	$pcp[0]=1.47;
	$pcp[1]=12.19;
	$pcp[2]=-$abp[1];
	$pcp[3]=$abp[1]*300000;
	$pcp[4]=$abp[1]*400000;
	$pcp[5]=3248500;
	$area=round((pi()*$abp[0]*$abp[0]/4),1);
	$sma=round((pi()*$abp[0]*$abp[0]*$abp[0]*$abp[0]/64),1);
	$pma=2*$sma;
	$resultant=sqrt($pcp[4]*$pcp[4]+$pcp[5]*$pcp[5]);
	$pcp[6]=round((($resultant/$sma)*(0.5*$abp[0])),1)+round(($pcp[0]*1000/$area),1);
	$pcp[7]=round((($resultant/$sma)*(0.5*$abp[0])),1)-round(($pcp[0]*1000/$area),1);
	$pcp[8]=round((($pcp[3]/$pma)*(0.5*$abp[0])),1);
?>
