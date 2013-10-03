

<?php if ($_SESSION["idioma"] == "eng") {
    echo ("Your project proposal ".Project::getName($emailData)." will be evaluated by our staff of moderators. In the coming days you will receive an e-mail communicating the next steps.");
}
elseif($_SESSION["idioma"] == "ita"){
    echo ("La tua proposta di progetto ".Project::getName($emailData)." sarà valutata dal nostro staff di moderatori. Nei prossimi giorni riceverete una e-mail comunicando i prossimi passi.");
}
else{
    echo ("Tu propuesta de proyecto ".Project::getName($emailData)." será evaluada por nuestro staff de moderadores. En los próximos días recibirás un e-mail comunicándote los pasos a seguir.");
}

?>