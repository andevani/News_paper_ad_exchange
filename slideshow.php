<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> News Paper Advertisement Images </title>
<link rel="stylesheet" type="text/css" href="slideshow_style.css">
<script>
document.cookie = "id = 1";
</script>

<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />

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
$newspaper = $_GET['newspaper'];
//$newspaper = '"'.$newspaper.'"';
//echo $newspaper;
//echo $_GET['uniqid'];
//$_GET['uniqid'];
$sql = "SELECT * from news.news3 WHERE unique_id='".$uniqid."'";
//$sql = 'SELECT * from news.news3 WHERE unique_id="5ab93a4874152"';
//echo $sql;

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
//mysqli_close($conn);

$i1 = $i2 = $i3 = $i4 = $cat2 = $agent2 = $client2 = $brand2 = $prdcat2 = $prod2 = '';

//query to get brand name from database
$bquery = "select * from news.brand";
$bresult = mysqli_query($conn, $bquery) or die(mysqli_error($conn));

$boption = '["Other",';
while($row = mysqli_fetch_array($bresult))
{
	$boption .= '"' .$row['bname'].'",';
}
$boption .= ']';
//echo $boption;

//query to get category name from database
$cquery = "select * from news.cat";
$cresult = mysqli_query($conn, $cquery) or die(mysqli_error($conn));

$coption = '';
while($row = mysqli_fetch_array($cresult))
{
	$coption .= '<option>'.$row['cname'].'</option>';
}

//query to get product name from database
$pquery = "select * from news.prd";
$presult = mysqli_query($conn, $pquery) or die(mysqli_error($conn));

$poption = '["Other",';
while($row = mysqli_fetch_array($presult))
{
	$poption .= '"' .$row['pname'].'",';
}
$poption .= ']';

//query to get product category from database
$pcquery = "select * from news.prdcat";
$pcresult = mysqli_query($conn, $pcquery) or die(mysqli_error($conn));

$pcoption = '["Other",';
while($row = mysqli_fetch_array($pcresult))
{
	$pcoption .= '"' .$row['pcname']. '",';
}
$pcoption .= ']';
//echo $pcoption;

//query to get agent & client from database
//echo $newspaper;
if ($newspaper == "Gujarat Samachar")
{
	//echo "pooja : GS NWSPPR";
	$aquery = "select * from news.advdata";
	//echo $aquery;
	$aresult = mysqli_query($conn, $aquery) or die(mysqli_error($conn));

	$aoption = "'<option> Other </option>";
	$cloption = "'<option> Other </option>";
	while($row = mysqli_fetch_array($aresult))
	{
		$aoption .= "<option> ".$row['agent']." </option>" ;
		$cloption .= "<option> ".$row['client']." </option>" ;
	}
	$aoption .= "'";
	$cloption.= "'";
}
else
{
	//agent
	//echo "else..";
	$aquery = "select * from news.agent";
	$aresult = mysqli_query($conn, $aquery) or die(mysqli_error($conn));
	$aoption = "['Other',";
	while($row = mysqli_fetch_array($aresult))
	{
		$aoption .= '"' .$row['aname']. '",';
	}
	$aoption .= ']';

	//Client
	$clquery = "select * from news.client";
	$clresult = mysqli_query($conn, $clquery) or die(mysqli_error($conn));

	$cloption = '[';
	while($row = mysqli_fetch_array($clresult))
	{
		$cloption .= '"' .$row['clname']. '",';
	}
	$cloption .= ']';
}

/* //query to get client from database
$clquery = "select * from news.client";
$clresult = mysqli_query($conn, $clquery) or die(mysqli_error($conn));


$cloption = '[';
while($row = mysqli_fetch_array($clresult))
{
	$cloption .= '"' .$row['clname']. '",';
}
$cloption .= ']'; */
?>

<script type="text/javascript">
$(document).ready(function() {
  
  var boption = <?php echo $boption; ?>;
  $("#brand").autocomplete({
    source: boption,
	minLength:3
  });
  
  var poption = <?php echo $poption; ?>;
  $("#prod").autocomplete({
    source: poption,
	minLength:3
  });
  
  var pcoption = <?php echo $pcoption; ?>;
  $("#prdcat").autocomplete({
    source: pcoption,
	minLength:3
  });

var newsp = <?php echo '"'.$newspaper.'"'; ?>;
//	alert(newsp);
  if (newsp == "Gujarat Samachar")
  {
  }
  else
  {
	var aoption = <?php echo $aoption; ?>;
	$("#agent").autocomplete({
		source: aoption,
		minLength:3
	});

	var cloption = <?php echo $cloption; ?>;
	$("#client").autocomplete({
		source: cloption,
		minLength:3
	});
  }

 });
