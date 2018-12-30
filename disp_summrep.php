<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn )
	{
	   die('Could not connect: ' . mysql_error());
	}

	$newspaper = $fdate = $tdate = $pageno = $section = $i1 = $i2 = $i3 = $i4 = $value = $edt_str = ''; 
	$edition = array();
	$hw = $hc = $thw = $thc = $h = $w = $column = $fact = $i = $th = $tw = $tcolumn = 0;

	$newspaper = trim($_POST['newspaper']);
	$pageno = trim($_POST['pageno']);
	//$date = trim($_POST['datepicker']);
	$fdate = date("y-m-d", strtotime(trim($_POST['fdate'])));
	$tdate = date("y-m-d", strtotime(trim($_POST['tdate'])));
	//$edition = $_POST['edition'];
	$section = trim($_POST['section']);
	$i1 = trim($_POST['input1']);
	$i2 = trim($_POST['input2']);
	$i3 = trim($_POST['input3']);
	$i4 = trim($_POST['input4']);

	foreach($_POST['edition'] as $value)
	{
		$edition[$i] = $value;
		$i = $i + 1;
	}
	
	//print_r($edition);
	
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
				Report Data
			</h1>
		</td>
	</tr>
	
	<tr>
		<th>Newspaper</th>
		<th>Date</th>
		<th>Edition</th>
		<th>Section</th>
		<th>File Name</th>
		<th>Height (cm)</th>
		<th>Width(cm)</th>
		<th>Height*Width(cm)</th>
		<th>Height(cm)</th>
		<th>Columns(nS)</th>
		<th>Height*Column(CC)</th>
	</tr>

	<tr>
    	<td align="center" width="500" colspan='17'>
			<h3 align="center">
				SUMMARY REPORT
			</h3>
		</td>
	</tr>
	
	<?php
	
	for ($i=0;$i<sizeof($edition);$i++)
	{
		echo $edition[$i];
		$query1 = $query . " AND a.edition =='". $edition[$i] ."' AND (a.date BETWEEN '". $fdate ."' AND '". $tdate ."'";
		
		mysqli_select_db($conn, 'news');

		$retval = mysqli_query($conn, $query);
		//$retval.$i = mysqli_query($conn, $query);

		if(! $retval ) {
		   die('Could not get data: ' . mysqli_error($conn));
		}
	
		while($row = mysqli_fetch_array($retval))
		{
			$h = $row['height'];
			$w = $row['width'];
			$fact = (trim($row['section']) == "Main" ? 4.5 : 4);
			
			$nh = ($h<=$fact) ? $fact :((ceil($h)%$fact === 0) ? ceil($h) : round(($h+$fact/2)/$fact)*$fact);
			$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round(($w+$fact/2)/$fact)*$fact);

			
			$column = $nw/$fact;
			
			$hw = $nh*$nw;
			$hc = $nh* $column;
			$th = $th + $nh;
			$tw = $tw + $nw;
			$tcolumn = $tcolumn + $column;
			$thw = $thw + $hw;
			$thc = $thc + $hc;
			$newspaper = $row['newspaper'];
		}
				
		echo "<tr>";
		echo "<td>" . $newspaper . "</td>";
		echo "<td></td>";
		echo "<td>" . $edition[$i] . "</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>" . $th . "</td>";
		echo "<td>" . $tw . "</td>";
		echo "<td>" . $thw . "</td>";
		echo "<td>" . $th . "</td>";
		echo "<td>" . $tcolumn . "</td>";
		echo "<td>" . $thc . "</td>";
		echo "</tr>";
	}
	?>
	
	<tr>
    	<td align="center" width="500" colspan='17'>
			<h3 align="center">
				DETAIL REPORT
			</h3>
		</td>
	</tr>
	
	<?php
	//date wise query & edition display
	for ($i=0;$i<sizeof($edition);$i++)
	{
		echo $edition[$i];
		$query1 = $query . " AND a.edition =='". $edition[$i] ."'";
		$days = date_diff($fdate, $tdate);
		echo $days;

		if($days > 0)
		{
			$date = $fdate;
			while($date <= $tdate)
			{
				$query2 = $query1 . "AND a.date='". $date ."'";
				
				mysqli_select_db($conn, 'news');

				$retval = mysqli_query($conn, $query);
				$retval.$i1 = mysqli_query($conn, $query);

				if(! $retval ) {
				   die('Could not get data: ' . mysqli_error($conn));
				}
				
				$k=0;
				while($row = mysqli_fetch_array($retval))
				{
					$h = $row['height'];
					$w = $row['width'];
					$fact = (trim($row['section']) == "Main" ? 4.5 : 4);
					
					$nh = ($h<=$fact) ? $fact :((ceil($h)%$fact === 0) ? ceil($h) : round(($h+$fact/2)/$fact)*$fact);
					$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round(($w+$fact/2)/$fact)*$fact);

					
					$column = $nw/$fact;
					
					$hw = $nh*$nw;
					$hc = $nh* $column;
					$th = $th + $nh;
					$tw = $tw + $nw;
					$tcolumn = $tcolumn + $column;
					$thw = $thw + $hw;
					$thc = $thc + $hc;
				}
						
				echo "<tr>";
				echo "<td>" . $row['newspaper'] . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td>" . $row['edition'] . "</td>";
				echo "<td>" . $row['section'] . "</td>";
				echo "<td>" . $row['filename'] . "</td>";
				echo "<td>" . $th . "</td>";
				echo "<td>" . $tw . "</td>";
				echo "<td>" . $thw . "</td>";
				echo "<td>" . $th . "</td>";
				echo "<td>" . $tcolumn . "</td>";
				echo "<td>" . $thc . "</td>";
				echo "</tr>";
			}
		}
		else
		{
			$query2 = $query1 . "AND a.date='". $fdate ."'";
			echo "PPPPOOOOJJJJAAA";
			mysqli_select_db($conn, 'news');

			$retval = mysqli_query($conn, $query);
			//$retval.$i = mysqli_query($conn, $query);

			if(! $retval ) 
			{
			   die('Could not get data: ' . mysqli_error($conn));
			}
			
			while($row = mysqli_fetch_array($retval))
			{
				$h = $row['height'];
				$w = $row['width'];
				$fact = (trim($row['section']) == "Main" ? 4.5 : 4);
				
				$nh = ($h<=$fact) ? $fact :((ceil($h)%$fact === 0) ? ceil($h) : round(($h+$fact/2)/$fact)*$fact);
				$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round(($w+$fact/2)/$fact)*$fact);

				
				$column = $nw/$fact;
				
				$hw = $nh*$nw;
				$hc = $nh* $column;
				$th = $th + $nh;
				$tw = $tw + $nw;
				$tcolumn = $tcolumn + $column;
				$thw = $thw + $hw;
				$thc = $thc + $hc;
			}
					
			echo "<tr>";
			echo "<td>" . $row['newspaper'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['edition'] . "</td>";
			echo "<td>" . $row['section'] . "</td>";
			echo "<td>" . $row['filename'] . "</td>";
			echo "<td>" . $th . "</td>";
			echo "<td>" . $tw . "</td>";
			echo "<td>" . $thw . "</td>";
			echo "<td>" . $th . "</td>";
			echo "<td>" . $tcolumn . "</td>";
			echo "<td>" . $thc . "</td>";
			echo "</tr>";
		}
	}
	
	?>
	
	</table>


	</body>

</html>

<?php
	mysqli_close($conn);
?>