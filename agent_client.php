	<?php
	$dbhost = 'localhost';

                $dbuser = 'root';

                $dbpass = '';



                $conn = mysqli_connect($dbhost, $dbuser, $dbpass);



                if(! $conn ) {

                   die('Could not connect: ' . mysql_error());

                }

                $client = $_GET['client'];
		$sql = 'SELECT * from news.advdata WHERE client=' .$client;

                mysqli_select_db($conn, 'news');

                $retval = mysqli_query($conn, $sql);

                if(! $retval ) {

                   die('Could not get data: ' . mysqli_error($conn));

                }
		$array = mysqli_fetch_row($retval);
		echo json_encode($array);
		//echo json_encode($array);
		//echo $array;

?>
