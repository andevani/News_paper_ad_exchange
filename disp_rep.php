<?php

	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn )
	{
	   die('Could not connect: ' . mysql_error());
	}
		

	$newspaper = $date = $pageno = $edition = $section = $i1 = $i2 = $i3 = $i4 = ''; 
	$hw = $hc = $thw = $thc = $h = $w = $aw = $column = $fact = 0;

	$newspaper = trim($_POST['newspaper']);
	$pageno = trim($_POST['pageno']);
	//$date = trim($_POST['datepicker']);
	$date = date("y-m-d", strtotime(trim($_POST['datepicker'])));
	//echo $date;
	$edition = trim($_POST['edition']);
	$section = trim($_POST['section']);
	$i1 = trim($_POST['input1']);
	$i2 = trim($_POST['input2']);
	$i3 = trim($_POST['input3']);
	$i4 = trim($_POST['input4']);

	$query = "Select * from news.news1 as a INNER JOIN news.news2 as b on a.unique_id=b.unique_id ";
	$query .= "INNER JOIN news.news3 as c on b.filename=c.filename where 1";
//	$query .="INNER JOIN news.news3 as c on b.filename=c.filename";


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

	if (isset($edition) and !empty($edition))
	{
		$query .= " AND a.edition='". $edition ."'";
	}
	
	if (isset($section) and !empty($section))
	{
		$query .= " AND a.section='". $section ."'";
	}
	
	if (isset($i1) and !empty($i1))
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

//	echo $date;
//	echo $query;
	
	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

//	if(! $retval ) {
//	   die('Could not get data: ' . mysqli_error($conn));
//	}
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
			alert("Data Exported Successfully");
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
    	<td align="center" width="500" colspan='18'>
			<h1 align="center">
				Report Data
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
		<th>Height (cm)</th>
		<th>Width(cm)</th>
		<th>Height*Width(cm)</th>
		<th>Height(cm)</th>
		<th>Columns(nS)</th>
		<th>Height*Column(CC)</th>
		<th>Advertise/News?</th>
		<th>Advertiser</th>
		<th>Product Category</th>
		<th>Input 3</th>
		<th>Input 4</th>
	</tr>

	<?php
	
	$i = 0;
	while($row = mysqli_fetch_array($retval))
	{
		$i=$i+1;
		$h = $row['height'];
		$w = $aw =  $row['width'];
		$fact = 4;
		if ($newspaper == 'Gujarat Samachar'){
		$fact = (trim($row['section']) == "Main" ? 4.5 : 4);
		$fact = (trim($row['edition']) == "MUM" ? 4 : $fact);
		}
		$nh = round($h);
		$w = round($w);
		//echo $w;
//echo $w . "    P    " . $fact. "     P     ".round($w)%$fact;
//echo "<br>";
		$nw = ($w<=$fact) ? $fact : (round($w)%$fact == 0 ? round($w) : round(($w+$fact/2)/$fact)*$fact);
		//(round($n)%$x === 0) ? round($n) : round(($n+$x/2)/$x)*$x;
		//$w = ceil($w);
		//$nw = ($w<=$fact) ? $fact : round(($w+$fact/2)/$fact)*$fact;
		//$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round(($w+$fact/2)/$fact)*$fact);
		//$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round($w/$fact)*$fact);
		
		//change : 20/10/18
		$column = round($nw/$fact);
		if ($newspaper == 'Sandesh' && $w > 30){
		$column = 8;
		}

		if ($newspaper == 'Sandesh' && $aw < 4.7 && $aw > 4){
		$column = 1;
		}

		if ($newspaper == 'Sandesh' && $aw < 17 && $aw > 16){
		$column = 4;
		}

		if ($newspaper == 'Divya Bhaskar' && $w > 30){
		$column = 8;
		}

		$hw = $nh*$nw;
		$hc = $nh* $column;
		$thw = $thw + $hw;
		$thc = $thc + $hc;
		echo "<tr>";
			echo "<td>" . $i . "</td>";
			echo "<td>" . $row['newspaper'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['pageno'] . "</td>";
			echo "<td>" . $row['edition'] . "</td>";
			echo "<td>" . $row['section'] . "</td>";
			echo "<td>" . $row['filename'] . "</td>";
			//echo "<td>" . $row['width'] . 'P' . $fact ."p". $x. "</td>";
			echo "<td>" . $nh . "</td>";
			echo "<td>" . $nw . "</td>";
			echo "<td>" . $hw . "</td>";
			echo "<td>" . $nh . "</td>";
			echo "<td>" . $column . "</td>";
			echo "<td>" . $hc . "</td>";
			echo "<td>" . $row['input1'] . "</td>";
			echo "<td>" . $row['input2'] . "</td>";
			echo "<td>" . $row['prdcat'] . "</td>";
			echo "<td>" . $row['input3'] . "</td>";
			echo "<td>" . $row['input4'] . "</td>";
		echo "</tr>";
	}
	?>

	<tfoot>
		<tr>
		  <td>Total</td>
		  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
		  <td> <?php echo $thw; ?></td>
		  <td></td><td></td>
		  <td> <?php echo $thc; ?></td>
		  <td></td><td></td><td></td><td></td><td></td>
		</tr>
	</tfoot>
	
	</table>


	</body>

</html>

<?php
	mysqli_close($conn);
?>

