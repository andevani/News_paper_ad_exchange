$(document).ready(function(){
 $( "#prev_image" ).click(function(){
  prev();
 });
 $( "#next_image" ).click(function(){
  next();
 });
});

// Write all the names of images in slideshow
//var images = [ "a.jpg" , "b.jpg" , "c.jpg" , "d.jpg" ];
var array=[
<?php
$query = mysql_query("SELECT * FROM news.news3");
        while ($car = mysql_fetch_assoc($query)) {
            $car_name = $car["filename"];
            echo "'$car_name',";
        }
?>
];
console.log(array);
function prev()
{
 $( '#slideshow_image' ).fadeOut(300,function()
 {
  var prev_val = document.getElementById( "img_no" ).value;
  var prev_val = Number(prev_val) - 1;
  if(prev_val< = -1)
  {
   prev_val = images.length - 1;
  }
  console.log('images/'+images[prev_val]+'.jpg');
  $( '#slideshow_image' ).attr( 'src' , 'images/'+images[prev_val]+'.jpg' );
  document.getElementById( "img_no" ).value = prev_val;
 });
 $( '#slideshow_image' ).fadeIn(1000);
}

function next()
{
 $( '#slideshow_image' ).fadeOut(300,function()
 {
  var next_val = document.getElementById( "img_no" ).value;
  var next_val = Number(next_val)+1;
  if(next_val >= images.length)
  {
   next_val = 0;
  }
  console.log('images/'+images[next_val]+'.jpg');
  $( '#slideshow_image' ).attr( 'src' , 'images/'+images[next_val]+'.jpg' );
  document.getElementById( "img_no" ).value = next_val;
 });
 $( '#slideshow_image' ).fadeIn(1000);
}
