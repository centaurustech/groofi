<?php /* @var $this ViewCC */ ?>


<div style="width:560px;">
    <?
    $this->set('title_for_layout', Project::getName($project));
    $this->set('pageTitle', Project::getName($project));



    if (!Project::belongsToOffer($project)) {
        $this->set('pageSubTitle', sprintf(__('PROJECT_BY %s IN CATEGORY %s', true)
                        , $this->Html->tag('span', User::getName($project), array('class' => 'highlight user-name', 'url' => User::getLink($project)))
                        , $this->Html->tag('span', Category::getName($project), array('class' => 'highlight category-name', 'url' => Category::getLink($project, 'projects')))
                )
        );
    } else {
        $this->set('pageSubTitle', sprintf(__('PROJECT_BY %s IN CATEGORY %s IN RESPONSE OF %s', true)
                        , $this->Html->tag('span', User::getName($project), array('class' => 'highlight user-name', 'url' => User::getLink($project)))
                        , $this->Html->tag('span', Category::getName($project), array('class' => 'highlight category-name', 'url' => Category::getLink($project, 'projects')))
                        , $this->Html->tag('span', Offer::getName($project), array('class' => 'highlight offer-name', 'url' => Offer::getLink($project)))
                )
        );
    }

    echo $this->Form->create('Sponsorship', array(
        'id' => 'sponsorshipContributionForm',
        'url' => preg_replace('/\/\d+$/', '', DS . $this->params['url']['url'])
            )
    );
    echo $this->Form->input('step', array('type' => 'hidden', 'value' => 1));
    ?>



    <div id="sponsorshipContribution" >
        <h3 class="title">
            <?= __('SPONSORSHIP_CREATE_TITLE', true) ?>
            <span>
                <?= __('SPONSORSHIP_CREATE_SUBTITLE', true) ?>
            </span>
        </h3>
        <div class="green-box-contribution" >
            <?
            echo $this->Form->input('Sponsorship.contribution', array('size' => 10));
            ?>
        </div>
    </div>

    <?
    echo $this->element(
            'projects/view_prizes', array(
        'data' => $project,
        'cols' => 3,
        'rows' => 2,
        'theme' => 'simple',
        'active' => (is_array($selectedPrize) ? $selectedPrize['Prize']['id'] : null ),
        'title' => __('SPONSORSHIP_CREATE_PRIZES_TITLE', true),
        'subtitle' => __('SPONSORSHIP_CREATE_PRIZES_SUBTITLE', true),
            )
    );
    ?>


    <div class="donation" >
        <?
        echo $this->Form->input('Sponsorship.no_prize', array('type' => 'checkbox'));
        echo $this->Form->submit(__('SPONSORSHIP_CREATE_SUBMIT', true));
        ?>
    </div>



    <? echo $this->Form->end(); ?>
</div>

<div class="sponsorshipFaq">&nbsp;</div>

<cake:script>
    <script type="text/javascript">


        var sponsorshipContribution = $('#SponsorshipContribution').bind('keyup blur',function(){
            $(this).val($(this).val().replace(/[^0-9]+/g, ''));
        });
        
        
        $('#PrizeId_<?=$prize_id?>').attr('checked','checked');
            
        $('.box.prize-box').click(function(){
            value = parseInt($(this).find('b').attr('value'));
            $(this).find('input[type=radio]').attr('checked','checked');
           
            sponsorshipContribution.attr('min-value',value);
            
            if ( sponsorshipContribution.val() < value || isNaN( sponsorshipContribution.val() ) ) {
                sponsorshipContribution.val(value);
            }
 
            if (!$(this).hasClass('active')){
                $('#SponsorshipNoPrize').attr('checked',false);
            }

        }).css('cursor','pointer').filter('.active');//.click();

        $('#SponsorshipNoPrize').bind('change',function(){
            
            if ($(this).attr('checked')) {
                $('.prize.title').hide();  
                $('.module.prizes-module').hide();  
                $('.module.prizes-module input[type=radio]').attr('checked',false);
            } else {
                $('.prize.title').show();  
                $('.module.prizes-module').show();  
            }
        }).change();

        
        /*  $('#sponsorshipContributionForm').submit(function(){

            $.post( $(this).attr('action') , $(this).serialize() );

            return false ;

        }); */
    </script>
</cake:script>