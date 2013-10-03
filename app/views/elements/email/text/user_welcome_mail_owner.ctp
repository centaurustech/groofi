
<?php if ($_SESSION["idioma"] == "eng") {
    echo ("To confirm your registration Groofi, please click on the following link or copy and paste this URL into your browser:");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("Per confermare la tua registrazione Groofi, clicca sul seguente link o copiare e incollare questo URL nel browser:");
}
else{
    echo ("Para confirmar tu registro en Groofi, por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:");
}

?>

<?=User::getLink( $emailData , 'mail-confirmation' , true )?>



<?php if ($_SESSION["idioma"] == "eng") {
    echo ("This link will be valid for ".CONFIMATION_TOKEN_DURATION." days. Please confirm your account by this deadline.");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("Questo link sarà valido per ".CONFIMATION_TOKEN_DURATION." giorni. Confermare il tuo account entro tale termine si prega.");
}
else{
    echo ("Este link será válido por ".CONFIMATION_TOKEN_DURATION." días. Por favor, confirma tu Cuenta antes de este plazo.");
}

?>
