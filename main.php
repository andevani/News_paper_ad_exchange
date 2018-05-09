<?php
    require_once('include-files/connection.php');
	require_once('datepicker.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

	<script type="text/javascript">

	/* $(document).ready(function(){
   $( "#report" ).click(function(){
    load_filter();
   }); */

	function load_filter()
	{
		$.get('rep_flt.php', function(data){
			alert("Report Exported Successfully");
		});
	}

	function validate()
	{
		var valid = true;
		//valid = $.get("validate.php");
		
		if (document.form.newspaper.value != "Gujarat Samachar")
		{
			//document.getElementById("e_newspaper").innerHTML="Not a valid Newspaper value";
			alert("Not a valid Newspaper value");
			//document.form.newspaper.setfocus();
			valid = false;
			return false;
		}
		
		var edition = ['AHM','BRD','SRT','RAJ','BHV','BHJ','MUM','RaviPurti','Shatdal','Chitralok','Dharmalok','Zagmag','Sahiyar'];
		if (edition.includes(document.form.edition.value))
		{
		}
		else{
			//document.getElementById("e_edition").innerHTML="Not a valid Edition value";
			alert("Not a valid Edition value");
			valid = false;
			return false;
		}
		
		if (document.form.section.value == "")
		{
			alert("Not a valid Section value");
			valid = false;
			return false;
		}
		
		switch(document.form.edition.value) 
		{
			case 'AHM':
				var section = ['Main', 'GSPlus', 'KhedaAnand', 'Gandhinagar', 'Surendranagar', 'Sabarkantha', 'Mehsana'];
				break;
				
			case 'BRD':
				var section = ['Main', 'BharuchPanchmahal'];
				break;
				
			case 'SRT':
				var section = ['Main', 'VapiValsad'];
				break;
				
			case 'RAJ':
				var section = ['Main'];
				break;
				
			case 'BHV':
				var section = ['Main'];
				break;
				
			case 'BHJ':
				var section = ['Main'];
				break;
				
			case 'MUM':
				var section = ['Main'];
				break;
				
			case 'Ravi':
				var section = ['Magazine'];
				break;
				
			case 'Shatdal':
				var section = ['Magazine'];
				break;
				
			case 'Chitralok':
				var section = ['Magazine'];
				break;
				
			case 'Dharmalok':
				var section = ['Magazine'];
				break;
				
			case 'Zagmag':
				var section = ['Magazine'];
				break;
				
			case 'Sahiyar':
				var section = ['Magazine'];
				break;
		}

		if (section.includes(document.form.section.value))
		{
		}
		else
		{
			//document.getElementById("e_edition").innerHTML="Not a valid Edition value";
			alert("Not a valid Section value for selected Edition");
			valid = false;
			return false;
		}
		
		if (valid)
		{
			return true;
		}
	
	}
	
	</script>

	<div class="Body">

	<form name="form" onsubmit="return validate();" action="action_submit.php" method="POST" enctype="multipart/form-data">


	
	<table width="500" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">

	<br>
	
	<tr>
    	<td align="center" width="500" colspan='2'>
			<h1 align="center">
				Newspaper Data
			</h1>
		</td>
	</tr>
	
    <tr>
    	<td align="right" valign="top" width="100">
        	Newspaper :
        </td>
        <td width="500">
        	<input list="newspaper" name="newspaper" />
			<datalist id="newspaper">
			  <option value="Gujarat Samachar">
			</datalist>
			
			<div id="e_newspaper"></div>
			
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
    	<td align="right" valign="top" width="500">
        	Edition :
        </td>
        <td width="500">
        	<input list="edition" name="edition" />
			<datalist id="edition">
			  <option value="AHM">
			  <option value="BRD">
			  <option value="SRT">
			  <option value="RAJ">
			  <option value="BHV">
			  <option value="BHJ">
			  <option value="MUM">
			  <option value="RaviPurti">
			  <option value="Shatdal">
			  <option value="Chitralok">
			  <option value="Dharmalok">
			  <option value="Zagmag">
			  <option value="Sahiyar">
			</datalist>
			
			<div id="e_edition"></div>
			
        </td>
	</tr>
	
	<tr>
    	<td align="right" valign="top" width="500">
        	Section :
        </td>
        <td width="500">
        	<input list="section" name="section" />
			<datalist id="section">
			  <option value="Main">
			  <option value="GSPlus">
			  <option value="KhedaAnand">
			  <option value="Gandhinagar">
			  <option value="Surendranagar">
			  <option value="Sabarkantha">
			  <option value="Mehsana">
			  <option value="BharuchPanchmahal">
			  <option value="VapiValsad">
			  <option value="Magazine">
			</datalist>
        </td>
	</tr>
	
	<tr>
    	<td align="right" valign="top" width="500">
			Select File :
		</td>
		<td>
			<input type="file" name="fileToUpload">
		</div>
		</td>
	</tr>

	<tr>
    	<td colspan="3" align="center">
		<div class="fileUpload btn btn-primary">
			<input type="submit" class="upload" value="Upload"/>
		</div>
		</td>
	</tr>

	</table>

	</form>

	</div>

<!------------------------------------------------ Footer---------------------------------------------->

	<div class="Footer">
	<br />
	</div>

</div>

</html>

