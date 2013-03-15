¡Ya eres patrocinador del proyecto "<?=Project::getName($emailData)?>"!
Hemos recibido tu aporte de <?=$emailData['Sponsorship']['contribution']?> dólares. En caso de que este proyecto no
alcance a recaudar USD <?=number_format($emailData['Project']['funding_goal'], 2, '.', '')?> el día <?=$this->Time->format($emailData['Project']['end_date'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')?>, el mismo no será financiado y se te
reintegrará el monto de tu aporte a la cuenta de PayPal desde la que se recibieron los
fondos. Recuerda que este reintegro puede demorar algunos días.