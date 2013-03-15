<div class="notification updated project_updated user_feed">
*******
    <div class="picture">
        <?
        $file = !$data['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_50px.png') : $this->Media->embed($this->Media->file('s50/' . $data['User']['avatar_file']));
        echo $this->Html->link($file, User::getLink($data), array('escape' => false, 'class' => 'thumb'));
        ?>
    </div>
    <div class="head">
        <?= $this->Html->link(User::getName($data), User::getLink($data), array('class' => 'username')); ?>
        <span class="ui-icon site-icon auto-icon medium">&nbsp;</span>
        <?=
        sprintf(
                __('HAS_UPDATED_THE_PROJECT %s %s', true), $this->Html->link(Project::getName($data), Project::getLink($data)), $this->Time->format($data['Post']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y')
        );
        ?>
    </div>
    <div class="body">
        <?
        echo $this->Html->tag('h3', Post::getName($data), array('url' => Post::getLink($data)));
        echo $this->Html->tag('p', $this->Text->truncate(strip_tags($data['Post']['description']), 400, array('ending' => '... ' . $this->Html->link(__('VIEW_UPDATE', true), Post::getLink($data)))));
        ?>
    </div>
</div>
