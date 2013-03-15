<?php /* @var $this ViewCC */ ?>
 
<?= $this->element('offers/view_menu', array('offer' => $offer )); ?>


<div class="col col-4 post"   id="content" >
    <?
        $formId=$model . 'AddComment_' . $id;
        $listId=$model . 'ListComment_' . $id;
        $content='';
        $full=!(bool) $this->params['isAjax'];

        if ($full) {

            $content .= $this->Html->div('form', $this->element('comments/add', array('model' => $model, 'id' => $id)), array('id' => $formId));
        }
        $comments='';
        foreach ($this->data as $data) {
            $comments .= $this->element('comments/comment', array('data' => $data));
        }

        $paging=$this->Paginator->hasPrev() ? $this->Paginator->prev(__('PREV_PAGE', true)) : '';
        $paging .= $this->Paginator->hasNext() ? $this->Paginator->next(__('NEXT_PAGE', true)) : '';
        $comments .= $this->Html->div('paging', $paging);

        echo $content . ( $full ? $this->Html->div('module comments', $comments, array('id' => $listId)) : $comments);
    ?>
</div>

<cake:script>
        <script type="text/javascript">
            $('.paging a').live('click',function(){
                $('#<?= $listId ?>').loader($(this).attr('href'));
                return false ;
            });
        </script>
</cake:script>
    
<div class="col col-5 right offer-info"   id="content" >
    <?php
        echo $this->element('offers/view_info', array('data' => $offer));
        echo $this->element('users/mini_info', array('data' => $offer));
    ?>
</div>



