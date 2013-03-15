
<div class="box box-project box-profile-project" id="project_<?= $project['Project']['id'] ?>">
    <?php
    /* @var $this ViewCC */
    if ($project) {

        $extra = Project::isFunded($project) ? '<div class="fundedProject"></div>' : '';
        echo $this->Html->div("thumb",
                $this->Media->getImage('l280', $project['Project']['image_file'], '/img/assets/img_default_280x210px.png').
                $extra
        );
        // info
        $info = $this->Html->tag('h3', $project['Project']['title'], array('class' => 'title', 'url' => Project::getLink($project)));

        if (isset($data['City']) && City::getName($data) != '') {
            $info .= $this->Html->tag('h4', sprintf(
                                    __('BY %s FROM %s', true), $this->Html->link(
                                            User::getName($data)
                                            , User::getLink($data)
                                    ), $this->Html->link(
                                            City::getName($data)
                                            , City::getLink($data, 'projects')
                                    )
                            )
                            , array('class' => 'sub-title')
            );
        } else {
            $info .= $this->Html->tag('h4', sprintf(
                                    __('BY %s', true), $this->Html->link(
                                            User::getName($data)
                                            , User::getLink($data)
                                    )
                            )
                            , array('class' => 'sub-title')
            );
        }
        $info .= $this->Html->tag('p', $project['Project']['short_description'], array('class' => 'description'));


        /* catregory */
        if (isset($project['Category'])) {

            $info .= $this->Html->link(
                            $this->Html->tag(
                                    'span'
                                    , '&nbsp;'
                                    , array(
                                'class' => 'site-icon small icon-tag'
                                    )
                            )
                            . Category::getName($project)
                            , Category::getLink($project, 'projects')
                            , array(
                        'class' => 'category tag'
                        , 'escape' => false
                            )
            );
        }

        echo $this->Html->div('info', $info);






        // Project status info
        if (Project::isPublic($project)) {
            ?>
            <div class="projectStats stats">

                <div class="graph">
                    <div class="bar"></div>
                    <div class="progress"></div>
                </div>

                <div class="statBox bottom left bl"><b><?= Project::getFundedValue($project) ?>% </b><? __('FUNDED') ?></div>

                <div class="statBox bottom left bl"><b>$<?= Project::getCollectedValue($project); ?></b><? __('PLEDGED') ?></div>

                <div class="statBox bottom left bl"><b><?= $project['Project']['sponsorships_count']; ?></b><? __('SPONSORSHIPS') ?></div>

                <? if (!Project::isFinished($project)) { ?>
                    <div class="statBox bottom right br"><b><?= $project['Project']['time_left']; ?></b><? __('DAYS_LEFT') ?></div>

                <? } elseif (Project::isFunded($project)) { ?>
                    <div class="statBox bottom right br green"><b><? __('PROJECT_FUNDED_INFO') ?></b>&nbsp;</div>
                <? } elseif (!Project::isFunded($project)) { ?>
                    <div class="statBox bottom right br green"><b><? __('PROJECT_NOT_FUNDED_INFO') ?></b>&nbsp;</div>

                <? } ?>

                <div class="clearfix">&nbsp;</div>
            </div>
            <?
        }
        $updates = '';

        if (isset($project['Post'])) {

            /* Project updates */
            foreach ($project['Post'] as $update) {
                $update = array('Post' => $update);
                $updates[] = $this->Html->tag('li', $this->Html->link(
                                        Post::getName($update), Post::getLink($update)
                                )
                                . $this->Html->tag('span', sprintf(
                                                __('CREATED_ON %s', true), $this->Time->i18nFormat($project['Project']['end_date'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')), array('class' => 'highlight')
                                )
                                . ( Project::isOwnProject($project) ? " ( " . $this->Html->link(__('EDIT', true), Post::getLink($update, 'edit')) . ' )' : '' )
                                . ' / ' . ( $update['Post']['public'] == 1 ? __('PUBLISHED', true) : __('UN_PUBLISHED', true) ) . ''
                );
            }
        }


        if (!Project::isPublic($project)) { //
            $actions['auth'][] = $this->Html->link(__('DELETE', true), "/projects/delete/{$project['Project']['id']}", array('class' => 'confirm')); // cancel proposal | delete project
            if (Project::isEnabled($project)) {
                $actions['status'] = $this->Html->div("extra message message-box orange", __('PROJECT_PENDING_PUBLISH', true));
                $actions['auth'][] = $this->Html->link(__('PREVIEW', true), "/projects/view/{$project['Project']['id']}");
                $actions['auth'][] = $this->Html->link(__('EDIT', true), "/projects/edit/{$project['Project']['id']}");
            } else {
                $actions['status'] = $this->Html->div("extra message message-box blue", __('PROJECT_PENDING_APPROVAL', true));
            }
        } elseif ($project['Project']['public'] == 1) {
            $actions['auth'][] = $this->Html->link(__('VIEW', true), "/projects/view/{$project['Project']['id']}");
            $actions['auth'][] = $this->Html->link(__('CREATE_UPDATE', true), "/project/{$project['Project']['id']}/create-update"); // cancel proposal | delete project

            if (Project::isFunded($project)) {
            $actions['auth'][] = $this->Html->link(__('VIEW_SPONSORS', true), "/projects/sponsors/{$project['Project']['id']}"); // cancel proposal | delete project
            }

            if (!empty($updates)) {
                $actions['auth'][] = $this->Html->div('updates-box-toggler', sprintf(__('PROJECT_UPDATES %s', true), count($updates)), array('id' => 'projectUpdate_' . $project['Project']['id']));
                $updates = $this->Html->div('box project-updates-box updates-box', $this->Html->tag('ul', implode('', $updates)));
            }
        }

        if (!empty($actions)) {
            $extra = '';
            if (!empty($actions['status'])) {
                echo $this->Html->div('project-status', $actions['status']);
            }
            echo $this->Html->div('clearfix', '');
            if (!empty($actions['auth']) && Project::isOwnProject($project)) {
                echo $this->Html->div('project-auth-actions auth-actions ', implode('&nbsp;|&nbsp;', $actions['auth']) . $updates);
            }
        }
    } else {
        trigger_error("ERROR : project data is not found");
    }
// Project updates...
    ?>
</div>

<cake:script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#project_<?= $project['Project']['id'] ?> .progress').width(0).animate({
                'width' : '<?= Project::getFundedValue($project, 100) ?>%'
            }, 1000 );
        });

        $('#project_<?= $project['Project']['id'] ?> a.confirm').click(function(){
            e = $(this) ;
            deleteProject(function(){
                window.location = '<?= Project::getLink($project, 'delete') ?>' ;
            });
            return false ;
        });


        $('.updates-box-toggler#projectUpdate_<?= $project['Project']['id'] ?>').click(function(){
            $(this).next('.updates-box').children('ul').toggle();
        }).css('cursor','pointer');
    </script>
</cake:script>