var ns={};


var alerta=function(m){
	 if(!$('custom_ext')){
				var ext=document.createElement('div');
				ext.style.opacity=0;
				ext.style.filter='alpha(opacity=0)';
				ext.id='custom_ext';
				ext.style.width='333px';
				ext.style.height='186px';
				ext.style.background='url(/2012/images/bgAlert.png)';
				ext.style.zIndex=21000;
				ext.style.position='fixed';
				ext.style.left='50%';
				ext.style.marginLeft='-166px';
				ext.style.fontFamily='Verdana, Arial, Helvetica, sans-serif';
				ext.style.fontSize='13px';
				ext.style.fontWeight='bold';
				var txt=document.createElement('div');
				txt.style.height='90px';
				txt.style.width='298px';
				txt.style.left='10px';
				txt.style.top='60px';
				txt.style.position='absolute';
				txt.style.color='#3d3d3d';
				txt.id='mjepopup';
				ext.appendChild(txt);
				ext.style.display='none';
				var closed=document.createElement('div');
				closed.style.width='25px';
				closed.style.height='25px';
				closed.style.position='absolute';
				closed.style.background='url(/2012/images/Vacio.gif)';
				closed.style.top='0px';
				closed.style.right='0px';
				closed.style.cursor='pointer';
				closed.style.textAlign='center';
				$('bglightbox2').onclick=closed.onclick=function(){closeAlert();};
				ext.appendChild(closed);
				document.body.appendChild(ext);
			 }
			 var meds=getWindowData();
			 $('custom_ext').style.top='100px';
			 $('mjepopup').innerHTML='<table width="100%" height="100%"><tr><td align="center" valign="middle">'+m+'</td></tr></table>';
			 $('bglightbox2').style.display=$('custom_ext').style.display='block';
			 $('bglightbox2').onMotionFinished=function(){};
			 fx($('bglightbox2'),[{'inicio':0,'fin':.8,'u':'','propCSS':'opacity'}],500,true,senoidal);
			 fx($('custom_ext'),[{'inicio':0,'fin':1,'u':'','propCSS':'opacity'}],500,true,senoidal);
 }


function closeAlert(){
	 fx($('bglightbox2'),[{'inicio':.8,'fin':0,'u':'','propCSS':'opacity'}],500,true,senoidal);
	 $('bglightbox2').onMotionFinished=function(){
		 $('bglightbox2').style.display=$('custom_ext').style.display='none';
	};
	 fx($('custom_ext'),[{'inicio':1,'fin':0,'u':'','propCSS':'opacity'}],500,true,senoidal);
	 
}

