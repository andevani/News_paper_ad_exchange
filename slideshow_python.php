<?php
$uniqid = $_GET['uniqid'];

$command = escapeshellcmd('/usr/bin/python3 python_old/detect1.py --image b.png --unique ' . $uniqid);
$output = shell_exec($command);
echo $output;
header("Location: slideshow.php?uniqid=".$uniqid);
?>
