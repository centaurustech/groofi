<?php /* @var $this ViewCC */ ?>

<div class="full form">
    <?
    if ($leadingProject) {
        echo $this->Html->link(
                __('LEADING_PROJECT_EXAMPLE', true) .
                $this->Html->tag('b', __('LEADING_PROJECT_EXAMPLE_SUBTITLE', true))
                , Project::getLink($leadingProject), array('target' => 'blank', 'class' => 'bigBtn leading', 'id' => 'leadingProject', 'escape' => false)
        );
    }


    echo $this->Form->create('Project', array('type' => 'file', 'url' => Router::url(array(
            'controller' => 'projects',
            'action' => 'edit',
            $this->Form->value('Project.id')
                )
        )
            )
    );

    echo $this->Form->input('Project.id');

    echo $this->Form->input('Project.offer_id', array('type' => 'hidden'));

    echo $this->Form->input('Project.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
    echo $this->Form->input('Project.public', array('type' => 'hidden'));
    /* not updateables */

    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_EDIT_FIRST_BLOCK_TITLE', true), 'pageSubTitle' => __('PROJECT_EDIT_FIRST_BLOCK_SUBTITLE', true)));


    echo $this->Form->nonEditableInput('Project.title', array('type' => 'text', 'between' => $this->Html->helpMessage(__('PROJECT__TITLE_EDIT_HELP_MESSAGE_TEXT', true))));

    echo $this->Form->nonEditableInput('Project.category_id', array('type' => 'select', 'between' => $this->Html->helpMessage(__('PROJECT__CATEGORY_EDIT_HELP_MESSAGE_TEXT', true)), 'options' => $base_categories)); // creo que tiene que ser editable....

    echo $this->Form->nonEditableInput('Project.short_description', array('type' => 'text', 'between' => $this->Html->helpMessage(__('PROJECT__SHORT_DESCRIPTION_EDIT_HELP_MESSAGE_TEXT', true))));

    /* */

    echo $this->Form->inputTip('Project.description', array('type' => 'textarea', 'class' => 'custom-html'));

    echo $this->Form->inputTip('Project.reason', array('type' => 'textarea', 'tipMessage' => false));




    //   echo $this->element('form/url', array('elements' => 10, 'assocAlias' => 'Link', 'options' => array('label' => __('GIVE_US_SOME_LINKS', true))));

    /**/

    // echo $this->Form->input('Project.image' , array( 'type'=>'file'));
    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_EDIT_SECOND_BLOCK_TITLE', true), 'pageSubTitle' => __('PROJECT_EDIT_SECOND_BLOCK_SUBTITLE', true)));



    $file = $this->Media->file('l280/' . $this->data['Project']['image_file']);

    echo $this->Form->input('Project.image_file', array('type' => 'hidden'));
    echo $this->Form->input('Project.dirname', array('type' => 'hidden'));
    echo $this->Form->input('Project.basename', array('type' => 'hidden'));

    echo $form->inputTip('file', array('type' => 'file', 'accept' => 'image/jpge , image/jpg , image/gif , image/png', 'between' => $this->Html->helpMessage(__('PROJECT__FILE_EDIT_HELP_MESSAGE_TEXT', true), __('PROJECT__FILE_EDIT_TIP_MESSAGE_TEXT', true)), 'after' => $file ? $this->Media->embed($file) : ''));


    $video = getVideoEmbed($this->data['Project']['video_url'], 280, 210);
    echo $this->Form->inputTip('Project.video_url', array(
        'after' => $this->Html->div('project-video', ($video ? $video : ''))
    ));




    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_EDIT_THIRD_BLOCK_TITLE', true), 'pageSubTitle' => __('PROJECT_EDIT_THIRD_BLOCK_SUBTITLE', true)));
    echo $this->Form->inputTip('Project.funding_goal');

    echo $this->Form->inputTip('Project.project_duration', array('type' => 'text', 'class' => 'range'));

    echo $this->element('form/prizes', array('elements' => 40, 'assocAlias' => 'Prize', 'options' => array('label' => __('GIVE_US_SOME_PrizeS', true))));

    echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_EDIT_FOURTH', true), 'pageSubTitle' => __('PROJECT_EDIT_FOURTH_BLOCK_SUBTITLE', true)));
    ?><div class="input link"><?
    if (!empty($this->data['Project']['paypal_id'])) {
        echo $this->Html->tag('p', sprintf(__('YOUR_PAYPAL_ACCOUNT_IS_ASSOCIATED_WITH_THE_ID %s', true), $this->data['Project']['paypal_id']));
    }
    echo $this->Html->helpMessage(__('PROJECT_PAYPAL_HELP_TEXT', true));

    if (empty($this->data['Project']['paypal_id'])) {
        echo $this->Html->link(
                __('ASSOCIATE_WITH_PAYPAL', true), $payPalURL
                , array(
            'id' => 'associateWithPaypal',
            'class' => 'btn'
                ,
                )
        );
        //  echo $this->Html->helpMessage(__('ASSOCIATE_WITH_PAYPAL_HELP_MESSAGE_TEXT', true), __('ASSOCIATE_WITH_PAYPAL_TIP_MESSAGE_TEXT', true));
    } else {
        ?>


            <?
            echo $this->Html->link(
                    __('ASSOCIATE_WITH_ANOTHER_PAYPAL', true), $payPalURL
                    , array(
                'id' => 'associateWithAnotherPaypal',
                'class' => 'btn'
                    ,
                    )
            );
            //   echo $this->Html->helpMessage(__('ASSOCIATE_WITH_ANOTHER_PAYPAL_HELP_MESSAGE_TEXT', true), __('ASSOCIATE_WITH_ANOTHER_PAYPAL_TIP_MESSAGE_TEXT', true));
        }
        ?><div class="clearfix"></div><?
        ?></div><?
        /*
          echo $this->element('common/page_simple_title', array('pageTitle' => __('PROJECT_EDIT_FIFTH', true), 'pageSubTitle' => __('PROJECT_EDIT_FIFTH_BLOCK_SUBTITLE', true)));

          echo $this->Form->input('User.id');

          echo $this->Form->autoComplete('User.city', array(
          'url' => '/services/cities/query.php'
          ), array(
          'after' =>   $this->Form->error('location_id'),
          'between' => $this->Html->helpMessage(__('USER_LOCATION_HELP_MESSAGE_TEXT',TRUE),__('USER_LOCATION_TIP_MESSAGE_TEXT',TRUE)) ,
          'label' => 'USER_LOCATION_LABEL',
          )
          );

          echo $this->Form->inputTip('User.biography');
         */
// user city
// user links
// user bio


        /**/

// Recompensas: Donación mínima para la recompensa, descripción (*)
// Websites (*)
        ?><div class="submit"><?
        /* ----- */
        echo $this->Form->button(__('SUBMIT_PROJECT', true), array('id' => 'saveProject'));
        if ($this->data['Project']['public'] == 0) { // only not published projects can be deleted or published...
            echo $this->Form->button(__('PUBLISH_PROJECT', true), array('id' => 'publishProject'));
            echo $this->Form->button(__('DELETE_PROJECT', true), array('id' => 'deleteProject'));
        }
        /* ----- */
        ?></div><?
        echo $this->Form->end();
        ?>
</div>


<div id="amount">&nbsp;</div>
<div id="slider-range-min">&nbsp;</div>


<div id="publish-modal" title="<? __('DO_U_WANT_TO_PUBLISH_THIS_PROJECT_TITLE') ?>" style="display:none;">
    <p><? __('DO_U_WANT_TO_PUBLISH_THIS_PROJECT_BODY') ?></p>
</div>

<cake:script>
    <script type="text/javascript">
        var documentFormChanged = false ;
        $('#main form').change(function(e){
            //var changedFieldset = $(e.target); // .parents('fieldset');
            //console.log(changedFieldset);
            documentFormChanged = true ;
        });


        $( "input.range" ).range({min:<?= PROJECT_MIN_DURATION ?>,max:<?= PROJECT_MAX_DURATION ?>});



        $('#saveProject').click(function(){
            $('#main form').attr('action','<?= Project::getLink($this->data, 'edit') ?>').submit();
            return false ;
        });

        $('#publishProject').click(function(){
            publishProject(function(){
                $('#main form').attr('action','<?= Project::getLink($this->data, 'publish') ?>').submit();
            });
            return false;
        });


        $('#deleteProject').click(function(){
            deleteProject(function() {
                window.location ='<?= Project::getLink($this->data, 'delete') ?>' ;
            });
            return false;
        });


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

        $('div.input.prize div.row').css({'display':'none'}).first().css({'display':''});

        $('div.input.prize .row select.value,div.input.prize .row input.prize').bind('blur focus keyup keydown change',prizeChecker).blur();


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


    </script>
</cake:script>