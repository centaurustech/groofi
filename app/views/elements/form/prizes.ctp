<?php

/* @var $this ViewCC */


if (!isset($this->Html) || !is_a($this->Html, 'HtmlHelper')) {
    $message = 'Attachments Element - The Html helper is not loaded but required.';
    trigger_error($message, E_USER_NOTICE);
    return;
}

if (!isset($this->Form) || !is_a($this->Form, 'FormHelper')) {
    $message = 'Attachments Element - The Form helper is not loaded but required.';
    trigger_error($message, E_USER_NOTICE);
    return;
}

if (!isset($model)) {
    $model = $this->Form->model();
}
$modelId = $this->Form->value($this->Form->model() . '.id'); // Este no lo tenia...

$assocAlias = (isset($assocAlias) ? ucfirst($assocAlias) : Inflector::singularize($model)) . '.';

$elements = count($base_prizes);

$start = isset($start) ? $start : 0;
$unique = isset($unique) ? $unique : false;


$myOptions = array('div' => false, 'label' => false);

$opt = isset($options) ? Set::merge($options, $myOptions) : $myOptions;

$fieldName = '.' . ( isset($fieldName) ? $fieldName : 'description' );



if (isset($this->data[$this->Form->model()]['id'])) {

    $prefix = 'EDIT';
} else {

    $prefix = ''; //ADD
}

// aca va el tema de el help 


        $helpMessage = isset($helpMessage) ? $helpMessage : __(up($model. '__PRIZE_' . $prefix .'_HELP_MESSAGE_TEXT'), true) ;
        $tipMessage = isset($tipMessage) ? $tipMessage : __(up($model. '_-PRIZE_' . $prefix .'_TIP_MESSAGE_TEXT'), true) ;

        $content='';

$rows = '' ;
$rows .= $this->Html->tag('span', __('Prize_VALUE', true), array('class' => 'value'));
$rows .= $this->Html->tag('span', __('Prize_TEXT', true), array('class' => 'prize'));



if (!$unique) {
    for ($key = 0; $key < $elements; $key++) {


        $opt['error'] = false; 
        /* array(
          'integer'      => __('THE_URL_IS_NOT_VALID', true),
          'default'   => __('THE_FIELD_IS_REQUIRED', true)
          ); */

        $opt['label'] = false;
        $opt['div'] = false;
        $opt['class'] = 'prize';

        $divContent = $this->Form->input($assocAlias . ($start + $key) . '.model', array('value' => Inflector::classify($this->name), 'div' => false, 'label' => false, 'type' => 'hidden'));



        $divContent .= $this->Form->input($assocAlias . ($start + $key) . '.value', array('class' => 'value', 'error' => false, 'label' => false, 'div' => false, 'type' => 'select' , 'empty' => true ,  'options' => $base_prizes ));

        $divContent .= $this->Form->input($assocAlias . ($start + $key) . $fieldName, $opt);

        $errors = $this->Form->error($assocAlias . ($start + $key) . '.value', null, array('warp' => false)) . $this->Form->error($assocAlias . ($start + $key) . $fieldName, null, array('warp' => false));

        $divContent .= $this->Html->div('error-message', $errors);

        $divContent .= $this->Html->div("clearfix", '');

        $divContent = $this->Html->div('row', $divContent, array('id' => "row_$key"));
        $rows .= $divContent; 
    }
    $content .= $this->Html->div('rows' ,$rows . $this->Html->div('clearfix' , '' ) . $this->Form->error( $model . '.prize' )) ;
} else {
    $content .= $this->Form->input($assocAlias . $fieldName, $opt);
}
$content .= $this->Html->helpMessage($helpMessage,$tipMessage) .  $this->Html->div("clearfix", '');



// ,array('style'=>'display:none')
$fieldName = preg_replace('/^\./', '', $fieldName);

echo $this->Html->div('input text prize', $this->Html->div('title', (isset($options['label']) ? $options['label'] : (__(up(Inflector::pluralize($fieldName) . '_title'), true)))) . $content);
?>