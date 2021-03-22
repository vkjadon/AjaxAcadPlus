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
	$power=$abp[0]*1000;		//Watt
	$rpm=400;
	$TauD=$abap[0];
	$cm=$abap[1]; 
	$ct=$abap[2];
	$TM[0]=(1000*60*$power)/(2*pi()*$rpm); //N.mm
	$TM[1]=(1000*60*$power)/(3*2*pi()*$rpm); //N.mm
	$pcp[0]=round(max($TM),2);
//	echo "MaxTM ".$pcp[0];

	$val=exp(0.22*pi());
	$FA2=(2*(2/3)*$TM[0])/($abp[2]*($val-1));
	$FA1=$val*$FA2;
	$FAz=$FA1+$FA2;

	$val=exp(0.22*pi());
	$FB2=(2*(1/3)*$TM[0])/($abp[3]*($val-1));
	$FB1=$val*$FB2;
	$FBy=$FB1+$FB2;
	
	$FCz=(2*$TM[0]/(3*$abp[1]));
	$alpha=20*(pi()/180);
	$FCy=$FCz*tan($alpha);
	
	$FEy=($FBy*150-$FCy*750)/900;
	$FDy=$FBy-$FCy-$FEy;

	$FEz=-($FAz*450+$FCz*750)/900;
	$FDz=-($FAz+$FCz+$FEz);
	
	$MBz=$FDz*150;
	$MBy=$FDy*150;
	$MB=sqrt(pow($MBz,2)+pow($MBy,2));

	$MAz=$FDz*450;
	$MAy=$FDy*450-$FBy*300;
	$MA=sqrt(pow($MAz,2)+pow($MAy,2));

	$MCz=$FEz*150;
	$MCy=$FEy*150;
	$MC=sqrt(pow($MCz,2)+pow($MCy,2));

	$bm=max($MC, $MA);
	$EqTM_BC=sqrt($bm*$bm+$TM[0]*$TM[0]);
//	echo "Max $bm EqTM $EqTM_BC ";

	$bm=max($MB, $MA);
	$EqTM_AB=sqrt($bm*$bm+$TM[1]*$TM[1]);
//	echo "Max $bm EqTM $EqTM_AB ";

	$pcp[1]=round(max($MB, $MA, $MC),2);
	$pcp[2]=round(max($EqTM_AB, $EqTM_BC),2);
	$var=(16*max($EqTM_AB, $EqTM_BC))/(pi()*$TauD);
//	echo "Dia $var";
	$shaft_diameter=pow($var,(1/3));
	require("../standard/shaft-diameters.php");
	$pcp[3]=$shaft_diameter;


// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Twisting Moment C-A </td><td>'.round($TM[0],2).' N.mm</td></tr>';
		echo '<tr><td>Twisting Moment A-B </td><td>'.round($TM[1],2).' N.mm</td></tr>';
		echo '<tr><td>F<sub>A2</sub> </td><td>'.round($FA2,2).' N</td></tr>';
		echo '<tr><td>F<sub>A1</sub> </td><td>'.round($FA1,2).' N</td></tr>';
		echo '<tr><td>F<sub>Az</sub> </td><td>'.round($FAz,2).' N (+z)</td></tr>';
		echo '<tr><td>F<sub>B2</sub> </td><td>'.round($FB2,2).' N</td></tr>';
		echo '<tr><td>F<sub>B1</sub> </td><td>'.round($FB1,2).' N</td></tr>';
		echo '<tr><td>F<sub>By</sub> </td><td>'.round($FBy,2).' N (-y)</td></tr>';
		echo '<tr><td>F<sub>Cy</sub> </td><td>'.round($FCy,2).' N (+y)</td></tr>';
		echo '<tr><td>F<sub>Cz</sub> </td><td>'.round($FCz,2).' N (+z)</td></tr>';
		echo '<tr><td>Reaction F<sub>Ey</sub> </td><td>'.round($FEy,2).' N </td></tr>';
		echo '<tr><td>Reaction F<sub>Ez</sub> </td><td>'.round($FEz,2).' N </td></tr>';
		echo '<tr><td>Reaction F<sub>Dy</sub> </td><td>'.round($FDy,2).' N </td></tr>';
		echo '<tr><td>Reaction F<sub>Dz</sub> </td><td>'.round($FDz,2).' N </td></tr>';
		echo '<tr><td>Bending Moment M<sub>B</sub> </td><td>'.round($MB,2).' N.mm </td></tr>';
		echo '<tr><td>Bending Moment M<sub>A</sub> </td><td>'.round($MA,2).' N.mm </td></tr>';
		echo '<tr><td>Bending Moment M<sub>C</sub> </td><td>'.round($MC,2).' N.mm </td></tr>';
		echo '</table>';
	}

?>
