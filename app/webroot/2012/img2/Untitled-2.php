<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>test</title> 
<script> 
function reflejo (contenedor, imagen) { 
        var ref = false; 
        if (document.createElement("canvas").getContext) { 
            /* ---- canvas ---- */ 
            ref = document.createElement("canvas"); 
            ref.width = imagen.width; 
            ref.height = imagen.height; 
            var context = ref.getContext("2d"); 
            context.translate(0, imagen.height); 
            context.scale(1,-1); 
            context.drawImage(imagen, 0, 0, imagen.width, imagen.height); 
            context.globalCompositeOperation = "destination-out"; 
            var gradient = context.createLinearGradient(0, 0, 0, imagen.height);
            gradient.addColorStop(0, "rgba(255, 255, 255, 1.0)"); 
            gradient.addColorStop(1, "rgba(255,255, 255, 0.1)"); 
            context.fillStyle = gradient; 
            context.fillRect(0,0,imagen.width, imagen.height); 
        } else { 
            /* ---- DXImageTransform ---- */ 
            ref=document.createElement('img'); 
            ref.src=imagen.src; 
            ref.style.filter = 'flipv progid:DXImageTransform.Microsoft.Alpha(opacity=50, style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy=' + imagen.height + ')';
        ref.width= imagen.width; 
        ref.height= imagen.height; 
        } 
        ref.style.position = 'absolute'; 
        ref.style.left= 0; 
        ref.style.top= imagen.height+'px' 
        contenedor.appendChild(ref); 
    } 
window.onload=function(){ 
    reflejo(document.getElementById('pp'), document.getElementById('ll')); 
} 
</script>   
</head> 

<body> 
<div id="pp" style="position:relative"><img id="ll" src="5.jpg" width="180" height="144" /></div> 
</body> 
</html>