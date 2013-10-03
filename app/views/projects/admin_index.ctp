<!--div id="menuCntr">
    <!--?
    $authUser = true;

    if (!empty($authUser) && !empty($adminMenu)) {
        echo $modules->adminMenu($adminMenu);

    }
    $this->Js->buffer("$('ul#admin_menu').superfish({dropShadows : false});");
    ?>
</div-->
<?
    echo $this->element('paginator/common');
    echo $this->element('paginator/filters');
?>
<script>
function _(x){return document.getElementById(x);}
var DR=function(f){
	if(document.addEventListener){
		var func=function(){f();document.removeEventListener('DOMContentLoaded',func,false);}
		document.addEventListener('DOMContentLoaded',func,false);
	}else{
		function r(f){/in/.test(document.readyState)?setTimeout(function(){r(f);},9):f();};
		r(f);
	}
}
</script>

<?
if (!empty($this->data['results'])) {
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'top'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'top'));
    ?>



    <table cellpadding="0" cellspacing="0">
        <div class="propiedades_proyectos">

            <li><?php echo $this->Paginator->sort('Project.id'); ?></li>
            <li><?php echo $this->Paginator->sort('Project.title'); ?></li>
            <li><?php echo $this->Paginator->sort('Project.category_id'); ?></li>
            <li><?php echo $this->Paginator->sort('Project.user_id'); ?></li>
            <li><?php echo $this->Paginator->sort('Project.created'); ?></li>
            <li><?php echo $this->Paginator->sort('Descripción'); ?></li>
        </div>


            <!--<th><?php __('Project.flags'); ?></th>-->
            <li id="last" colspan="2" class="actions"><?php __('Actions'); ?></li>

        <?php
        $i = 0;
    /*    echo '<pre>';
    var_dump($this->data['results']);*/

        foreach ($this->data['results'] as $result):
		    $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>

                <td  width="250" class="public-period">
                     <?= $this->element('projects/admin/project_status', array('result' => $result)); ?>
                </td>

                <td colspan="5" class="info info_nuevo">
                    <!--?= $this->element('projects/admin/project_info', array('result' => $result)); ?-->
                    <!--span><//?= $result['Project']['dirname'];?></span-->
                    <div class="propiedades_proyectos_admin">
                    <div class="thumb">
                        <? $imagen_extension = explode('.',$result['Project']['basename'])?>
                    <img style="display: block" src="/media/filter/s64/<?= $result['Project']['dirname'].'/'.$imagen_extension[0].'.png';?>" width="64" height="64">
                    </div>
                    <span><?= $result['Project']['id'];?></span>
                    <span><?= $result['Project']['title'];?></span>
                    <span><?= $result['Category']['name'];?></span>
                    <span><?= $result['User']['display_name'];?></span>
                    <span><?= $result['User']['created'];?></span>
                    <span style="width: 250px"><?= $result['Project']['short_description'];?></span>

                    </div>



					<? if(!empty($result['Project']['videoid']) && !empty($result['Project']['videotype'])  && !empty($result['Project']['leading'])){
					if($result['Project']['videotype']=='youtube')
						echo '<div id="videocaso'.$result['Project']['id'].'"><p><h3 style="clear:both; color:#000; padding-top:10px">Video del caso:</h3><iframe width="400" height="225" src="http://www.youtube.com/embed/'.$result['Project']['videoid'].'" frameborder="0" allowfullscreen></iframe></p></div>';
					else
						echo '<div id="videocaso'.$result['Project']['id'].'"><p><h3 style="clear:both; color:#000; padding-top:10px">Video del caso:</h3><iframe src="http://player.vimeo.com/video/'.$result['Project']['videoid'].'" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></p></div>';
					}else{echo '<div id="videocaso'.$result['Project']['id'].'"></div>';}?>
                </td>


                <td  width="150" class="flags">

                    <?
                    if (Project::isPublished($result)) {
                        echo $this->Form->input("Project.{$result['Project']['id']}.enabled", array('label' => 'ENABLED_PROJECT', 'type' => 'checkbox', 'checked' => ( $result['Project']['enabled'] ? true : false )));
                        if (Project::isPublic($result)) {
                            echo $this->Form->input("Project.{$result['Project']['id']}.outstanding", array('label' => 'SHOW_IN_HOMEPAGE', 'type' => 'checkbox', 'checked' => ( $result['Project']['outstanding'] ? true : false )));
                            echo $this->Form->input("Project.{$result['Project']['id']}.leading", array('label' => 'STUDY_CASE', 'type' => 'checkbox', 'checked' => ( $result['Project']['leading'] ? true : false )));
                        }
						$checked='';
						if($result['Project']['week']==1){
							$checked=' checked="checked" ';
						}
						echo '<label><input  autocomplete="off"  onchange="_(\'proceso\').value=\'weekProject\';_(\'json\').value=\'{&quot;checked&quot;:\'+(this.checked || 0)+\',&quot;projectId&quot;:&quot;'.$result['Project']['id'].'&quot;}\';_(\'paninoform\').submit();" '.$checked.'  type="checkbox" name="week" value="1" /> Destacado de la semana</label>';
                        echo $this->Html->div('input radio', $this->Form->radio("Project.{$result['Project']['id']}.payment_type", array(
                                    EXPRESSCHECKOUT => __('EXPRESSCHECKOUT_PAYMENT', true),
                                    PREAPPROVAL => __('PREAPPROVAL_PAYMENT', true),
                                        ), array(
                                    'legend' => __('PAYMENT_TYPE', true),
                                    'value' => $result['Project']['payment_type']
                                        )
                                )
                        ); //, 'checked' => ( $result['Project']['leading'] ? true : false )
                    } else {
                        echo $this->Html->tag('div', '-', array('style' => 'text-align:center;'));
                    }
                    ?> 
					
                </td>


                <td  width="170"  class="actions">

                    <?
                    echo $this->Html->link(__('VIEW_DETAILS', true), array('action' => 'view', $result['Project']['id']));
                    echo $this->Html->link(__('VIEW_PROJECT_PAGE', true), Project::getLink($result),array('target'=>'_blank'));

                    if (Project::isPublished($result)) {
                        echo $this->Html->link(__('VIEW_BALANCE', true), array('action' => 'projectBalance', $result['Project']['id']));
                    }
                    ?>
                </td>


            </tr>
        <?php endforeach; ?>
    </table>

    <?
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'bottom'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'bottom'));
    ?>
