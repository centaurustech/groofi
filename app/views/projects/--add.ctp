
<?php
echo $javascript->link('ckeditor/ckeditor');
?>


<?php
/* @var $this ViewCC */

// $this->set('pageSubTitle', sprintf( __('BY %',true), $this->Html->link( User::getName($this->Session->read('Auth')) , User::getLink($this->Session->read('Auth'))) ));
?>

<div class="full form">
    <?
    echo $this->Form->create('Project', array('type' => 'file', 'url' => DS . $this->params['url']['url']));

    if ($offerId) {

        $this->set('pageSubTitle', sprintf(__('IN_RENSPONSE_OF %s FROM %s', true), $this->Html->tag('span', Offer::getName($offer), array('class' => 'highlight offer-name', 'url' => Offer::getLink($offer))), $this->Html->tag('span', User::getName($offer), array('class' => 'highlight user-name', 'url' => User::getLink($offer)))
                )
        );

        echo $this->Form->input('Project.offer_id', array('type' => 'hidden', 'value' => $offerId));
    }


    echo $this->Form->input('Project.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));



    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_ADD_FIRST_BLOCK_TITLE', true), 'pageSubTitle' => __('PROJECT_ADD_FIRST_BLOCK_SUBTITLE', true)));


    echo $this->Form->inputTip('Project.title', 
					array(
						  'onKeyDown' =>'textCounter(this,this.form.remTitl,50)',
						  'onKeyUp' =>'textCounter(this,this.form.remTitl,50)',
						  'tipMessage' =>  __('PROJECT_COUNT_LEFT', true).'<input readonly style="width:50px" type="text" name="remTitl" size="3" maxlength="3" value="50">'
						 )
				);

    echo $this->Form->inputTip('Project.category_id', array('options' => $base_categories, 'empty' => true, 'tipMessage' => false));

    echo $this->Form->inputTip('Project.short_description', 
					array(
						  'type' => 'textarea',
						  'onKeyDown' =>'textCounter(this,this.form.remDescCl,140)',
						  'onKeyUp' =>'textCounter(this,this.form.remDescCl,140)',
						  'tipMessage' =>  __('PROJECT_COUNT_LEFT', true).'<input readonly style="width:50px" type="text" name="remDescCl" size="3" maxlength="3" value="140">'
						 )
				);

    echo $this->Form->inputTip('Project.description', array('type' => 'textarea', 'class' => 'custom-html'));

    echo $this->Form->inputTip('Project.motivation', array('type' => 'textarea', 'tipMessage' => false));

    echo $this->element('form/url', array('elements' => 10, 'assocAlias' => 'Link', 'tipMessage' => false, 'options' => array('label' => __('GIVE_US_SOME_LINKS', true))));



    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_ADD_SECOND_BLOCK_TITLE', true), 'pageSubTitle' => __('PROJECT_ADD_SECOND_BLOCK_SUBTITLE', true)));

    echo $this->Form->input('Project.image_file', array('type' => 'hidden'));

    echo $form->inputTip('file', array('type' => 'file', 'accept' => 'image/jpge , image/jpg , image/gif , image/png', 'between' => $this->Html->helpMessage(__('PROJECT__FILE__HELP_MESSAGE_TEXT', true), __('PROJECT__FILE__TIP_MESSAGE_TEXT', true))));



    echo $this->Form->inputTip('Project.video_url');


    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_ADD_THIRD_BLOCK_TITLE', true), 'pageSubTitle' => __('PROJECT_ADD_THIRD_BLOCK_SUBTITLE', true)));
    /**/


    echo $this->Form->inputTip('Project.funding_goal');

    echo $this->Form->inputTip('Project.project_duration', array('type' => 'text', 'class' => 'range'));


    echo $this->element('form/prizes', array('elements' => 40, 'assocAlias' => 'Prize', 'options' => array('label' => __('GIVE_US_SOME_PrizeS', true))));

    echo $this->Form->submit(__('SUBMIT_PROJECT_PROPOSAL', true));

    echo $this->Form->end();
    ?>
</div>
<cake:script>
    <script type="text/javascript">
        $( "input.range" ).range({min:<?= PROJECT_MIN_DURATION ?>,max:<?= PROJECT_MAX_DURATION ?>});
       
       
       $('#ProjectFile').bind('change',function(e){
            accept = String($(this).attr('accept')).toLowerCase().replace(/image\/|\s|\t/g,'').replace(/,\s*$/,  '').split(',');
            ext = $(this).val().split('.').pop().toLowerCase() ;
            if ( accept.in_array(ext) ) {
                return true ;
            } else {
                $(this).val('');
                return false ;
            }
        }).customFileInput();
        
        

        var prizesValues = <?= json_encode($base_prizes) ?> ;
        prizeChecker = function(ev){
            var el      = $(this);
            var row     = el.parent('.row');
            var id      = row.attr('id').replace(/[^\d]/g,'');
            var value   = $( 'div.input.prize div.row#row_' + id + ' .value' );
            var prize   = $( 'div.input.prize div.row#row_' + id + ' .prize' );

            $('select.value:visible').each(function(k,e){
                if (  el.attr('id') != $(e).attr('id')   ) {
                    if ( el.val() ==  $(e).val() ) {
                        el.val('') ;
                    }
                }
            }) ; 
         
            filled = $(value).val() != '' | $(prize).val() != '' ;
            
            if( !filled && row.nextAll('.row:visible').length > 0 ) {
                row.children('.error-message').remove();
                row.hide().insertAfter(row.nextAll('.row').last());
                e = row.prevAll('.row:visible').first().children('input.value') ;
                if ( e ){
                    e.focus();
                }

            } else if( filled && row.nextAll('.row:visible').length == 0 ) {
                row.nextAll('.row').first().show().children('select.value') ;
            }
        }

        
        function validatePrizes() {


            $('.prize .row:visible input.value').each(function(k,e){

                el=$(e);

                row = el.parent('.row');
                id = row.attr('id').replace(/[^\d]/g,'');

                prevValues = row.prev('.row:visible').contents('input.value');
                prevValues = parseInt(prevValues.length > 0 ? prevValues.val() : 0) ;

                nextValues = row.next('.row:visible').contents('input.value');
                nextValues = parseInt(nextValues.length > 0 && nextValues.val() != '' ? nextValues.val()  : 10000000) ;

                if ( el.val() != ''  ) {

                    if (  el.val() <= prevValues ) {
                        el.nextAll('.error-message').first().text( 'The value must be greater than '  + prevValues + ', Now is ' +   el.val());
                    } else if ( el.val() > nextValues  ) {
                        el.nextAll('.error-message').first().text( 'The value must be less than '  + nextValues + ', Now is ' +   el.val());
                    } else {

                        el.nextAll('.error-message').first().text('') ;
                    }
                }
            });
            return true;
        }

     $('div.input.prize div.row').css({'display':'none'}).first().css({'display':''});

        $('div.input.prize .row select.value,div.input.prize .row input.prize').bind('blur focus keyup keydown change',prizeChecker).blur();
    </script>
</cake:script>
