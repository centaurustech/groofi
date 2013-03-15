<?php
/* @var $this ViewCC */
if ($offer) {
    $response = $this->Html->div('thumb', $this->Media->getImage('l280', $offer['Offer']['image_file'], '/img/assets/img_default_280x210px.png'));
    // info

    $info = $this->Html->tag('h3', Offer::getName($offer), array('class' => 'title', 'url' => Offer::getLink($offer)));

        if (isset($data['ViewUser'])) {
        
        $prefix = $offer['Offer']['user_id'] == $data['ViewUser']['id'] ? '' : 'ORIGINALY_CREATED_';
    } else {
        $prefix = '' ;
    }
   
    $info .= $this->Html->tag('h4', sprintf(
                            __($prefix . 'BY %s', true), $this->Html->link(
                                    User::getName($offer), User::getLink($offer)
                            )
                    )
                    , array('class' => 'sub-title')
    );
    $info .= $this->Html->tag('p', $offer['Offer']['short_description'], array('class' => 'description'));
    $updates = '' ;
    if (isset($offer['Post'])) {
        foreach ($offer['Post'] as $update) {
            $update = array('Post' => $update);
            $updates[] = $this->Html->tag('li', $this->Html->link(
                                    Post::getName($update), Post::getLink($update)
                            )
                            . $this->Html->tag('span', sprintf(
                                            __('CREATED_ON %s', true), $this->Time->i18nFormat($offer['Offer']['end_date'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')), array('class' => 'highlight')
                            )
                            . ( Offer::isOwnOffer($offer) ? " (" . $this->Html->link(__('EDIT', true), Post::getLink($update, 'edit')) . ')' : '' )
            );
        }
    }
    /* catregory */
    $info .= $this->Html->link(
                    $this->Html->tag(
                            'span'
                            , '&nbsp;'
                            , array(
                        'class' => 'site-icon small icon-tag'
                            )
                    )
                    . Category::getName($offer)
                    , Category::getLink($offer)
                    , array(
                'class' => 'category tag'
                , 'escape' => false
                    )
    );


    $response .= $this->Html->div('info', $info);

    if ($offer['Offer']['public'] == 0) { //
        $actions['auth'][] = $this->Html->link(__('DELETE', true), "/offers/delete/{$offer['Offer']['id']}", array('class' => 'confirm')); // cancel proposal | delete offer
        if ($offer['Offer']['enabled'] >= 1) {
            $actions['status'] = $this->Html->div("extra message message-box orange", __('OFFER_PENDING_PUBLISH', true));
            $actions['auth'][] = $this->Html->link(__('PREVIEW', true), "/offers/view/{$offer['Offer']['id']}");
            $actions['auth'][] = $this->Html->link(__('EDIT', true), "/offers/edit/{$offer['Offer']['id']}");
        } else {
            $actions['status'] = $this->Html->div("extra message message-box blue", __('OFFER_PENDING_APPROVAL', true));
        }
    } elseif ($offer['Offer']['public'] == 1) {
        $actions['auth'][] = $this->Html->link(__('VIEW', true), "/offers/view/{$offer['Offer']['id']}");
        $actions['auth'][] = $this->Html->link(__('CREATE_UPDATE', true), "/offer/{$offer['Offer']['id']}/create-update"); // cancel proposal | delete offer


        if (!empty($updates)) {
            $actions['auth'][] = $this->Html->div('updates-box-toggler', sprintf(__('OFFER_UPDATES %s', true), count($updates)), array('id' => 'offerUpdate_' . $offer['Offer']['id']));
            $actions['auth'][] = $this->Html->div('box offer-updates-box updates-box', $this->Html->tag('ul', implode('', $updates)));
        }
    }

    if (!empty($actions)) {

        $extra = '';
        if (!empty($actions['status'])) {
            $response .= $this->Html->div('offer-status', $actions['status']);
        }

        $response .= $this->Html->div('clearfix', '');

        if (!empty($actions['auth']) && Offer::isOwnOffer($offer)) {
            $response .= $this->Html->div('offer-auth-actions auth-actions', implode('&nbsp;|&nbsp;', $actions['auth']));
        }
    }



    echo $this->Html->div("box box-offer box-profile-offer", $response , array('id' => 'offer_' . $offer['Offer']['id']  ));
} else {
    trigger_error("ERROR : offer data is not found");
}
// Offer updates...
?>
<cake:script>
    <script type="text/javascript">
        $('#offer_<?= $offer['Offer']['id'] ?> a.confirm').click(function(){
            deleteOffer(function() {
                window.location = '<?= Offer::getLink($offer, 'delete') ?>' ;
            });
            return false ;
        });
               
                
        $('.updates-box-toggler#offerUpdate_<?= $offer['Offer']['id'] ?>').click(function(){
            $(this).next('.updates-box').children('ul').toggle();
        }).css('cursor','pointer');
    </script>
</cake:script>