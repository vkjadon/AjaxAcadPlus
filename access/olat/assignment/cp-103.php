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
	$sigmaX=90;		
	$sigmaY=50;		
	$tauXY=-35;		
	$theta=90-$abp[0];		 
	
	
	$thetaRadian=(pi()/180)*$theta;
	$sigmaTheta=round((0.5*($sigmaX+$sigmaY)+0.5*($sigmaX-$sigmaY)*cos(2*$thetaRadian)+$tauXY*sin(2*$thetaRadian)),2);
	$tauTheta=round(((-0.5)*($sigmaX-$sigmaY)*sin(2*$thetaRadian)+$tauXY*cos(2*$thetaRadian)),2);

	$sigma1=round(0.5*($sigmaX+$sigmaY)+sqrt(pow(0.5*($sigmaX-$sigmaY),2)+pow($tauXY,2)),2);
	$sigma2=round(0.5*($sigmaX+$sigmaY)-sqrt(pow(0.5*($sigmaX-$sigmaY),2)+pow($tauXY,2)),2);
	$tauMax=($sigma1-$sigma2)/2;
	
	$tan2theta=(2*$tauXY/($sigmaX-$sigmaY));
	$thetaP1=(90/pi())*atan($tan2theta);
//	if($thetaP1>180)$thetaP1=$thetaP1-360;
	$thetaS1=$thetaP1+45;
	
	
	$pcp[0]=round($sigmaTheta,2);
	$pcp[1]=round($tauTheta,2);

	$pcp[2]=round($thetaP1,2);
	$pcp[3]=round($tauMax,2);


// Solution
	if($solution=='Y')
	{
		echo '<table class="table table-bordered">';
		echo '<tr><td>Normal Stress</td><td>'.$pcp[0].' MPa</td></tr>';
		echo '<tr><td>Shear Stress</td><td>'.$pcp[1].' MPa</td></tr>';
		echo '<tr><td>Principal Plane </td><td>'.$pcp[2].' degree</td></tr>';
//		echo '<tr><td>Maximum Principal Stress </td><td>'.$pcp[2].' MPa</td></tr>';
//		echo '<tr><td>Plane of Maximum Shear Stress</td><td>'.$pcp[3].' degree</td></tr>';
//		echo '<tr><td>Minimum Principal Stress </td><td>'.$pcp[5].'MPa</td></tr>';
		echo '<tr><td>Maximum Shear Stress </td><td>'.$pcp[3].' MPa</td></tr>';
		echo '</table>';
	}
?>