function closeBoxUser(){
	$('boxUser').style.display='none';
}
function placeHolder(t){
	if(t.value==t.defaultValue){
		t.value='';
	}
}
function placeHolder2(t){
	if(t.value.length<1){
		t.value=t.defaultValue;
	}
}
function placeHolderPass(t){
	if($('fakepass').value==$('fakepass').defaultValue){
		$('fakepass').value='';
	}
}
function placeHolder2Pass(t){
	if(t.value.length<1){
		$('fakepass').value=$('fakepass').defaultValue;
	}
}
function openBoxUser1(e){
					cancelEvent(e);
					stopEvent(e);
					if(window.animationOn)return;
					clearTimeout(ns.timer);

					var pos=getElementPosition.call($('gear'));
					$('boxUser').style.left=(pos.left-171)+'px';
					$('boxUser').style.top=(pos.top+4)+'px';
					$('boxUser').style.width='210px';
					$('boxUser').style.height='140px';
					$('boxUser').style.background='url(/2012/images/bgLogOn.png)';
					$('boxUser').style.display='block';

}
function openBoxUser2(e){
					cancelEvent(e);
					stopEvent(e);
					if(window.animationOn)return;
					clearTimeout(ns.timer);

					var pos=getElementPosition.call($('gear'));
					$('boxUser').style.left=(pos.left-144)+'px';
					$('boxUser').style.top=(pos.top+5)+'px';
					$('boxUser').style.width='180px';
					$('boxUser').style.height='193px';
					$('boxUser').style.background='url(/2012/images/bgLogOff.png)';
					$('boxUser').style.display='block';
					$('login_text').innerHTML='<a onclick="openBoxUser2(event)" id="gear2" href="#">'+ingresar+'</a> / <a onclick="window.location=&quot;/signup&quot;;return false;" href="#">'+registrar+'</a>';
					$('boxUser').innerHTML='<form id="flogsup" action="/login2" method="post" target="ifr"><input tabindex="1" onfocus="placeHolder(this)" onblur="placeHolder2(this)" type="text" id="username" name="data[User][email]" value="E-mail"><input  onfocus="placeholderPass(this)" onblur="placeHolder2Pass(this)" type="text" id="fakepass" value="Password" tabindex="100">  <input onfocus="if($(&quot;fakepass&quot;).value==$(&quot;fakepass&quot;).defaultValue)$(&quot;fakepass&quot;).value=&quot;&quot;" onblur="if(this.value.length<1)$(&quot;fakepass&quot;).value=$(&quot;fakepass&quot;).defaultValue;" tabindex="2" type="password" id="pass" value="" name="data[User][password]"></form><a onclick="location=&quot;/forgotPassword&quot;;return false;" id="recpass" href="#">'+recupera+'</a><a onclick="$(&quot;flogsup&quot;).submit();return false;" id="loginbt" href="#">Login</a><a onclick="window.location=&quot;/fbConnect.php&quot;;return false;" id="loginfb" href="#">'+conface+'</a><a onclick="window.location=&quot;/signup&quot;;return false;" id="nuevosusuario" href="/signup">'+newuser+'</a><div id="btclose" onclick="closeBoxUser()"></div>';
}
DR(
	function(){
		if(ns.logueado){
			$('login_text').innerHTML='<a onclick="openBoxUser1(event)" id="gear3" href="#">'+perfi+'</a> / <a href="/logout">'+out+'</a>';
		}else{
			$('login_text').innerHTML='<a onclick="openBoxUser2(event)" id="gear2" href="#">'+ingresar+'</a> / <a href="/signup">'+registrar+'</a>';
		}
		
	}   
);
DR(
	function(){
		$('gear').hover(
			function(){
				this.style.background='url(/2012/images/gear_over.gif)';
				this.style.backgroundRepeat='no-repeat';
			},
			function(){
				this.style.background='url(/2012/images/gear.gif)';
				this.style.backgroundRepeat='no-repeat';
			}
		);
		if(ns.logueado){
			$('gear').addEvent(
				'click',
				openBoxUser1
			);
		}else{
			$('gear').addEvent(
				'click',
				openBoxUser2
			);
		}
		panino.getO(document).addEvent(
			'click',
			closeBoxUser
		);
		$('boxUser').addEvent(
			'click',
			function(e){
				cancelEvent(e);
				stopEvent(e);
			}
		);
		
	}   
);
/*
ns.plegado=1;
function desplegarCategorias(){
	if(window.animationOn2)return setTimeout(function(){desplegarCategorias()},1000);
	ns.plegado=0;
	var t=new Transition(easing,300,function(percentage){
			var fin=260,inicio=35, delta=fin-inicio;
			if($('filtro'))
			$('filtro').style.height=(inicio+(percentage*delta))+'px';						  
	});
	t.run();
	t=null;
}
function plegarCategorias(){
	if(window.animationOn2)return setTimeout(function(){plegarCategorias()},1000);
	ns.plegado=1;
	var t=new Transition(easing,300,function(percentage){
			var fin=35,inicio=175, delta=inicio-fin;
			if($('filtro'))
			$('filtro').style.height=(inicio-(percentage*delta))+'px';						  
	});
	t.run();
	t=null;
}*/
/*DR(
	function(){
		if($('filtro'))
		$('filtro').addEvent(
			'mouseover',
			function(){
				
				clearTimeout(ns.timer5);
				if(ns.plegado){
					
					desplegarCategorias();
				}
			}
		);
		if($('filtro'))
		$('filtro').addEvent(
			'mouseout',
			function(){
				if(!ns.plegado){
					clearTimeout(ns.timer);
					ns.timer5=setTimeout( plegarCategorias,1000);
				}
			}
		);
	}   
);*/
function promptPrivate(privateTitle,privateAutor){
			if(!$('custom_ext_private')){
				var ext=document.createElement('div');
				ext.style.opacity=0;
				ext.style.filter='alpha(opacity=0)';
				ext.id='custom_ext_private';
				ext.style.width='532px';
				ext.style.height='309px';
				ext.style.background='url(/2012/images/proyprivados_lightbox.png)';
				ext.style.zIndex=18500;
				ext.style.position='fixed';
				ext.style.left='50%';
				ext.style.marginLeft='-266px';
				ext.style.fontFamily='Verdana, Arial, Helvetica, sans-serif';
				ext.style.fontSize='13px';
				ext.style.fontWeight='bold';
				var txt=document.createElement('div');
				txt.style.height='90px';
				txt.style.width='298px';
				txt.style.left='10px';
				txt.style.top='60px';
				txt.style.position='absolute';
				txt.style.color='#3d3d3d';
				txt.id='mjepopup_private';
				ext.appendChild(txt);
				ext.style.display='none';
				var closed=document.createElement('div');
				closed.style.width='25px';
				closed.style.height='25px';
				closed.style.position='absolute';
				closed.style.background='url(/2012/images/Vacio.gif)';
				closed.style.top='0px';
				closed.style.right='0px';
				closed.style.cursor='pointer';
				closed.style.textAlign='center';
				$('bglightbox_private').onclick=closed.onclick=function(){closePromptPrivate();};
				ext.appendChild(closed);
				document.body.appendChild(ext);
			 }
			 var meds=getWindowData();
			 $('custom_ext_private').style.top='100px';
			 $('mjepopup_private').innerHTML='<div style="position:absolute; width:420px; height:20px; left:65px; top:-17px; text-align:left;  font-size:16px;">'+privateTitle+'</div><div style="position:absolute; width:420px; height:20px; left:65px; top:5px; text-align:left;  font-size:11px; font-style:italic; color:#4c4c4c">por '+privateAutor+'</div><div onclick="$(&quot;keyPrivate&quot;).value=$(&quot;claveprivate&quot;).value;$(&quot;formprivate&quot;).submit();" onmouseover="this.style.filter=&quot;alpha(opacity=20)&quot;;this.style.opacity=&quot;.2&quot;" onmouseout="this.style.filter=&quot;alpha(opacity=0)&quot;;this.style.opacity=&quot;0&quot;" style="width:101px; height:42px; position:absolute; left:19px; top:184px; background:#FFF;opacity:0;filter:alpha(opacity=0);cursor:pointer;"></div><div onmouseover="this.style.filter=&quot;alpha(opacity=20)&quot;;this.style.opacity=&quot;.2&quot;" onmouseout="this.style.filter=&quot;alpha(opacity=0)&quot;;this.style.opacity=&quot;0&quot;" style="width:80px; height:42px; position:absolute; left:125px; top:184px; background:#FFF;opacity:0;filter:alpha(opacity=0);cursor:pointer;" onclick="closePromptPrivate();"></div><form onsubmit="$(&quot;keyPrivate&quot;).value=$(&quot;claveprivate&quot;).value;$(&quot;formprivate&quot;).submit();return false;"><input autocomplete="off" name="claveprivate" id="claveprivate" type="password" style="width:190px; height:38px; position:absolute; left:160px; top:120px; background:url(/2012/images/Vacio.gif)"></form><div id="claveprivadaerror" style="color:red; position:absolute; width:190px; height:15px; font-size:10px; left:168px; top:165px; text-align:left; font-weight:normal; display:none">La clave es incorrecta</div>';
			 $('bglightbox_private').style.display=$('custom_ext_private').style.display='block';
			 $('bglightbox_private').onMotionFinished=function(){};
			 fx($('bglightbox_private'),[{'inicio':0,'fin':.8,'u':'','propCSS':'opacity'}],500,true,senoidal);
			 fx($('custom_ext_private'),[{'inicio':0,'fin':1,'u':'','propCSS':'opacity'}],500,true,senoidal);
}

