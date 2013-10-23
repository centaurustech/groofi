<?
$funded = sprintf(__('%s%% ( '.$moneda.' %s of '.$moneda.' %s )', true), Project::getFundedValue($project),/* money_format('%(#10n', */Project::getCollectedValue($project)/*)*/, /*money_format('%(#10n',*/ $project['Project']['funding_goal'])/*)*/;
$fundedn = Project::getFundedValue($project) >= 100 ? 1 : 0;
$moneda=Project::getMoneda($project);
switch ($project['Project']['status']) {
    case PROJECT_STATUS_NEW :
        $status = __('PROPOSAL_PROJECT_STATUS', true);
        break;
    case PROJECT_STATUS_APROVED :
        $status = __('APPROVED_PROJECT_STATUS', true);
        break;
    case PROJECT_STATUS_REJECTED :
        $status = __('REJECTED_PROJECT_STATUS', true);
        break;
    case PROJECT_STATUS_PUBLISHED :
        $status = __('PUBLISHED_PROJECT_STATUS', true);
        break;
    default :
        $status = __('UNKNOWN_PROJECT_STATUS', true);
        break;
}
?>

<div style="width:560px;float: left;" class="main-info">

    <? if (!Project::belongsToOffer($project)) { ?> 
        <h2><?= sprintf(__('PROJECT %s FROM %s IN THE CATEGORY %s', true), $this->Html->tag('span', Project::getName($project)), $this->Html->tag('span', User::getName($project)), $this->Html->tag('span', Category::getName($project))); ?> </h2>
    <? } else { ?> 
        <h2><?= sprintf(__('PROJECT %s FROM %s  IN THE CATEGORY %s IN RESPONSE OF %s', true), $this->Html->tag('span', Project::getName($project)), $this->Html->tag('span', User::getName($project)), $this->Html->tag('span', Category::getName($project)), $this->Html->tag('span', Offer::getName($project))); ?> </h2>
    <? } ?> 

    <h3><? __('SHORT_DESCRIPTION') ?></h3>
    <p class="short-description">
        <?php echo $project['Project']['short_description']; ?>
    </p>  

    <? if ($project['Project']['reason']) { ?>
        <h3><? __('REASON') ?></h3>
        <p class="reason">
            <?php echo $project['Project']['reason']; ?>
        </p>  
    <? } ?> 

    <h3><? __('MOTIVATION') ?></h3>
    <p class="motivation">
        <?php echo $project['Project']['motivation']; ?>
    </p>  



    <div class="full-description post"> 
        <h3><? __('PROJECT_MAIN_POST') ?></h3>
        <?php echo $project['Project']['description']; ?> 
    </div>

</div>


