<?php /* @var $this ViewCC */ ?>
<div class="box box-comment comment"  id="commentId<?= $data['Comment']['id'] ?>">
        <div class="thumb">
            <a href="<?= User::getLink($data) ?>" >
            <?
                echo $this->Media->getImage('s50/',$data['User']['avatar_file'] , '/img/assets/img_default_50px.png');
            ?>
            </a>
        </div>

        <div class="page-comment">
        <?
            echo $this->Html->link(User::getName($data), User::getLink($data), array('class' => 'username', 'id' => 'userId' . $data['User']['id']));
            echo $this->Html->div('right', $this->Time->timeAgoInWords($data['Comment']['created']));
            echo $this->Html->tag('p', splitText($data['Comment']['comment']));
        ?>
    </div>
</div>

