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

//	$L=4000;		// Length of beam m
	$b1=80;			
	$h1=240;
	$b2=12;	
	$h2=160;
	$maxBM=$abp[0];
	$m=$abp[1];
	
//	echo "maxBM $maxBM";

	$H=$h1;
	
	$A1=2*$b1*$h1;
	$A2=$b2*$h2;
	
	$A=$A1+$A2;

//	echo "Area $A";

	$ybar=120;

//	echo "ybar $ybar";
	
	$I1=(2*$b1*$h1*$h1*$h1)/12;
	$I2=($m*$b2*$h2*$h2*$h2)/12;
		
	$Ixx=$I1+$I2;	

//	echo "Ixx $Ixx";

	$sigmaWood=(pow(10,6)*$maxBM*$ybar)/($Ixx);

//	echo "sigmaWood $sigmaWood";

	$pcp[0]=round($sigmaWood, 2);

	$sigmaSteel=$m*(pow(10,6)*$maxBM*80)/($Ixx);

	$pcp[1]=round($sigmaSteel, 2);
// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
//		echo '<tr><td>x_bar</td><td>'.$pcp[0].' mm</td></tr>';
//		echo '<tr><td>y_bar</td><td>'.$pcp[0].' mm</td></tr>';
//		echo '<tr><td>Ixx</td><td>'.$pcp[1].' mm<sup>4</sup></td></tr>';
//		echo '<tr><td>Iyy</td><td>'.$pcp[3].' mm<sup>4</sup></td></tr>';
//		echo '<tr><td>udl</td><td>'.$pcp[2].' kN/m</td></tr>';
//		echo '<tr><td>Section Modulus</td><td>'.$pcp[1].' mm<sup>3</sup></td></tr>';
//		echo '<tr><td>Max Bending Moment</td><td>'.$pcp[2].' N.mm</td></tr>';
		echo '<tr><td>Max Tensile Stress in Wood </td><td>'.$pcp[0].' MPa</td></tr>';
		echo '<tr><td>Max Tensile Stress in Steel </td><td>'.$pcp[1].' MPa</td></tr>';
		echo '</table>';
	}
?>