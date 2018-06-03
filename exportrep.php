<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
	   die('Could not connect: ' . mysql_error());
	}

	$query = trim($_GET['query']);
	echo $query;

	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}

	$fp = fopen('/home/tops/Desktop/Export_report_folder/REPORT_EXPORT_DATA.csv', 'w');

	while($row = mysqli_fetch_assoc($retval)){
		 fputcsv($fp, $row);
	}

	fclose($fp);

	mysqli_close($conn);
	
	header("Location: rep_flt.php");
?>
