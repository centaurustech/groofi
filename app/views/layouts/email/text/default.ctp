<?
$extra = isset($extra) ? $extra : array();
$debug = isset($debug) ? $debug : false ;

if ($debug) {
    echo "<pre>";
}
?>
Hola <?= User::getName($user); ?>,

<?=(!$debug?$content_for_layout:$this->element('email/text/' . low($template), array('emailData' => $emailData)));?>


Gracias,

El equipo de Groofi
contacto@groofi.com
www.groofi.com
<? if ($debug) {
    echo "</pre>";
} ?>