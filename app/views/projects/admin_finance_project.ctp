<?
//vd($this->data);
// sponsorships
?>

<? if (!empty($this->data[EXPRESSCHECKOUT])) { ?>
    <table>
        <tr>
            <?
            $fields = array_keys($this->data[EXPRESSCHECKOUT][0]['Sponsorship']);
            echo implode('', array_map(function($args) {
                                return "<th>" . __(up('Sponsorship_' . $args), true) . "</th>";
                            }, $fields));
            ?>
        </tr>


        <? foreach ($this->data[EXPRESSCHECKOUT] as $sponsorship) { ?>
            <tr>
                <?
                $sponsorship = $sponsorship['Sponsorship'];
                echo implode('', array_map(function($args) {
                                    return "<td>$args</td>";
                                }, $sponsorship));
                ?>
            </tr>


        <? } ?>
    </table>
<? } ?>

<? if (!empty($this->data[PREAPPROVAL])) { ?>
    <table>
        <tr>
            <?
            $fields = array_keys($this->data[PREAPPROVAL][0]['Sponsorship']);
            echo implode('', array_map(function($args) {
                                return "<th>" . __(up('Sponsorship_' . $args), true) . "</th>";
                            }, $fields));
            ?>
        </tr>


        <? foreach ($this->data[PREAPPROVAL] as $sponsorship) { ?>
            <tr>
                <?
                $sponsorship = $sponsorship['Sponsorship'];
                echo implode('', array_map(function($args) {
                                    return "<td>$args</td>";
                                }, $sponsorship));
                ?>
            </tr>


        <? } ?>
    </table>
<? } ?>



<table>
    <tr>
        <th><? __('PAYMENT_INFO') ?></th>
        <th><? __('PAYMENT_STATUS') ?></th>

    </tr>
    <?
    foreach ($this->data['Projectpayments'] as $result) {
        ?>

        <tr>
            <td>
                <ul>
                    <?
                    echo $this->Html->tag('li', $result['Projectpayment']['responseenvelope_timestamp']);
                    echo $this->Html->tag('li', $result['Projectpayment']['responseEnvelope_ack']);
                    $text = sprintf(__('Payment %s OF %s FOR USD %s OF USD %s TO %s', true), $result['Projectpayment']['current_payment'], $result['Projectpayment']['total_payments'], money_format('%(#10n', $result['Projectpayment']['amount']), money_format('%(#10n', $result['Projectpayment']['amount_total']), $result['Projectpayment']['receiver_email']
                    );

                    echo $this->Html->tag('li', $text);
                    ?>
                </ul>
            </td>
            <td>

                <? if (!empty($result['Projectpayment']['errors'])) { ?>
                    <ul class=" error-list">
                        <?
                        $errors = unserialize($result['Projectpayment']['errors']);
                        foreach ($errors as $error) {
                            ?>
                            <li>
                                <b class="error-code"><? echo array_shift($error); ?></b>
                                <ul  class="details_list error-detail">
                                    <?
                                    foreach (array_keys($error) as $errorTag) {
                                        echo $this->Html->tag('li', $this->Html->tag('b', __(up($errorTag), true)) . $error[$errorTag]);
                                    }
                                    ?>
                                </ul>
                            </li>
                        <? } ?>
                    </ul>
                <? } elseif (!empty($result['Projectpayment']['info'])) {  ?>
                        <ul class="details_list info-list">
                            <?
                            $errors = unserialize($result['Projectpayment']['info']);
                            foreach ($errors as $error) {
                                foreach (array_keys($error) as $errorTag) {
                                    echo $this->Html->tag('li', $this->Html->tag('b', __(up($errorTag), true)) . $error[$errorTag]);
                                }
                            }
                            ?>
                        </ul>
                    <? } ?>
                </td>

            </tr>
            <?
        }
        ?>

</table>


<cake:script>

    <script type="text/javascript">
        $('.error-code').toggle(function(){ $(this).next('ul').show(); }, function(){ $(this).next('ul').hide(); }).next('ul').hide();
        
    </script>
</cake:script>

<style type="text/css">
    ul.details_list li { color : #111111 ;  }
    ul.details_list b { color : #333333 ;  display: inline-block ; padding-right: 2px ; }
    
</style>