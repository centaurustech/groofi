<?

switch ($result['Project']['status']) {
    case PROJECT_STATUS_NEW :
        $status = __('PROPOSAL_PROJECT_STATUS', true);
        break;
    case PROJECT_STATUS_APROVED :
        $status = __('APPROVED_PROJECT_STATUS', true);
        break;
    case PROJECT_STATUS_REJECTED :
        $status = __('REJECTED_PROJECT_STATUS', true);
        break;
    case PROJECT_STATUS_PUBLISHED :
        $status = __('PUBLISHED_PROJECT_STATUS', true);
        break;
    default :
        $status = __('UNKNOWN_PROJECT_STATUS', true);
        break;
}



if (Project::isFinished($result)) { // terminado
    $date = sprintf(__('THE_PROJECT_HAS_FINISHED %s', true), $this->Time->format($result['Project']['end_date'], '%d/%m/%Y'));
    $daten = 3;
} elseif (Project::isAboutToFinish($result)) { // terminando
    $date = sprintf(__('FINISH IN %s days', true), $result['Project']['time_left']);
    $daten = 2;
} elseif ($result['Project']['time_left'] > DAYS_TO_BE_FINISHING) {  // publicado y corriendo
    $date = sprintf(__('FINISH IN %s days', true), $result['Project']['time_left']);
    $daten = 1;
} else {
    $date = '-';
    $daten = 0;
}





if (Project::isPublished($result)) {

    echo $this->Html->div("status date_status date_$daten", $date);
	
	$funded =sprintf(__('%s%% ( USD %s of USD %s )', true), Project::getFundedValue($result), Project::getCollectedValue($result), '%(#10n', $result['Project']['funding_goal']);
 
	$FundedValue = Project::getFundedValue($result, 100);
    $fundedn = $FundedValue >= 100 ? 1 : 0;
    $bar = $this->Html->div('bar', '', array('style' => "width:{$FundedValue}%"));
    $text = $this->Html->div('text', $funded);
    echo ( $funded != '' ? $this->Html->div("graph funded_status funded_$fundedn", $bar . $text) : '' );
} else {
    echo $this->Html->tag('span', $status, array('class' => 'status project status_' . $result['Project']['status']));
}




if (Project::belongsToOffer($result)) {
    echo $this->Html->tag('span', __('OFFER_RESPONSE', true), array('class' => 'status offer_response'));
}
?>