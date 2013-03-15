<?php /* @var $this ViewCC */ ?>
<ul class="pageElement tabs user-profile">
    <?
    $user = isset($user) ? $user : $this->data;

    $owner = User::isOwner($this->data);




    $offerCount = ( $owner ? $this->data['User']["offer_count"] + $this->data['User']["offer_proposal_count"] : $this->data['User']["offer_count"] ) + $this->data['User']["follow_offer_count"];
    $projectCount = $owner ? $this->data['User']["project_count"] + $this->data['User']["project_proposal_count"] : $this->data['User']["project_count"];

    $hasTab = false;
    if ($owner) {
        $active = $section == 'wall' ? 'active' : '' ;
        echo $this->Html->tag('li', $this->Html->link(__('ACTIVITY', true), Router::url(array('controller' => 'notifications', 'action' => 'wall'))), array('class' => $active));
    }

     $active = $section == 'activity' ? 'active' : '' ;
     echo $this->Html->tag('li',$this->Html->link(__('USER_ACTIVITY', true), User::getLink($this->data,'activity')), array('class' => $active));





    if ($projectCount > 0) {
        $active = $section == 'projects' ? 'active' : '' ;
        $hasTab = true;
        $url = User::getLink($this->data, 'projects');
        echo $this->Html->tag('li', $this->Html->link(sprintf(__('USER_PROJECTS %s', true), $projectCount), $url) , array('class' => $active));
    } elseif ($owner) {
        echo $this->Html->tag('li', $this->Html->link(__('CREATE_A_PROJECT', true), Router::url(array('controller' => 'projects', 'action' => 'add'))));
    }

    if ($offerCount > 0) {
        $hasTab = true;
        $active = $section == 'offers' ? 'active' : '' ;
        $url = User::getLink($this->data, 'offers');
        echo $this->Html->tag('li', $this->Html->link(sprintf(__('USER_OFFERS %s', true), $offerCount), $url), array('class' => $active));
    } elseif ($owner) {
        echo $this->Html->tag('li', $this->Html->link(__('CREATE_AN_OFFER', true), Router::url(array('controller' => 'offers', 'action' => 'add'))));
    }



    if ($this->data['User']["sponsorships_count"] > 0) {
        $hasTab = true;
        $active = $section == 'sponsorships' ? 'active' : '' ;
        $url = User::getLink($this->data, 'bakes');
        echo $this->Html->tag('li', $this->Html->link(sprintf(__('USER_SPONSORSHIPS %s', true), $this->data['User']["sponsorships_count"]), $url), array('class' => $active));
    }

    if ($this->data['User']["follow_count"]  > 0) {
        $hasTab = true;
        $active = $section == 'follows' ? 'active' : '' ;
        $url = User::getLink($this->data, 'follows');
        echo $this->Html->tag('li', $this->Html->link(sprintf(__('USER_FOLLOWS %s', true), $this->data['User']["follow_count"]), $url), array('class' => $active));
    }
    ?>
</ul>




<? if (!$hasTab) {

    //echo 'Sin tabs papa' ;
} ?>