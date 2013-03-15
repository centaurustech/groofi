<?php /* @var $this ViewCC */ ?>
<?

    $type=isset($type) ? $type : 'default';
    $data=isset($data) ? $data : null;
    if ( isset($data['Offers']) && is_array($data['Offers'])) {
        $offers = $data['Offers'] ;
        foreach ($offers as $key => $offer) {
            $owner=($this->Session->read('Auth.User.id') == $offer['Offer']['user_id']);
            if ($offer['Offer']['enabled'] > 0 || $owner) {

                $data['ViewUser']   = $data['User'] ;
                $data['User']       = $offer['User'] ;
                
                echo $this->element("offers/$type", array(
                        'offer' => $offer,
                        'data' => $data 
                    )
                );
            }
        }
    }
?>