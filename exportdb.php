<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
	   die('Could not connect: ' . mysql_error());
	}

	$uid = $_GET['uniqueid'];
	//'5ab72c0ec4c0c';
	$uid = trim($_GET['uniqueid'],"'");
	echo $uid;



	$query = "Select news.news1.*, news.news2.*, news.news3.* from news.news1, news.news2, news.news3 where news.news1.unique_id = '". $uid;
	$query .= "' AND news.news2.unique_id='". $uid;
	$query .= "' AND news.news3.unique_id='". $uid ."'";

	echo $query;

	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}

	$fp = fopen($uid.'EXPORT_DATA.csv', 'w');

	while($row = mysqli_fetch_assoc($retval)){
		 fputcsv($fp, $row);
	}

	fclose($fp);

	mysqli_close($conn);
?>