<div  style="width:380px;float: right;" class="actions">
    <?
    if (Project::isFinished($project)) {
        $date = sprintf(__('THE_PROJECT_HAS_FINISHED %s', true), $this->Time->format($project['Project']['end_date'], '%d/%m/%Y'));
        $daten = 3;
    } elseif (Project::isAboutToFinish($project)) {
        $date = sprintf(__('FROM %s TO %s %s days', true), $this->Time->format($project['Project']['publish_date'], '%d/%m/%Y'), $this->Time->format($project['Project']['end_date'], '%d/%m/%Y'), $project['Project']['time_left']);
        $daten = 2;
    } elseif ($project['Project']['time_left'] > DAYS_TO_BE_FINISHING) {
        $date = sprintf(__('FROM %s TO %s %s days', true), $this->Time->format($project['Project']['publish_date'], '%d/%m/%Y'), $this->Time->format($project['Project']['end_date'], '%d/%m/%Y'), $project['Project']['time_left']);
        $daten = 1;
    } else {
        $date = '-';
        $daten = 0;
    }

    if ($project['Project']['status'] == PROJECT_STATUS_NEW) {
        echo $this->Html->link(__('APPROVE_PROPOSAL_WITH_EXPRESSCHECKOUT_PAYMENTS', true), Router::url(array('controller' => 'projects', 'action' => 'approve', $project['Project']['id'], EXPRESSCHECKOUT, 'admin' => true)), array('class' => 'auto-process confirm reload'));
        echo '<div style="display:none">'.$this->Html->link(__('APPROVE_PROPOSAL_WITH_PREAPPROVAL_PAYMENTS', true), Router::url(array('controller' => 'projects', 'action' => 'approve', $project['Project']['id'], PREAPPROVAL, 'admin' => true)), array('class' => 'auto-process confirm reload')).'</div>';
        echo $this->Html->link(__('REJECT_PROPOSAL', true), Router::url(array('controller' => 'projects', 'action' => 'reject', $project['Project']['id'], 'admin' => true)), array('class' => 'auto-process confirm reload'));
    }
    if (Project::isPublished($project)) {
        echo $this->Html->link(__('VIEW_BALANCE', true), array('action' => 'projectBalance', $project['Project']['id']));
        echo $this->Html->link(__('VIEW_PROJECT_PAGE', true), Project::getLink($project), array('target' => '_blank'));

        $flags = $this->Form->input("Project.{$project['Project']['id']}.enabled", array('label' => 'ENABLED_PROJECT', 'type' => 'checkbox', 'checked' => ( $project['Project']['enabled'] ? true : false )));
        $flags .= $this->Form->input("Project.{$project['Project']['id']}.outstanding", array('label' => 'SHOW_IN_HOMEPAGE', 'type' => 'checkbox', 'checked' => ( $project['Project']['outstanding'] ? true : false )));
        $flags .=$this->Form->input("Project.{$project['Project']['id']}.leading", array('label' => 'STUDY_CASE', 'type' => 'checkbox', 'checked' => ( $project['Project']['leading'] ? true : false )));
        $flags .= '<div style="display:none">'.$this->Html->div('input radio', $this->Form->radio("Project.{$project['Project']['id']}.payment_type", array(
                            EXPRESSCHECKOUT => __('EXPRESSCHECKOUT_PAYMENT', true),
                            /*PREAPPROVAL => __('PREAPPROVAL_PAYMENT', true),*/
                                ), array(
                            'legend' => __('PAYMENT_TYPE', true),
                            'value' => $project['Project']['payment_type']
                                )
                        )
        ).'</div>';
        echo $this->Html->div('flags', $flags);

        if (Project::belongsToOffer($project)) {
            echo $this->Html->tag('span', __('OFFER_RESPONSE', true), array('class' => 'status offer_response'));
        }








        $funded = sprintf(__('%s%% ( '.$moneda.' %s of '.$moneda.' %s )', true), Project::getFundedValue($project), /*money_format('%(#10n',*/ Project::getCollectedValue($project)/*)*/, /*money_format('%(#10n',*/ $project['Project']['funding_goal'])/*)*/;
        $FundedValue = Project::getFundedValue($project, 100);
        $fundedn = $FundedValue >= 100 ? 1 : 0;


        $bar = $this->Html->div('bar', '', array('style' => "width:{$FundedValue}%"));
        $text = $this->Html->div('text', $funded);


        echo ( $funded != '' ? $this->Html->div("graph funded_status funded_$fundedn", $bar . $text) : '' );
    }


    echo $this->Html->tag('span', $status, array('class' => 'status project status_' . $project['Project']['status']));
    echo $this->Html->div("status status date_status date_$daten", $date);
    ?>
</div>


