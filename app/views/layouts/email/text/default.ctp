<?

$extra = isset($extra) ? $extra : array();
$debug = isset($debug) ? $debug : false ;

if ($debug) {
    echo "<pre>";
}
?>

<?php
if ($_SESSION["idioma"] == "eng") {
    echo ("Hello ".User::getName($user));
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("Ciao ".User::getName($user));
}
else{
    echo ("Hola ".User::getName($user));
}

?>


<?=(!$debug?$content_for_layout:$this->element('email/text/' . low($template), array('emailData' => $emailData)));?>


<?php if ($_SESSION["idioma"] == "eng") {
    echo ("Thanks,");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("Grazie,");
}
else{
    echo ("Gracias,");
}
?>


<?php
if ($_SESSION["idioma"] == "eng") {
    echo ("Groofi Team.");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("Groofi Squadra.");
}
else{
    echo ("El equipo de Groofi.");
}
?>

contacto@groofi.com





<? if ($debug) {
    echo "</pre>";
} ?>

