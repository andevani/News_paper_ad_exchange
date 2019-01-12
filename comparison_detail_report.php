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

$newpapers = !empty($_POST['newspapers'])?"'".implode("','",$_POST['newspapers'])."'":'';
$categories = !empty($_POST['categories'])?"'".implode("','",$_POST['categories'])."'":'';
$product_categories = !empty($_POST['product_categories'])?"'".implode("','",$_POST['product_categories'])."'":'';
$clients = !empty($_POST['clients'])?"'".implode("','",$_POST['clients'])."'":'';
$editions = !empty($_POST['editions'])?"'".implode("','",$_POST['editions'])."'":'';
$from_date = !empty($_POST['from_date'])?$_POST['from_date']:'';
$to_date = !empty($_POST['to_date'])?$_POST['to_date']:'';

$query = "SELECT n2.cat,n2.prdcat,n2.prod,n1.edition,n2.client,n1.newspaper,sum(IF (n1.newspaper = 'Gujarat Samachar', ROUND(n3.height)*ROUND(n3.width),0 )) as gtotal,
sum(IF (n1.newspaper = 'Sandesh', ROUND(n3.height)*ROUND(n3.width),0 )) as stotal, sum(IF (n1.newspaper = 'Divya Bhaskar', ROUND(n3.height)*ROUND(n3.width),0 )) as dtotal from news2 n2 inner join news3 n3 on n3.filename=n2.filename Inner Join news1 n1 on n1.unique_id=n3.unique_id where client!='' ";

if(!empty($newpapers)){
	$query .= " and newspaper in (".$newpapers.")";	
}

if(!empty($categories)){
	$query .= " and cat in (".$categories.")";	
}

if(!empty($product_categories)){
	$query .= " and prdcat in (".$product_categories.")";	
}

if(!empty($clients)){
	$query .= " and client in (".$clients.")";	
}

if(!empty($editions)){
	$query .= " and edition in (".$editions.")";	
}

if(!empty($from_date) and !empty($to_date)){
	$query .= " and date >='".date('Y-m-d',strtotime($from_date))."' and date<= '".date('Y-m-d',strtotime($to_date))."'";	
}

$query .= " GROUP by n2.client ORDER BY n2.client";
// echo $query;die;
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
		var str = "export_comparison.php?query='<?php echo $query; ?>'";
		$.get(str, function(data){
			alert("Data Exported Successfully");
		});
	}

</script>

<body background="bg.png">

	<div class="header" align="center" style="background-color: #fffff0;border:1px solid black;">
	
		<br>
		
		<?php
		$file = "export_comparison.php?query=" . $query;
		?>
		<form action="<?php echo $file ?>" method="POST">
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='comparison_report_filter.php'">
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
		<th>Category</th>
		<th>Product</th>
		<th>Client</th>
		<th>Edition</th>
		<th>Gujarat Samachar Total</th>
		<th>Sandesh Total</th>
		<th>Divya Bhaskar Total</th>
	</tr>

	<?php
	
	$i = 0;
	while($row = mysqli_fetch_array($retval))
	{
		$i=$i+1;
		
		echo "<tr>";
			echo "<td>" . $i . "</td>";
			echo "<td>" . $row['cat'] . "</td>";
			echo "<td>" . $row['prod'] . "</td>";
			echo "<td>" . $row['client'] . "</td>";
			echo "<td>" . $row['edition'] . "</td>";
			echo "<td>" . $row['gtotal'] . "</td>";
			echo "<td>" . $row['stotal'] . "</td>";
			echo "<td>" . $row['dtotal'] . "</td>";
		echo "</tr>";
	}
	?>

	</table>


	</body>

</html>

<?php
	mysqli_close($conn);
?>

