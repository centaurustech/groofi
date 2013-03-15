<?php

    /* @var $this ViewCC */
    if ($data) {
        $response=$this->Html->div('thumb', $this->Media->getImage('s64', $data['Offer']['image_file'], '/img/assets/img_default_64px.png'));
        // info
        $info=$this->Html->tag('h3', $data['Offer']['title'], array('class' => 'title', 'url' => Offer::getLink($data)));
 
            $info .= $this->Html->tag('h4',
                    sprintf(
                        __('BY %s', true),
                        User::getName($data, 'User')
                    )
                    , array('class' => 'sub-title')
            );
      
        $info .= $this->Html->tag('p', $data['Offer']['short_description'], array('class' => 'description'));

 
        /*catregory*/
        $info .= $this->Html->link(
                $this->Html->tag(
                    'span'
                    , '&nbsp;'
                    , array(
                        'class' => 'site-icon small icon-tag'
                    )
                )
                . Category::getName($data)
                , Category::getLink($data,'offers')
                , array(
                     'class' => 'category tag'
                    ,'escape' => false
                )
        );


        $response .= $this->Html->div('info', $info);

        if ($data['Offer']['public'] == 0) { //
            $actions['auth'][]=$this->Html->link(__('DELETE', true), "/offers/delete/{$data['Offer']['id']}"); // cancel proposal | delete offer
            if ($data['Offer']['enabled'] >= 1) {
                $actions['status']=$this->Html->div("extra message message-box orange", __('OFFER_PENDING_PUBLISH', true));
                $actions['auth'][]=$this->Html->link(__('PREVIEW', true), "/offers/view/{$data['Offer']['id']}");
                $actions['auth'][]=$this->Html->link(__('EDIT', true), "/offers/edit/{$data['Offer']['id']}");
            } else {
                $actions['status']=$this->Html->div("extra message message-box blue", __('OFFER_PENDING_APPROVAL', true));
            }
        } elseif ($data['Offer']['public'] == 1) {
            $actions['auth'][]=$this->Html->link(__('VIEW', true), "/offers/view/{$data['Offer']['id']}");
            $actions['auth'][]=$this->Html->link(__('CREATE_UPDATE', true), "/offer/{$data['Offer']['id']}/create-update"); // cancel proposal | delete offer
        }

        if (!empty($actions)) {

            $extra = ''  ;
            if (!empty($actions['status'])) {
                $response .= $this->Html->div('offer-status',  $actions['status'] );
            }

            $response .= $this->Html->div('clearfix', '');

            if (!empty($actions['auth']) && Offer::isOwnOffer($data)) {
                $response .= $this->Html->div('offer-auth-actions', implode('&nbsp;|&nbsp;', $actions['auth']));
            }

        }



        echo $this->Html->div("box box-offer box-project-offer", $response);
    } else {
        trigger_error("ERROR : offer data is not found");
    }
    // Offer updates...
?>
