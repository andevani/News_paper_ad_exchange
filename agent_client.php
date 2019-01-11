<?php

	$dbhost = 'localhost';

	$dbuser = 'root';

	$dbpass = '';



	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);



	if(! $conn ) {

	   die('Could not connect: ' . mysql_error());

	}

	$client = $_GET['client'];
	$sql = "SELECT * from news.advdata WHERE trim(news.advdata.client)='" .$client."'";
//echo $sql;
//die;
	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $sql);

	if(! $retval ) 
	{

	   die('Could not get data: ' . mysqli_error($conn));

	}
	//Initialize array variable
	$arr = array();

	//Fetch into associative array
	//while ( $row = $retval->fetch_assoc())  
	//{
	//	$arr[]=$row;
	//}
	$arr = mysqli_fetch_row($retval);
	//echo "<pre>";
	//print_r(json_encode($arr));
	echo json_encode($arr);

?>
