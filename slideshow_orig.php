<html>
<head>
<title> News Paper Advertisement Images </title>
<link rel="stylesheet" type="text/css" href="slideshow_style.css">
<script type="text/javascript" src="jquery-3.3.1.min.js"></script>

<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if(! $conn ) {
   die('Could not connect: ' . mysql_error());
}

$height = [];
$width = [];
$json = [];

$uniqid = $_GET['uniqid'];
//echo $_GET['uniqid'];
//$_GET['uniqid'];
$sql = 'SELECT * from news.news3 WHERE unique_id='.$uniqid;
//$sql = 'SELECT * from news.news3 WHERE unique_id="5ab93a4874152"';

mysqli_select_db($conn, 'news');

$retval = mysqli_query($conn, $sql);

if(! $retval ) {
   die('Could not get data: ' . mysqli_error($conn));
}

while($row = mysqli_fetch_assoc($retval)){
   $json[] = $row["filename"];
	 $height[] = $row["height"];
	 $width[] = $row["width"];
}


//print_r($height);
//print_r($width);
mysqli_close($conn);


?>

</head>

<body>


  <script type="text/javascript">
  document.cookie = "id = 1";
  $(document).ready(function(){
   $( "#prev_image" ).click(function(){
    prev();
   });
   $( "#next_image" ).click(function(){
    next();
   });
  });

  // we should remove php tag here??

  // Write all the names of images in slideshow

  var height = <?php echo json_encode($height); ?>;
  var width = <?php echo json_encode($width); ?>;
  var images = <?php echo json_encode($json); ?>;
  document.cookie = "id = 1";


  function prev()
  {
   $( '#slideshow_image' ).fadeOut(300,function()
   {
    var prev_val = document.getElementById( "img_no" ).value;
    var prev_val = Number(prev_val - 1);
    if(prev_val < 0)
    {
     prev_val = 0;
	 //prev_val = images.length - 1;
    }

	document.cookie = "id = " + prev_val;

    $( '#slideshow_image' ).attr( 'src' , 'images/'+images[prev_val] );
    document.getElementById( "img_no" ).value = prev_val;
    document.getElementById("height").innerHTML = height[prev_val];
    document.getElementById("width").innerHTML = width[prev_val];
   });
   //alert("value of height is ..."+height[prev_val]);

   $( '#slideshow_image' ).fadeIn(1000);

  }


  function next()
  {
   $( '#slideshow_image' ).fadeOut(300,function()
   {
    var next_val = document.getElementById( "img_no" ).value;
    var next_val = Number(next_val)+1;
    if(next_val >= images.length)
    {
     next_val = images.length-1;
	 //next_val = 0;
	//return false;
    }

	document.cookie = "id = " + next_val;

    $( '#slideshow_image' ).attr( 'src' , 'images/'+images[next_val]);
    document.getElementById( "img_no" ).value = next_val;
    document.getElementById("height").innerHTML = height[next_val];
    document.getElementById("width").innerHTML = width[next_val];
    //alert("value of height is ..."+height[next_val]);
   });

   $( '#slideshow_image' ).fadeIn(1000);

  }


  function export_data()
  {
	var str = "exportdb.php?uniqueid='<?php echo $uniqid; ?>'";
	$.get(str, function(data){
		alert("Data Exported Successfully");
	});
  }

  </script>

<center>
 <div id="slide_cont">
  <img src="e.png" id="slideshow_image">
 </div>
 <div align="center">

	<?php
    $_id = "1";
	$_id= $_COOKIE['id'];
	?>

	<h4>
	Height :
	&nbsp;&nbsp;

  <label name='height' id='height'>
	</label>


	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Width :
	&nbsp;&nbsp;
  <label name='width' id='width'>
	</label>
	</h4>
 </div>

 <input type="image" id="prev_image" src="prev.png" >
 <input type="image" id="next_image" src="next.png" >
 <input type="hidden" id="img_no" value="-1">




</center>

<?php
require_once('include-files/connection.php');

$i1 = $i2 = $i3 = $i4 = '';



if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $msg = '';
  $i1 = trim($_POST['input1']);
  $i2 = trim($_POST['input2']);
  $i3 = trim($_POST['input3']);
  $i4 = trim($_POST['input4']);

  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = '';

  $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
  $query1 = "SELECT * FROM news.news2 where filename='".$json[$_id]."'";
  //echo "$query1";
  $result = mysqli_query($conn,$query1);

  //echo $result;
  //echo "ankir..";
  if(mysqli_num_rows($result) < 1)
  {
    $query = 'INSERT INTO news.news2 SET ';
    $query .= ' input1 = \''.$i1.'\'';
    $query .= ' , input2 = \''.$i2.'\'';
    $query .= ' , input3 = \''.$i3.'\'';
    $query .= ' , input4 = \''.$i4.'\'';
    $query .= ' , filename = \''.$json[$_id].'\'';
    $query .= ' , unique_id = '.  $uniqid;
//echo $query;
    mysqli_query($conn, $query) or die(mysqli_error($conn));
  }
  else {
      $query = 'UPDATE news.news2 SET ';
      $query .= ' input1 = \''.$i1.'\'';
      $query .= ' , input2 = \''.$i2.'\'';
      $query .= ' , input3 = \''.$i3.'\'';
      $query .= ' , input4 = \''.$i4.'\'';
      $query .= ' where filename = \''.$json[$_id].'\'';
  //echo $query;
      mysqli_query($conn, $query) or die(mysqli_error($conn));
  }
}
mysqli_close($conn);
?>

<form name="form" action="" method="POST">

	<input type="text" style="display:none" id="hiddenVal" value='1' />

	<table align="center" cellpadding="5" cellspacing="5" border='0' width = '500'>

	<tr>
    	<td align="right" width="100">
        	Advertisement/News :
        </td>
        <td width="100">
        	<input type="text" name="input1" id="input1" size="30" value="<?php echo $i1 ?>" />
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Advertiser :
        </td>
        <td width="100">
        	<input type="text" name="input2" id="input2" size="30" value="<?php echo $i2 ?>" />
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Input 3 :
        </td>
        <td width="100">
        	<input type="text" name="input3" id="input3" size="30" value="<?php echo $i3 ?>" />
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Input 4 :
        </td>
        <td width="100">
        	<input type="text" name="input4" id="input4" size="30" value="<?php echo $i4	 ?>" />
        </td>
	</tr>

	<tr>
		<td align="center" colspan='4'>
			<input type="submit">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="export" value="Export" onclick='export_data()'>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
		</td>
	</tr>

	</table>

	</form>

</body>
</html>
