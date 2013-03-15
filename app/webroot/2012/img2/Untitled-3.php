<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script type="text/javascript">
function agregar_carrito(pos_cd) {
	return function(){
		alert(pos_cd); 
	}
}
onload=function(){
var a = document.createElement('a'); 
    a.innerHTML = 'Agregar al carrito de compras !'; 
    a.id='ppp'; 
    a.onclick = agregar_carrito(a.id);
	document.body.appendChild(a);
}
</script>

</head>

<body>
</body>
</html>