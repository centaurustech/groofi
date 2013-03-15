<?php
/* @var $this ViewCC */
$full = isset($full) ? $full : false;
$postId = $data['Post']['id'] ;

if ($full) {
    $isFirst = true;

    $this->Paginator->options(array(
        'url' => array(
            'controller' => 'Posts',
            'action' => 'view',
            'post' => $postId,
            'user' => User::getSlug($data)
        )
            )
    );
}
$model = 'Post';
$formId = $model . 'AddComment_' . $postId;
$listId = $model . 'ListComment_' . $postId;
?>

<div class="col col-4 post" id="postContent_<?= $postId ?>" >

    <!-- POST -->
    <h3  class="post-header">
        <?= $data['Post']['title'] ?>
        <b><?= sprintf(__("UPDATED ON %s", true), $this->Time->i18nFormat($data['Post']['published'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')); ?></b>
    </h3>
    <?
    echo $this->Html->tag('p', nl2br($data['Post']['description']));
    ?>
    <!-- POST -->

    <div class="postComments"   id="postComments_<?= $postId ?>" >

        <?= $this->Html->div('form', $this->element('comments/add', array('model' => $model, 'id' => $postId)), array('id' => $formId)); ?>
        <?= $this->Html->div('module comments', '', array('id' => $listId)); ?>

        <?
        /*

          $comments = '';
          if (isset($data['Comment']) && $isFirst) {
          $commentLimit = !$full ? 3 : false;

          foreach ($data['Comment'] as $key => $commentData) {
          if ($key < $commentLimit || $commentLimit === false) {
          if (!isset($commentData['Comment'])) {
          $commentData['Comment'] = $commentData;
          }
          $comments .= $this->element('comments/comment', array('data' => $commentData));
          } else {
          break;
          }
          }




          if (count($data['Comment']) > $commentLimit && !$full) {
          $comments .= $this->Html->link(__('VIEW_ALL_COMMENTS', true), Post::getLink($data) . DS . 1);
          } elseif ($full) {


          $comments .= $this->Paginator->hasPrev() ? $this->Paginator->prev(__('PREV_PAGE', true)) : '';
          $comments .= $this->Paginator->hasNext() ? $this->Paginator->next(__('NEXT_PAGE', true)) : '';
          }
          }

          //   echo $content . $this->Html->div('module comments', $comments, array('id' => $listId));
         * 
         */
        ?>

    </div>



</div>


<cake:script>
    <script type="text/javascript">
  
        $('#<?= $listId ?>').loader('/comments/index/posts/<?=$postId?>' );
        
        $('.paging a') . live('click', function() {
            $('#<?= $listId ?>').loader($(this).attr('href'));
            return false;
        });
    </script>
</cake:script>
















