<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
	   die('Could not connect: ' . mysql_error());
	}

	$query = trim($_GET['query']);
	
	$thw = $thc = $column = $hw = $hc = $i = $h = $w = $aw = $fact = $nh = $nw = 0;
	//echo $query;

	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}

	$fp = fopen('/home/tops/Desktop/Export_report_folder/REPORT_EXPORT_DATA.csv', 'w');
	//$fp = fopen('C:\Users\Rumit\Desktop\REPORT_EXPORT_DATA.csv', 'w');
	//header of file
	//print_r($retval);
	$header = array("Sr No","Category","Product","Client","Edition","Gujarat Samachar Total","Sandesh Total","Divya Bhaskar Total");
	fputcsv($fp, $header);
	$i = 0;
	while($row = mysqli_fetch_assoc($retval)){
		$i=$i+1;
		$row_n = array($i,$row['cat'],$row['prod'],$row['client'],$row['edition'],$row['gtotal'],$row['stotal'],$row['dtotal']);
		fputcsv($fp, $row_n);
	}

	//footer of file
	$footer = array("","","","","","","","","","","","","","","","","");
	fputcsv($fp, $footer);
	
	fclose($fp);

	mysqli_close($conn);
	
	header("Location: comparison_report_filter.php");
?>
