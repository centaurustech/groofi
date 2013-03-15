<?

echo $this->element('common/scripts/lang', array('cache' => '1 day'));


if (Configure::read('debug') > 0 || Configure::read('Asset.filter.js') == false ) { //
    Configure::write('Asset.filter.js', false);
    $includeFiles = preg_grep("/^(\/\*\s*@include\s*(?P<filename>[\w|\/|\d|\-|_|\.]+)\s*\*\/\s*)/", preg_split("/\r\n|\n/", file_get_contents(APP . DS . WEBROOT_DIR . DS . 'js' . DS . 'framework.js')));
    foreach ($includeFiles as $k => $includeFile) {
        preg_match_all("/^(\/\*\s*@include\s*(?P<filename>[\w|\/|\d|\-|_|\.]+)\s*\*\/\s*)/", $includeFile, $includeFile);
        if (array_key_exists('filename', $includeFile)) {
            echo $this->Html->script($includeFile['filename'][0], array('once' => true, 'inline' => true));
        }
    }
} else {
    echo $this->Html->script('framework', array('once' => true, 'inline' => true));
}

$this->Js->buffer(
        "$.datepicker.setDefaults( $.datepicker.regional['" . Configure::read('Config.language') . "']);" // regional setings for datepicker
);


//  echo $this->Html->script('jquery/main.js', array('once' => true, 'inline' => true)); // staticpages only use main jquery framework

echo str_replace("\r\n", ' ', $this->element('common/loader', array('cache' => '1 day')));

echo $this->Js->writeBuffer();

if (GOOGLE_ANALITYCS_ACCOUNT) {
    echo $this->element('common/scripts/google_analitycs', array('cache' => '1 day'));
}
?>

<script type="text/javascript" src="/js/tinymce/jquery.tinymce.js"></script>

