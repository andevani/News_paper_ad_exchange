
<?php

require_once('include-files/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $msg = '';
  $i1 = trim($_POST['input1']);
  $i2 = trim($_POST['input2']);
  $i3 = trim($_POST['input3']);
  $i4 = trim($_POST['input4']);

  if(isset($msg) && $msg == '')
  {
    echo "POOJA";
    $query = 'INSERT INTO news.news2 SET ';
    $query .= ' i1 = \''.$i1.'\'';
    $query .= ' , i2 = \''.$i2.'\'';
    $query .= ' , i3 = \''.$i3.'\'';
    $query .= ' , i4 = \''.$i4.'\'';

    mysqli_query($conn, $query) or die(mysql_error());
  }
}
?>