<? } else {
    ?>

    <p class="alert-message info"><?= __('NO_RESULTS_FOUND', true) ?></p>
<? } ?>



<cake:script>

    <script type="text/javascript">
        $('.flags input[type=checkbox],.flags input[type=radio]').change(function(){
            var e = $(this).attr('disabled',true) ;
			
			if($(this)[0].name.indexOf('leading')!=-1 && $(this)[0].checked){
					document.getElementById('bglightbox2').style.display=document.getElementById('addVideo').style.display='block';
					var chId=$(this)[0].id;
					var pid=$(this)[0].id.split('Project').join('').split('Leading').join('');
					var iframes=document.getElementsByTagName('iframe'),l=iframes.length;
					var sel='<select style="width:150px; heigth:20px; position:absolute;top:50px; left:50%; margin-left:-75px;" id="tipodevideo"><option value="vimeo">vimeo</option><option value="youtube">youtube</option></select>';
					var labelinp='<label style="font-size:10px;width:200px; heigth:20px; position:absolute;top:75px; left:50%; margin-left:-75px; cursor:default">C&oacute;digo o URL del video:</label>';
					var inp='<input style="width:150px; heigth:20px; position:absolute;top:90px; left:50%; margin-left:-75px;" id="keyvideo" type="text">';
					window.losifrs=iframes;
					var ok='<div id="btok" onclick="var code=_(&quot;keyvideo&quot;).value;this.className=code;if(_(&quot;keyvideo&quot;).value.length<2){return;}else{_(&quot;json&quot;).value=&quot;{\'projectId\':\''+pid+'\',\'videoId\':\'&quot;+this.className+&quot;\',\'tipo\':\'&quot;+_(&quot;tipodevideo&quot;).value+&quot;\'}&quot;;_(&quot;proceso&quot;).value=&quot;saveVideo&quot;;_(&quot;paninoform&quot;).submit();}" style="width:50px; height:30px; text-align:center; line-height:30px; color:#FFF;font-size:10px;cursor:pointer;position:absolute;left:92px; top:130px; background:#39a0c6">Aceptar</div>';
					var ko='<div class="'+chId+'" style="width:50px; height:30px; text-align:center; line-height:30px; color:#FFF;font-size:10px;cursor:pointer;position:absolute;left:152px; top:130px; background:#39a0c6" onclick="document.getElementById(this.className).checked=0;data = {} ; data[document.getElementById(this.className).name] = document.getElementById(this.className).checked;$.post(&quot;/admin/projects/flag&quot;, data ,function(response){});document.getElementById(&quot;bglightbox2&quot;).style.display=document.getElementById(&quot;addVideo&quot;).style.display=&quot;none&quot;;document.getElementById(&quot;addVideo&quot;).innerHTML=&quot;&quot;;var l=self.losifrs.length;for(var i=0;i<l;i++)self.losifrs[i].style.visibility=&quot;visible&quot;;">Cancelar</div>';
					document.getElementById('addVideo').innerHTML='<div class="'+chId+'" style="cursor:pointer;width:30px; height:30px; position:absolute;right:0; top:0;" onclick="document.getElementById(this.className).checked=0;data = {} ; data[document.getElementById(this.className).name] = document.getElementById(this.className).checked;$.post(&quot;/admin/projects/flag&quot;, data ,function(response){});document.getElementById(&quot;bglightbox2&quot;).style.display=document.getElementById(&quot;addVideo&quot;).style.display=&quot;none&quot;;document.getElementById(&quot;addVideo&quot;).innerHTML=&quot;&quot;;;var l=self.losifrs.length;for(var i=0;i<l;i++)self.losifrs[i].style.visibility=&quot;visible&quot;;"></div>'+sel+labelinp+inp+ok+ko;
					for (var i=0;i<l;i++){
						iframes[i].style.visibility='hidden';
					}
					
			}
			if($(this)[0].name.indexOf('leading')!=-1 && !$(this)[0].checked){
				var id='videocaso'+$(this)[0].id.split('Project').join('').split('Leading').join('');
				if(document.getElementById(id))
					document.getElementById(id).innerHTML='';
				
			}	
            data = {} ;
            if (e.attr('type') == 'checkbox' ) {
                data[e.attr('name')] = e.attr('checked') ? 1 : 0 ;
            } else {
                data[e.attr('name')] = e.val();
            }
            $.post('/admin/projects/flag', data ,function(response){
                e.attr('disabled',false);
            });
        });
        
      
        
    </script>
</cake:script>
<form action="/proceso.php?<?php echo SID ?>" id="paninoform" target="ifr" method="post">
<input name="proceso" type="hidden" id="proceso" value="x" />
<input name="json" type="hidden" id="json" value="x" />
</form>
<iframe name="ifr" style="width:0; height:o; position:absolute; top:-15000px;"></iframe>