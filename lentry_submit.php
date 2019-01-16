	<?php
	
	require_once('include-files/connection.php');

	$newspaper = $pgno = $client = $agent = $cobw = $brand = $pname = $pcat = $bpg = $ppg = $matter = '';
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$msg = '';
		$newspaper = isset($_POST['newspaper']) ? trim($_POST['newspaper']) : '';
		$pgno = isset($_POST['pgno']) ? trim($_POST['pgno']) : '';
		$client = isset($_POST['client']) ? trim($_POST['client']) : '';
		$agent = isset($_POST['agent']) ? trim($_POST['agent']) : '';
		$cobw = isset($_POST['cobw']) ? trim($_POST['cobw']) : '';
		$brand = isset($_POST['brand']) ? trim($_POST['brand']) : '';
		$pname = isset($_POST['pname']) ? trim($_POST['pname']) : '';
		$pcat = isset($_POST['pcat']) ? trim($_POST['pcat']) : '';
		$bpg = isset($_POST['bpg']) ? trim($_POST['bpg']) : '';
		$ppg = isset($_POST['ppg']) ? trim($_POST['ppg']) : '';
		$matter = isset($_POST['matter']) ? trim($_POST['matter']) : '';

		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';

		$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

		$query = 'INSERT INTO news.advdata_new SET ';
		$query .= ' newspaper = \''.$newspaper.'\'';
		$query .= ' , pgno = \''.$pgno.'\'';
		$query .= ' , client = \''.$client.'\'';
		$query .= ' , agent = \''.$agent.'\'';
		$query .= ' , cobw = \''.$cobw.'\'';
		$query .= ' , brand = \''.$brand.'\'';
		$query .= ' , pname = \''.$pname.'\'';
		$query .= ' , pcat = \''.$pcat.'\'';
		$query .= ' , bpg = \''.$bpg.'\'';
		$query .= ' , ppg = \''.$ppg.'\'';
		$query .= ' , matter = \''.$matter.'\'';
		
		echo $query;
		mysqli_query($conn, $query) or die(mysqli_error($conn));
		
		mysqli_close($conn);
	}

	mysqli_close($conn);
	
	header("Location: lentry.php");
	?>