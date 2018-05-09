<?php

	header('Content-Type: image/png');
	// Create the image
	$im = imagecreatefromjpeg('image-1.jpg');

	// Save the image as 'simpletext.png'
	imagepng($im, 'b.png');

	// Free up memory
	imagedestroy($im);

?>