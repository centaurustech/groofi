<?
setlocale(LC_MONETARY, 'en_US');
$moneda=Project::getMoneda($this->data);
//vd($moneda);
//
////echo money_format('%(#10n', $number) . "\n";
$paymentTypes = array(
    'expressCheckout', 'preApproval'
);
$status = sprintf(__('%s%% ( '.$moneda.' %s of '.$moneda.' %s )', true), Project::getFundedValue($this->data),  Project::getCollectedValue($this->data),  $this->data['Project']['funding_goal']);


if ($this->data['Project']['funding_goal'] < $this->data['total']) {
    $statusn = PROJECT_FUNDED;
} else {
    $statusn = PROJECT_NOT_FUNDED;
}
?>


<?
if (Project::isFinished($this->data)) {
    echo $this->Html->div('alert-message info', __('PROJECT_FINISHED', true) );
}

if (Project::isPaid($this->data)) {
    echo $this->Html->div('alert-message success', __('PROJECT_FOUNDS_HAS_BEEN_TRANFERED_TO_PROJECT_OWNER', true));
}


if ($this->data['balance'] < ( $this->data['refoundTotal'] + $this->data['expressCheckoutTotal'] )) {
    echo $this->Html->div('alert-message error', __('INSUFICIENT_FOUNDS_TO_DO_A_REFOUND', true));
}

if (($this->data['balance'] + $this->data['preApprovalTotal']) < $this->data['owner']) {
    echo $this->Html->div('alert-message error', __('INSUFICIENT_FOUNDS_TO_PAY_THIS_PROJECT', true));
}
?>


<h1 class="project-balance-title title ">
    <?= sprintf(__('PROJECT_BALANCE_FOR %s', true), $this->Html->link(Project::getName($this->data), Project::getLink($this->data), array('target' => '_blank'))); ?>
    <div class="project_funded_percentage">
        <? __('PROJECT_FUNDED_PERCENTAGE') ?>
        <div class="graph funded_status funded_0">
            <div class="bar" style="width:0%">&nbsp;</div>
            <div class="text"><?= $status ?></div>
        </div>
        
    </div>
</h1>







<table id="project_balance">
    <tr>
        <th width="250"><? __('PAYMENT_TYPE') ?></th>
        <th width="250"><? __('RESUMEN_NET') ?></th>
        <th width="250"><? __('REFOUND_COST') ?></th>
        <th width="250"><? __('RESUMEN_COMISION') ?></th>
        <th width="250"><? __('RESUMEN_PROJECT_PAYMENT') ?></th>
        <th width="250">
            <?
            if (Project::isFinished($this->data) && Project::isFunded($this->data)) {
                echo $this->Html->link(__('TRANSFER_ALL_FOUNDS', true), Router::url(array(
                            'controller' => 'sponsorships',
                            'action' => 'admin_charge_all',
                            'admin' => true,
                            $this->data['Project']['id']
                        )), array('class' => 'action btn'));
            } else {
                echo '&nbsp';
            }
            ?>
        </th>
    </tr>  


    <? foreach ($paymentTypes as $paymentType) { ?>

        <tr id="<?= $paymentType ?>" class="altrow total" onclick="$('.<?= $paymentType ?>').toggle();" >
            <td><? __(up($paymentType . '_PAYMENT_TOTAL')) ?></td>
            <td><?=$moneda?> <?=  $this->data[$paymentType . 'Total'] ?></td>
            <td><?=$moneda?> <?=  ( $this->data[$paymentType . 'RefoundTotal']) ?> + <?=$moneda?> <?=  $this->data[$paymentType . 'Total'] ?></td>
            <td><?=$moneda?> <?= ($this->data[$paymentType . 'Total'] * PROJECT_COMISION / 100) ?></td>
            <td><?=$moneda?> <?= ($this->data[$paymentType . 'Total'] * ( 100 - PROJECT_COMISION ) / 100) ?></td>
            <td>&nbsp;</td>
        </tr>

        <? if (!empty($this->data[$paymentType])) { ?>
            <? foreach ($this->data[$paymentType] as $payment) { ?>    
                <tr style="display:none;" class="<?= $paymentType ?> detail" >
                    <td>
                        <?= low($payment[low($paymentType) . '_status']); ?>&nbsp;(<?= $payment['transferred'] == 1 ? __('CHARGED', true) : __('NOT-CHARGED', true) ?>)
                    </td>
                    <td><?=$moneda?> <?=  $payment['contribution'] ?></td>

                    <td>

                        <? if ($paymentType == 'expressCheckout') { ?>
                            <?=$moneda?> <?=  $payment['contribution'] ?> + <?=$moneda?> <?=  $payment['refound_cost'] ?>
                        <? } else { ?>
                            <?=$moneda?> <?=  $payment['refound_cost'] ?>
                        <? } ?>
                    </td>
                    <td><?=$moneda?> <?=  ($payment['contribution'] * PROJECT_COMISION / 100) ?></td>
                    <td><?=$moneda?> <?=  ($payment['contribution'] * ( 100 - PROJECT_COMISION ) / 100) ?></td>


                    <td>
                        <?
                        if ($payment['transferred'] != 1 && Project::isFinished($this->data) && Project::isFunded($this->data)) {
                            echo $this->Html->link(__('CHARGE_SPONSORSHIP', true), Router::url(array(
                                        'controller' => 'sponsorships',
                                        'action' => 'charge',
                                        'admin' => true,
                                        $payment['id']
                                            )
                                    ), array('class' => 'action btn auto-process ajax confirm reload'));
                        }
                        ?>
                    </td>

                </tr>  
            <? } ?>
        <? } ?>

    <? } ?>

    <tr id="total">
        <td><? __('TOTAL') ?></td>

        <td><?=$moneda?> <?=  $this->data['total'] ?></td>
        <td>
            <b class="<?= ($this->data['balance'] < ( $this->data['refoundTotal'] + $this->data['expressCheckoutTotal'] ) ? 'insuficient-founds' : 'ok-founds') ?>" >

