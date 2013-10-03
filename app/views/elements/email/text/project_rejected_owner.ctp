
<?php if ($_SESSION["idioma"] == "eng") {
    echo ("Your project proposal ".Project::getName($emailData)." has not been approved by our staff moderators. However, you can try another proposal whenever you want. To access your account, please click the following link or copy and paste this URL into your browser:");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("La tua proposta ".Project::getName($emailData)." di progetto non è stato approvato dal nostro staff personale. Tuttavia, si può provare un'altra proposta ogni volta che vuoi. Per accedere al tuo account, fai clic sul seguente link o copiare e incollare questo URL nel browser:");
}
else{
    echo ("Tu propuesta de proyecto ".Project::getName($emailData)." no ha sido aprobada por nuestro staff de moderadores. Sin embargo, puedes intentar con otra propuesta siempre que lo desees. Para acceder a tu cuenta por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:");
}

?>
<?=User::getLink($emailData,'login',true)?>