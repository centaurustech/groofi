<div class="notification created project_created user_feed">
     <div class="picture">
         <?
            $file = !$data['User']['avatar_file'] ? $this->Html->image('/img/assets/img_default_50px.png') : $this->Media->embed($this->Media->file('s50/' . $data['User']['avatar_file']));
            echo $this->Html->link(  $file,User::getLink($data), array('escape'=>false, 'class' => 'thumb'));
         ?>
     </div>
     <div class="head">
        <?=$this->Html->link(User::getName($data),User::getLink($data),array('class'=>'username'));?>
         <span class="ui-icon site-icon auto-icon medium">&nbsp;</span>
        
         <? 
         if (Project::belongsToOffer($data)) {
                          echo sprintf(
                 __('HAS_CREATED_THE_PROJECT %s IN RESPONSE OF %s %s',true),
                 $this->Html->link(Project::getName($data),Project::getLink($data)),
                 $this->Html->link(Offer::getName($data),Offer::getLink($data)),
                 $this->Time->format( $data['Project']['publish_date'] ,  '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y' )
         );
         } else { 
             echo sprintf(
                 __('HAS_CREATED_THE_PROJECT %s %s',true),
                 $this->Html->link(Project::getName($data),Project::getLink($data)),
                 $this->Time->format( $data['Project']['publish_date'] ,  '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y' )
         );
             
         }
         ?>
         
         
     </div>
     <div class="body">
         <?  echo $this->element("projects/profile_project", array(
                        'project' => $data,
                        'data' => $data 
                    )
                );
        ?>
       
     </div>
</div>
