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
        	<input list="newspaper" name="newspaper" />
			<datalist id="newspaper">
			  <option value="Gujarat Samachar">
			  <option value="Divyabhaskar">
			  <option value="Sandesh">
			  <option value="Times of India">
			  <option value="Sanj Samachar">
			</datalist>
        </td>
	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	Date :
        </td>
        <td width="500">

	<input type='text' id="datepicker" name="datepicker" />
        </td>

	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
        	Page No :
        </td>
        <td width="500">
        	<input list="pageno" name="pageno" />
			<datalist id="pageno">
			  <option value="1">
			  <option value="2">
			  <option value="3">
			  <option value="4">
			  <option value="5">
			</datalist>
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Input 1 :
        </td>
        <td width="100">
        	<input type="text" name="input1" id="input1" size="30" value="" />
        </td>
	</tr>

	<tr>
    	<td align="right" width="100">
        	Input 2 :
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