function closePromptPrivate(){
	 fx($('bglightbox_private'),[{'inicio':.8,'fin':0,'u':'','propCSS':'opacity'}],500,true,senoidal);
	 $('bglightbox_private').onMotionFinished=function(){
		 $('bglightbox_private').style.display=$('custom_ext_private').style.display='none';
	};
	 fx($('custom_ext_private'),[{'inicio':1,'fin':0,'u':'','propCSS':'opacity'}],500,true,senoidal);
	 
}
function verVideo(vid,vtip,titulo, autor,proylink,autorlink){
	if(vtip=='vimeo'){
		var video='<iframe src="http://player.vimeo.com/video/'+vid+'" width="733" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}else{
		var video='<iframe width="733" height="400" src="http://www.youtube.com/embed/'+vid+'" frameborder="0" allowfullscreen></iframe>';
	}
	$('bglightbox_private').style.opacity=.8;
	$('bglightbox_private').style.filter='alpha(opacity=80)';
	$('bglightbox_private').style.display=$('videodelcasolb').style.display='block';
	$('videodelcasolb').innerHTML='<div style="width:731px; height:30px; left:30px; top:60px; position:absolute; font-size:21px; font-weight:bold; text-align:left;color:#4c4c4c;  font-family: Asap, sans-serif; z-index:2;"><span style="cursor:pointer" onclick="location=&quot;'+proylink+'&quot;" onmouseout="this.style.textDecoration=&quot;none&quot;" onmouseover="this.style.textDecoration=&quot;underline&quot;">'+titulo+'</span> <span style="font-size:14px; font-style:italic">por</span> <span style="cursor:pointer;font-size:14px; font-style:italic" onclick="location=&quot;'+autorlink+'&quot;" onmouseout="this.style.textDecoration=&quot;none&quot;" onmouseover="this.style.textDecoration=&quot;underline&quot;">'+autor+'</span></div><div onclick="cerrarVideo()" style=" width:40px; height:40px; right:5px; top:25px; position:absolute; cursor:pointer"></div><div style=" width:733px; height:400px; left:30px; top:100px; position:absolute">'+video+'</div>';
}
function cerrarVideo(){
	$('bglightbox_private').style.opacity=0;
	$('bglightbox_private').style.filter='alpha(opacity=0)';
	$('bglightbox_private').style.display=$('videodelcasolb').style.display='none';
	$('videodelcasolb').innerHTML='';
}