<?php

App::import('Helper', 'Html', 'Js' , 'AppHtml');

class AppFormHelper extends FormHelper {

    var $helpers = array('Html', 'Js' , 'AppHtml');

    
    
    function &_introspectModel($model) {

        $object = parent::_introspectModel($model);
        if (!empty($object) && !empty($object->validate)) {
            $this->fieldset[$object->name]['validationRules'] = $object->validate;
        }
        return $object;
    }

    function nonEditableInput($fieldName, $options = array()) {
        $this->setEntity($fieldName);

        $options = array_merge(
                array('before' => null, 'between' => null, 'after' => null, 'format' => null), $this->_inputDefaults, $options
        );


        $modelKey = $this->model();
        $fieldKey = $this->field();
        if (!isset($this->fieldset[$modelKey])) {
            $this->_introspectModel($modelKey);
        }

        if (!isset($options['type'])) {
            $magicType = true;
            $options['type'] = 'text';
            if (isset($options['options'])) {
                $options['type'] = 'select';
            } elseif (in_array($fieldKey, array('psword', 'passwd', 'password'))) {
                $options['type'] = 'password';
            } elseif (isset($this->fieldset[$modelKey]['fields'][$fieldKey])) {
                $fieldDef = $this->fieldset[$modelKey]['fields'][$fieldKey];
                $type = $fieldDef['type'];
                $primaryKey = $this->fieldset[$modelKey]['key'];
            }

            if (isset($type)) {
                $map = array(
                    'string' => 'text', 'datetime' => 'datetime',
                    'boolean' => 'checkbox', 'timestamp' => 'datetime',
                    'text' => 'textarea', 'time' => 'time',
                    'date' => 'date', 'float' => 'text'
                );

                if (isset($this->map[$type])) {
                    $options['type'] = $this->map[$type];
                } elseif (isset($map[$type])) {
                    $options['type'] = $map[$type];
                }
                if ($fieldKey == $primaryKey) {
                    $options['type'] = 'hidden';
                }
            }
            if (preg_match('/_id$/', $fieldKey) && $options['type'] !== 'hidden') {
                $options['type'] = 'select';
            }

            if ($modelKey === $fieldKey) {
                $options['type'] = 'select';
                if (!isset($options['multiple'])) {
                    $options['multiple'] = 'multiple';
                }
            }
        }
        $types = array('checkbox', 'radio', 'select');

        if (
                (!isset($options['options']) && in_array($options['type'], $types)) ||
                (isset($magicType) && $options['type'] == 'text')
        ) {
            $view = & ClassRegistry::getObject('view');
            $varName = Inflector::variable(
                            Inflector::pluralize(preg_replace('/_id$/', '', $fieldKey))
            );
            $varOptions = $view->getVar($varName);
            if (is_array($varOptions)) {
                if ($options['type'] !== 'radio') {
                    $options['type'] = 'select';
                }
                $options['options'] = $varOptions;
            }
        }

        $autoLength = (!array_key_exists('maxlength', $options) && isset($fieldDef['length']));
        if ($autoLength && $options['type'] == 'text') {
            $options['maxlength'] = $fieldDef['length'];
        }
        if ($autoLength && $fieldDef['type'] == 'float') {
            $options['maxlength'] = array_sum(explode(',', $fieldDef['length'])) + 1;
        }

        $divOptions = array();
        $div = $this->_extractOption('div', $options, true);
        unset($options['div']);

        if (!empty($div)) {
            $divOptions['class'] = 'input';
            $divOptions = $this->addClass($divOptions, $options['type']);
            if (is_string($div)) {
                $divOptions['class'] = $div;
            } elseif (is_array($div)) {
                $divOptions = array_merge($divOptions, $div);
            }
            if (
                    isset($this->fieldset[$modelKey]) &&
                    in_array($fieldKey, $this->fieldset[$modelKey]['validates'])
            ) {
                $divOptions = $this->addClass($divOptions, 'required');
            }
            if (!isset($divOptions['tag'])) {
                $divOptions['tag'] = 'div';
            }
        }

        $label = null;
        if (isset($options['label']) && $options['type'] !== 'radio') {
            $label = $options['label'];
            unset($options['label']);
        }

        if ($options['type'] === 'radio') {
            $label = false;
            if (isset($options['options'])) {
                $radioOptions = (array) $options['options'];
                unset($options['options']);
            }
        }

        if ($label !== false) {
            $label = $this->_inputLabel($fieldName, $label, $options);
        }

        $error = $this->_extractOption('error', $options, null);
        unset($options['error']);

        $selected = $this->_extractOption('selected', $options, null);
        unset($options['selected']);

        if (isset($options['rows']) || isset($options['cols'])) {
            $options['type'] = 'textarea';
        }

        if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time' || $options['type'] === 'select') {
            $options += array('empty' => false);
        }
        if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
            $dateFormat = $this->_extractOption('dateFormat', $options, 'MDY');
            $timeFormat = $this->_extractOption('timeFormat', $options, 12);
            unset($options['dateFormat'], $options['timeFormat']);
        }

        $type = $options['type'];
        $out = array_merge(
                array('before' => null, 'label' => null, 'between' => null, 'input' => null, 'after' => null, 'error' => null), array('before' => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after'])
        );
        $format = null;
        if (is_array($options['format']) && in_array('input', $options['format'])) {
            $format = $options['format'];
        }
        unset($options['type'], $options['before'], $options['between'], $options['after'], $options['format']);


        $input = $this->hidden($fieldName, $options); // always create a hidden field with value
        $fakeFieldOptions = $this->_initInputField($fieldName, $options);


        if (isset($options['options']) && $type == 'select') {
            $fakeFieldOptions['value'] = $options['options'][$fakeFieldOptions['value']];
        } else {
            $fakeFieldOptions['value'] = !empty($fakeFieldOptions['value'] ) ? $fakeFieldOptions['value']  : '&nbsp;' ; 
        }
        
        
        $input .= $this->Html->tag('span', $fakeFieldOptions['value'] ,array('class'=>"fakeField $fieldName $type "));

        /*
          switch ($type) {
          case 'hidden':
          $input=$this->hidden($fieldName, $options);
          $format=array('input');
          unset($divOptions);
          break;
          case 'checkbox':
          $input=$this->checkbox($fieldName, $options);
          $format=$format ? $format : array('before', 'input', 'between', 'label', 'after', 'error');
          break;
          case 'radio':
          $input=$this->radio($fieldName, $radioOptions, $options);
          break;
          case 'text':
          case 'password':
          case 'file':
          $input=$this->{$type}($fieldName, $options);
          break;
          case 'select':
          $options += array('options' => array());
          $list=$options['options'];
          unset($options['options']);
          $input=$this->select($fieldName, $list, $selected, $options);
          break;
          case 'time':
          $input=$this->dateTime($fieldName, null, $timeFormat, $selected, $options);
          break;
          case 'date':
          $input=$this->dateTime($fieldName, $dateFormat, null, $selected, $options);
          break;
          case 'datetime':
          $input=$this->dateTime($fieldName, $dateFormat, $timeFormat, $selected, $options);
          break;
          case 'textarea':
          default:
          $input=$this->textarea($fieldName, $options + array('cols' => '30', 'rows' => '6'));
          break;
          }
         */
        if ($type != 'hidden' && $error !== false) {
            $errMsg = $this->error($fieldName, $error);
            if ($errMsg) {
                $divOptions = $this->addClass($divOptions, 'error');
                $out['error'] = $errMsg;
            }
        }

        $out['input'] = $input;
        $format = $format ? $format : array('before', 'label', 'between', 'input', 'after', 'error');
        $output = '';
        foreach ($format as $element) {
            $output .= $out[$element];
            unset($out[$element]);
        }

        if (!empty($divOptions['tag'])) {
            $tag = $divOptions['tag'];
            unset($divOptions['tag']);
            $output = $this->Html->tag($tag, $output, $divOptions);
        }
        
        return $output;
    }

    private function __setDefault(&$default, $type=false, $override=false) {
        if (empty($default)) {
            if (!$override) {
                switch ($type) {
                    case 'String' : $default = "";
                        break;
                    case 'Boolean' : $default = false;
                        break;
                    case 'Array' : $default = array();
                        break;
                }
            } else {
                $default = $override;
            }
        }
    }

    private function __setType(&$value, $type=false) {
        if ($type == 'Boolean') {
            $value = $value == '1' || strtolower($value) == 'true' ? true : false;
        } else {
            $value = $value;
        }
    }

    private function __initOptions($method, &$options, $unsetEmpty=false, $unsetOptions=false) {
        foreach ($this->{$method . 'Options'} as $option) {
            list($option, $type) = explode(':', $option);
            @list($type, $default) = explode('=', $type);
            $this->__setDefault($default, $type);
            $this->__setType($default, $type);
            $options[$option] = isset($options[$option]) ? $options[$option] : @$default;

            //debug("$option:$type:{$options[$option]}");
            if (!$unsetEmpty) {
                $ret[$option] = $options[$option];
            } else if (!empty($options[$option]) || $options[$option] === false) {
                $ret[$option] = $options[$option];
            }

            if (!$unsetOptions) {
                unset($options[$option]);
            }
        }
        return $ret;
    }

    /**
     * Returns a formatted LABEL element for HTML FORMs. Will automatically generate
     * a for attribute if one is not provided.
     *
     * @param string $fieldName This should be "Modelname.fieldname"
     * @param string $text Text that will appear in the label field.
     * @param mixed $options An array of HTML attributes, or a string, to be used as a class name.
     * @return string The formatted LABEL element
     * @link http://book.cakephp.org/view/1427/label
     */
    function label($fieldName = null, $text = null, $options = array()) {

        $view = ClassRegistry::getObject('view');
        if (empty($fieldName)) {
            $fieldName = implode('.', $view->entity());
        }

        if ($text === null) {
            if (strpos($fieldName, '.') !== false) {
                $text = str_replace('.', '__', $fieldName);
            } else {
                $text = $fieldName;
            }
            if (substr($text, -3) == '_id') {
                $text = substr($text, 0, strlen($text) - 3);
            }
            $text = __(up($text), true);
        } else {
            $text = __(up($text), true);
        }

        if (is_string($options)) {
            $options = array('class' => $options);
        }

        if (isset($options['for'])) {
            $labelFor = $options['for'];
            unset($options['for']);
        } else {
            $labelFor = $this->domId($fieldName);
        }

        return sprintf(
                $this->Html->tags['label'], $labelFor, $this->_parseAttributes($options), $text
        );
    }

    function __url($fieldName, $options = array()) {
        $options = $this->_initInputField($fieldName, array_merge(
                                array('type' => 'text'), $options
                        ));
        return sprintf(
                $this->Html->tags['input'], $options['name'], $this->_parseAttributes($options, array('name'), null, ' ')
        );
    }

    function create($model = null, $options = array()) {
        $options = array_merge(
                array(
            'inputDefaults' => array(
                'autocomplete' => 'off',
                'error' => array(
                    'notEmpty' => __('NOT_EMPTY_GENERIC_ERROR', true),
                    'minLength' => __('MIN_LENGHT_GENERIC_ERROR', true),
                    'minLength_3' => __('MIN_LENGHT_3_ERROR', true),
                    'maxLength' => __('MAX_LENGTH_GENERIC_ERROR', true),
                    'maxLength_50' => __('MAX_LENGTH_50_ERROR', true),
                    'url' => __('URL_GENERIC_ERROR', true),
                    'email' => __('EMAIL_GENERIC_ERROR', true),
                    'VideoUrl' => __('THIS_VIDEO_SITE_URL_IT_IS_NOT_VALID', true),
                )
            )
                ), $options
        );


        return parent::create($model, $options);
    }

    var $autoCompleteOptions = array(
        'delay:Number=150',
        'minLength:Number=3',
        'limit:Number=10',
        'source:Function',
        'url:String',
        'data:Array',
        'extraData:Object',
        'search:Function',
        'open:Function',
        'focus:Function',
        'select:Function',
        'close:Function',
        'change:Function'
    );

    function autoComplete($fieldName, $options =false, $fieldOptions=array()) {

        if (strstr($fieldName, '.')) {
            list( $modelName, $fieldName ) = explode('.', $fieldName);
        } else {
            $this->setEntity($fieldName);
            $view = & ClassRegistry::getObject('view');
            $entity = $view->entity();
            $modelName = $entity[0];
            $entity = join('.', $entity);
        }

        unset($fieldOptions['id']);

        $helper_options = $this->__initOptions('autoComplete', $options, false, true);
        $domFieldName = $modelName . '.' . $fieldName;
        $helper_options['domFieldName'] = isset($fieldOptions['id']) ? $fieldOptions['id'] : $this->domId($domFieldName);
        $idFieldName = $domFieldName . '_id';
        $helper_options['idFieldName'] = $this->domId($idFieldName);


        $fieldOptions['after'] = isset($fieldOptions['after']) ? $fieldOptions['after'] : '';

        $fieldOptions['after'] .= $this->input($idFieldName, array('type' => 'hidden'));

        $code = $this->input($domFieldName, $fieldOptions);



        $jsCode = '$("#:domFieldName").autocomplete({
                    source: :source ,
                    minLength: :minLength ,
                    delay: :delay ,
                    search: :search ,
                    open: :open ,
                    focus: :focus ,
                    select: :select ,
                    close: :close ,
                    change: :change
            });';





        if (!empty($helper_options['source'])) {
            $source = $helper_options['source'];
        } elseif (!empty($helper_options['url'])) {
            $f = 'function(request, response) {
                    $.ajax({
                        url: ":url" ,
                        dataType: "jsonp",
                        data: {
                            maxRows: :limit,
                            q: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                //console.log(item)
                                return {
                                    label : item.label ,
                                    value : item.value ,
                                    id : item.id,
                                    country : item.country,
                                    country_id : item.country_id
                        }}))}})}';

            $f = String::insert($f, $helper_options);
            $helper_options['source'] = $f;
            unset($helper_options['url']);
        } elseif (!empty($helper_options['data'])) {
            $helper_options['source'] = $helper_options['data'];
            unset($helper_options['data']);
        } else {
            var_dump('Not source defined');
        }

        if (empty($helper_options['search'])) {
            $helper_options['search'] = 'function() {} ';
        }
        if (empty($helper_options['open'])) {
            $helper_options['open'] = String::insert('function() { $("#:idFieldName").val(""); }', $helper_options);
        }
        if (empty($helper_options['focus'])) {
            $helper_options['focus'] = ' function() {} ';
        }
        if (empty($helper_options['select'])) {
            $helper_options['select'] = String::insert(' function(event, ui) { $("#:idFieldName").val( ui.item ? ui.item.id : "");} ', $helper_options);
        }
        if (empty($helper_options['close'])) {
            $helper_options['close'] = 'function() { }';
        }
        if (empty($helper_options['change'])) {
            $helper_options['change'] = ' function() {} ';
        }

        $jsCode = String::insert($jsCode, $helper_options);


        $this->Js->buffer(
                $jsCode
        );


        return $code;
    }

    function inputTip($fieldName, $options = array()) {
        
        if (strpos($fieldName, '.') !== false) {
            $text = str_replace('.', '__', $fieldName);
        } else {
            $text = $fieldName;
        }
        if (substr($text, -3) == '_id') {
            $text = substr($text, 0, strlen($text) - 3);
        }
    
        if (isset($this->data[$this->model()]['id'] ) ){
            $prefix = 'EDIT' ;
        } else {
            
            $prefix = '' ; //ADD
        }
       // vd(up($text . '_'.$prefix.'_HELP_MESSAGE_TEXT'));
        $helpText = isset($options['helpMessage']) ? $options['helpMessage'] : __(up($text . '_'.$prefix.'_HELP_MESSAGE_TEXT'), true);
        $tipText  = isset($options['tipMessage']) ? $options['tipMessage'] :__(up($text . '_'.$prefix.'_TIP_MESSAGE_TEXT'), true);
        

        $options = array_merge(
                array('before' => null, 'between' => $this->Html->helpMessage($helpText,$tipText) , 'after' => null
            
            , 'format' => null), $this->_inputDefaults, $options
        );

        return parent::input($fieldName, $options);
    }
    
    
     

}

?>
