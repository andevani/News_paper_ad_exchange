<?php
require_once('include-files/connection.php');
//------------------------------------------------ Date storage----------------------------------------------

	$newspaper = '';
	$date = '';
	$pageno = '';
	$edition = '';
	$section = '';
	$filename = '';
	$msg = '';
	$file = '';
	$cheight = '';
	$cwidth = '';

	$newspaper = trim($_POST['newspaper']);
	$pageno = trim($_POST['pageno']);
	$edition = trim($_POST['edition']);
	$section = trim($_POST['section']);
	$date = trim($_POST['datepicker']);
	echo $date;
	$date = date("y-m-d", strtotime(trim($_POST['datepicker'])));

	//$filename = trim($_POST['fileToUpload']);

	$filename = $_FILES["fileToUpload"]["name"];
	$filename_tmp = $_FILES["fileToUpload"]["tmp_name"];
	echo $filename;
	echo $filename_tmp;
	if (isset($_FILES["fileToUpload"]["name"])) {

    $name = $_FILES["fileToUpload"]["name"];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $error = $_FILES['fileToUpload']['error'];
		echo "Ankur.........";
	}

	if(isset($filename) && $filename == '')
	{
		$msg = "Please select PDF File to upload.<br />";
	}

	$target_dir = "uploads/";
	$target_file = $target_dir . $filename;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if ($uploadOk == 0)
	{
		echo "Sorry, your file was not uploaded.";
	}
	else
	{
		//echo $filename;
		//echo $target_file;
		//echo $_FILES["fileToUpload"]["name"];
		//if (move_uploaded_file($_FILES['filename'], $target_file))
		if (move_uploaded_file($filename_tmp, $target_file))
		{
			echo "The file ". basename($filename). " has been uploaded.";
		}
		else
		{
			echo "Sorry, there was an error uploading your file.";
		}
	}
  //$unique_id = "11223344";

	if(isset($msg) && $msg == '')
	{
		$unique_id = uniqid();

		$query = 'INSERT INTO news.news1 SET ';
		$query .= ' newspaper = \''.$newspaper.'\'';
		$query .= ' , date = \''.$date.'\'';
		$query .= ' , pageno = \''.$pageno.'\'';
		$query .= ' , edition = \''.$edition.'\'';
		$query .= ' , section = \''.$section.'\'';
		$query .= ' , unique_id = \''.$unique_id.'\'';
		$query .= ' , filename = \''.$filename.'\'';

		mysqli_query($conn,$query) or die(mysqli_error($conn));
	}
		echo $filename;
		$command = escapeshellcmd('/usr/bin/python3 pdftoppm.py --image '.$filename);
		$output = shell_exec($command);
		echo $output;
		//$command = escapeshellcmd('/usr/local/bin/pdftoppm -png 20180403_1.PDF > b.png');
		//$output = shell_exec($command);
		//sleep(5);
		//echo $output;
		echo "ankur..";
		//$command = escapeshellcmd('/usr/local/bin/python3 python_old/detect1.py --image b.png --unique ' . $unique_id);
	 	//$output = shell_exec($command);
	 	//echo $output;
   //
   
   //calculate height & width of canvas
   $query = 'Select * from news.news4 where newspaper = \''.$newspaper.'\' AND edition = \''.$edition.'\' AND section = \''.$section.'\'';
   echo $query;
   $result = mysqli_query($conn, $query);
   
   $cweight = $cheight = '';
   
	while($row = mysqli_fetch_assoc($result)){
		$cheight = 6.14*$row["pheight"];
		$cwidth = 6.74*$row["pwidth"];
	}
	
	echo 'ppppp'.$cheight;
	echo 'ppppp'.$cwidth;
	
	//$cheight = '2000';
	//$cwidth = '2000';
	
	//echo $cheight;
	//echo $cwidth;
	header("Location: ankur2.php?uniqid='".$unique_id."'&cheight='".$cheight."'&cwidth='".$cwidth."'");
	 //header("Location: slideshow.php?uniqid='".$unique_id."'");
	 //header("Location: upload.php?num=".$_POST['num']."");
?>
