<div class="notification comented post_comented user_feed">
     <div class="picture">
         <?
            $file = !$data['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_50px.png') : $this->Media->embed($this->Media->file('s50/' . $data['User']['avatar_file']));
            echo $this->Html->link(  $file,User::getLink($data), array('escape'=>false, 'class' => 'thumb'));
         ?>
     </div>
     <div class="head">
         <?=$this->Html->link(User::getName($data),User::getLink($data),array('class'=>'username'));?>
         <span class="ui-icon site-icon auto-icon medium">&nbsp;</span>
         <?=sprintf(
                 __('COMMENT_THE_POST %s %s',true),
                 $this->Html->link(Post::getName($data),Post::getLink($data)),
                 $this->Time->format($data['Comment']['created'],  '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y' )
         );?>
     </div>
     <div class="body">
         <?=$data['Comment']['comment']?>
     </div>
</div>