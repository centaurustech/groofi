Para restablecer tu contraseña, por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:

<?=User::getLink( $emailData , 'mail-password-recovery' , true )?>

Este link será válido por <?=CONFIMATION_TOKEN_DURATION?> días.