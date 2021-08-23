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
	$b1=$abp[1];
	$h1=$abp[2];
	$b2=$abp[2];
	$h2=$abp[0];
	$b3=$b1;
	$h3=$h1;
	
	$H=$h1+$h2+$h3;
	
	$A1=$b1*$h1;
	$A2=$b2*$h2;
	$A3=$b3*$h3;
	
	$A=$A1+$A2+$A3;

	echo "Area $A";

	$y1bar=0.5*$h1;
	$y2bar=$h1+0.5*$h2;
	$y3bar=$h1+$h2+0.5*$h3;

	$ybar=($A1*$y1bar+$A2*$y2bar+$A3*$y3bar)/$A;

	echo "ybar $ybar";
	
	$pcp[1]=round($ybar,2);

	$I1cg=($b1*$h1*$h1*$h1)/12;
	$I2cg=($b2*$h2*$h2*$h2)/12;
	$I3cg=($b3*$h3*$h3*$h3)/12;
	
	$d1=$ybar-0.5*$h1;
	$d2=$ybar-$h1-0.5*$h2;
	$d3=$ybar-$h1-$h2-0.5*$h3;
		
	$I1=$I1cg+$A1*$d1*$d1;			
	$I2=$I2cg+$A2*$d2*$d2;			
	$I3=$I3cg+$A3*$d3*$d3;
	
	$Ixx=$I1+$I2+$I3;			

	$pcp[2]=round($Ixx,2);
	
	$x1bar=0.5*$b1;
	$x2bar=0.5*$b2;
	$x3bar=0.5*$b3;

	$xbar=($A1*$x1bar+$A2*$x2bar+$A3*$x3bar)/$A;

	echo "xbar $xbar";

	$pcp[0]=round($xbar,2);

	$I1cg=($h1*$b1*$b1*$b1)/12;
	$I2cg=($h2*$b2*$b2*$b2)/12;
	$I3cg=($h3*$b3*$b3*$b3)/12;
	
	$d1=$xbar-0.5*$b1;
	$d2=$xbar-0.5*$b2;
	$d3=$xbar-0.5*$b3;
		
	$I1=$I1cg+$A1*$d1*$d1;			
	$I2=$I2cg+$A2*$d2*$d2;			
	$I3=$I3cg+$A3*$d3*$d3;
	
	$Iyy=$I1+$I2+$I3;			

	$pcp[3]=round($Iyy,2);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>x_bar</td><td>'.$pcp[0].' mm</td></tr>';
		echo '<tr><td>y_bar</td><td>'.$pcp[1].' mm</td></tr>';
		echo '<tr><td>Ixx</td><td>'.$pcp[2].' mm<sup>4</sup></td></tr>';
		echo '<tr><td>Iyy</td><td>'.$pcp[3].' mm<sup>4</sup></td></tr>';
//		echo '<tr><td>udl</td><td>'.$pcp[2].' kN/m</td></tr>';
//		echo '<tr><td>Section Modulus</td><td>'.$pcp[1].' mm<sup>3</sup></td></tr>';
//		echo '<tr><td>Max Bending Moment</td><td>'.$pcp[2].' N.mm</td></tr>';
//		echo '<tr><td>Max Bending Stress in Tension</td><td>'.$pcp[3].' MPa</td></tr>';
		echo '</table>';
	}
?>