</script>

</head>

<body background="bg.png">

	<div class="header" align="center" width='50' style="background-color: #ffffff;border:1px solid black;">
	
		<br>
		
		<input type="button" name="home" id="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="export" id="export" value="Export" onclick='export_data()'>

	
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
      url: "api.php?uniqid='<?php echo $uniqid; ?>'&filename='" + images[prev_val] + "'", 
      data: data,
        dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
        if (data == null){
			document.getElementById( "input2" ).value = "";
			//document.getElementById( "input3" ).value = "";
			//document.getElementById( "input4" ).value = "";
			document.getElementById( "cat" ).value = "";
			document.getElementById( "brand" ).value = "";
			document.getElementById( "prod" ).value = "";
			document.getElementById( "prdcat" ).value = "";
			document.getElementById( "agent" ).value = "";
			document.getElementById( "client" ).value = "";
			document.getElementById( "cat2" ).value = "";
			document.getElementById( "agent2" ).value = "";
			document.getElementById( "client2" ).value = "";
			document.getElementById( "brand2" ).value = "";
			document.getElementById( "prdcat2" ).value = "";
			document.getElementById( "prod2" ).value = "";
        }
        else{
			//var input1 = document.form.input1;
			//input1[data[1]].checked = true;
			$("input[name=input1][value="+data[1]+"]").attr('checked', true);
			document.getElementById( "input2" ).value = data[2];
			//document.getElementById( "input3" ).value = data[3];
			//document.getElementById( "input4" ).value = data[4];
			document.getElementById( "cat" ).value = data[3];
			document.getElementById( "brand" ).value = data[4];
			document.getElementById( "prod" ).value = data[5];
			document.getElementById( "prdcat" ).value = data[6];
			document.getElementById( "agent" ).value = data[7];
			document.getElementById( "client" ).value = data[8];
			document.getElementById( "cat2" ).value = data[9];
			document.getElementById( "brand2" ).value = data[10];
			document.getElementById( "prod2" ).value = data[11];
			document.getElementById( "prdcat2" ).value = data[12];
			document.getElementById( "agent2" ).value = data[13];
			document.getElementById( "client2" ).value = data[14];
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
		document.cookie = "id = " + next_val;
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
      url: "api.php?uniqid='<?php echo $uniqid; ?>'&filename='" + images[next_val] + "'", 
      data: data,
	dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {

	if (data == null){
		document.getElementById( "input2" ).value = "";
		//document.getElementById( "input3" ).value = "";
		//document.getElementById( "input4" ).value = "";
		document.getElementById( "cat" ).value = "";
		document.getElementById( "brand" ).value = "";
		document.getElementById( "prod" ).value = "";
		document.getElementById( "prdcat" ).value = "";
		document.getElementById( "agent" ).value = "";
		document.getElementById( "client" ).value = "";
		document.getElementById( "cat2" ).value = "";
		document.getElementById( "agent2" ).value = "";
		document.getElementById( "client2" ).value = "";
		document.getElementById( "brand2" ).value = "";
		document.getElementById( "prdcat2" ).value = "";
		document.getElementById( "prod2" ).value = "";
	}
	else{
		//var input1 = document.form.input1;
		//input1[data[1]].checked = true;
//alert(data);
		$("input[name=input1][value="+data[1]+"]").attr('checked', true);
		document.getElementById( "input2" ).value = data[2];
		//document.getElementById( "input3" ).value = data[3];
		//document.getElementById( "input4" ).value = data[4];
		document.getElementById( "cat" ).value = data[3];
		document.getElementById( "brand" ).value = data[4];
		document.getElementById( "prod" ).value = data[5];
		document.getElementById( "prdcat" ).value = data[6];
		document.getElementById( "agent" ).value = data[7];
		document.getElementById( "client" ).value = data[8];
		document.getElementById( "cat2" ).value = data[9];
		document.getElementById( "brand2" ).value = data[10];
		document.getElementById( "prod2" ).value = data[11];
		document.getElementById( "prdcat2" ).value = data[12];
		document.getElementById( "agent2" ).value = data[13];
		document.getElementById( "client2" ).value = data[14];
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

function loadnextdata()
  {
	var i = <?php echo $_id + 1; ?>;
	//alert(i);
	var height = <?php echo json_encode($height); ?>;
    var width = <?php echo json_encode($width); ?>;
    var images = <?php echo json_encode($json); ?>;
	//alert(images);
  
	if(i >= images.length)
    {
		if(confirm("Entry is Completed. Do you want to go to Home Page?"))
		{
			document.getElementById("home").click();
		}
	}
	else
	{
		$( '#slideshow_image' ).attr( 'src' , 'images/'+images[i]);
		
	}
    document.getElementById( "img_no" ).value = i;
	document.cookie = "id = " + i;
	
	var data = data;
    $.ajax({
      url: "api.php?uniqid='<?php echo $uniqid; ?>'&filename='" + images[i] + "'", 
      data: data,
	dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
	//alert(data);
	if (data == null){
		document.getElementById( "input2" ).value = "";
		//document.getElementById( "input3" ).value = "";
		//document.getElementById( "input4" ).value = "";
		document.getElementById( "cat" ).value = "";
		document.getElementById( "brand" ).value = "";
		document.getElementById( "prod" ).value = "";
		document.getElementById( "prdcat" ).value = "";
		document.getElementById( "agent" ).value = "";
		document.getElementById( "client" ).value = "";
		document.getElementById( "cat2" ).value = "";
		document.getElementById( "agent2" ).value = "";
		document.getElementById( "client2" ).value = "";
		document.getElementById( "brand2" ).value = "";
		document.getElementById( "prdcat2" ).value = "";
		document.getElementById( "prod2" ).value = "";
	}
	else{
		//var input1 = document.form.input1;
		//input1[data[1]].checked = true;
		$("input[name=input1][value="+data[1]+"]").attr('checked', true);
		document.getElementById( "input2" ).value = data[2];
		//document.getElementById( "input3" ).value = data[3];
		//document.getElementById( "input4" ).value = data[4];
		document.getElementById( "cat" ).value = data[3];
		document.getElementById( "brand" ).value = data[4];
		document.getElementById( "prod" ).value = data[5];
		document.getElementById( "prdcat" ).value = data[6];
		document.getElementById( "agent" ).value = data[7];
		document.getElementById( "client" ).value = data[8];
		document.getElementById( "cat2" ).value = data[9];
		document.getElementById( "brand2" ).value = data[10];
		document.getElementById( "prod2" ).value = data[11];
		document.getElementById( "prdcat2" ).value = data[12];
		document.getElementById( "agent2" ).value = data[13];
		document.getElementById( "client2" ).value = data[14];
	}
    }   
    });
    //document.getElementById("height").innerHTML = height[i];
    //document.getElementById("width").innerHTML = width[i];
  }
  
  function update_agent()
  {
	var client = document.getElementById( "client" ).value;
	//var data = data;
	var data = new Array();
//alert(agent);
	$.ajax({
		type : "POST",		
		url: "agent_client.php?client='" + client + "'", 
		data: data,
		dataType: 'json',                //data format      
		success: function(data)          //on recieve of reply
		{
			//alert('aNKUR');
			//alert(data);
			if (data == null)
			{
			}
			else
			{
				document.getElementById( "agent" ).value = data[2];
			}
 		}   
	    });
	//alert(data);
  }
	
  </script>

	<input type="text" style="display:none" id="hiddenVal" value='1' />
	<br>

	<?php
		$_id= $_COOKIE['id'];
	?>

	<table align="center" cellspacing='3' cellpadding='3'  border='0' width="1100" frame="box" style="background-color: #ffffff;">
 
		<tr height="10">
			<th width="150" rowspan="16">
        
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

<?php
require_once('include-files/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $msg = '';
  $i1 = isset($_POST['input1']) ? trim($_POST['input1']) : 'Pooja';
  $i2 = isset($_POST['input2']) ? trim($_POST['input2']) : '';
  //$i3 = isset($_POST['input3']) ? trim($_POST['input3']) : '';
  //$i4 = isset($_POST['input4']) ? trim($_POST['input4']) : '';
  $cat = isset($_POST['cat']) ? trim($_POST['cat']) : '';
  $brand = isset($_POST['brand']) ? trim($_POST['brand']) : '';
  $prod = isset($_POST['prod']) ? trim($_POST['prod']) : '';
  $prdcat = isset($_POST['prdcat']) ? trim($_POST['prdcat']) : '';
  $agent = isset($_POST['agent']) ? trim($_POST['agent']) : '';
  $client = isset($_POST['client']) ? trim($_POST['client']) : '';
  $cat2 = isset($_POST['cat2']) ? trim($_POST['cat2']) : '';
  $brand2 = isset($_POST['brand2']) ? trim($_POST['brand2']) : '';
  $prod2 = isset($_POST['prod2']) ? trim($_POST['prod2']) : '';
  $prdcat2 = isset($_POST['prdcat2']) ? trim($_POST['prdcat2']) : '';
  $agent2 = isset($_POST['agent2']) ? trim($_POST['agent2']) : '';
  $client2 = isset($_POST['client2']) ? trim($_POST['client2']) : '';
//echo $cat;
//echo $agent;
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
	$query .= ' , cat = \''.$cat.'\'';
	$query .= ' , brand = \''.$brand.'\'';
	$query .= ' , prod = \''.$prod.'\'';
	$query .= ' , prdcat = \''.$prdcat.'\'';
	$query .= ' , agent = \''.$agent.'\'';
	$query .= ' , client = \''.$client.'\'';
	$query .= ' , cat2 = \''.$cat2.'\'';
	$query .= ' , brand2 = \''.$brand2.'\'';
	$query .= ' , prod2 = \''.$prod2.'\'';
	$query .= ' , prdcat2 = \''.$prdcat2.'\'';
	$query .= ' , agent2 = \''.$agent2.'\'';
	$query .= ' , client2 = \''.$client2.'\'';
    $query .= ' , input3 = \''.$i3.'\'';
    $query .= ' , input4 = \''.$i4.'\'';
    $query .= ' , filename = \''.$json[$_id].'\'';
    $query .= ' , unique_id = "'.  $uniqid .'"';
//echo $query;
    mysqli_query($conn, $query) or die(mysqli_error($conn));
  }
  else {
	$query = 'UPDATE news.news2 SET ';
	$query .= ' input1 = \''.$i1.'\'';
	$query .= ' , input2 = \''.$i2.'\'';
	$query .= ' , cat = \''.$cat.'\'';
	$query .= ' , brand = \''.$brand.'\'';
	$query .= ' , prod = \''.$prod.'\'';
	$query .= ' , prdcat = \''.$prdcat.'\'';
	$query .= ' , agent = \''.$agent.'\'';
	$query .= ' , client = \''.$client.'\'';
	$query .= ' , cat2 = \''.$cat2.'\'';
	$query .= ' , brand2 = \''.$brand2.'\'';
	$query .= ' , prod2 = \''.$prod2.'\'';
	$query .= ' , prdcat2 = \''.$prdcat2.'\'';
	$query .= ' , agent2 = \''.$agent2.'\'';
	$query .= ' , client2 = \''.$client2.'\'';
	$query .= ' , input3 = \''.$i3.'\'';
	$query .= ' , input4 = \''.$i4.'\'';
	$query .= ' where filename = \''.$json[$_id].'\'';
  //echo $query;
      mysqli_query($conn, $query) or die(mysqli_error($conn));
  }
  //echo $query;
  //mysqli_close($conn);

  //$i1 = $i2 = $i3 = $i4 = '';
  echo '<script type="text/javascript">',

     'loadnextdata();',

     '</script>';
}

//mysqli_close($conn);
?>
		
<form name="form" action="" method="POST" autocomplete="off">

	<tr height="100">
    	
	</tr>
<!---------------------------------------------------------------------------------------->
	<tr height="10">
    	<td width="150">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="input1" id="input1" value="News"> News
        </td>
		
        <td width="150">
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="input1" id="input1" value="Advertisement"> Advertisement
        </td>
	</tr>
<!---------------------------------------------------------------------------------------->
	<tr height="10">
    	<th align="right" width="150">
        	Advertiser :
        </th>
        <td width="150">
        	<input type="text" name="input2" id="input2" size="30" value="<?php echo $i2; ?>" />
        </td>
	</tr>

<!---------------------------------------------------------------------------------------->
	
	<tr height=10>
		<th align="right" width="150">
        	Category :
        </th>
        <td width="150">
        	<select list="cat" name="cat" id="cat" style="width:244px;" />
				<?php echo $coption; ?>
				<option> Other </option>
		</select>
        </td>
	</tr>
	<tr height="10">
    	<th align="right" width="150">
        </th>
        <td width="150">
        	<input type="text" name="cat2" id="cat2" size="20" value="<?php echo $cat2; ?>" />
        </td> 
	</tr>
<!---------------------------------------------------------------------------------------->

	<tr height=10>
	<th align="right" width="150">
        	Client :
        </th>
        <td width="150">
		<?php
        	if ($newspaper == "Gujarat Samachar")
		{
		?>
        	<select list="client" name="client" id="client" style="width:244px;" onchange="update_agent()"/>
				<?php echo $cloption; ?>
		</select>
		<?php
		}
		else
		{
		?>
		<div class="autocomplete">
        	<input type="text" name="client" id="client" size="30" class="form-control" placeholder="Client" />
		</div>
		<?PHP
		}
		?>
        </td>
	</tr>
	<tr height="10">
    	<th align="right" width="150">
        </th>
        <td width="150">
        	<input type="text" name="client2" id="client2" size="20" value="<?php echo $client2; ?>" />
        </td>
	</tr>
<!---------------------------------------------------------------------------------------->

	<tr height=10>
	<th align="right" width="150">
        	Agent :
        </th>
        <td width="150">
		<?php
		//echo $aoption;
        	if ($newspaper == "Gujarat Samachar")
		{
		?>
		<select list="agent" name="agent" id="agent" style="width:244px;"/>
				<?php echo $aoption; ?>
		</select>
		<?php
		}
		else
		{
		?>
		<div class="autocomplete">
        	<input type="text" name="agent" id="agent" size="30" class="form-control" placeholder="Agent" />
		</div>
		<?PHP
		}
		?>
        </td>
	</tr>
	<tr height="10">
    	<th align="right" width="150">
        </th>
        <td width="150">
        	<input type="text" name="agent2" id="agent2" size="20" value="<?php echo $agent2; ?>" />
        </td>
	</tr>

<!---------------------------------------------------------------------------------------->

	<tr height=10>
	<th align="right" width="150">
        	Brand Name :
        </th>
        <td width="150">
			<div class="autocomplete">
        	<input type="text" name="brand" id="brand" size="30" class="form-control" placeholder="Brand" />
			</div>
        </td>
	</tr>
	<tr height="10">
    	<th align="right" width="150">
        </th>
        <td width="150">
        	<input type="text" name="brand2" id="brand2" size="20" value="<?php echo $brand2; ?>" />
        </td>
	</tr>
<!---------------------------------------------------------------------------------------->

	<tr height=10>
	<th align="right" width="150">
        	Product Name :
        </th>
        <td width="150">
        	<input type="text" name="prod" id="prod" size="30" class="form-control" placeholder="Product Name" />
        </td>
	</tr>
	<tr height="10">
    	<th align="right" width="150">
        </th>
        <td width="150">
        	<input type="text" name="prod2" id="prod2" size="20" value="<?php echo $prod2; ?>" />
        </td>
	</tr>
<!---------------------------------------------------------------------------------------->

	<tr height=10>
	<th align="right" width="150">
        	Product Category :
        </th>
        <td width="150">
        	<input type="text" name="prdcat" id="prdcat" size="30" class="form-control" placeholder="Product Category" />
        </td>
	</tr>
	<tr height="10">
    	<th align="right" width="150">
        </th>
        <td width="150">
        	<input type="text" name="prdcat2" id="prdcat2" size="20" value="<?php echo $prdcat2; ?>" />
        </td>
	</tr>
<!---------------------------------------------------------------------------------------->

	<tr height='10'>
		<th align="center" colspan='4'>
			<input type="submit">
		</th>
	</tr>
<!---------------------------------------------------------------------------------------->
	<tr height="10">
    	
	</tr>
<!---------------------------------------------------------------------------------------->
	</table>

	</form>

</body>
</html>
