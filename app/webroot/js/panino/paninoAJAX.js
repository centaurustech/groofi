// JavaScript Document
/*credits: Andrés Fernández*/
String.prototype.tratarResponseText=function(){
    var pat=/<script[^>]*>([\S\s]*?)<\/script[^>]*>/ig;
    var pat2=/\bsrc=[^>\s]+\b/g;
    var elementos = this.match(pat) || [];
    for(i=0;i<elementos.length;i++) {
        var nuevoScript = document.createElement('script');
        nuevoScript.type = 'text/javascript';
        var tienesrc=elementos[i].match(pat2) || [];
        if(tienesrc.length){
            nuevoScript.src=tienesrc[0].split("'").join('').split('"').join('').split('src=').join('').split(' ').join('');
        }else{
            var elemento = elementos[i].replace(pat,'$1');
            nuevoScript.text = elemento;
        }
        document.getElementsByTagName('body')[0].appendChild(nuevoScript);
    }
    return this.replace(pat,'');
} 

function http(){
	if(typeof window.XMLHttpRequest!='undefined'){
		return new XMLHttpRequest();	
	}else{
		try{
			return new ActiveXObject('Microsoft.XMLHTTP');
		}catch(e){
			alert('Su navegador no soporta AJAX');
			return false;
		}	
	}	
}

function requestPOST(url,divId,params){
	var H=new http();
	if(!H)return;
	H.open('post',url+'?'+Math.random(),true);
	H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	H.onreadystatechange=function(){
		if(H.readyState==4){
			$(divId).parentNode.style.backgroundImage='none';
			$(divId).innerHTML=H.responseText.tratarResponseText();
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}else{
			$(divId).innerHTML='';
		}
	}
	var p='';
	for(var i in params){
		p+='&'+i+'='+escape(params[i]);	
	}
	H.send(p);
}



function requestGET(url,divId,params,callback){
	var H=new http();
	if(!H)return;
	var p='';
	for(var i in params){
		p+='&'+i+'='+escape(params[i]);	
	}
	H.open('get',url+'?'+p+'&'+Math.random(),true);
	H.onreadystatechange=function(){
		if(H.readyState==4){
			
			$(divId).parentNode.style.backgroundImage='none';
			$(divId).innerHTML=H.responseText.tratarResponseText();
			if(callback)callback();
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}else{
			$(divId).innerHTML='';
		}
	}
	H.send(null);
}

function requestCallback(url,callback,params){
	var H=new http();
	if(!H)return;
	H.open('post',url+'?'+Math.random(),true);
	H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	H.onreadystatechange=function(){
		if(H.readyState==4){
			callback();
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}
	}
	var p='';
	for(var i in params){
		p+='&'+i+'='+escape(params[i]);	
	}
	H.send(p);
}

function requestCallbackParam(url,callback,params){
	var H=new http();
	if(!H)return;
	H.open('post',url+'?'+Math.random(),true);
	H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	H.onreadystatechange=function(){
		if(H.readyState==4){
			callback(H.responseText);
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}
	}
	var p='';
	for(var i in params){
		p+='&'+i+'='+encodeURIComponent(params[i]);	
	}
	H.send(p);
}
function getXML(url,callback,params){
	var H=new http();
	if(!H)return;
	H.open('post',url+'?'+Math.random(),true);
	H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	H.onreadystatechange=function(){
		if(H.readyState==4){
			callback(H.responseXML);
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}
	}
	var p='';
	for(var i in params){
		p+='&'+i+'='+escape(params[i]);	
	}
	H.send(p);
}
function requestCallbackParamXML(url,callback,params){
	var H=new http();
	if(!H)return;
	H.open('post',url+'?'+Math.random(),true);
	H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	H.onreadystatechange=function(){
		if(H.readyState==4){
			callback(H.responseXML);
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}
	}
	var p='';
	for(var i in params){
		p+='&'+i+'='+escape(params[i]);	
	}
	H.send(p);
}
function requestCallbackParamUnicode(url,callback,params){
	var H=new http();
	if(!H)return;
	H.open('post',url+'?'+new Date().getTime(),true);
	var xmlHttpTimeout=setTimeout(function(){
		if($('aguarde')){
			$('aguarde').innerHTML='Server Error';
		}
		H.onreadystatechange=function(){}
		H.abort();
		H=null;	
		requestCallbackParamUnicode(url,callback,params);
	},600000);
	H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	H.onreadystatechange=function(){
		if(H.readyState==4 && H.status == 200){
			clearTimeout(xmlHttpTimeout);
			if($('aguarde')){
				$('aguarde').style.visibility='hidden';
			}
			callback(H.responseText);
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}
	}
	var p='';
	for(var i in params){
		p+='&'+i+'='+encodeURIComponent(params[i]);	
	}
	H.send(p);
}
function requestGETCallbackParam(url,callback,params){
	var H=new http();
	if(!H)return;
	var p='';
	for(var i in params){
		p+='&'+i+'='+encodeURIComponent(params[i]);	
	}
	H.open('get',url+'?'+p+'&'+Math.random(),true);
	H.onreadystatechange=function(){
		if(H.readyState==4){
			callback(H.responseText);
			H.onreadystatechange=function(){}
			H.abort();
			H=null;
		}
	}
	H.send(null);
}