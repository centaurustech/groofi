El proyecto "<?=Project::getName($emailData)?>" finalizará en <?=DAYS_TO_BE_FINISHING?> días. Todavía estás a tiempo de hacer un nuevo aporte a este proyecto. Para aportar por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:

<?=Project::getLink($emailData,array(),true)?>