<!doctype html>
<html>
<head>
<?php
require_once('include-files/connection.php');

$cwidth = $cheight = '';

$uniqid = $_GET['uniqid'];
$cheight = $_GET['cheight'];
$cwidth = $_GET['cwidth'];
$newspaper = $_GET['newspaper']
?>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <body>
	
	<div class="header" align="center" style="background:'ffff0f'">
	
		<br><br>
		<input type="button" name="home" value="Home" onclick="parent.location='main.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="report" value="Report" onclick="parent.location='rep_flt.php'">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="download" value="Downoad" onclick="img_save()">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="undo" value="Undo" onclick="img_undo()">	
	</div>

        <canvas id="canvas" align='center'></canvas>
      <script>

      var canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d');
	
	context.canvas.width = <?php echo $cwidth; ?>;
    context.canvas.height = <?php echo $cheight; ?>;
	//context.canvas.width = 0.88*window.innerWidth;
    //context.canvas.height = 2.4*window.innerHeight;
	var restorePoints = [];
    make_base();

    function make_base()
    {
      base_image = new Image();
      base_image.src = 'b.png';
      base_image.onload = function(){
         context.drawImage(base_image, 0, 0,base_image.width,base_image.height,0,0,base_image.width,base_image.height);
       }
    }
      </script>

<script>
$(function(){
  var mouse = {
      x: 0,
      y: 0,
      startX: 0,
      startY: 0
  };
  var canv = document.createElement('canvas');

    var canvas=document.getElementById("canvas");
    var ctx=canvas.getContext("2d");

    var canvasOffset=$("#canvas").offset();
    var offsetX=canvasOffset.left;
    var offsetY=canvasOffset.top;

    //console.log("offset location:", offsetX, offsetY);
    var startX;
    var startY;
    var isDown=false;

    ctx.fillStyle="rgba(255, 0, 0, 0)";
    ctx.globalAlpha = 1;
    ctx.strokeStyle="red";
    ctx.lineWidth=5;

    var modeName="square";

    $('input[name=mode]').click(function() {
        modeName=$('input[name=mode]:checked').val();
        console.log(modeName);
    });

    function handleMouseDown(e){

      mouseX=parseInt(e.clientX-offsetX)+document.documentElement.scrollLeft;
      //mouseX=e.clientX;
      mouseY=parseInt(e.clientY-offsetY)+document.documentElement.scrollTop;
      //mouseY=e.clientY;

      // Put your mousedown stuff here
     startX=mouseX;
     startY=mouseY;
//$("#downlog").html("Down: " + mouseX + " / " + mouseY);
console.log("strtx and starty: " + startX + " / " + startY);
console.log("mouse location:", e.clientX, e.clientY)

  //var rect = canvas.getBoundingClientRect();
            //startX=(e.clientX - rect.left);
            //startY=(e.clientY - rect.top) ;
            //console.log("mouse location new:",startX, startY);

      if (isDown == false){
        isDown=true;
        //startX=mouseX;
        //startY=mouseY;
      }
      else{
        isDown=false;
    //  drawRectangle(mouseX,mouseY);
      }
    }

    function handleMouseUp(e){
      mouseX=parseInt(e.clientX-offsetX)+document.documentElement.scrollLeft;
      mouseY=parseInt(e.clientY-offsetY)+document.documentElement.scrollTop;
      $("#uplog").html("Up: "+ mouseX + " / " + mouseY);

      // Put your mouseup stuff here
      isDown=false;
       //$("#uplog").html("Up: " + mouseX + " / " + mouseY);
       console.log("mouse up location:", mouseX, mouseY,document.documentElement.scrollTop||document.body.scrollTop);
	var canvas = document.getElementById("canvas");

      var dataURL_undo = canvas.toDataURL();

      console.log(dataURL_undo);

      restorePoints.push(dataURL_undo);

      drawRectangle(mouseX,mouseY);
	//drawRectangle(mouseX,mouseY);
    }

    function handleMouseMove(e){
      mouseX=parseInt(e.clientX-offsetX)+document.documentElement.scrollLeft;
      mouseY=parseInt(e.clientY-offsetY)+document.documentElement.scrollTop
;

      // Put your mousemove stuff here
      if(!isDown){return;}
      //$("#movelog").html("Move: " + mouseX + " / " + mouseY);

      //drawRectangle(mouseX,mouseY);
    //  ctx.clearRect(startX,startY,mouseX-startX,mouseY-startY);
  //   drawRectangle(mouseX,mouseY);
}

    function drawRectangle(mouseX,mouseY){
        var width=mouseX-startX;
        var height=mouseY-startY;
	console.log("width....."+width+"..height...."+height+"total...width"+base_image.width+"..baseimage height.."+base_image.height);
        ctx.beginPath();
        ctx.rect(startX,startY,width,height);
        ctx.fill();
        ctx.stroke();
        element = document.createElement('ctx');
        element.className = 'rectangle'
        //element.style.left = mouse.x + 'px';
        //element.style.top = mouse.y + 'px';
        canvas.appendChild(element);
        canvas.style.cursor = "crosshair";
    }

    function drawSquare(mouseX,mouseY){
        var width=Math.abs(mouseX-startX)*(mouseX<startX?-1:1);
        var height=Math.abs(width)*(mouseY<startY?-1:1);
        ctx.beginPath();
        ctx.rect(startX,startY,width,height);
        ctx.fill();
        ctx.stroke();
        element = document.createElement('ctx');
        element.className = 'rectangle'
        //element.style.left = mouse.x + 'px';
        //element.style.top = mouse.y + 'px';
        canvas.appendChild(element)
        canvas.style.cursor = "crosshair";
    }

    $("#canvas").mousedown(function(e){handleMouseDown(e);});
    $("#canvas").mousemove(function(e){handleMouseMove(e);});
    $("#canvas").mouseup(function(e){handleMouseUp(e);});



}); // end $(function(){});
</script>

</head>

<body>
	
    <canvas id="canvas" width=<?php echo $cwidth ?> height=<?php echo $cheight ?> align="center"></canvas><br>
	
	
<script>
function img_save() {

  //alert ("inside image save..");
  var canvas = document.getElementById("canvas");
 var ajax = new XMLHttpRequest();
  var canvasData = canvas.toDataURL("image/png");
ajax.open("POST","testSave.php",false);
ajax.setRequestHeader('Content-Type', 'application/upload');
ajax.send("imgData="+canvasData);
//ajax.send("height="+"15");
//alert (canvasData);
var uniqid = <?php echo $uniqid; ?>;
var newspaper = <?php echo $newspaper; ?>;
alert(newspaper);
//var str = "slideshow_python.php?uniqid='" + uniqid + "'&pageno='"+pageno+"'";
//alert(str)
location.href = "slideshow_python.php?uniqid=" + uniqid + "&pageno="+newspaper;
}

function img_undo() {

var oImg = new Image();



oImg.onload = function() {



var canvas = document.getElementById("canvas");

var canvasContext = canvas.getContext('2d');

canvasContext.clearRect(0, 0, canvas.width, canvas.height);

canvasContext.drawImage(oImg, 0, 0);

}



oImg.src = restorePoints.pop();

}
  </script>

</body>
</html>
