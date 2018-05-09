	<?php
	$dbhost = 'localhost';

                $dbuser = 'root';

                $dbpass = '';



                $conn = mysqli_connect($dbhost, $dbuser, $dbpass);



                if(! $conn ) {

                   die('Could not connect: ' . mysql_error());

                }

		$uniqid = $_GET['uniqid'];
		$json_file = $_GET['filename'];

	//	$sql = "SELECT * from news.news2 WHERE unique_id='5acd053f6ef2e' AND filename='5acd053f6ef2e_1.png'";
                $sql = 'SELECT * from news.news2 WHERE unique_id=' .$uniqid. ' AND filename='. $json_file;
		//$sql = "SELECT * from news.news2 WHERE unique_id='5acd1d82e957d' AND filename='5acd1d82e957d_1.png'";
	//	echo $sql;
		//$sql = "SELECT * from news.news2 WHERE unique_id='5accf507df4a2' AND filename='5accf507df4a2_1.png";

		//$sql = "SELECT * from news.news2 WHERE unique_id='5accf507df4a2' AND filename='5accf507df4a2_1.png'";

                mysqli_select_db($conn, 'news');

		$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");


fwrite($myfile, $sql);

//fclose($myfile);




                $retval = mysqli_query($conn, $sql);

//fwrite($myfile, $retval);

                if(! $retval ) {

                   die('Could not get data: ' . mysqli_error($conn));

                }
		$array = mysqli_fetch_row($retval);
		echo json_encode($array);
		//echo $array;
fclose($myfile);

?>
