<?php
/* @var $this ViewCC */
$full = isset($full) ? $full : false;
if ($full) {
    $isFirst = true;

    $this->Paginator->options(array(
        'url' => array(
            'controller' => 'Posts',
            'action' => 'view',
            'post' => $id,
            'user' => User::getSlug($data)
        )
            )
    );
}
$postId = $data['Post']['id'];
?>

<div class="col col-4 post" id="postContent_<?= $postId ?>" >
    <div class="post-header">
        <h3>
            <?= $data['Post']['title'] ?>
            <b><?= sprintf(__("UPDATED ON %s", true), $this->Time->i18nFormat($data['Post']['published'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')); ?></b>
        </h3>
    </div>
    <?
    echo $this->Html->tag('p', nl2br($data['Post']['description']));
    ?>


    <div class="postComments"   id="postComments_<?= $postId ?>" >aca van los comments</div>



</div>




<cake:script>
    <script type="text/javascript">
        $('.paging a') . live('click', function() {
            $('#postComments_<?= $postId ?><?= $listId ?>').loader($(this).attr('href'));
            return false;
        });
    </script>
</cake:script>
















