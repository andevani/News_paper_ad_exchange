<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn )
	{
	   die('Could not connect: ' . mysql_error());
	}

	$newspaper = '';
	$date = '';
	$pageno = '';

	$newspaper = trim($_POST['newspaper']);
	$pageno = trim($_POST['pageno']);
	//$date = trim($_POST['datepicker']);
	$date = date("y-m-d", strtotime(trim($_POST['datepicker'])));
	$i1 = trim($_POST['input1']);
	$i2 = trim($_POST['input2']);
	$i3 = trim($_POST['input3']);
	$i4 = trim($_POST['input4']);

	$query = "Select * from news.news1 as a INNER JOIN news.news2 as b on a.unique_id=b.unique_id ";
	$query .= "INNER JOIN news.news3 as c on b.filename=c.filename where 1";


	if (isset($newspaper) and !empty($newspaper))
	{
		$query .= " AND a.newspaper = '". $newspaper ."'";
	}

	if (isset($pageno) and !empty($pageno))
	{
		$query .= " AND a.pageno='". $pageno ."'";
	}

	if (isset($date) and !empty($date))
	{
		$query .= " AND a.date='". $date ."'";
	}

	if (isset($input1) and !empty($input1))
	{
		$query .= " AND b.input1='". $i1 ."'";
	}

	if (isset($i2) and !empty($i2))
	{
		$query .= " AND b.input2='". $i2 ."'";
	}

	if (isset($i3) and !empty($i3))
	{
		$query .= " AND b.input3='". $i3 ."'";
	}

	if (isset($i4) and !empty($i4))
	{
		$query .= " AND b.input4='". $i4 ."'";
	}

	//echo $query;


//echo $query;
	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Report</title>

	<link href="CSS/._main.css" rel="stylesheet" type="text/css">

</head>

<script type="text/javascript" src="JS/._main.js"></script>

<body background="bg.png">

	<div class="header" align="center" style="background-color: #fffff0;border:1px solid black;">
	
		<br>
		
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
	
		<br>
		<br>
	</div>
	
	<br>
	
	<table border="1" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">
	
	<tr>
    	<td align="center" width="500" colspan='10'>
			<h1 align="center">
				Report Data
			</h1>
		</td>
	</tr>
	
	<tr>
		<th>Newspaper</th>
		<th>Date</th>
		<th>Page No</th>
		<th>File Name</th>
		<th>Height</th>
		<th>Width</th>
		<th>Advertise/News?</th>
		<th>Advertiser</th>
		<th>Input 3</th>
		<th>Input 4</th>
	</tr>

	<?php
	while($row = mysqli_fetch_array($retval))
	{
		echo "<tr>";
			echo "<td>" . $row['newspaper'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['pageno'] . "</td>";
			echo "<td>" . $row['filename'] . "</td>";
			echo "<td>" . $row['height'] . "</td>";
			echo "<td>" . $row['width'] . "</td>";
			echo "<td>" . $row['input1'] . "</td>";
			echo "<td>" . $row['input2'] . "</td>";
			echo "<td>" . $row['input3'] . "</td>";
			echo "<td>" . $row['input4'] . "</td>";
		echo "</tr>";
	}
	?>

	</table>


	</body>

</html>

<?php
	mysqli_close($conn);
?>
