<?php

    App::import('Helper', 'Form', 'Js');

    class AppHtmlHelper extends HtmlHelper {

        var $helpers=array('Form', 'Js');

        function tag($name, $text = null, $options = array()) {

            if (!empty($options['url'])) {
                $url=$options['url'];
                unset($options['url']);
            }


            if (is_array($options) && isset($options['escape']) && $options['escape']) {
                $text=h($text);
                unset($options['escape']);
            }
            if (!is_array($options)) {
                $options=array('class' => $options);
            }
            if ($text === null) {
                $tag='tagstart';
            } else {
                $tag='tag';
            }

            if (isset($url)) {
                $text = sprintf( $this->tags['link'], $this->url($url), null, $text);
            }
            
            $tag=sprintf($this->tags[$tag], $name, $this->_parseAttributes($options, null, ' ', ''), $text, $name);

            return $tag;
        }
        
        
        function helpMessage($helpText ,$tipText = false ) {
            $tag = $this->div('help-message',  $this->tag('span','',array('class' => 'site-icon small icon-help')) . $helpText);
            if ( $tipText ) {
                $tag .= $this->div('tip-message',  $this->tag('span','',array('class' => 'site-icon small icon-tip'))  . $tipText );
            }   
            return $this->div('form-message' ,$tag );
        }

    }

?>
