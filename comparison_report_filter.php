<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once('connection.php');
require_once('datepicker.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Comparison Report Filters</title>

</head>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#from_datepicker" ).datepicker();
    $( "#to_datepicker" ).datepicker();
  } );
  </script>


<body background="bg.png">
<?php
	$query = "SELECT cname FROM `cat` order by `cname`";
    $result_cat = mysqli_query($conn, $query);
?>
<?php
	$query = "SELECT pcname FROM `prdcat` order by `pcname`";
    $result_prdcat = mysqli_query($conn, $query);
?>
<?php
	$query = "SELECT clname FROM `client` order by `clname`";
    $result_client = mysqli_query($conn, $query);
?>
<div>

<!------------------------------------------------ Header---------------------------------------------->

	<div class="header" align="center" style="background-color: #ffffff;border:1px solid black;">
		<br>
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		<br>
		<br>
	</div>

<!------------------------------------------------ Main Body---------------------------------------------->

	<div class="Body">

	<br>
	<form name="form" action="comparison_detail_report.php" method="POST" enctype="multipart/form-data">

	<table width="700" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">

	<tr>
    	<td align="center" width="500" colspan='2'>
			<h1 align="center">
				Select Filters
			</h1>
		</td>
	</tr>
	
    <tr>
    	<td align="right" valign="top" width="500">
        	Select Newspapers :
        </td>
        <td width="500">
        	<select multiple="true" name="newspapers[]" style="width:220px;"/>
			  <option> Gujarat Samachar	</option>
			  <option> Sandesh		</option>
			  <option> Divya Bhaskar	</option>
			</select>
        </td>
	</tr>

	<tr>
    	
    	<td align="right" valign="top" width="500">
        	Select Categories :
        </td>
        <td width="500">
        	<select multiple="true" name="categories[]" style="width:220px;"/>
			  <?php 
					while($row = mysqli_fetch_assoc($result_cat)){ ?>
						<option><?php echo $row['cname']; ?></option>
					<?php }
				?> 
			</select>
        </td>

	</tr>

	<tr>
    	
    	<td align="right" valign="top" width="500">
        	Select Product Category :
        </td>
        <td width="500">
        	<select multiple="true" name="product_categories[]" style="width:220px;"/>
			  <?php 
					while($row = mysqli_fetch_assoc($result_prdcat)){ ?>
						<option><?php echo $row['pcname']; ?></option>
					<?php }
				?> 
			</select>
        </td>

	</tr>

	<tr>
    	
    	<td align="right" valign="top" width="500">
        	Select Clients :
        </td>
        <td width="500">
        	<select multiple="true" name="clients[]" style="width:220px;"/>
			  <?php 
					while($row = mysqli_fetch_assoc($result_client)){ ?>
						<option><?php echo $row['clname']; ?></option>
					<?php }
				?> 
			</select>
        </td>
	</tr>

	<tr>
    	
    	<td align="right" valign="top" width="500">
        	Select Editions :
        </td>
        <td width="500">
        	<select multiple="true" name="editions[]" id="editions" style="width:220px;"/>
			  <option> AHM </option>
			  <option> BRD </option>
			  <option> SRT </option>
			  <option> RAJ </option>
			  <option> BHV </option>
			  <option> BHJ </option>
			  <option> MUM </option>
			  <option> RaviPurti </option>
			  <option> Shatdal </option>
			  <option> Chitralok </option>
			  <option> Dharmalok </option>
			  <option> Zagmag </option>
			  <option> Sahiyar </option>
			</select>
        </td>

	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	From Date :
        </td>
        <td width="500">
			<input type='text' id="from_datepicker" name="from_date" style="width:220px;"/>
        </td>
	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	To Date :
        </td>
        <td width="500">
			<input type='text' id="to_datepicker" name="to_date" style="width:220px;"/>
        </td>
	</tr>

	
	<tr>
    	<td colspan="3" align="center">
		<div class="fileUpload btn btn-primary">
			<input type="submit" class="upload" value="Show Report"/>
		</div>
		</td>
	</tr>

	</table>

	</form>

	</div>

</div>

</body>
</html>

