<?php
//	echo "Start ";
/*
	use $abp[0] for parameter-1
	use $abp[1] for parameter-2
	...... and so on....

For Design Type Problems

	use $abap[0] for Assumed parameter-1
	use $abap[1] for Assumed parameter-2
	...... and so on....

To inclue standard file
	require("../standard/shaft-diameters.php");
*/
	$power=($abp[0]+$abp[1]+4)*1000;		//Watt
	$rpm=750;
	$TauD=$abap[0];
	$cm=$abap[1]; 
	$ct=$abap[2];
	$TM[0]=(1000*60*$power)/(2*pi()*$rpm); //N.mm
	$TM[1]=(1000*60*($power-$abp[0]))/(2*pi()*$rpm); //N.mm
	$TM[2]=(1000*60*($power-$abp[0]-$abp[1]))/(2*pi()*$rpm); //N.mm
	$pcp[0]=round(max($TM),2);
//	echo "MaxTM ".$pcp[0];
	$MAxy=945000; $MAxz=1855000;
	$BM[0]=sqrt(pow($MAxy,2)+pow($MAxz,2));

	$MBxy=1200000; $MBxz=$abp[3]*1000;
	$BM[1]=sqrt(pow($MBxy,2)+pow($MBxz,2));

	$MCxy=$abp[2]*1000; $MCxz=2010000;
	$BM[2]=sqrt(pow($MCxy,2)+pow($MCxz,2));

	$MDxy=1150000; $MDxz=500000;
	$BM[3]=sqrt(pow($MDxy,2)+pow($MDxz,2));
	
	$MaxBM=max($BM);
	
//	echo "MaxBM $MaxBM";
	
	$pcp[1]=round($MaxBM,2);
	
	$bm=max($BM[0], $BM[1]);
	$EqTM_AB=sqrt($bm*$bm+$TM[0]*$TM[0]);
//	echo "Max $bm EqTM $EqTM_AB ";
	$bm=max($BM[1], $BM[2]);
	$EqTM_BC=sqrt($bm*$bm+$TM[1]*$TM[1]);
//	echo "Max $bm EqTM $EqTM_BC ";
	$bm=max($BM[2], $BM[3]);
	$EqTM_CD=sqrt($bm*$bm+$TM[2]*$TM[2]);
//	echo "Max $bm EqTM $EqTM_CD ";
	
//	$EqTM[1]=sqrt((max($BM[1],$BM[2]))*(max($BM[1],$BM[2]))+$TM[1]*$TM[1]);
//	$EqTM[2]=sqrt((max($BM[2],$BM[3]))*(max($BM[2],$BM[3]))+$TM[2]*$TM[2]);
	$pcp[2]=round(max($EqTM_AB, $EqTM_BC, $EqTM_CD),2);
	$var=(16*max($EqTM_AB, $EqTM_BC, $EqTM_CD))/(pi()*$TauD);
//	echo "Dia $var";
	$shaft_diameter=pow($var,(1/3));
	require("../standard/shaft-diameters.php");
	$pcp[3]=$shaft_diameter;
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Twisting Moment</td><td>'.$pcp[0].' N.mm</td></tr>';
		echo '<tr><td>BM at A </td><td>'.round($BM[0],2).' N.mm</td></tr>';
		echo '<tr><td>BM at B </td><td>'.round($BM[1],2).' N.mm</td></tr>';
		echo '<tr><td>BM at C </td><td>'.round($BM[2],2).' N.mm</td></tr>';
		echo '<tr><td>BM at E </td><td>'.round($BM[3],2).' N.mm</td></tr>';
		echo '<tr><td>Maximum Twisting Moment </td><td>'.$pcp[0].' N.mm</td></tr>';
		echo '<tr><td>Maximum Bending Moment </td><td>'.$pcp[1].' N.mm</td></tr>';
		echo '<tr><td>Maximum Equivalent Twisting Moment </td><td>'.$pcp[2].' N.mm</td></tr>';
		echo '<tr><td>Shaft Diameter, MSST</td><td>'.$pcp[3].' mm</td></tr>';
		echo '</table>';
	}

?>
