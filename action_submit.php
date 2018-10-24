<?php
require_once('include-files/connection.php');
//------------------------------------------------ Date storage----------------------------------------------

	$newspaper = '';
	$date = '';
	$pageno = '';
	$edition = '';
	$section = '';
	$filename = '';
	$afilename = '';
	$msg = '';
	$file = '';
	$cheight = '';
	$cwidth = '';

	$newspaper = trim($_POST['newspaper']);
	$pageno = trim($_POST['pageno']);
//echo "<br>";
//echo $pageno;
//echo "<br>";
	$edition = trim($_POST['edition']);
	$section = trim($_POST['section']);
	$date = trim($_POST['datepicker']);
	echo $date;
	$date = date("y-m-d", strtotime(trim($_POST['datepicker'])));
	$unique_id = uniqid();

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

//=========================================================================	
	//upload data of file into database
	
	$afilename = $_FILES["advfile"]["name"];

	if ($afilename)
	{

	require_once('excel_reader2.php');
	require_once('SpreadsheetReader.php');
       
  //$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  //if(in_array($_FILES["advfile"]["type"],$allowedFileType)){

        mysqli_query($conn,'TRUNCATE TABLE news.advdata');
		$targetPath = 'uploads/'.$_FILES['advfile']['name'];
		echo "<br>";
		echo "<br>";
		echo $targetPath."pooooojjjjjaaaa";
		echo "<br>";
		echo "<br>";
        move_uploaded_file($_FILES['advfile']['tmp_name'], $targetPath);

	//PYTHON CALLING
	//location.href = "slideshow_python.php?uniqid=<?php echo $uniqid;
	//python csv_modify.py $targetPath;
	echo $targetPath;
	$command = escapeshellcmd('/usr/bin/python3 csv_modify.py ' . $targetPath);
	$output = shell_exec($command);
        

        $Reader = new SpreadsheetReader("out_modified.csv");
        
        $sheetCount = count($Reader->sheets());
		echo $sheetCount;
		echo "<br>";
		echo "<br>";
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
                $agent = "";
                if(isset($Row[1])) {
                    $agent = mysqli_real_escape_string($conn,$Row[1]);
                }
                
				$client = "";
                if(isset($Row[2])) {
                    $client = mysqli_real_escape_string($conn,$Row[2]);
                }
				
				$cobw = "";
                if(isset($Row[3])) {
                    $cobw = mysqli_real_escape_string($conn,$Row[3]);
                }
				
				$size = "";
                if(isset($Row[4])) {
                    $size = mysqli_real_escape_string($conn,$Row[4]);
                }
				
				$cat = "";
                if(isset($Row[5])) {
                    $cat = mysqli_real_escape_string($conn,$Row[5]);
                }
				
				$pdate = "";
                if(isset($Row[6])) {
                    $pdate = mysqli_real_escape_string($conn,$Row[6]);
                }
				
				$ppg = "";
                if(isset($Row[7])) {
                    $ppg = mysqli_real_escape_string($conn,$Row[7]);
                }
				
				$bpg = "";
                if(isset($Row[8])) {
                    $bpg = mysqli_real_escape_string($conn,$Row[8]);
                }
				
				$pgno = "";
                if(isset($Row[9])) {
                    $pgno = mysqli_real_escape_string($conn,$Row[9]);
                }
				
				$matter = "";
                if(isset($Row[10])) {
                    $matter = mysqli_real_escape_string($conn,$Row[10]);
                }
				
                if (!empty($pgno) || !empty($agent) || !empty($client)) {
                    $query = "insert into news.advdata(uniqueid,agent,client,cobw,size,cat,pdate,ppg,bpg,pgno,matter) values('".$unique_id."','".$agent."','".$client."','".$cobw."','".$size."','".$cat."','".$pdate."','".$ppg."','".$bpg."','".$pgno."','".$matter."')";
					//echo $query;
					//echo "<br>";
					//echo "<br>";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
        
         }
	}
  //}
  //else
  //{ 
   //     $type = "error";
    //    $message = "Invalid File Type. Upload Excel File.";
  //}
	
//========================================================================	
	

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
   if (trim($_POST['h_w']) == "default")
   {
	   $query = 'Select * from news.news4 where newspaper = \''.$newspaper.'\' AND edition = \''.$edition.'\' AND section = \''.$section.'\'';
	   //echo $query;
	   $result = mysqli_query($conn, $query);
	   
	   $cweight = $cheight = '';
	   
		while($row = mysqli_fetch_assoc($result)){
			$cheight = 6.14*$row["pheight"];
			$cwidth = 6.74*$row["pwidth"];
		}
   }
   else
   {
	   $cheight = trim($_POST['cheight']);
	   $cwidth = trim($_POST['cwidth']);
   }
	//echo 'ppppp'.$cheight;
	//echo 'ppppp'.$cwidth;
	
	//$cheight = '2000';
	//$cwidth = '2000';
	
	//echo $cheight;
	//echo $cwidth;
	//echo $pgno;
	header("Location: ankur2.php?uniqid='".$unique_id."'&cheight='".$cheight."'&cwidth='".$cwidth."'&newspaper='".$newspaper."'");
	 //header("Location: slideshow.php?uniqid='".$unique_id."'");
	 //header("Location: upload.php?num=".$_POST['num']."");
?>