<div  style="width:380px;float: right;" class="extra-info">



    <ul class="status-info info">
        <li><b>Nombre y apellido</b><?= User::getName($project); ?> [<a href="<?= User::getLink($project); ?>" target="_blank"><? __('VIEW_PROFILE') ?></a>] </li>
        <li><b>email</b><?= $project['User']['email'] ?></li>
        <li><b>Idioma del proyecto</b><?= $project['Project']['idioma'] ?></li>
        <li><a  class="editproy" href="/projects/editprojects/<?=$project['Project']['id']?>/1"><span class="editp"></span>Editar</a></li>
        <div class="link_sponsor"><a href="/projects/adminuploadimage/<?=$project['Project']['id'].'/'.base64_encode('1') ?>" >Agregar Imagen para Sponsor</a></div>



<? if (!Project::isPublic($project)) { ?>
            <li><b><? __('PROJECT_CREATED') ?></b><? echo $this->Time->format($project['Project']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'); ?></li>
            <li><b><? __('PROJECT_FUNDING_GOAL') ?></b><?=$moneda?> <?php echo $project['Project']['funding_goal']; ?></li>
<? } ?>
        <? if (Project::isPublic($project)) { ?>



            <li><h3><? __('PROJECT_STATS') ?></h3></li>

            <li><b><? __('PROJECT_BAKES') ?></b><? echo sprintf(__('%s SPONSORSHIPS', true), $project['Project']['sponsorships_count']); ?></li>
            <li><b><? __('PROJECT_UPDATES') ?></b><?php echo $project['Project']['post_count']; ?></li>
            <li><b><? __('PROJECT_COMMENTS') ?></b><?php echo $project['Project']['comment_count']; ?></li>
            <li><b><? __('PROJECT_FOLLOWS') ?></b><?php echo $project['Project']['follow_count']; ?></li>
<? } ?> 

        <? if (Project::belongsToOffer($project)) { ?>
            <li><h3><? __('RELATED_OFFER') ?></h3></li>
            <li><?php echo $this->Html->link(Offer::getName($project), Offer::getLink($project), array('target' => '_BLANK')); ?></li>
<? } ?> 

    </ul>

    <div class="">
<?
if ($video = getVideoEmbed($project['Project']['video_url'], 340, 262)) {
    ?><h3><? __('PROJECT_VIDEO') ?></h3><?
        echo $this->Html->div('project-video', $video);
    }
?><h3><? __('PROJECT_IMAGE') ?></h3><?
        $file = $this->Media->file('l280/' . $project['Project']['image_file']);
        $image = $this->Media->embed($file);
        echo $this->Html->div('project-image', ( $image ? $image : $this->Html->image('/img/assets/img_default_280x210px.png')));
?>

    </div>




<?php if (!empty($project['Link'])): ?>
        <div class="related">
            <h3><?php __('Related Links'); ?></h3>
            <ul>
    <?php
    $i = 0;
    foreach ($project['Link'] as $link):
        ?>
                    <li>  
                    <?php echo $this->Html->link($link['link'], $link['link'], array('target' => '_BLANK')); ?>
                    </li>
                    <?php endforeach; ?>
            </ul>
        </div>
<?php endif; ?>



<?php if (!empty($project['Prize'])): ?>
        <div class="related">
            <h3><?php __('Related Prizes'); ?> (<?=$moneda?>)</h3>
            <ul>
    <?php
    foreach ($project['Prize'] as $prize):
        ?>
                    <li>
                        <span class="value"><?php echo $prize['value']; ?></span>
                        <span class="prize"><?php echo $prize['description']; ?></span>
                    </li>
    <?php endforeach; ?>
            </ul>
        </div>
<?php endif; ?>




</div>


<cake:script>

    <script type="text/javascript">
        $('.flags input[type=checkbox],.flags input[type=radio]').change(function(){
            var e = $(this).attr('disabled',true) ;
            data = {} ;
            if (e.attr('type') == 'checkbox' ) {
                data[e.attr('name')] = e.attr('checked') ? 1 : 0 ;
            } else {
                data[e.attr('name')] = e.val();
            }
            $.post('/admin/projects/flag', data ,function(response){
                e.attr('disabled',false);
            });
        });
        
      
        
    </script>
</cake:script>