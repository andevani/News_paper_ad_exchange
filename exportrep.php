<?php

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
	   die('Could not connect: ' . mysql_error());
	}

	$query = trim($_GET['query']);
	
	$thw = $thc = $column = $hw = $hc = $i = $h = $w = $aw = $fact = $nh = $nw = 0;
	//echo $query;

	mysqli_select_db($conn, 'news');

	$retval = mysqli_query($conn, $query);

	if(! $retval ) {
	   die('Could not get data: ' . mysqli_error($conn));
	}

	$fp = fopen('/home/tops/Desktop/Export_report_folder/REPORT_EXPORT_DATA.csv', 'w');

	//header of file
	//print_r($retval);
	$header = array("Sr No","Newspaper","Date","Page No","Edition","Section","Filename","Height(cm)","width(cm)","H*W(cm)","Height(cm)","Column(nS)","H*C(CC)","Advertise/News","Advertiser","ProductCategory", "Input3","Input4");
	fputcsv($fp, $header);
	
	while($row = mysqli_fetch_assoc($retval)){
		$newspaper = $row['newspaper'];
		echo $newspaper;
		$i=$i+1;
		$h = $row['height'];
		$w = $aw = $row['width'];
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
		//$nw = ($w<=$fact) ? $fact :((ceil($w)%$fact === 0) ? ceil($w) : round(($w+$fact/2)/$fact)*$fact);

		
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
		
		$row_n = array($i,$row['newspaper'],$row['date'],$row['pageno'],$row['edition'],$row['section'],$row['filename'],$nh,$nw, $hw,$nh, $column, $hc,$row['input1'],$row['input2'],$row['prdcat'],$row['input3'],$row['input4']);
		
		fputcsv($fp, $row_n);
	}

	//footer of file
	$footer = array("","","","","","","","","",$thw,"","",$thc,"","","","");
	fputcsv($fp, $footer);
	
	fclose($fp);

	mysqli_close($conn);
	
	header("Location: rep_flt.php");
?>
