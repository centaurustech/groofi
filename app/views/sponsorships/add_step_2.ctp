<?php /* @var $this ViewCC */ ?>
<div >
    <?
    $this->set('title_for_layout', Project::getName($project));
    $this->set('pageTitle', Project::getName($project));
    
    if (!Project::belongsToOffer($project)) {
        $this->set('pageSubTitle',
        sprintf(__('PROJECT_BY %s IN CATEGORY %s' , true )
                , $this->Html->tag('span', User::getName($project), array('class' => 'highlight user-name', 'url' => User::getLink($project)))
                , $this->Html->tag('span', Category::getName($project), array('class' => 'highlight category-name', 'url' => Category::getLink($project,'projects'))) 
            )
        ); 
    } else {
        $this->set('pageSubTitle',
        sprintf(__('PROJECT_BY %s IN CATEGORY %s IN RESPONSE OF %s' , true )
                , $this->Html->tag('span', User::getName($project), array('class' => 'highlight user-name', 'url' => User::getLink($project)))
                , $this->Html->tag('span', Category::getName($project), array('class' => 'highlight category-name', 'url' => Category::getLink($project,'projects'))) 
                , $this->Html->tag('span', Offer::getName($project), array('class' => 'highlight offer-name', 'url' => Offer::getLink($project))) 
            )
        );        
    }

        echo $this->Form->create('Sponsorship', array(
            'id' => 'sponsorshipContributionForm',
            'url' => preg_replace('/\/\d+$/', '', DS . $this->params['url']['url'])
            )
        );
    ?>
    
    
    <div id="sponsorshipContribution" class="step_2" style="width:560px;float:left;">
        <h3 class="title">
            <?= __('SPONSORSHIP_CREATE_2_TITLE', true) ?>
            <span>
                <?= __('SPONSORSHIP_CREATE_2_SUBTITLE', true) ?>
            </span>
        </h3>
        <div class="green-box-contribution" >
        <?
            echo $this->Form->nonEditableInput('Sponsorship.contribution',array('label' => __('SPONSORSHIP_CREATE_2_INPUT_LABEL',true) , 'size'=> 10));
            
            
            
            if (!empty($selectedPrize)) {
                ?><div class="selected-prize"><?
                echo $this->Html->div('prize-title',__('YOUR_BENEFIT',true));
                echo $this->Html->div('prize-description',$selectedPrize['Prize']['description'] );
                ?></div><?
                
            } else {
                ?><div class="selected-prize"><?
                echo $this->Html->div('prize-title',__('YOUR_BENEFIT',true));
                echo $this->Html->div('prize-description', __('YOU_SELECT_ONLY_HELP',true));
                ?></div><?
                  
            }
            
        ?>
            
        <div class="clearfix"></div>
            
        </div>
        
    </div>

    <div id="sponsorshipPayment" style="float:right;width:360px;" >
    
        <h3 class="title">
            <?= __('SPONSORSHIP_LAST_STEP_TITLE', true) ?>
            <span>
                <?= __('SPONSORSHIP_LAST_STEP_SUBTITLE', true) ?>
            </span>
        </h3>
        <div class="box-payment">
            <?
             echo $this->element('common/message_box', array(
                    'title' => __('IMPORTANT_PAYPAL_TITLE', true),
                    'message' =>__('IMPORTANT_PAYPAL_BODY', true)  ,
                    'icon' => 'icon-alert'
                    )
                );
                ?>
            <img src="/img/assets/paypal.png" style="margin: auto;" />

        <?
        echo $this->Form->input('Sponsorship.no_prize', array('type' => 'hidden'));
        echo $this->Form->input('Prize.id', array('type' => 'hidden'));
        echo $this->Form->input('step', array('type' => 'hidden' , 'value' => 2 ));
        echo $this->Form->submit(__('SPONSORSHIP_CREATE_STEP_2_SUBMIT', true), array( 'id' => 'sponsorshipEnd' , 'before' => $this->Form->button(__('SPONSORSHIP_CREATE_STEP_2_BACK', true), array('type'=>'button' , 'onclick'=>'history.back();' ,   'id' => 'SponsorshipBack'))));
        ?>
                    
        </div>
                    
                    
                    
    </div>
<? echo $this->Form->end(); ?>
            </div>
            <cake:script>
                <script type="text/javascript">

                    $('#SponsorshipBack').click(function(){   window.location =  '<?= $url ?>' ;  return false ;  }) ;
                    
                    
               
                    $('#SponsorshipContribution').bind('click keypress keydown keyup focus',function(){   return false;  }) ;
    </script>
</cake:script>