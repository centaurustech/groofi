<?php
 $full = !(bool) $this->params['isAjax'];
if ($full) {
    /* @var $this ViewCC */

    echo $this->element('projects/view_menu', array('project' => $project));
}
?>


<? if ($full) { ?><div class="col col-4 post" id="content" ><? } ?>
    <?
    $formId = $model . 'AddComment_' . $id;
    $listId = $model . 'ListComment_' . $id;
    $content = '';
   

    if ($full) {
        //$content .= $this->element( low(Inflector::pluralize($model)) . '/view_menu', array('active' => 'comments' , 'slug' => $id ));
        $content .= $this->Html->div('form', $this->element('comments/add', array('model' => $model, 'id' => $id)), array('id' => $formId));
    }

    $comments = '';
    foreach ($this->data as $data) {
        $comments .= $this->element('comments/comment', array('data' => $data));
    }

    $paging  =  $this->Paginator->hasPrev() ? $this->Paginator->prev(__('PREV_PAGE', true)) : '' ;
    $paging .= $this->Paginator->hasNext() ? $this->Paginator->next(__('NEXT_PAGE', true)) : '' ;
    $comments .= $this->Html->div('comments paging', $paging);
    

    echo $content . ( $full ? $this->Html->div('module comments', $comments, array('id' => $listId)) : $comments);
    ?>
<? if ($full) { ?></div><? } ?>
<?
if ($full) {
    echo $this->element('projects/info_col', array('data' => $project));
}
?>


<? if ($full) { ?><cake:script><? } ?>
<script type="text/javascript">
$('.paging a') . live('click', function() {
                    $('#<?= $listId ?>').loader($(this).attr('href'));
                    return false;
                });
</script>
<? if ($full) { ?></cake:script><? } ?>
