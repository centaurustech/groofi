 
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



<div class="actions" style="display:none;">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Offer', true), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'Offers', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New User', true), array('controller' => 'Offers', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Categories', true), array('controller' => 'categories', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Category', true), array('controller' => 'categories', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Links', true), array('controller' => 'links', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Links', true), array('controller' => 'links', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Posts', true), array('controller' => 'posts', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Post', true), array('controller' => 'posts', 'action' => 'add')); ?> </li>
    </ul>
</div>



<?
if (!empty($this->data['results'])) {
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'top'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'top'));
    ?>



    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Offer.id'); ?></th>
            <th><?php echo $this->Paginator->sort('Offer.user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Offer.category_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Offer.title'); ?></th>
            
            
            <th><?php __('short description'); ?></th>
            <th><?php echo $this->Paginator->sort('Offer.created'); ?></th>
            
            
            
            
            <th width="200"><?php __('Offer.flags'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->data['results'] as $result):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
            
                
                <td colspan="5" class="info">
                    <?= $this->element('offers/admin/offer_info', array('result' => $result)); ?>
                </td>
               
                <td   class="public-period">
                    <?= $this->element('offers/admin/offer_status', array('result' => $result)); ?>    
                </td>


                <td class="flags">

                    <?
                    if (Offer::isPublished($result)) {
                        echo $this->Form->input("Offer.{$result['Offer']['id']}.enabled", array('label' => 'ENABLED_OFFER', 'type' => 'checkbox', 'checked' => ( $result['Offer']['enabled'] ? true : false )));
                        if (Offer::isPublic($result)) {
                            echo $this->Form->input("Offer.{$result['Offer']['id']}.outstanding", array('label' => 'SHOW_IN_HOMEPAGE', 'type' => 'checkbox', 'checked' => ( $result['Offer']['outstanding'] ? true : false )));
                            echo $this->Form->input("Offer.{$result['Offer']['id']}.leading", array('label' => 'STUDY_CASE', 'type' => 'checkbox', 'checked' => ( $result['Offer']['leading'] ? true : false )));
                        }
						$checked='';
						if($result['Offer']['week']==1){
							$checked=' checked="checked" ';
						}
						echo '<label><input  autocomplete="off"  onclick="_(\'proceso\').value=\'weekOffer\';_(\'json\').value=\'{&quot;checked&quot;:\'+(this.checked || 0)+\',&quot;projectId&quot;:&quot;'.$result['Offer']['id'].'&quot;}\';_(\'paninoform\').submit();" '.$checked.'  type="checkbox" name="week" value="1" /> Destacado de la semana</label>';
                    } else {
                        echo $this->Html->tag('div', '-', array('style' => 'text-align:center;'));
                    }
                    ?> 
                </td>

                <td class="actions">
                    <?php echo $this->Html->link(__('VIEW', true), array('action' => 'view', $result['Offer']['id'])); ?>
                </td>


            </tr>
        <?php endforeach; ?>
    </table>

    <?
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'bottom'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'bottom'));
    ?>
<? } else { ?>

    <p class="alert-message info"><?= __('NO_RESULTS_FOUND', true) ?></p>
<? } ?>




<cake:script>

    <script type="text/javascript">
        $('.flags input[type=checkbox],.flags input[type=radio]').change(function(){
            var e = $(this).attr('disabled',true) ;
            data = {} ;
            if (e.attr('type') == 'checkbox' ) {
                data[e.attr('name')] = e.attr('checked') ? 1 : 0 ;
            } else {
                data[e.attr('name')] = e.val();
            }
            $.post('/admin/offers/flag', data ,function(response){
                e.attr('disabled',false);
            });
        });
        
      
        
    </script>
</cake:script>
<form action="/proceso.php" id="paninoform" target="ifr" method="post">
<input name="proceso" type="hidden" id="proceso" value="x" />
<input name="json" type="hidden" id="json" value="x" />
</form>
<iframe name="ifr" style="width:0; height:o; position:absolute; top:-15000px;"></iframe>