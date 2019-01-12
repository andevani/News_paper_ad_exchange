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

	$newpapers = !empty($_POST['newspapers'])?$_POST['newspapers']:'';
	$editions = !empty($_POST['editions'])?$_POST['editions']:'';
	$sections = !empty($_POST['sections'])?$_POST['sections']:'';
	$from_date = !empty($_POST['from_date'])?$_POST['from_date']:'';
	$to_date = !empty($_POST['to_date'])?$_POST['to_date']:'';
	//	SUBSTRING_INDEX(adv.size,'X',1) as uploaded_height, SUBSTRING_INDEX(adv.size,'X',-1) as uploaded_column, 
	$query = "SELECT 
	CASE 
		WHEN (n1.newspaper = 'Gujarat Samachar' and n1.section='Main' and n1.edition!='MUM')
		THEN 
			CASE
				WHEN (ROUND(n3.width) <= 4.5) THEN '1'
				ELSE
					CASE
						WHEN (MOD(ROUND(n3.width),4.5)=0) 
						THEN ROUND(ROUND(n3.width)/4.5)
						ELSE ROUND(round(((n3.width+4.5/2)/4.5)*4.5)/4.5)
					END
			END
			WHEN(n1.newspaper = 'Sandesh' and ROUND(n3.width > 30)) THEN '8'
			WHEN(n1.newspaper = 'Sandesh' and n3.width < 4.7 and n3.width > 4) THEN '1'
			WHEN(n1.newspaper = 'Sandesh' and n3.width < 17 and n3.width > 16) THEN '4'
			WHEN(n1.newspaper = 'Divya Bhaskar' and ROUND(n3.width > 30)) THEN '8'
			WHEN(n1.newspaper = 'Divya Bhaskar' and ROUND(n3.width > 30)) THEN '52'
		ELSE
			CASE
				WHEN (ROUND(n3.width) <= 4) THEN '1'
				ELSE
					CASE
						WHEN (MOD(ROUND(n3.width),4)=0) 
						THEN ROUND(ROUND(n3.width)/4)
						ELSE ROUND(round(((n3.width+4/2)/4)*4)/4)
					END
			END
	END as software_column,SUBSTRING_INDEX(adv.size,'X',1) as uploaded_height, SUBSTRING_INDEX(adv.size,'X',-1) as uploaded_column,n3.width,adv.size,n2.prdcat, n2.input2, n1.date, n1.section, ROUND(n3.height) as software_height, n2.cat, n2.prdcat, n2.prod, n1.edition, n2.client, n1.newspaper 
	from news2 n2 
	Inner join news3 n3 on n3.filename=n2.filename 
	Inner join advdata adv on trim(adv.client)=trim(n2.client) 
	Inner Join news1 n1 on n1.unique_id=n2.unique_id 
	where 1 ";

	 if(!empty($newpapers)){
		$query .= " and newspaper='".$newpapers."'";
	}

	if(!empty($editions)){
		$query .= " and edition='".$editions."'";
	}

	if(!empty($sections)){
		$query .= " and section='".$sections."'";
	}

	if(!empty($from_date) and !empty($to_date)){
		$query .= " and date >='".date('Y-m-d',strtotime($from_date))."' and date<= '".date('Y-m-d',strtotime($to_date))."'";	
}

// $query .= " GROUP by n2.client ORDER BY n2.client ASC LIMIT 10";
// $query .= "limit 10";
$query .=" having (uploaded_height*uploaded_column)!=(software_height*software_column)";
mysqli_select_db($conn, 'news');
$retval = mysqli_query($conn, $query);

if(!$retval) {
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
			alert("Data Exported Successfully");
		});
	}

</script>

<body background="bg.png">

	<div class="header" align="center" style="background-color: #fffff0;border:1px solid black;">
	
		<br>
		
		<?php
		$file = "export_exception.php?query=" . $query;
		?>
		<form action="<?php echo $file ?>" method="POST">
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='exception_report_filter.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="hidden" name="query" value="<?php echo $query; ?>"/>
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
		<th>Edition</th>
		<th>Section</th>
		<th>Software Height</th>
		<th>Software Column</th>
		<th>Uploaded Height</th>
		<th>Uploaded Column</th>
		<th>Advertise</th>
		<th>Product Category</th>
	</tr>

	<?php
	
	$i = 0;
	while($row = mysqli_fetch_array($retval))
	{
		$i=$i+1;
		
		// $software_height = $row['software_height'];
		// $width = $aw =  $row['width'];
		// $fact = 4;
		// if ($newpapers == 'Gujarat Samachar')
		// {
		// 	$fact = (trim($row['section']) == "Main" ? 4.5 : 4);
		// 	$fact = (trim($row['edition']) == "MUM" ? 4 : $fact);
		// }
		// $nh = round($software_height);
		// $width = round($width);
		
		// $nw = ($width<=$fact) ? $fact : (round($width)%$fact == 0 ? round($width) : round(($width+$fact/2)/$fact)*$fact);
		
		// $column = round($nw/$fact);

		// if ($newpapers == 'Sandesh' && $width > 30){
		// 	$column = 8;
		// }

		// if ($newpapers == 'Sandesh' && $aw < 4.7 && $aw > 4){
		// 	$column = 1;
		// }

		// if ($newpapers == 'Sandesh' && $aw < 17 && $aw > 16){
		// 	$column = 4;
		// }

		// if ($newpapers == 'Divya Bhaskar' && $width > 30){
		// 	$column = 8;
		// }

		// if ($newpapers == 'Divya Bhaskar' && $nh > 50){
		// 	$nh = 52;
		// }
		
		$size_array = explode('X',$row['size']);

		echo "<tr>";
			echo "<td>" . $i . "</td>";
			echo "<td>" . $row['newspaper'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['edition'] . "</td>";
			echo "<td>" . $row['section'] . "</td>";
			echo "<td>" . $row['software_height'] . "</td>";
			echo "<td>" . $row['software_column'] . "</td>";
			echo "<td>" . $size_array[0] . "</td>";
			echo "<td>" . $size_array[1] . "</td>";
			echo "<td>" . $row['input2'] . "</td>";
			echo "<td>" . $row['prdcat'] . "</td>";
		echo "</tr>";
	}
	?>
	
	</table>


	</body>

</html>

<?php
	mysqli_close($conn);
?>

