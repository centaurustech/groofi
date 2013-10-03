
<?php if ($_SESSION["idioma"] == "eng") {
    echo ("To reset your password, please click on the following link or copy and paste this URL into your browser:");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("Per reimpostare la password, clicca sul seguente link o copiare e incollare questo URL nel browser:");
}
else{
    echo ("Para restablecer tu contraseña, por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:");
}

?>

<?=User::getLink( $emailData , 'mail-password-recovery' , true )?>



<?php if ($_SESSION["idioma"] == "eng"){

    echo ("This link will be valid for ".CONFIMATION_TOKEN_DURATION." days.");
}
elseif($_SESSION["idioma"] == "ita"){

    echo ("Questo link sarà valido per".CONFIMATION_TOKEN_DURATION." giorni.");
}
else{
    echo ("Este link será valido por ".CONFIMATION_TOKEN_DURATION." días.");

}

