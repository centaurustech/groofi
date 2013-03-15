<? setlocale(LC_MONETARY, 'en_US'); ?>
<table>
    <tr>
        <th><? __('id') ?></th>
        <th><? __('contribution') ?></th>
        <th><? __('payer_id') ?></th>
        <th><? __('payer_email') ?></th>
        <th><? __('expresscheckout_status') ?></th>
        <th><? __('expresscheckout_transaction_id') ?></th>
        <th><? __('expresscheckout_token') ?></th>
        <th><? __('expresscheckout_status') ?></th>
        <th><? __('masspay_masspay_txn_id') ?></th>
        <th><? __('masspay_mc_gross') ?></th>
        <th><? __('masspay_mc_fee') ?></th>
        <th><? __('masspay_status') ?></th>

    </tr>
    <? foreach ($this->data['expresscheckouts'] as $expresscheckout) { ?>
        <tr>

            <td><?= $expresscheckout['Sponsorship']['id'] ?></td>
            <td><?= money_format('%i', $expresscheckout['Sponsorship']['contribution']); ?></td>


            <!-- -->
            <td><?= $expresscheckout['Sponsorship']['payer_id'] ?></td>
            <td><?= $expresscheckout['Sponsorship']['payer_email'] ?></td>
            <td><?= $expresscheckout['Sponsorship']['expresscheckout_status'] ?></td>
            <td><?= $expresscheckout['Sponsorship']['expresscheckout_transaction_id'] ?></td>
            <td><?= $expresscheckout['Sponsorship']['expresscheckout_token'] ?></td>
            <td><?= $expresscheckout['Sponsorship']['expresscheckout_status'] ?></td>

            <!-- -->
            <td><?= $expresscheckout['Sponsorship']['masspay_masspay_txn_id'] ?></td>
            <td><?= money_format('%i', $expresscheckout['Sponsorship']['masspay_mc_gross']); ?></td>
            <td><?= money_format('%i', $expresscheckout['Sponsorship']['masspay_mc_fee']); ?></td>
            <td><?= up($expresscheckout['Sponsorship']['masspay_status']) ?></td>



        </tr>
    <? } ?>
</table>

<table>
    <tr>
        <th><? __('id') ?></th>
        <th><? __('contribution') ?></th>
        <th><? __('preapproval_key') ?></th>
        <th><? __('preapproval_approved') ?></th>
        <th><? __('preapproval_status') ?></th>
        <th><? __('preapproval_curpayments') ?></th>
        <th><? __('preapproval_curpaymentsamount') ?></th>
        <th><? __('preapproval_curperiodattempts') ?></th>
        <th><? __('preapproval_currencycode') ?></th>
    </tr>

    <? foreach ($this->data['preapprovals'] as $preapproval) { ?>
        <tr>
            <td><?= $preapproval['Sponsorship']['id'] ?></td>
            <td><?= money_format('%i', $preapproval['Sponsorship']['contribution']); ?></td>

            <td><?= $preapproval['Sponsorship']['preapproval_key'] ?></td>
            <td><?= $preapproval['Sponsorship']['preapproval_approved'] ?></td>
            <td><?= $preapproval['Sponsorship']['preapproval_status'] ?></td>
            <td><?= $preapproval['Sponsorship']['preapproval_curpayments'] ?></td>
            <td><?= money_format('%i', $preapproval['Sponsorship']['preapproval_curpaymentsamount']); ?></td>
            <td><?= $preapproval['Sponsorship']['preapproval_curperiodattempts'] ?></td>
            <td><?= $preapproval['Sponsorship']['preapproval_currencycode'] ?></td>


        </tr>
    <? } ?>
</table>


