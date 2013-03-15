<?
echo $this->element('paginator/common');
echo $this->element('paginator/filters');

?>



<?
if (!empty($this->data['results'])) {
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'top'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'top'));
    ?>



    <table cellpadding="0" cellspacing="0">
        <tr>
            <th width="400"><? __('SPONSORSHIP_INFO') ?></th>

            <th>Imformaci&oacute;n Mercado Pago</th>



            <th  width="100" class="actions">&nbsp;</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->data['results'] as $result):
			//vd($result);
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>

                <td  class="info" >
                    <div class=" info-box user_info">
                        <?= $this->element('users/admin/user_info', array('result' => $result, 'full' => false)); ?>
                    </div>

                    <div class=" info-box project_info">
                        <?= $this->element('projects/admin/project_info2', array('result' => $result, 'full' => false)); ?>
                    </div>

                    <ul class="info-list info-box sponsorship_info">
                        <li><b><? __('SPONSORSHIP_ID') ?></b><?= '#' . $result['Sponsorship']['id']; ?></li>
                        <li><b><? __('SPONSORSHIP_VALUE') ?></b><?= 'ARS ' . $result['Sponsorship']['contribution']; ?></li>            
                        <li><b><? __('CREATED') ?></b><?= $this->Time->format($result['Sponsorship']['created'], '%d/%m/%Y'); ?></li>
                        <li><b><? __('MODIFIED') ?></b><?= $this->Time->format($result['Sponsorship']['modified'], '%d/%m/%Y'); ?></li>
                    </ul>


                </td>


                <td> 

                    <ul class="info-list info-box payment">
                       

                       Nro. de Operaci&oacute;n: <?=$result['Sponsorship']['idmercadolibre']?> 
                    <div class="status payment_status status_<?= $result['Sponsorship']['status'] ?>" ><? __(Configure::read('Sponsorship.status.' . $result['Sponsorship']['status'])) ?></div>
                    
                </td>



                <td class="actions">


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


<style type="text/css">
    ul.info-box { padding-left: 0px ; margin-left: 0px ; }

    .info-box { padding-bottom: 10px ; margin-bottom: 10px ; border-bottom: 1px solid #EAEAEA ;}

    .info-box li  {  list-style: none ; }
    .info-box li b { padding-right: 5px ; display: inline-block;  }
</style>
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
            $.post('/admin/sponsorships/flag', data ,function(response){
                e.attr('disabled',false);
            });
        });
        
      
        
    </script>
</cake:script>