<?

switch ($result['Offer']['status']) {
    case OFFER_STATUS_NEW :
        $status = __('PROPOSAL_OFFER_STATUS', true);
        break;
    case OFFER_STATUS_APROVED :
        $status = __('APPROVED_OFFER_STATUS', true);
        break;
    case OFFER_STATUS_REJECTED :
        $status = __('REJECTED_OFFER_STATUS', true);
        break;
    case OFFER_STATUS_PUBLISHED :
        $status = __('PUBLISHED_OFFER_STATUS', true);
        break;
    default :
        $status = __('UNKNOWN_OFFER_STATUS', true);
        break;
}
 



if (Offer::isFinished($result)) {
    $date = sprintf(__('THE_OFFER_HAS_FINISHED %s', true), $this->Time->format($result['Offer']['end_date'], '%d/%m/%Y'));
    $daten = 3;
} elseif (Offer::isAboutToFinish($result)) {
    $date = sprintf(__('FROM %s TO %s %s days', true), $this->Time->format($result['Offer']['publish_date'], '%d/%m/%Y'), $this->Time->format($result['Offer']['end_date'], '%d/%m/%Y'), $result['Offer']['time_left']);
    $daten = 2;
} elseif ($result['Offer']['time_left'] > DAYS_TO_BE_FINISHING) {
    $date = sprintf(__('FROM %s TO %s %s days', true), $this->Time->format($result['Offer']['publish_date'], '%d/%m/%Y'), $this->Time->format($result['Offer']['end_date'], '%d/%m/%Y'), $result['Offer']['time_left']);
    $daten = 1;
    echo $this->Html->tag('span', $status, array('class' => 'status offer status_' . $result['Offer']['status']));
} else {
    echo $this->Html->tag('span', $status, array('class' => 'status offer status_' . $result['Offer']['status']));
    $date = '-';
    $daten = 0;
}


echo $this->Html->div("status date_status date_$daten", $date);
?>