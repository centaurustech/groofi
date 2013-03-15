Tu ofrecimiento "<?=Offer::getName($emailData)?>" ha finalizado. No te olvides de visitar los proyectos creados a partir éste para patrocinarlos con el monto ofrecido. Para conocer esos proyectos, visita la página de tu ofrecimiento haciendo clic en el siguiente link o copiando y pegando esta URL en tu navegador:

<?=Project::getLink($emailData,array(),true)?>