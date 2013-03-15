<?

class ModulesHelper extends Helper {

    var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Js');

    private function __defaultSet(&$var, $value) {
        $var = @$var ? $var : $value;
        return $var;
    }

    private function __initOptionsJS($method, &$options, $unsetEmpty=false) {
        foreach ($this->{$method . 'Options'} as $option) {
            list($option, $type) = explode(':', $option);
            @list($type, $default) = explode('=', $type);
            if ($default) {
                $this->__setDefault($default, $type);
                $this->__setType($default, $type);
                $options[$option] = !empty($options[$option]) ? $options[$option] : $default;
            }
            if (isset($options[$option])) {
                $this->__setTypeJS($options[$option], $type);
            }

            if (!$unsetEmpty) {
                $ret[$option] = $options[$option];
            } else if (isset($options[$option])) {
                $ret[$option] = $options[$option];
            }
            unset($options[$option]);
        }
        return $ret;
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

    private function __jsObject($data = array()) {
        $aux = 1;
        $str = '';
        foreach ($data as $key => $value) {
            $sep = $aux < count($data) ? ",\n\t\t " : '';
            $str .= "{ id : '$key' , value : '$value'}$sep";
            $aux++;
        }
        $data = count($data) >= 2 ? "[ \n\t\t" . $str . "\n ]" : '[ ' . $str . "]";
        return $data;
    }

    private function __jsObjectAssociative($data = array()) {
        $aux = 1;
        $str = '';
        foreach ($data as $key => $value) {
            $sep = $aux < count($data) ? ",\n\t\t " : '';
            $str .= "'$key' : '$value'$sep";
            $aux++;
        }
        $data = count($data) >= 2 ? "{ \n\t\t" . $str . "\n }" : '{ ' . $str . "}";
        return $data;
    }

    function breadcrumbs($url, $options = array()) {
        @list($prefix, $controller, $view) = explode('/', $this->params['url']['url']);
        $prefix_text = __(up(str_replace('admin_admin', 'admin', low(isset($options['area']) ? $options['area'] . '_' . $prefix : 'admin_' . $prefix))), true); // OK
        $controller = $controller ? $controller : ADMIN_DEFAULT_HOME; // "/admin"// OK
        $controller_text = __(up(isset($options['area']) ? $options['area'] . '_' . $controller : 'admin_' . $controller ), true); // OK


        $view_text = isset($options['prefix']) ? $options['prefix'] . '_' . $view : 'admin_' . $view;
        $view_text = isset($options['view']) ? $options['view'] : $view_text;
        $view_text = isset($options['filter']) ? $options['filter'] . '_' . $view_text : $view_text;

 		/* echo '<pre>';
         // var_dump( $prefix, $prefix_text , $prefix_link , $controller , $controller_text , $controller_link , $view , $view_text , $bread);
		 echo $view_text;
          echo '</pre>';*/
        $view_text = __(up(preg_replace("/_$/", '_index', $view_text)), true);
		 /*echo '<pre>';
         var_dump( $prefix, $prefix_text , $prefix_link , $controller , $controller_text , $controller_link , $view , $view_text , $bread);
		 //echo $view_text;
          echo '</pre>';*/
        $prefix_link = $this->Html->link($prefix_text, '/' . $prefix);
        $controller_link = $this->Html->link($controller_text, '/' . $prefix . '/' . $controller);
        $separator = $this->Html->tag('span', (isset($options['separator']) ? $options['separator'] : '&nbsp;>&nbsp;'));
        $bread = implode($separator, array($prefix_link, $controller_link, $view_text));
        $bread = $bread . ( @$options['after'] ? $separator . $options['after'] : '' );
        
        
        


        echo $this->Html->tag((@$options['tag'] ? $options['tag'] : 'h3'), $bread, array('class' => 'breadcrumb title underline full'));
    }

    var $fileTypes = array();
    var $ajaxUploaderOptions = array(
        'thumb:String=img/assets/thumb_nophoto.png'
        , 'thumbWidth:Number=96'
        , 'thumbHeight:Number=96'
        , 'thumbClass:String=uploaderImageCntr'
        , 'description:String'
        , 'descriptionClass:String=description'
        , 'UpdloadDescription:String'
        , 'label:String'
        , 'uploadUrl:String'
        , 'fileExt:String'
        , 'fileDesc:String'
        , 'fullSizeLink:Boolean=false'
        , 'showDelete:String='
        , 'hasComment:Boolean=true'
        , 'buttonText:String=Browse'
        , 'debug:Boolean=false'
        , 'flashThumb:Boolean=false'
        , 'btnWidth:Number=110'
        , 'btnHeight:Number=30'
    );

    //function

    function ajaxUploader($fieldName, $id = null, $options=array()) {


        if (strstr($fieldName, '.')) {
            list( $modelName, $fieldName ) = explode('.', $fieldName);
        } else {
            $this->setEntity($fieldName);
            $view = & ClassRegistry::getObject('view');
            $entity = $view->entity();
            $modelName = $entity[0];
            $entity = join('.', $entity);
        }



        $helper_options = $this->__initOptions('ajaxUploader', $options, false, true);
        $domFieldName = $this->Form->domId($fieldName);

        $uploadUrl = $helper_options['uploadUrl'] ? $helper_options['uploadUrl'] : '/' . low(Inflector::pluralize($modelName)) . '/upload/' . $fieldName . '/' . ( $id ? $id : 'tmp' );
        $hasComment = $helper_options['hasComment'];
        $showComment = "show";
        if ($this->data && ( $helper_options['thumb'] || $helper_options['flashThumb'] )) {
            if (array_key_exists($modelName, $this->data)) {
                if (array_key_exists($fieldName, $this->data[$modelName]) && $this->data[$modelName][$fieldName] != '') {
                    $helper_options['thumb'] = $this->data[$modelName][$fieldName];
                } else {
                    $showComment = "hide";
                }
            } else {
                $showComment = "hide";
            }
        } else {
            if (@$this->data[$modelName][$fieldName] == '') {
                $showComment = "hide";
            } else {
                $showComment = "show";
            }
        }



        $before = $helper_options['label'] === false ? '' : $this->Form->label($fieldName, !empty($helper_options['label']) ? $helper_options['label'] : null);
        $before .= $helper_options['description'] ? $this->Html->div($helper_options['descriptionClass'], $helper_options['description']) : '';


        if ($helper_options['thumb'] && !$helper_options['flashThumb']) {

            $thumb = $this->Html->image($this->MagickConvert->resizeAndCrop($helper_options['thumb'], $helper_options['thumbWidth'], $helper_options['thumbHeight'], false), array('id' => $domFieldName . '_thumbImage', 'class' => $helper_options['thumbClass'], 'width' => $helper_options['thumbWidth'], 'height' => $helper_options['thumbHeight']));

            if ($helper_options['fullSizeLink']) {
                $full = $this->MagickConvert->resize($helper_options['thumb'], 1024, 768, false, array(), array('class' => 'thumb'));


                $before .= $this->Html->link($thumb, $full, array('class' => 'thumb', 'target' => '_blank', 'escape' => false));
            } else {
                $thumb .= $this->Html->div('uploading', $this->Html->image(ASSETS_SERVER . '/img/static/assets/loading.gif', array('style' => 'top:0px;right:0px;position:absolute;'))
                                , array(
                            'style' => 'display:none;text-align:center;position:absolute;top:0px;left:0px;width:' . $helper_options['thumbWidth'] . 'px;height:' . $helper_options['thumbHeight'] . 'px;'
                        ));

                $before .= $this->Html->div('ctnr', $thumb, array('style' => 'position:relative'));
            }
        }

        $before = $this->Html->div('before', $before);
        $after = $hasComment ? $this->Form->input($fieldName . 'Comment', array('id' => $domFieldName . '_Comment', 'label' => false, 'after' => $helper_options['UpdloadDescription'] ? $this->Html->div('message-description', $helper_options['UpdloadDescription'], array('id' => $domFieldName . '_UpdloadDescription', 'style' => 'display:none;')) : '')) : '';


        $after .= $helper_options['debug'] ? $this->Html->div('UploadLog', ' ', array('id' => 'response_' . $domFieldName)) : '';

        $after .= '';

        if ($helper_options['showDelete'] != '' && $this->data[$modelName][$fieldName] != '') {
            $after .= $this->Html->link(__('Delete media', true), $helper_options['showDelete'], array('class' => 'ajax delete link'));
        }



        $after .= $this->Form->input($fieldName, array('type' => 'hidden', 'div' => false, 'label' => false));



        //if (!$id){
        $after .= $this->Form->input($fieldName . '_id', array('type' => 'hidden')
        );
        //}


        $ajaxUploader = $this->Form->input(
                        $fieldName . 'File', array_merge(
                                $options
                                , array(
                            'type' => 'file'
                            , 'label' => false
                            , 'div' => array('style' => 'width:100%;')
                            , 'before' => $before
                            , 'after' => $after . $this->Form->error($fieldName . '_id') . $this->Form->error($fieldName))
                        )
        );

        $javaScript = <<<EOD
 				// <![CDATA[
				$(document).ready(function() {
					$('#:domFieldNameFile').uploadify({
						uploader  : '/swf/uploadify.swf',
						script    : ':uploadUrl',
						cancelImg : ':assets_server/img/static/icons/small_icon_close.png',
                                                 :flashThumb
						auto        : true ,
						width        : ':btnWidth' ,
						heigth        : ':btnHeight' ,
						method      : 'POST',
						queueSizeLimit      : 1,
						buttonText  : ':buttonText' ,
						fileDataName      : 'data[:fieldName][]' ,
						multi      : false ,
						fileExt    : ':fileExt' ,
						fileDesc   : ':fileDesc' ,
						scriptData   : {sk : ':sesKey', CAKESESSION :':sesKey' } ,
						onInit  : function (){
                            $('input#:domFieldName').attr('name',':domFieldName');
                            $('#:domFieldName_Comment').:showComment();
                            $('#:domFieldName_UpdloadDescription').:showComment();
                            $('#:domFieldNameUploader').css('float','left');
						},
						onSelect  : function (){
                            $('#:domFieldName_Comment').hide();
                            $('#:domFieldName_UpdloadDescription').hide();
                            $('.uploading').show();


						}, 

						onComplete : function (event , queueID ,fileObj ,response , data ) {
                            rJ = response.split('::');
                            rJson = {} ;
                            for(a in rJ ){
                                rJ[a] = String(rJ[a]).split('|');
                                rJson[rJ[a][0]] = rJ[a][1];
                            }
                            $('#:domFieldName_UpdloadDescription').show();

                            $('#:domFieldName_thumbImage').attr( 'src' , rJson['image_thumb'] );

                            $('#:domFieldNameId').val(rJson['id']);

                            $('#:domFieldName_Comment').show();
                            $('#:domFieldName_UpdloadDescription').show();
                            $('.uploadifyQueue > div').remove();
                            $('.uploading').hide();
                            :tAction
                            :debug
						}
					});
				});
				// ]]>
EOD;

        $javaScript = String::insert($javaScript, array('flashThumb' => ( $helper_options['flashThumb'] ? " 'buttonImg' : ':thumb' , 'width' : :tWidth , 'height' : :tHeight ,  " : '' )));
        $javaScript = String::insert($javaScript, array(
                    'thumb' => $this->MagickConvert->resizeAndFill($helper_options['thumb'], $helper_options['thumbWidth'], $helper_options['thumbHeight'], false)
                    , 'tWidth' => $helper_options['thumbWidth']
                    , 'tHeight' => $helper_options['thumbHeight']
                    , 'tAction' => $helper_options['flashThumb'] ? "$('#:domFieldName').uploadifySettings('buttonImg',response);" : ''
                        )
        );

        $javaScript = String::insert($javaScript, array('debug' => ( $helper_options['debug'] ? "$('#response_:domFieldName').html(response);" : '' )));

        $javaScript = String::insert($javaScript, array(
                    'buttonText' => $helper_options['buttonText'],
                    'showComment' => $showComment,
                    'fieldName' => $fieldName,
                    'domFieldName' => $domFieldName, //.'File',
                    'uploadUrl' => $uploadUrl,
                    'btnWidth' => $helper_options['btnWidth'],
                    'btnHeight' => $helper_options['btnHeight'],
                    'fileExt' => $helper_options['fileExt'],
                    'fileDesc' => $helper_options['fileDesc'],
                    'assets_server' => ASSETS_SERVER,
                    'sesKey' => $this->Session->id()
                        )
        );

        if ($helper_options['debug']) {
            // print_r('<pre>'. htmlentities($javaScript).'</pre>');
        }
        $javaScript = $this->Javascript->codeBlock($javaScript, array('allowCache' => false, 'safe' => true, 'inline' => true));
        $rnd = Security::hash(rand(9999, 99999), 'sha1');
        return $ajaxUploader . $javaScript;
    }

    /**
     *  Ajax AutoComplete for jQuery
     *
     *  Creates a autocomplete field.
     *
     *  @author : Dario Gaston Musante
     *  @param string $fieldName  The field name
     *  @param mixed $data Array of values or value resource url.
     *  @param mixed $data Array of values or value resource url.
     *  @param mixed $data Array of values or value resource url.
     *  @return string A HTML input tag.
     *  @access public
     *
     *   See /webroot/css/autocomplete/autocomplete.css
     *   $autoCompleteOptions Doc in http://docs.jquery.com/Plugins/Autocomplete/autocomplete#url_or_dataoptions
     * */
    // this should be here to have a reference about the function options.
    // Extra option -> fieldId ( set's ID in hidden field )


    /*
      var $autoCompleteOptions = array(
      'autoFill:Boolean',
      'cacheLength:Number',
      'delay:Number',
      'extraParams:Object',
      'formatItem:Function',
      'formatMatch:Function',
      'formatResult:Function',
      'highlight:Function',
      'matchCase:Boolean',
      'matchContains:Boolean',
      'matchSubset:Boolean',
      'max:Number',
      'minChars:Number',
      'multiple:Boolean',
      'multipleSeparator:String',
      'mustMatch:Boolean',
      'scroll:Boolean',
      'scrollHeight:Number',
      'selectFirst:Boolean',
      'width:Number'
      );
     */

    var $autoCompleteOptions = array(
        'delay:Number=300',
        'minLength:Number=1',
        'limit:Number=50',
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
        $helper_options['domFieldName'] = isset($fieldOptions['id']) ? $fieldOptions['id'] : $this->Form->domId($domFieldName);
        $idFieldName = $domFieldName . '_id';
        $helper_options['idFieldName'] = $this->Form->domId($idFieldName);
        //$fieldOptions['id'] = $domFieldName ; //$fieldName . '_' . rand(9999,999999) ;
        //$fieldOptions['multiple'] = false; //$fieldName . '_' . rand(9999,999999) ;
        // var_dump($helper_options['domFieldName']);

        $code = $this->Form->input($domFieldName, $fieldOptions);
        $code .= $this->Form->input($idFieldName, array(
                    'type' => 'hidden'
                        )
        );
        /*
          function(request, response) {
          $.ajax({
          url: "http://sn.gv/services/cities/query.php" , //"http://ws.geonames.org/searchJSON",
          dataType: "jsonp",
          data: {
          maxRows: 12,
          q: request.term
          },
          success: function(data) {
          response($.map(data, function(item) { //.geonames
          return {
          label : item.label ,
          value : item.value ,
          id : item.id ,
          }
          }))
          }
          })
          }
         */
        $jsCode = <<<EOD
            $("#:domFieldName").autocomplete({
                    source: :source ,
                    minLength: :minLength ,
                    delay: :delay ,
                    
                    search: :search ,
                    open: :open ,
                    focus: :focus ,
                    select: :select ,
                    close: :close ,
                    change: :change 
            });
EOD;





        if (!empty($helper_options['source'])) {
            $source = $helper_options['source'];
        } elseif (!empty($helper_options['url'])) {
            $f = <<<EOD
            function(request, response) {
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
                                id : item.id
                            }
                        }))
                    }
                })
            }
