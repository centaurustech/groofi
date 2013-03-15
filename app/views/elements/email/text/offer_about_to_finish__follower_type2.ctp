El ofrecimiento "<?=Offer::getName($emailData)?>" finalizará en 24 horas. Si aún no has sido patrocinado por su creador, puedes visitar su perfil y ponerte en contacto con él haciendo clic en el siguiente link o copiando y pegando esta URL en tu navegador:

<?=User::getLink(array('User'=>$emailData['Owner']) , null , true )?>