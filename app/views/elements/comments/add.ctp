<?php /* @var $this ViewCC */ ?>

<?
    $formId=$model . 'AddComment_' . $id;
    $listId=$model . 'ListComment_' . $id;
    /**/

    echo $this->Form->create('Comment', array('url' => Router::url(array('controller' => 'comments', 'action' => 'add', $model, $id))));
    echo $this->Form->input('Comment.model', array('value' => $model, 'type' => 'hidden'));
    echo $this->Form->input('Comment.model_id', array('value' => $id, 'type' => 'hidden'));
    echo $this->Form->input('Comment.comment', array('type' => 'textarea','style'=>"width:558px;"));
    echo $this->Form->submit(__('SEND',true) );
    echo $this->Form->end();
?>
<cake:script>
<script type="text/javascript">
        $('#<?= $formId ?>').submit(function(){

            h = function() {
                data = $('#<?= $formId ?> form').serialize();
                $('#<?= $formId ?> .submit > *').hide();
                var loader = $('<div class="loader"><img src="/img/assets/loader.gif" alt="Loading..."/></div>');
                $('#<?= $listId ?>').prepend(loader);
                $.post( $('#<?= $formId ?> form').attr('action') , data , function (data){
                    $('div.error-message').remove() ;
                    if (!data.error) {
                        $('#<?= $formId ?> textarea').val('');
                        $.get( '<?= Router::url(array('controller' => 'comments', 'action' => 'view')) ?>/' + data.comment_id , function(data){
                            $('#<?= $listId ?>').prepend(data);
                        });
                    } else {
                        for ( err in data.errors ){
                            $('<div>').addClass('error-message').text( data.errors[err] ).insertAfter( $('#'+err) );
                        }
                    }
                    loader.remove();
                    $('#<?= $formId ?> .submit > *').show();
            });
        }
        Auth.exec(h);
        return false ;
    })

</script>
</cake:script>