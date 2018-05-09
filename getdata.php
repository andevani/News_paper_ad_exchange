	  <?php
 		if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
{
		$dbhost = 'localhost';

		$dbuser = 'root';

		$dbpass = '';



		$conn = mysqli_connect($dbhost, $dbuser, $dbpass);



		if(! $conn ) {

		   die('Could not connect: ' . mysql_error());

		}

		

		$sql = 'SELECT * from news.news2 WHERE unique_id=' .$uniqid. ' AND filename="'. $json[$_COOKIE['id']] . '"';



		mysqli_select_db($conn, 'news');



		$retval = mysqli_query($conn, $sql);

		

		if(! $retval ) {

		   die('Could not get data: ' . mysqli_error($conn));

		}

		return '10';
		$array = mysqli_fetch_row($retval);
		//return json_encode();
		mysqli_close($conn);
		}
		?>