EOD;
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

        //var_dump($helper_options);



        $jsCode = String::insert($jsCode, $helper_options);

        //print_r($jsCode);

        $this->Js->buffer(
                //$this->Js->domReady(
                $jsCode
                //)
        );


        return $code;
        /*

          $codeExtra = '';
          if (is_array($data)) {
          if (@$options['fieldId']) {
          $data = $this->__jsObject($data);
          $hiddenID = $this->Form->domId($fieldName . '_id');       //; $options['fieldId'] . '_' . rand(9999,999999) ;
          $code .= $this->Form->input($options['fieldId'], array('type' => 'hidden', 'options' => '', 'id' => $hiddenID));
          $codeExtra = "$('#" . $fieldOptions['id'] . "').result(function(event, data, formatted) {
          if (data){
          $('#$hiddenID').val( data.id ) ;
          } else {
          $('#$hiddenID').val('');
          }
          }).blur(function(){
          $(this).search();
          });";
          $options['autoFill'] = 'false';
          $options['formatMatch'] = "function(row, i, max) {return row.value;}";
          $options['formatResult'] = "function(row){ return row.value; }";
          $options['formatItem'] = "function( row , i , max , term ) {  return row.value }";
          unset($options['fieldId']);
          } else {
          $data = "['" . implode("','", $data) . "']";
          }
          } else {
          $data = "'$data'";
          if (@$options['fieldId']) {
          $hiddenID = $this->Form->domId($fieldName . '_id');       //; $options['fieldId'] . '_' . rand(9999,999999) ;
          $code .= $this->Form->input($options['fieldId'], array('type' => 'hidden', 'options' => '', 'id' => $hiddenID));
          $codeExtra = "$('#" . $fieldOptions['id'] . "').result(function(event, data, formatted) {
          if (data){
          $('#$hiddenID').val( data[1] ) ;
          } else {
          $('#$hiddenID').val('');
          }
          }
          ).blur(function(){
          if ( $('#$hiddenID').val() == '' ) {
          $(this).search();
          }
          });";
          unset($options['fieldId']);
          }
          }


          $helper_options = $this->__initOptionsJS('autoComplete', $options, true);
          $jsCode = "$(document).ready(function() {\n";
          $jsCode .= "\n\t$('#" . $fieldOptions['id'] . "').autocomplete( $data ";
          $aux = 1;
          foreach ($helper_options as $key => $option) {
          $jsCode .= $aux == 1 ? ", \n\t{\n" : "";
          $sep = $aux < count($helper_options) ? ' ,' : '';
          $jsCode .= "\t\t'$key' :" . $option . "$sep\n";
          $jsCode .= $aux == count($helper_options) ? "\t}" : "";
          $aux++;
          }
          $jsCode = str_replace(", {\n\t}", '', $jsCode);
          $jsCode .= ");\n" . $codeExtra . "\n";
          $jsCode .= "});\n";
          //  $code .=  $this->Javascript->link('autocomplete/autocomplete', false);
          //  $code .=  $this->Html->css('autocomplete/autocomplete' , 'stylesheet' , array() , false );
          $code .= $this->Javascript->codeBlock($jsCode, array('inline' => false));
          return $code;
         */
    }

    private function __setTypeJS(&$value, $type=false) {
        if ($type == 'Boolean') {
            $value = $value == true ? 'true' : 'false';
        } elseif ($type == 'Object') {
            $value = is_array($value) ? $this->__jsObjectAssociative($value) : $value;
        } elseif ($type == 'String') {
            $value = "'" . $value . "'";
        } elseif ($type == 'Function') {
            $value = !$value ? 'false' : $value;
        }
    }

    function adminMenu($menu) {
        $ret = '';
        $first = 0;

        foreach ($menu as $menuName => $menuItem) {
            $link = array();
            $header = true;
            foreach ($menuItem as $title => $value) {
                if ($header) {
                    $hasArrow = count($menu[$menuName]) == 1 ? false : true;

                    $span = $hasArrow ? $this->Html->tag('span', '&raquo;', array('class' => 'sf-sub-indicator')) : '';

                    // $action = $value['action'];
                    $url = array_key_exists('url', $value) ? $value['url'] : false;

                    if (is_string($url)) {
                        
                    } elseif (is_array($url)) {
                        
                    }
                    $link[] = $this->Html->link(
                                    ( is_string($title) ? __($title, true) : ( array_key_exists('text', $value) ? $value['text'] : '&nbsp;') ) . $span
                                    , $url
                                    , array(
                                'class' => ( $hasArrow ? 'sf-with-ul' : '' ) . ' ' . ( array_key_exists('extra_class', $value) ? $value['extra_class'] : '')
                                , 'escape' => false
                                    )
                    );

                    $header = false;
                    $first++;
                } else {
                    if (is_array($value)) {

                        foreach ($value as $title => $subitem) {
                            $url = array_key_exists('url', $subitem) ? $subitem['url'] : false;
                            $link[] = $this->Html->link($title, $url, array('escape' => false));
                        }
                    } else {
                        //vd($value);
                    }
                }
            }
            $aux = array_shift($link);


            foreach ($link as $key => $item) {
                $link[$key] = $this->Html->tag('li', $item, array('class' => 'sf-menu-item ' . ($key == 0 ? 'first' : (($key + 1) == count($link) ? 'last' : '') )));
            }
            // vd($menuItem);

            $aux .= ! empty($link) ? $this->Html->tag('ul', implode('', $link)) : '';

            $ret .= $this->Html->tag(
                            'li'
                            , $aux
                            , array(
                        'class' => ($first == 1 ? 'first' : 'sf-menu-header') . ' ' . ( $first == count($menu) ? 'last' : '' . ' ' )
                        . ' ' . ( array_key_exists('extra_class', $menuItem) ? $menuItem['extra_class'] : ' ' )
                            )
            );

            //$first++;
        }
        $ret = $ret != '' ? $this->Html->tag('div', $this->Html->tag('ul', $ret, array('class' => 'sf-menu sf-js-enabled sf-shadow', 'id' => 'admin_menu')), array('id' => 'menu', 'class' => 'admin_menu')) : '';
        return $ret;
    }

    function authorizedKey($user, $url) {
        
    }

    function authorizedLink($user = null, $title = null, $url = null, $options = array(), $confirmMessage = false) {


        App::import('model', 'Role');

        $this->Role = new Role();

        if ($this->Role->isAuthorized($user, $url)) {
            return $this->Html->link($title, $url, $options, $confirmMessage);
        } else {
            return false;
        }
    }

    function paginationFilters($fieldName = null, $filters = array(), $url=array(), $options = array()) {


        if (strstr($fieldName, '.')) {
            list( $modelName, $fieldName ) = explode('.', $fieldName);
        } else {
            $this->setEntity($fieldName);
            $view = & ClassRegistry::getObject('view');
            $entity = $view->entity();
            $modelName = $entity[0];
            $entity = join('.', $entity);
        }






        $paginationFilters = array();
        $selected = $this->Form->value($modelName . '.' . $fieldName);
        $html = $this->Form->input($modelName . '.' . $fieldName, array('type' => 'hidden'));

        
        $separate = 6;
        
        $count = 1;

        foreach ($filters as $field => $name) {
            $extraClass = array();


            $extraClass[] = ( low($field) == low($selected) ? 'ui-state-active' : 'ui-state-default' );


            $extraClass[] = ( $count == 1 ? 'ui-corner-left' : ( $count == count($filters) ? 'ui-corner-right' : '') );


            $extraClass[] = zebra($count - 1, $separate, array('ui-corner-left', 'ui-corner-right'));

            $extraClass = implode(' ', array_unique($extraClass));

   


            $class = "ui-button ui-widget ui-button-text-only $extraClass";
            $url[$fieldName] = $field;
            $paginationFilters[] = $this->Html->link(
                            $this->Html->tag('span', $name, array('class' => 'ui-button-text')), Router::url($url), array('class' => $class, 'escape' => false)
            );
            
            if (zebra($count - 1, $separate, array(false, true))) {
                $paginationFilters[] = $this->Html->div('filter-separator','&nbsp;' ) ;
            }

            $count++;
        }


        if (!isset($options['legend'])) {
            $html .= $this->Html->div('legend', __(up('FILTER_TITLE_' . $fieldName), true));
        } elseif ($options['legend']) {
            $html .= $this->Html->div('legend', $options['legend']);
        }

        $html .= implode('', $paginationFilters);
        return $this->Html->div('filterBox ui-widget', $html, array('id' => $fieldName));
    }

    function authorizedPaginationFilters($user, $url = null, $name = null, $options = array()) {
        App::import('model', 'Role');
        $this->Role = new Role();
        $url = is_string($url) ? Router::parse($url) : Router::parse(Router::url($url));

        foreach ($options as $value => $title) {
            $filterUrl['controller'] = $url['controller'];
            $filterUrl['action'] = $url['action'];
            if (isset($url['prefix'])) {
                $filterUrl['prefix'] = $url['prefix'];
            }
            $filterUrl['admin'] = (!empty($url['admin']) ? true : false );
            $filterUrl[$name] = $value;

            $filterUrl = Router::url($filterUrl);
            if (!$this->Role->isAuthorized($user, $filterUrl)) {
                unset($options[$value]);
            }
            unset($filterUrl);
        }
        return $this->paginationFilters($url, $name, $options);
    }
	function js_encode($s){
		$s=utf8_decode($s);
		$texto='';
		$lon=strlen($s);
		for($i=0;$i<$lon;++$i){
			$num=ord($s[$i]);
			if($num<16) $texto.='\x0'.dechex($num);
			else $texto.='\x'.dechex($num);
		}
		return $texto;
	}

}

?>
