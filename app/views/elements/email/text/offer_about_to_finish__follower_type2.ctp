<? if ($_SESSION["idioma"] == "eng"){
    echo ('The offer '.Offer::getName($emailData).'ends in 24 hours. If you have not been sponsored by its creator, you can visit your profile and contact him by clicking on the following link or copying and pasting this URL into your browser:');
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("L'offerta ".Offer::getName($emailData)."scade tra 24 ore. Se non sei stato sponsorizzato dal suo creatore, è possibile visitare il tuo profilo e contattarlo cliccando sul seguente link o copiare e incollare questo URL nel browser:");
}
else{echo ("El ofrecimiento ".Offer::getName($emailData)." finalizará en 24 horas. Si aún no has sido patrocinado por su creador, puedes visitar su perfil y ponerte en contacto con él haciendo clic en el siguiente link o copiando y pegando esta URL en tu navegador:");}?>




<?=User::getLink(array('User'=>$emailData['Owner']) , null , true )?>

<!--El ofrecimiento "<!--?=Offer::getName($emailData)?>" finalizará en 24 horas. Si aún no has sido patrocinado por su creador, puedes visitar su perfil y ponerte en contacto con él haciendo clic en el siguiente link o copiando y pegando esta URL en tu navegador:-->