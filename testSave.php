<?php
echo "ankur..";
//if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
//if(1)
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
{
//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
  // Get the data
  $imageData=$GLOBALS['HTTP_RAW_POST_DATA'];

//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

  $pos_uniq = strpos($imageData,"&uniqid=");
  $uniqid = substr($imageData,$pos_uniq+8);
  //$fp = fopen( 'ab.txt', 'wb' );
  //fwrite( $fp, $uniqid);
  //fclose( $fp );

 echo $imageData;
  // Remove the headers (data:,) part.
  // A real application should use them according to needs such as to check image type
  $filteredData=substr($imageData, strpos($imageData, ",")+1);

  // Need to decode before saving since the data we received is already base64 encoded
  $unencodedData=base64_decode($filteredData);

  //echo "unencodedData".$unencodedData;
  //echo $_POST['width'];
  // Save file. This example uses a hard coded filename for testing,
  // but a real application can specify filename in POST variable
  $updated_a = $uniqid.'_a.png';
  $fp = fopen( $updated_a, 'wb' );
  fwrite( $fp, $unencodedData);
  fclose( $fp );
//  echo ("completed...");
}
?>
