El usuario <?=User::getName($emailData)?> ha patrocinado tu proyecto <?=Project::getName($emailData)?> con <?=$emailData['Sponsorship']['contribution']?> dólares. Para conocer a tu nuevo patrocinador por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:

<?=User::getLink($emailData,null,true)?>
