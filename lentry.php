<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Link Entry Module</title>
</head>


<body background="bg.png">

<div>
	
	<!------------------------------------------------ Main Body---------------------------------------------->
	<div class="Body">

	<div class="header" align="center" width='50' style="background-color: #ffffff;border:1px solid black;">
	
		<br>
		
		<input type="button" name="home" id="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
	
		<br>
		<br>
	</div>
	
	<form name="form" action="lentry_submit.php" method="POST" enctype="multipart/form-data">
	
	<table width="500" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">

	<br>
	
	<tr>
    	<td align="center" width="500" colspan='2'>
			<h1 align="center">
				Connection Entry
			</h1>
		</td>
	</tr>
	
	<tr>
    	<td align="right" valign="top" width="300">
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
		<td align="right">
			Page No : 
		</td>
		
		<td align="left">
			<input type="input" name="pgno" id="pgno" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Client : 
		</td>
		
		<td align="left">
			<input type="input" name="client" id="client" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Agent : 
		</td>
		
		<td align="left">
			<input type="input" name="agent" id="agent" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			COBW : 
		</td>
		
		<td align="left">
			<input type="input" name="cobw" id="cobw" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Brand Name : 
		</td>
		
		<td align="left">
			<input type="input" name="brand" id="brand" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Product Name : 
		</td>
		
		<td align="left">
			<input type="input" name="pname" id="pname" style="width:220px;">
		</td>
	</tr>

	<tr>
		<td align="right">
			Product Category : 
		</td>
		
		<td align="left">
			<input type="pcat" name="pcat" id="pcat" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			BPG : 
		</td>
		
		<td align="left">
			<input type="pcat" name="bpg" id="bpg" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			PPG : 
		</td>
		
		<td align="left">
			<input type="pcat" name="ppg" id="ppg" style="width:220px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Matter : 
		</td>
		
		<td align="left">
			<input type="matter" name="matter" id="uname" style="width:220px;">
		</td>
	</tr>
	
	<tr></tr>
	
	<tr>
		<td align="center" colspan="2">
			<input type="submit" value="Submit"/>
		</td>
	</tr>
	
	</table>
	
	</form>
	
	</div>
	
</div>

</body>

</html>