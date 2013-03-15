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
?>
<ul class="pageElement tabs">

    <li class="tab-projects"><a href="<?= Project::getLink($project); ?>"><? __('THE_PROJECT') ?></a></li>
    <? if (Project::isPublic($project)) { ?>
        <li class="tab-sponsorships"><a href="<?= Project::getLink($project, 'sponsorships'); ?>"><? __('PROJECT_SPONSORS') ?></a></li>
        <li class="tab-comments"><a href="<?= Project::getLink($project, 'comments'); ?>"><? __('COMMENTS') ?></a></li>
        <? if ($project['Project']['post_count'] > 0 ) {?>
            <li class="tab-posts"><a href="<?= Project::getLink($project, 'updates'); ?>"><? __('UPDATES') ?></a></li>
        <? } ?>
    <? } ?>
    <? if (Project::isOwnProject($project)) { ?>
        <? if (!Project::isPublic($project)) { ?>
            <li class="action"><a href="<?= Project::getLink($project, 'edit'); ?>"><? __('EDIT_THIS_PROJECT') ?></a></li>
            <li class="action"><a href="<?= Project::getLink($project, 'publish_2'); ?>" class="confirm"><? __('PUBLISH_THIS_PROJECT') ?></a></li>
        <? } else { ?>
        <li class="action"><a href="<?= Project::getLink($project, 'create-update'); ?>"><? __('CREATE_UPDATE') ?></a></li>
        <? } ?>
    <? } else { ?>
        <li class="action ajax unfollow" style="<?= (!Follow::isFollowing($project) ? 'display:none' : '') ?>" ><a href="<?= Project::getLink($project, 'unfollow'); ?>" rel="nofollow"><? __('UNFOLLOW_THIS_PROJECT') ?></a></li>
        <li class="action ajax follow"   style="<?= (Follow::isFollowing($project) ? 'display:none' : '') ?>" ><a href="<?= Project::getLink($project, 'follow'); ?>" rel="nofollow"><? __('FOLLOW_THIS_PROJECT') ?></a></li>
    <? } ?>
</ul>


<cake:script>
    <script type="text/javascript">
        $('.tab-<?= low($this->params['controller']) ?>').addClass('active');
        $('a.confirm').click(function(){
            publishProject(function() {
                window.location = '<?= Project::getLink($project, 'publish') ?>' ;
            });
            return false ;
        });    
        $('li.action.ajax a').click(function(){
            var e = $(this) ;
            $.get(e.attr('href') , function(r){
                li =  e.parent('li').hide();
                if ( li.hasClass('follow') ) {
                    $('li.unfollow').show();
                } else {
                   
                    $('li.follow').show();
                }
               
               
               
               
               
               
            });
            return false ;
        });
    </script>
</cake:script>