Se ha creado el proyecto "<?=Project::getName($emailData);?>" en base a tu ofrecimiento "<?=Offer::getName($emailData);?>". Para verlo y patrocinarlo, por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:

<?=Project::getLink($emailData,null,true);?>