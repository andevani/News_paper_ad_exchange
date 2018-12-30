<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn )
	{
	   die('Could not connect: ' . mysql_error());
	}

	$newspaper = $date = $pageno = $edition = $section = $i1 = $i2 = $i3 = $i4 = ''; 
	$hw = $hc = $thw = $thc = $h = $w = $column = $fact = 0;

	$query = "Select * from news.news1 as a INNER JOIN news.news2 as b on a.unique_id=b.unique_id ";
	$query .= "INNER JOIN news.news3 as c on b.filename=c.filename where b.cat='Other' OR ";
	$query .= "b.brand='Other' OR b.prod='Other' OR b.prdcat='Other' OR b.agent='Other' OR b.client='Other'";
	
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

</head>

<script type="text/javascript" src="jquery-3.3.1.min.js"></script>

<script type="text/javascript">

	function export_data()
	{
		var str = "exportrep.php?query='<?php echo $query; ?>'";
		$.get(str, function(data){
			alert("Data Exported Succesfully");
		});
	}

</script>

<body background="bg.png">

	<div class="header" align="center" style="background-color: #fffff0;border:1px solid black;">
	
		<br>
		
		<?php
		$file = "exportrep.php?query=" . $query;
		?>
		<form action="<?php echo $file ?>" method="POST">
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="export" id="export" value="Export" onclick="export_data();">
		</form>
	
		<br>
		<br>
	</div>
	
	<br>
	
	<table border="1" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">
	
	<tr>
    	<td align="center" width="500" colspan='17'>
			<h1 align="center">
				Exception Report
			</h1>
		</td>
	</tr>
	
	<tr>
		<th>Sr. No</th>
		<th>Newspaper</th>
		<th>Date</th>
		<th>Page No</th>
		<th>Edition</th>
		<th>Section</th>
		<th>File Name</th>
		<th>Category</th>
		<th>Categoryv- 2</th>
		<th>Brand</th>
		<th>Brand - 2</th>
		<th>Product Category</th>
		<th>Product Category - 2</th>
		<th>Product Name</th>
		<th>Product Name - 2</th>
		<th>Agent</th>
		<th>Agent - 2</th>
		<th>Client</th>
		<th>Client - 2</th>
	</tr>

	<?php
	
	$i = 0;
	while($row = mysqli_fetch_array($retval))
	{
		echo "<tr>";
			echo "<td>" . $i . "</td>";
			echo "<td>" . $row['newspaper'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['pageno'] . "</td>";
			echo "<td>" . $row['edition'] . "</td>";
			echo "<td>" . $row['section'] . "</td>";
			echo "<td>" . $row['filename'] . "</td>";
			echo "<td>" . $row['cat'] . "</td>";
			echo "<td>" . $row['cat2'] . "</td>";
			echo "<td>" . $row['brand'] . "</td>";
			echo "<td>" . $row['brand2'] . "</td>";
			echo "<td>" . $row['prdcat'] . "</td>";
			echo "<td>" . $row['prdcat2'] . "</td>";
			echo "<td>" . $row['prod'] . "</td>";
			echo "<td>" . $row['prod2'] . "</td>";
			echo "<td>" . $row['agent'] . "</td>";
			echo "<td>" . $row['agent2'] . "</td>";
			echo "<td>" . $row['client'] . "</td>";
			echo "<td>" . $row['client2'] . "</td>";
		echo "</tr>";
	}
	?>
	
	</table>


	</body>

</html>

<?php
	mysqli_close($conn);
?>
