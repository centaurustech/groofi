<?

    /* @var $this ViewCC */


    if (!isset($this->Html) || !is_a($this->Html, 'HtmlHelper')) {
        $message='Attachments Element - The Html helper is not loaded but required.';
        trigger_error($message, E_USER_NOTICE);
        return;
    }

    if (!isset($this->Form) || !is_a($this->Form, 'FormHelper')) {
        $message='Attachments Element - The Form helper is not loaded but required.';
        trigger_error($message, E_USER_NOTICE);
        return;
    }

    if (!isset($model)) {
        $model=$this->Form->model();
    }
    $modelId=$this->Form->value($this->Form->model() . '.id'); // Este no lo tenia...

    $assocAlias=(isset($assocAlias) ? ucfirst($assocAlias) : Inflector::singularize($model)) . '.';
    $elements=isset($elements) ? $elements : 1;
    $start=isset($start) ? $start : 0;
    $unique=isset($unique) ? $unique : false;


    $myOptions=array('div' => false , 'label' => false );

    $opt=isset($options) ? Set::merge($options, $myOptions) : $myOptions;

    $fieldName='.' . ( isset($fieldName) ? $fieldName : 'link' );
    $content  = '' ;

    if (!$unique) {
        for ($key=0; $key < $elements; $key++) {
            $opt['error'] = array(
				'url'      => __('THE_URL_IS_NOT_VALID', true),
				'notEmpty'   => __('THE_FIELD_IS_REQUIRED', true)
            );

            $content .= $this->Form->input( $assocAlias . ($start + $key) .  '.model', array('value' => Inflector::classify( $this->name ) , 'type' => 'hidden' ) ) ;

            $content .= $this->Form->input( $assocAlias . ($start + $key) . $fieldName, $opt) ;
            
        }
    } else {
        $content .=  $this->Form->input($assocAlias . $fieldName, $opt);
    }

    $fieldName = preg_replace( '/^\./',  '', $fieldName);
    echo $this->Html->div( 'input text url', (isset($options['label']) ? $options['label']  : (__(up(Inflector::pluralize($fieldName) . '_title') ,true ))). $content );
?>
