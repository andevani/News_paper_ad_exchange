<?php
echo "Ankur..";
$uniqid = $_GET['uniqid'];
$newspaper = $_GET['newspaper'];
//$command = escapeshellcmd('ls');
//$output = shell_exec($command);
//echo $output;
//passthru('python3',$returnval);
//echo  "<hr/>".$returnval;
//echo getcwd();
$command = escapeshellcmd('/usr/bin/python3.6 python_old/detect1.py --image b.png --unique ' . $uniqid);
$output = shell_exec($command);
//echo $output;
header("Location: slideshow.php?uniqid=".$uniqid."&newspaper=".$newspaper);
?>
