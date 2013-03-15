<?php /* @var $this ViewCC */?>


<?= $this->element ('projects/view_menu', array ('project' => $project));?>




<div class="col col-4 post" id="content" >


    <?

    if (!empty ($this->data)) {
        foreach ($this->data as $user) {

            ?>
            <div class="user sponsorship info">
                <?

                echo $this->Html->link (
                        $this->Media->getImage ('s50', $user['User']['avatar_file'], '/img/assets/img_default_50px.png'), User::getLink ($user), array ('escape' => false, 'class' => 'thumb')
                );

                echo $this->Html->tag ('h3', User::getName ($user), array ('url' => User::getLink ($user)));
                echo $this->Html->tag ('p', sprintf (__ ('IT_SUPPORTING %s PROJECTS', true), $user['User']['sponsorships_count']));

                ?>
            </div>
            <?

        }
    } else {

        ?>


        <div class="not-found-msg">
    <?=

    sprintf (
            __ ('THIS_PROJECT_WAS_NOT_SUPPORTED_YET %s', true), $this->Html->link (__ ('BE_THE_FIRST', true), Project::getLink ($project, 'back'))
    );

    ?>



        </div>

<? }?>
</div>

<?= $this->element ('projects/info_col', array ('data' => $project));?>





