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
	$b1=140;			// 2 identical members
	$h1=$abp[0];
	$b2=2*0.5*($abp[1]-$abp[2]);	// 2 identical members
	$h2=$abp[3]-0.5*$b2;
	$b3=$abp[1];
	$h3=0.5*$b2;
	
	$H=$h1+$h2+$h3;
	
	$A1=$b1*$h1;
	$A2=$b2*$h2;
	$A3=$b3*$h3;
	
	$A=$A1+$A2+$A3;

//	echo "Area $A";

	$y1bar=0.5*$h1;
	$y2bar=$h1+0.5*$h2;
	$y3bar=$h1+$h2+0.5*$h3;

	$ybar=($A1*$y1bar+$A2*$y2bar+$A3*$y3bar)/$A;

//	echo "ybar $ybar";
	
	$pcp[0]=round($ybar,2);

	$I1cg=($b1*$h1*$h1*$h1)/12;
	$I2cg=($b2*$h2*$h2*$h2)/12;
	$I3cg=($b3*$h3*$h3*$h3)/12;
	
	$d1=$ybar-0.5*$h1;
	$d2=$ybar-$h1-0.5*$h2;
	$d3=$ybar-$h1-$h2-0.5*$h3;
		
	$I1=$I1cg+$A1*$d1*$d1;			
	$I2=$I2cg+$A2*$d2*$d2;			
	$I3=$I3cg+$A3*$d3*$d3;
	
	$d1=$ybar-0.5*$h1;
	$d2=$ybar-$h1-0.5*$h2;
	$d3=$ybar-$h1-$h2-0.5*$h3;
		
	$I1=$I1cg+$A1*$d1*$d1;			
	$I2=$I2cg+$A2*$d2*$d2;			
	$I3=$I3cg+$A3*$d3*$d3;
	
	$Ixx=$I1+$I2+$I3;			

	$pcp[1]=round($Ixx,2);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
//		echo '<tr><td>x_bar</td><td>'.$pcp[0].' mm</td></tr>';
		echo '<tr><td>y_bar</td><td>'.$pcp[0].' mm</td></tr>';
		echo '<tr><td>Ixx</td><td>'.$pcp[1].' mm<sup>4</sup></td></tr>';
//		echo '<tr><td>Iyy</td><td>'.$pcp[3].' mm<sup>4</sup></td></tr>';
//		echo '<tr><td>udl</td><td>'.$pcp[2].' kN/m</td></tr>';
//		echo '<tr><td>Section Modulus</td><td>'.$pcp[1].' mm<sup>3</sup></td></tr>';
//		echo '<tr><td>Max Bending Moment</td><td>'.$pcp[2].' N.mm</td></tr>';
//		echo '<tr><td>Max Bending Stress in Tension</td><td>'.$pcp[3].' MPa</td></tr>';
		echo '</table>';
	}
?>