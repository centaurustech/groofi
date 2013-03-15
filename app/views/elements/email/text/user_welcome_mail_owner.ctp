Para confirmar tu registración en Groofi, por favor haz clic en el siguiente link o copia y pega esta URL en tu navegador:

<?=User::getLink( $emailData , 'mail-confirmation' , true )?>

Este link será válido por <?=CONFIMATION_TOKEN_DURATION?> días. Por favor, confirma tu cuenta antes de este plazo.