<!--    <?=$moneda?> <?=  $this->data['refoundTotal'] ?> + <?=$moneda?> <?=  $this->data['expressCheckoutTotal'] ?> -->

                <?=$moneda?> <?=  $this->data['refoundTotal'] + $this->data['expressCheckoutTotal'] ?>  

            </b>
        </td>
        <td><?=$moneda?> <?=  $this->data['groofi'] ?></td>
        <td>
            <b class="<?= ( ($this->data['balance'] + $this->data['preApprovalTotal']) ? 'insuficient-founds' : 'ok-founds') ?>" >
                <?=$moneda?> <?=  $this->data['owner'] ?>
            </b>
        </td>
        <td>&nbsp;</td>
    </tr>     
</table>







<div style="margin-top:30px;">

    <? if ($statusn == PROJECT_FUNDED && Project::isFinished($this->data)) { ?>
        <h3><? __('PROJECT_FUNDED_TITLE') ?></h3>
        <table>
            <tr>

                <th><? __('PAYMENT_NUMBER') ?></th>
                <th><? __('PAYMENT_AMMOUNT') ?></th>

            </tr>
            <? foreach ($this->data['payments'] as $key => $payment) { ?>    
                <tr>
                    <td><?= $key ?></td>
                    <td><?=$moneda?> <?=  $payment; ?></td>
                </tr>

            <? } ?>    


        </table>
        <?
        if ($this->data['balance'] > $this->data['owner']) {
            echo $this->Html->link(__('FOUND_THIS_PROJECT', true), Router::url(
                            array(
                                'controller' => 'projects',
                                'action' => 'financeProject',
                                'admin' => true,
                                $this->data['Project']['id'],
                            )
                    ), array('class' => 'action btn ajax'));
        }
        ?>

    <? } else { ?>
        <h3>&nbsp;</h3>


        <table>
            <tr>

                <th><? __('FUNDING_GOAL') ?></th>
                <th><? __('TOTAL_REVENUE') ?></th>
                <th><? __('DIFFERENCE') ?></th>
                <th><? __('REFOUND_COST') ?></th>
                <th><? __('ACTION') ?></th>
            </tr>

            <tr>
                <td><?=$moneda?> <?=  $this->data['Project']['funding_goal']; ?></td>
                <td><?=$moneda?> <?=  $this->data['total']; ?></td>
                <td><?=$moneda?> <?=  $this->data['Project']['funding_goal'] - $this->data['total']; ?></td>
                <td><?=$moneda?> <?=  $this->data['refoundTotal']; ?></td>

                <td>
                    <?
                    if (
                            (!Project::isFinished($this->data) || Project::isAboutToFinish($this->data)) // siempre y cuando no este finalizado.
                            && Project::getFundedValue($this->data) >= PROJECT_FUNDED_VALUE_VALID
                    ) {
                        echo $this->Html->link(__('SPONSORSHIP_THIS_PROJECT', true), Project::getLink($this->data, 'back'), array('target' => '_blank', 'class' => 'action btn'));
                    }

                    if (Project::isFinished($this->data) && $this->data['balance'] >= ( $this->data['refoundTotal'] + $this->data['expressCheckoutTotal'] )) {
                        
                        echo $this->Html->link(__('REFOUND_ALL_PAYMENTS_AND_SEND_NOTIFICATIONS', true), Router::url(array(
                                    'controller' => 'projects',
                                    'action' => 'notFinanceProject',
                                    'admin' => true,
                                    $this->data['Project']['id']
                                )), array('class' => 'action btn auto-process confirm'));
                    }
                    ?>

                </td>
            </tr>




        </table>
    <? } ?>
</div>




<cake:script>
    <script type="text/javascript">
        $(document).ready(function(){
        
            $('.bar').width(0).animate({
                width : '<?= Project::getFundedValue($this->data, 100) ?>%',
                opacity : '<?= Project::getFundedValue($this->data, 100) ?>%'
            },750)
        });
    
    
    </script>
</cake:script>
