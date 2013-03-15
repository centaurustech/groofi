<?php /* @var $this ViewCC */ ?>
<div class="full form">
    <?
        echo $this->Form->create('Offer', array('type' => 'file', 'url' => Router::url(array())));

        echo $this->Form->input('Offer.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));


        /* ---------- */
        
        echo $this->element('common/page_simple_title' , array( 'pageTitle' => __('OFFER_ADD_FIRST_BLOCK_TITLE',true) , 'pageSubTitle' =>  __('OFFER_ADD_FIRST_BLOCK_SUBTITLE',true) ));
        
        
        echo $this->Form->inputTip('Offer.title',array('tipMessage'=>false));
        echo $this->Form->inputTip('Offer.category_id', array('options' => $base_categories, 'empty' => true ,'tipMessage'=>false));
        echo $this->Form->inputTip('Offer.short_description', array('type' => 'textarea'));
        echo $this->Form->inputTip('Offer.description', array('type' => 'textarea', 'class' => 'custom-html'));
        echo $this->element('form/url', array('elements' => 10, 'assocAlias' => 'Link','tipMessage'=>false, 'options' => array('label' => __('GIVE_US_SOME_LINKS', true))));

        echo $this->element('common/page_simple_title' , array( 'pageTitle' => __('OFFER_ADD_SECOND_BLOCK_TITLE',true) , 'pageSubTitle' =>  __('OFFER_ADD_SECOND_BLOCK_SUBTITLE',true) ));
        /* ---------- */
        echo $this->Form->inputTip('file', array('type' => 'file', 'between' => $this->Html->helpMessage(__('OFFER__FILE__HELP_MESSAGE_TEXT',true),__('OFFER__FILE__TIP_MESSAGE_TEXT',true)), 'accept' => 'image/jpge , image/jpg , image/gif , image/png'));
        echo $this->Form->inputTip('Offer.video_url');
        /* ---------- */
echo $this->element('common/page_simple_title' , array( 'pageTitle' => __('OFFER_ADD_THIRD_BLOCK_TITLE',true) , 'pageSubTitle' =>  __('OFFER_ADD_THIRD_BLOCK_SUBTITLE',true) ));
        echo $this->Form->inputTip('Offer.funding_sponsorships_founds',array('tipMessage'=>false));

        echo $this->Form->inputTip('Offer.offer_sponsorships',array('tipMessage'=>false));

        echo $this->Form->inputTip('Offer.offer_duration', array('type' => 'text', 'class' => 'range','tipMessage'=>false));
 

 echo $this->Form->inputTip('Offer.offer_public', array('tipMessage' => false, 'type' => 'checkbox'));

        echo $this->Form->submit(__('SUBMIT_OFFER', true));

        echo $this->Form->end();
    ?>

</div>

<cake:script>
    <script type="text/javascript">
        var documentFormChanged = false ;
        $('#main form').change(function(e){
            //var changedFieldset = $(e.target); // .parents('fieldset');
            //console.log(changedFieldset);
            documentFormChanged = true ;
        });

        $( "input.range" ).range({min:<?=OFFER_MIN_DURATION?>,max:<?=OFFER_MAX_DURATION?>});

        $('#OfferFile').bind('change',function(e){
            accept = String($(this).attr('accept')).toLowerCase().replace(/image\/|\s|\t/g,'').replace(/,\s*$/,  '').split(',');

            ext = $(this).val().split('.').pop().toLowerCase() ;

            if ( accept.in_array(ext) ) {
                return true ;
            } else {
                $(this).val('');
                return false ;
            }
        }).customFileInput();



    </script>
</cake:script>