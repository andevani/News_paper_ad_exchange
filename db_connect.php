<?php
$servername = "localhost";

$username = "root";

$password = "";

$database = "news";



// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);



// Check connection

if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

echo "Connected successfully";
$query = "Select * from news.news1";
       // $query = "select * from  news.news3";

        mysqli_select_db($conn, 'news');

//	$query = "select * from news.news4";
        $retval = mysqli_query($conn, $query);
	echo "Ankur.";

?>
