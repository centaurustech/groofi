<div class="notification about_to_finish offer_about_to_finish user_feed">
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
                 __('THE_OFFER_IS_ABOUT_TO_FINISH %s %s',true),
                 $this->Html->link(Offer::getName($data),Offer::getLink($data)),
                 $this->Time->format($data['Offer']['end_date'],  '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y' )
         );?>
     </div>
     <div class="body">
         <?  echo $this->element("offers/profile_offer", array(
                        'offer' => $data,
                        'data' => $data 
                    )
                );
        ?>
       
     </div>
</div>
