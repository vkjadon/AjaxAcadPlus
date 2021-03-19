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
	$sigmaX=85;		
	$sigmaY=85;		
	$tauXY=0;		
	$theta=$abp[0]-90;		 
		
	$thetaRadian=(pi()/180)*$theta;
	$sigmaX1=round((0.5*($sigmaX+$sigmaY)+0.5*($sigmaX-$sigmaY)*cos(2*$thetaRadian)+$tauXY*sin(2*$thetaRadian)),2);
	$tau1=round(((-0.5)*($sigmaX-$sigmaY)*sin(2*$thetaRadian)+$tauXY*cos(2*$thetaRadian)),2);
	
//	echo "Sigma X1 $sigmaX1<br>";
//	echo "Tau1 $tau1<br>";

	$theta=$abp[0];		
		
	$thetaRadian=(pi()/180)*$theta;
	$sigmaY1=round((0.5*($sigmaX+$sigmaY)+0.5*($sigmaX-$sigmaY)*cos(2*$thetaRadian)+$tauXY*sin(2*$thetaRadian)),2);

//	echo "Sigma Y1 $sigmaY1<br>";
//	echo "Tau1 $tau1";

	$sigmaX=0;		
	$sigmaY=0;		
	$tauXY=-35;		
	$theta=$abp[1]-90;		 
		
	$thetaRadian=(pi()/180)*$theta;
	$sigmaX2=round((0.5*($sigmaX+$sigmaY)+0.5*($sigmaX-$sigmaY)*cos(2*$thetaRadian)+$tauXY*sin(2*$thetaRadian)),2);
	$tau2=round(((-0.5)*($sigmaX-$sigmaY)*sin(2*$thetaRadian)+$tauXY*cos(2*$thetaRadian)),2);

//	echo "Theta $theta Sigma X2 $sigmaX2<br>";
//	echo "Tau1 $tau2<br>";

	$theta=$abp[1];		 // added 90 deg for other plane
		
	$thetaRadian=(pi()/180)*$theta;
	$sigmaY2=round((0.5*($sigmaX+$sigmaY)+0.5*($sigmaX-$sigmaY)*cos(2*$thetaRadian)+$tauXY*sin(2*$thetaRadian)),2);
//	echo "sigmaY2 $sigmaY2<br>";

//	$sigma1=round(0.5*($sigmaX+$sigmaY)+sqrt(pow(0.5*($sigmaX+$sigmaY),2)+pow($tauXY,2)),2);
//	$sigma2=round(0.5*($sigmaX+$sigmaY)-sqrt(pow(0.5*($sigmaX+$sigmaY),2)+pow($tauXY,2)),2);
//	$tauMax=($sigma1-$sigma2)/2;
	
//	$tan2theta=(2*$tauXY/($sigmaX-$sigmaY));
//	$thetaP1=(180/pi())*atan($tan2theta/2);
//	if($thetaP1>180)$thetaP1=$thetaP1-360;
//	$thetaS1=$thetaP1+45;
	
	$sigmaX=$sigmaX1+$sigmaX2;
	$sigmaY=$sigmaY1+$sigmaY2;
	$tauXY=$tau1+$tau2;
	
	$pcp[0]=round($sigmaX,2);
	$pcp[1]=round($sigmaY,2);
	$pcp[2]=round($tauXY,2);

// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Normal Stress along x-axis due element-1 </td><td>'.$sigmaX1.' MPa</td></tr>';
		echo '<tr><td>Normal Stress along y-axis due element-1 </td><td>'.$sigmaY1.' MPa</td></tr>';
		echo '<tr><td>Shear Stress due element-1 </td><td>'.$tau1.' MPa</td></tr>';
		echo '<tr><td>Normal Stress along x-axis due element-2 </td><td>'.$sigmaX2.' MPa</td></tr>';
		echo '<tr><td>Normal Stress along y-axis due element-2 </td><td>'.$sigmaY2.' MPa</td></tr>';
		echo '<tr><td>Shear Stress due element-2 </td><td>'.$tau2.' MPa</td></tr>';
		echo '<tr><td>SigmaX</td><td>'.$pcp[0].' MPa</td></tr>';
		echo '<tr><td>SigmaY</td><td>'.$pcp[1].' MPa</td></tr>';
		echo '<tr><td>Tau XY</td><td>'.$pcp[2].' MPa</td></tr>';
//		echo '<tr><td>Maximum Principal Stress </td><td>'.$pcp[2].' MPa</td></tr>';
//		echo '<tr><td>Plane of Maximum Shear Stress</td><td>'.$pcp[3].' degree</td></tr>';
//		echo '<tr><td>Minimum Principal Stress </td><td>'.$pcp[5].'MPa</td></tr>';
//		echo '<tr><td>Maximum Shear Stress </td><td>'.$pcp[3].' MPa</td></tr>';
		echo '</table>';
	}
?>