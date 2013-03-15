<?php
/* @var $this ViewCC */
$full = isset($full) ? $full : false;
if ($full) {
    $isFirst = true;

    $this->Paginator->options(array(
        'url' => array(
            'controller' => 'Posts',
            'action' => 'view',
            'post' => $id
        )
            )
    );
}
$postId = $data['Post']['id'];
?>

<div class="col col-4" id="postContent_<?= $postId ?>" >
    <div class="post-header">
        <h3>
            <?= $data['Post']['title'] ?>
            <b><?= sprintf(__("UPDATED ON %s", true), $this->Time->i18nFormat($data['Post']['modified'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')); ?></b>
        </h3> 
    </div>

    <div class="post">
        <?
        echo $this->Html->tag('p', nl2br($data['Post']['description']));
        ?>

        <!-- comments -->
        <div class="postComments" id="postComments_<?= $postId ?>" style="display:<?= $isFirst ? 'block' : 'none'; ?>"  >
            <?
            $model = 'Post';
            $formId = $model . 'AddComment_' . $postId;
            $listId = $model . 'ListComment_' . $postId;
            $content = '';

            $content .= $this->Html->div('form', $this->element('comments/add', array('model' => $model, 'id' => $postId)), array('id' => $formId));

            $comments = '';

            $commentLimit = !$full ? 3 : false;

            if (isset($data['Comment'])) { // && $isFirst


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

                if ($full) {
                    if ($this->Paginator->hasPrev()) {
                        $comments .= $this->Paginator->prev('prev');
                    }
                    if ($this->Paginator->hasNext()) {

                        $comments .= $this->Paginator->next('next');
                    }
                }
                if (count($data['Comment']) > $commentLimit && !$full) {
                    $comments .= $this->Html->link(__( 'VIEW_ALL_COMMENTS' ,true ), Post::getLink($data),array('style'=>'float:right;'));
                }
            }

            echo $content . $this->Html->div('module comments', $comments, array('id' => $listId));
            ?>
        </div>


        <div class="post action" id="postAction_<?= $postId ?>" style="display:<?= !$isFirst ? 'block' : 'none'; ?>"  >
            <span class="ui-icon site-icon medium auto-icon"></span>
            <?
            if (count($data['Comment']) >= 1 ) {
              //  echo $this->Html->link(__('VIEW_COMMENTS', true), Post::getLink($data));
                echo $this->Html->tag('span', __('VIEW_COMMENTS', true), array('class' => 'view-comment'));
            } else {
                echo $this->Html->tag('span', __('ADD_A_COMMENT', true), array('class' => 'add-comment'));
            }
            ?>
        </div>

    </div>


</div>



<cake:script>
    <script type="text/javascript">
        $('.add-comment,.view-comment').parent('div.post.action').click(function(){
            $('.postComments').hide();
            $('.post.action').show();
            $(this).hide().prev('.postComments').show();
        }).css('cursor','pointer');
    </script>

</cake:script>










