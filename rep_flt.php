<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once('datepicker.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fetch Data from News Paper</title>

</head>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>


<body background="bg.png">


<div>

<!------------------------------------------------ Header---------------------------------------------->

	<div class="header" align="center" style="background-color: #ffffff;border:1px solid black;">
	
		<br>
		
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
	
		<br>
		<br>
	</div>

<!------------------------------------------------ Main Body---------------------------------------------->

	<div class="Body">

	<br>
	<form name="form" action="disp_rep.php" method="POST" enctype="multipart/form-data">

	<table width="700" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">

	<tr>
    	<td align="center" width="500" colspan='2'>
			<h1 align="center">
				Select Filter
			</h1>
		</td>
	</tr>
	
    <tr>
    	<td align="right" valign="top" width="500">
        	Select Newspaper :
        </td>
        <td width="500">
        	<select list="newspaper" name="newspaper" style="width:220px;"/>
			  <option> Gujarat Samachar	</option>
			  <option> Sandesh		</option>
			  <option> Divya Bhaskar	</option>
			</select>
        </td>
	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	Date :
        </td>
        <td width="500">

	<input type='text' id="datepicker" name="datepicker" style="width:220px;"/>
        </td>

	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	Page No :
        </td>
        <td width="500">
        	<input type="text" name="pageno" id="pageno" style="width:220px;"/>
        </td>
	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	Edition :
        </td>
        <td width="500">
        	<select list="edition" name="edition" id="edition" style="width:220px;"/>
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
			</datalist>
			
			<div id="e_edition"></div>
			
        </td>
	</tr>
	
	<tr>
    	<td align="right" valign="top" width="500">
        	Section :
        </td>
        <td width="500">
        	<select list="section" name="section" id="section" style="width:220px;"/>
			  <option> Main </option>
			  <option> GSPlus </option>
			  <option> KhedaAnand </option>
			  <option> Gandhinagar </option>
			  <option> Surendranagar </option>
			  <option> Sabarkantha </option>
			  <option> Mehsana </option>
			  <option> BharuchPanchmahal </option>
			  <option> VapiValsad </option>
			  <option> Magazine </option>
			</datalist>
        </td>
	</tr>
	
	<tr>
    	<td align="right" width="100">
        	Advertise/News :
        </td>
        <td width="100">
        	<select name="input1" id="input1" style="width:220px;">
			  <option value="advertisement">Advertisement</option>
			  <option value="news">News</option>
			</select>
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Advertiser :
        </td>
        <td width="100">
        	<input type="text" name="input2" id="input2" size="30" value="" />
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Input 3 :
        </td>
        <td width="100">
        	<input type="text" name="input3" id="input3" size="30" value="" />
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Input 4 :
        </td>
        <td width="100">
        	<input type="text" name="input4" id="input4" size="30" value="" />
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

