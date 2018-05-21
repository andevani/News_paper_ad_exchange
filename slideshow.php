<html>
<head>
<title> News Paper Advertisement Images </title>
<link rel="stylesheet" type="text/css" href="slideshow_style.css">
<script>
document.cookie = "id = 1";
</script>

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


//$_id = "0";

$_id= $_COOKIE['id'];


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

<body background="bg.png">

	<div class="header" align="center" width='50' style="background-color: #ffffff;border:1px solid black;">
	
		<br>
		
		<input type="button" name="home" id="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="export" id="export" value="Export" onclick='export_data()'>
		&nbsp;&nbsp;&nbsp;&nbsp;
	
		<br>
		<br>
	</div>


  <script type="text/javascript">
  //document.cookie = "id = 1";
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
  //document.cookie = "id = 1";


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
	//return false;
	
    }

	document.cookie = "id = " + prev_val;

    $( '#slideshow_image' ).attr( 'src' , 'images/'+images[prev_val] );
    document.getElementById( "img_no" ).value = prev_val;
    document.getElementById("height").innerHTML = height[prev_val];
    document.getElementById("width").innerHTML = width[prev_val];
     var data = data;
    $.ajax({
      url: "api.php?uniqid=<?php echo $uniqid; ?>&filename='" + images[prev_val] + "'", 
      data: data,
        dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
      //  alert(data);
        if (data == null){
        document.getElementById( "input1" ).value = "";
        document.getElementById( "input2" ).value = "";
        document.getElementById( "input3" ).value = "";
        document.getElementById( "input4" ).value = "";
        }
        else{
         document.getElementById( "input1" ).value = data[1];
         document.getElementById( "input2" ).value = data[2];
        document.getElementById( "input3" ).value = data[3];
        document.getElementById( "input4" ).value = data[4];
        }
    }   
    });

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
     	if(confirm("Entry is Completed. Do you want to go to Home Page?"))
	{
	 	document.getElementById("home").click();
	}
	else
	{
		return;
	}

    }
    document.cookie = "id = " + next_val;
    $( '#slideshow_image' ).attr( 'src' , 'images/'+images[next_val]);
    document.getElementById( "img_no" ).value = next_val;
    document.getElementById("height").innerHTML = height[next_val];
    document.getElementById("width").innerHTML = width[next_val];
        var data = data;
    $.ajax({
      url: "api.php?uniqid=<?php echo $uniqid; ?>&filename='" + images[next_val] + "'", 
      data: data,
	dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
	//alert(data);
	if (data == null){
	document.getElementById( "input1" ).value = "";
	document.getElementById( "input2" ).value = "";
	document.getElementById( "input3" ).value = "";
	document.getElementById( "input4" ).value = "";
	}
	else{
	document.getElementById( "input1" ).value = data[1];
	document.getElementById( "input2" ).value = data[2];
    document.getElementById( "input3" ).value = data[3];
    document.getElementById( "input4" ).value = data[4];
	}
    }   
    });
 });

 
   $( '#slideshow_image' ).fadeIn(1000);
  // $.get("getdata.php");
  }


  function export_data()
  {
	var str = "exportdb.php?uniqueid='<?php echo $uniqid; ?>'";
	$.get(str, function(data){
		alert("Data Exported Successfully");
	});
  }

function keepdata()
  {
	var i = <?php echo $_id; ?>;
	var height = <?php echo json_encode($height); ?>;
    var width = <?php echo json_encode($width); ?>;
    var images = <?php echo json_encode($json); ?>;
  
	$( '#slideshow_image' ).attr( 'src' , 'images/'+images[i]);
    document.getElementById( "img_no" ).value = i;
    document.getElementById("height").innerHTML = height[i];
    document.getElementById("width").innerHTML = width[i];
  }
	
  </script>

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

  //print_r($result);
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
  //echo $query;
  mysqli_close($conn);

  $i1 = $i2 = $i3 = $i4 = '';

}
//mysqli_close($conn);
?>

	<input type="text" style="display:none" id="hiddenVal" value='1' />
	<br>

	<?php
		$_id= $_COOKIE['id'];
//echo $_id;
	?>

	<table align="center" cellspacing='5' cellpadding='5'  border='0' width="1000" frame="box" style="background-color: #ffffff;">
 
		<tr height="10">
			<th width="150" rowspan="8">
        
				<center>
				 <div id="slide_cont">
				  <img src="e.png" id="slideshow_image" height='200' width='200'>
				 </div>
				 <div a

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
			</th>
		</tr>

<form name="form" action="" method="POST">

	<tr height="100">
    	
	</tr>

	<tr height="10">
    	<th align="right" width="150">
        	Advertise/News:
        </th>
        <td width="150">
			<select name="input1" id="input1" style="width:240px;">
			  <option value="advertisement">Advertisement</option>
			  <option value="news">News</option>
			</select>
			
        </td>
	</tr>

	<tr height="10">
    	<th align="right" width="150">
        	Advertiser :
        </th>
        <td width="150">
        	<input type="text" name="input2" id="input2" size="30" value="<?php echo $i2 ?>" />
        </td>
	</tr>

	<tr height="10">
    	<th align="right" width="150">
        	Input 3 :
        </th>
        <td width="150">
        	<input type="text" name="input3" id="input3" size="30" value="<?php echo $i3 ?>" />
        </td>
	</tr>

	<tr height="10">
    	<th align="right" width="150">
        	Input 4 :
        </th>
        <td width="150">
        	<input type="text" name="input4" id="input4" size="30" value="<?php echo $i4	 ?>" />
        </td>
	</tr>

	<tr height='10'>
		<th align="center" colspan='4'>
			<input type="submit">
		</th>
	</tr>

	<tr height="100">
    	
	</tr>
	
	</table>

	</form>

</body>
</html>
