<?php

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    class AppHelper extends Helper {

        function label($fieldName = null, $text = null, $options = array()) {

            if (empty($fieldName)) {
                $view=ClassRegistry::getObject('view');
                $fieldName=implode('.', $view->entity());
            }

            if ($text === null) {
                if (strpos($fieldName, '.') !== false) {
                    $text=array_pop(explode('.', $fieldName));
                } else {
                    $text=$fieldName;
                }
                if (substr($text, -3) == '_id') {
                    $text=substr($text, 0, strlen($text) - 3);
                }
                $text=__(Inflector::humanize(Inflector::underscore($text)), true);
            }

            if (is_string($options)) {
                $options=array('class' => $options);
            }

            if (isset($options['for'])) {
                $labelFor=$options['for'];
                unset($options['for']);
            } else {
                $labelFor=$this->domId($fieldName);
            }

            return sprintf(
                $this->Html->tags['label'],
                $labelFor,
                $this->_parseAttributes($options), $text
            );
        }

    }

?>
