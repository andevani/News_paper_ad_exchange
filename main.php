<?php

	session_start();
	//echo $_SESSION['uname'];
	if(isset($_SESSION['uname']))
	{
		$uname = $_SESSION['uname'];
	require_once('include-files/connection.php');
    require_once('datepicker.php');
	//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	//header("Cache-Control: post-check=0, pre-check=0", false);
	//header("Pragma: no-cache");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fetch Data from News Paper</title>
</head>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="jquery-date/jquery-1.6.2.min.js"></script>
  <script src="jquery-date/jquery-ui-1.8.16.custom.min.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  
  window.onload = function() {
   document.getElementById('cheight').disabled = true;
   document.getElementById('cwidth').disabled = true;

};
  </script>

<body background="bg.png">


<div>

<!------------------------------------------------ Header---------------------------------------------->

	<div class="header" align="center" style="background-color: #ffffff;border:1px solid black;">
	
		<br>
		
		<?php
			if($uname == "admin")
			{
		?>
		
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Comparison Report" onclick="parent.location='comparison_report_filter.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Exception Report" onclick="parent.location='exception_report_filter.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="sreport" value="Summary Report" onclick="parent.location='summrep_flt.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="ereport" value="Exception Report" onclick="parent.location='ereport.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="centry" value="Link Entry" onclick="parent.location='lentry.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="logout" value="Log out" onclick="parent.location='logout.php'" align="right">
		
		<?php
			}
			else
			{
		?>
		
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="centry" value="Link Entry" onclick="parent.location='lentry.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="logout" value="Log out" onclick="parent.location='index.php'" align="right">
		
		<?php
			}
		?>
		
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

		if (document.form.newspaper.value == "Sandesh" || document.form.newspaper.value == "Divya Bhaskar")
		{
			section = ['Main'];
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

		if (document.form.pageno.value == "" || isNaN(document.form.pageno.value))
		{
			alert("Invalid Page No");
			valid = false;
			return false;
		}
		
		if (valid)
		{
			return true;
		}
	
	}
	
	function custhw()
	{
		if (document.getElementById("default").checked)
		{
			document.getElementById('cheight').value = '';
			document.getElementById('cwidth').value = '';
			
			document.getElementById('cheight').disabled = true;
			document.getElementById('cwidth').disabled = true;
		}
		else
		{
			document.getElementById('cheight').disabled = false;
			document.getElementById('cwidth').disabled = false;
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
			</select>
			
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
		<td align="right" valign="top" width="500">
			Newspaper Height/Width :
		</td>
		
		<td>
			<input type="radio" name="h_w" id="default" value="default" onclick="custhw()" checked> Default <br>
			<input type="radio" name="h_w" id="customized" value="customized" onclick="custhw()"> Customized <br>
		</td>
	</tr>
	
	<tr>
    	<td align="right" valign="top" width="500">
			Height :
		</td>
		<td>
			<input type="input" name="cheight" id="cheight" style="width:120px;">
		</td>
	</tr>

	<tr>
    	<td align="right" valign="top" width="500">
			Width :
		</td>
		<td>
			<input type="input" name="cwidth" id="cwidth" style="width:120px;">
		</td>
	</tr>
	
	<tr>
    	<td align="right" valign="top" width="500">
			Select Upload File :
		</td>
		<td>
			<input type="file" name="advfile">
		</div>
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

<?php
	}
	else
	{
		header("Location: index.php");
	}
?>
