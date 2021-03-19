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

	$pcp[0]=0;
	$var1=(4000*$abp[1]*$abap[0])/(pi()*240);
	$var2=$abp[0]*$abp[0];
	if($var2>$var1)
	{
		$var3=sqrt($var2-$var1);
		$pcp[0]=round($var3,2);
	}
	else echo '<h3><span class="bg-danger">Negative in Square Root. Please reduce FoS for Hollow Shaft or Solid Shaft is the answer</span></h3>';
//	echo "abap in cpfile $abap[0]<br>";
//	echo "abp in cpfile $abp[0]<br>";
//	echo "var1 in cpfile $var1<br>";
//	echo "var2 in cpfile $var2<br>";
//	echo "pcp in cpfile $pcp[0]<br>";
?>