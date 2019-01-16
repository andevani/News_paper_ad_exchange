<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Welcome to Newspaper Data Entry Module</title>
</head>


<body background="bg.png">

<div>
	
	<!------------------------------------------------ Main Body---------------------------------------------->
	<div class="Body">

	<?php
	require_once('include-files/connection.php');

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$msg = '';
		$uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
		$pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
		
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';

		$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
		$query = "SELECT * FROM news.login where uname = '" . $uname . "' AND pwd = '" . $pwd . "'";
		echo $query;
		$result = mysqli_query($conn,$query);
		print_r($result);
		
		//mysqli_close($conn);
		
		if(mysqli_num_rows($result) < 1)
		{
			
			echo '<script type="text/javascript">',

			 'alert("Invalid Username or Password")',

			 '</script>';
		}
		else
		{
			session_start();
			$_SESSION['uname'] = $uname;
			header("Location: main.php");
		}
		
	}
	?>
	
	<form name="form" name="form" action="" method="POST" autocomplete="off">
	
	<table width="500" align="center" cellpadding="10" cellspacing="10" frame="box" style="background-color: #ffffff;">

	<br>
	
	<tr>
    	<td align="center" width="500" colspan='2'>
			<h1 align="center">
				Login
			</h1>
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Username : 
		</td>
		
		<td align="left">
			<input type="input" name="uname" id="uname" style="width:150px;">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Password : 
		</td>
		
		<td align="left">
			<input type="password" name="pwd" id="pwd" style="width:150px;">
		</td>
	</tr>
	
	<tr>
		<td align="center" colspan="2">
			<input type="submit" value="Login"/>
		</td>
	</tr>
	
	</table>
	
	</form>
	
	</div>
	
</div>

</body>

</html>