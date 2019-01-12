<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
	   die('Could not connect: ' . mysql_error());
	}

	$query = trim($_POST['query']);
	
	$thw = $thc = $column = $hw = $hc = $i = $h = $w = $aw = $fact = $nh = $nw = 0;
	//echo $query;

	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}

	 $fp = fopen('/home/tops/Desktop/Export_report_folder/REPORT_EXPORT_DATA.csv', 'w');
	// $fp = fopen('C:\Users\Rumit\Desktop\REPORT_EXPORT_DATA.csv', 'w');
	//header of file
	//print_r($retval);
	$header = array("Sr No","Newspaper","Date","Edition","Section","Software Height","Software Column","Uploaded Height","Uploaded Column","Advertise","Product Category");
	fputcsv($fp, $header);
	$i = 0;
	while($row = mysqli_fetch_assoc($retval)){
		$i=$i+1;
		$size_array = explode('X',$row['size']);
		$row_n = array($i,$row['newspaper'],$row['date'],$row['edition'],$row['section'],$row['software_height'],$row['software_column'],$size_array[0],$size_array[1],$row['input2'],$row['prdcat']);
		fputcsv($fp, $row_n);
	}

	// footer of file
	$footer = array("","","","","","","","","","","","","","","","","");
	fputcsv($fp, $footer);
	
	fclose($fp);

	mysqli_close($conn);
	
	header("Location: exception_report_filter.php");
?>
