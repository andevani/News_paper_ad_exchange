<?php
	//session_start();

	//mysql_connect('localhost','root','');
	//mysql_select_db('news');
	$conn = new mysqli("localhost", "root", "");

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//echo "Connected successfully";

?>
