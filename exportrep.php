<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
	   die('Could not connect: ' . mysql_error());
	}

	$query = trim($_GET['query']);
	$thw = $thc = $column = $hw = $hc = $i = $h = $w = $fact = $nh = $nw = 0;
	//echo $query;

	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}

	$fp = fopen('/home/tops/Desktop/Export_report_folder/REPORT_EXPORT_DATA.csv', 'w');

	//header of file
	//print_r($retval);
	$header = array("Sr No","Newspaper","Date","Page No","Edition","Section","Filename","Height(cm)","width(cm)","H*W(cm)","Height(cm)","Column(nS)","H*C(CC)","Advertise/News","Advertiser","Input3","Input4");
	fputcsv($fp, $header);
	
	while($row = mysqli_fetch_assoc($retval)){
		$i=$i+1;
		$h = $row['height'];
		$w = $row['width'];
		$fact = (trim($row['section']) == "Main" ? 4.5 : 4);
		
		$nh = round($h);
		$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round(($w+$fact/2)/$fact)*$fact);

		
		$column = $nw/$fact;
		
		$hw = $nh*$nw;
		$hc = $nh* $column;
		$thw = $thw + $hw;
		$thc = $thc + $hc;
		
		$row_n = array($i,$row['newspaper'],$row['date'],$row['pageno'],$row['edition'],$row['section'],$row['filename'],$nh,$nw, $hw,$nh, $column, $hc,$row['input1'],$row['input2'],$row['input3'],$row['input4']);
		
		fputcsv($fp, $row_n);
	}

	//footer of file
	$footer = array("","","","","","","","","",$thw,"","",$thc,"","","","");
	fputcsv($fp, $footer);
	
	fclose($fp);

	mysqli_close($conn);
	
	header("Location: rep_flt.php");
?>

