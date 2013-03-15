<?php /* @var $this ViewCC */ ?>
<div class="full form">
    <?
    echo $this->Form->create('Offer', array('type' => 'file', 'url' => Router::url(array(
            'controller' => 'offers',
            'action' => 'edit',
            $this->Form->value('Offer.id')
                )
        )
            )
    );
    echo $this->element('common/page_simple_title', array('pageTitle' => __('OFFER_EDIT_FIRST_BLOCK_TITLE', true), 'pageSubTitle' => __('OFFER_EDIT_FIRST_BLOCK_SUBTITLE', true)));




    echo $this->Form->input('Offer.id');
    echo $this->Form->input('Offer.public', array('type' => 'hidden'));
    echo $this->Form->input('Offer.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));

    /* not updateables --------------------------------------------------------------------------------------------------------- */
    echo $this->Form->nonEditableInput('Offer.title', array('type' => 'text', 'between' => $this->Html->helpMessage(__('OFFER__TITLE_EDIT_HELP_MESSAGE_TEXT', true))));
    echo $this->Form->nonEditableInput('Offer.category_id', array('type' => 'select', 'between' => $this->Html->helpMessage(__('OFFER__CATEGORY_EDIT_HELP_MESSAGE_TEXT', true)), 'options' => $base_categories));
    echo $this->Form->nonEditableInput('Offer.short_description', array('type' => 'text', 'between' => $this->Html->helpMessage(__('OFFER__SHORT_DESCRIPTION_EDIT_HELP_MESSAGE_TEXT', true))));
    /* not updateables --------------------------------------------------------------------------------------------------------- */

    echo $this->Form->inputTip('Offer.description', array('type' => 'textarea', 'class' => 'custom-html'));

    //echo $this->element('form/url', array('elements' => 10, 'assocAlias' => 'Link', 'options' => array('label' => __('GIVE_US_SOME_LINKS', true))));

    echo $this->element('common/page_simple_title', array('pageTitle' => __('OFFER_EDIT_SECOND_BLOCK_TITLE', true), 'pageSubTitle' => __('OFFER_EDIT_SECOND_BLOCK_SUBTITLE', true)));

    $file = $this->Media->file('m200/' . $this->data['Offer']['image_file']);
    echo $this->Form->input('Offer.image_file', array('type' => 'hidden'));
    echo $this->Form->input('Offer.dirname', array('type' => 'hidden'));
    echo $this->Form->input('Offer.basename', array('type' => 'hidden'));
    echo $form->inputTip('file', array('type' => 'file', 'between' => $this->Html->helpMessage(__('OFFER__FILE_EDIT_HELP_MESSAGE_TEXT', true), __('OFFER__FILE_EDIT_TIP_MESSAGE_TEXT', true)), 'accept' => 'image/jpge , image/jpg , image/gif , image/png', 'before' => $file ? $this->Media->embed($file) : ''));
    echo $this->Form->inputTip('Offer.video_url');

    echo $this->element('common/page_simple_title', array('pageTitle' => __('OFFER_EDIT_THIRD_BLOCK_TITLE', true), 'pageSubTitle' => __('OFFER_EDIT_THIRD_BLOCK_SUBTITLE', true)));
    echo $this->Form->inputTip('Offer.funding_sponsorships_founds', array('tipMessage' => false));
    echo $this->Form->inputTip('Offer.offer_sponsorships', array('tipMessage' => false));
    echo $this->Form->inputTip('Offer.offer_duration', array('type' => 'text', 'tipMessage' => false, 'class' => 'range'));

    
    echo $this->Form->inputTip('Offer.offer_public', array('tipMessage' => false, 'type' => 'checkbox'));
    
    ?><div class="submit"><?
    /* ----- */
    echo $this->Form->button(__('SAVE_OFFER', true), array('id' => 'saveOffer'));
    echo $this->Form->button(__('PUBLISH_OFFER', true), array('id' => 'publishOffer'));
    echo $this->Form->button(__('DELETE_OFFER', true), array('id' => 'deleteOffer'));
    /* ----- */
    ?></div><?
        echo $this->Form->end();
    ?>
</div>


<div id="amount">&nbsp;</div>
<div id="slider-range-min">&nbsp;</div>

 

<cake:script>
    <script type="text/javascript">
        var documentFormChanged = false ;
        $('#main form').change(function(e){
            documentFormChanged = true ;
        });
        
        $( "input.range" ).range({min:<?= OFFER_MIN_DURATION ?>,max:<?= OFFER_MAX_DURATION ?>});
        
        
      
        $('#saveOffer').click(function(){
            $('#main form').attr('action','<?= Offer::getLink($this->data, 'edit') ?>').submit();
            return false ;
        });

         
        $('#publishOffer').click(function(){
            publishOffer(function(){
                $('#main form').attr('action','<?= Offer::getLink($this->data, 'publish') ?>').submit();
            });
            return false;
        });

        $('#deleteOffer').click(function(){
            deleteOffer(function() {
                window.location = '<?= Offer::getLink($this->data, 'delete') ?>' ;
            });
            return false ;
        });
        
       

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