var nshome={}
nshome.pause=0;
function createSlideHome(images,cajaimages,tns){
	
	nshome.cajaimages=cajaimages;
	
	if(nshome.intervalo)clearInterval(nshome.intervalo);
	nshome={}
	var thumbs=tns.getElementsByTagName('img');
	ns.titulos=[];
	var fragment=document.createDocumentFragment();
	
	nshome.images=[];
	for(var i=0,l=images.length,n=l-1;i<l;i++,n--){
		try{ns.titulos.push(thumbs[i].getAttribute('data-titulo'));}catch(e){}
		var im=document.createElement('div');
		im.innerHTML=images[i];
		im.style.width=im.style.height='100%';
	  	im.style.position='absolute';
		im.style.left='0px';
		im.style.top='0px';
		im.style.zIndex=0;
		im.style.visibility='hidden';
		im.id='eff'+(+new Date)+Math.random();
		im.setAttribute('custom',nshome.images.length);
		fragment.appendChild(im);
		(function(im){nshome.images.push(im);})(im);
		im=null;
		
	}
	cajaimages.appendChild(fragment);
	
	
	$('velo').style.left=$('titulovelo').style.left=0;
	$('titulovelo').innerHTML=ns.titulos[0]
	nshome.arriba=$(nshome.images[0].id);
	nshome.abajo=$(nshome.images[1].id);
	$(nshome.images[0].id).css('zIndex',2);
	$(nshome.images[0].id).css('visibility','visible');
	ns.recordar=[nshome.arriba,nshome.abajo];
	nshome.intervalo=setInterval(function(){visualizar(nshome.arriba,nshome.abajo);},10000);
}
function visualizar(arriba,abajo){
		ns.recordar=[arriba,abajo];
		if(nshome.pause){return;}
		if(nshome.ocupado){
			return setTimeout(function(){visualizar(arriba,abajo);},100);	
		}
		
		$(arriba.id).onMotionStart=function(){
			nshome.ocupado=1;
		}
		$(arriba.id).onMotionFinished=function(){
			nshome.ocupado=0;
		}
		$(arriba.id).css('zIndex',1);
		$(abajo.id).css('zIndex',2);
		$(arriba.id).css('visibility','visible');
		$(abajo.id).css('visibility','visible');
		$(abajo.id).alfa(0);
		var indiceActualArriba=parseInt($(abajo.id).getAttribute('custom'));
			$('velo').style.left=$('titulovelo').style.left=(120*indiceActualArriba)+'px';
			$('titulovelo').innerHTML=ns.titulos[indiceActualArriba]
			window.currentDiapo=indiceActualArriba;
			nshome.arriba=$(nshome.images[indiceActualArriba].id);
			
			if(indiceActualArriba+1>nshome.images.length-1){
				nshome.abajo=$(nshome.images[0].id);
			}else{
				nshome.abajo=$(nshome.images[indiceActualArriba+1].id);
			}
			if(!nshome.intervalo)nshome.intervalo=setInterval(function(){visualizar(nshome.arriba,nshome.abajo);},10000);
			
		
		fx(arriba,[{'inicio':1,'fin':0,'u':'','propCSS':'opacity'}],1250,false,senoidal);
		fx(abajo,[{'inicio':0,'fin':1,'u':'','propCSS':'opacity'}],1250,false,senoidal);
		
		
}

			function clickTn(i){
						if(!nshome.images[i])return setTimeout(function(){clickTn(i);},100);
						clearInterval(nshome.intervalo);
						despausar();
						$('velo2').style.display='none';
						$('titulovelo2').style.display='none';
						nshome.intervalo=null;
						
						nshome.abajotmp=$(nshome.images[i].id);
						
						
						if(nshome.arriba!=nshome.abajotmp){
								nshome.abajo=nshome.abajotmp;
						}else{
							
							return	nshome.intervalo=setInterval(function(){visualizar(nshome.arriba,nshome.abajo);},10000);
						}
						visualizar(nshome.arriba,nshome.abajo);
			}
function slidePause(e){
	cancelEvent(e)
	nshome.pause=1;
	if($('play'))
		$('play').style.display='block';
	if($('pause'))
		$('pause').style.display='none';
	
}
function slidePlay(e){
	cancelEvent(e)
	nshome.pause=0;
	
	visualizar.apply(null,ns.recordar);
	if($('play'))
		$('play').style.display='none';
	if($('pause'))
		$('pause').style.display='block';
	
}
DR(
	function(){
		if($('play'))
			$('play').addEvent(
						'click',
						slidePlay
			)
		if($('pause'))
			$('pause').addEvent(
						'click',
						slidePause
			)
		if($('ad'))
			$('ad').addEvent(
						'click',
						avanceSlide
			)
		if($('at'))
			$('at').addEvent(
						'click',
						retrocedeSlide
			)
	}   
);

function despausar(){
	nshome.pause=0;
	if($('play'))
		$('play').style.display='none';
	if($('pause'))
		$('pause').style.display='block';
}
function avanceSlide(e){
	cancelEvent(e)
	var adonde=window.currentDiapo+1
	if(adonde>nshome.images.length-1)
		adonde=0;
	clickTn(adonde);
	
}
function retrocedeSlide(e){
	cancelEvent(e)
	var adonde=window.currentDiapo-1
	if(adonde<0)
		adonde=nshome.images.length-1
	clickTn(adonde);
}

function overThumb(index,titulo,t2){
	if(index==window.currentDiapo)return;
	$('velo2').style.display='block';
	$('titulovelo2').style.display='block';
	$('titulovelo2').style.left=$('velo2').style.left=(120*index)+'px';
	$('titulovelo2').setAttribute('custom',titulo);
	$('titulovelo2').innerHTML=t2;
}
function outThumb(){
	$('velo2').style.display='none';
	$('titulovelo2').style.display='none';
}