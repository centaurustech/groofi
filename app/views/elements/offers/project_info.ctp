<?php /* @var $this ViewCC */ ?>

<?

if (!empty($data['Project'])) {
    
    echo $this->Html->tag('h4',__('WHANT_TO_DO_THIS',true). $this->Html->tag('p' , sprintf( __('%s MEMBERS',true) ,$data['Offer']['project_count'])), array('class'=>'title underline facepile-title'));

    foreach ($data['Project'] as $key => $project) {
        $extraClass = zebra($key, 5);
        $faces[] = $this->Html->div("thumb $extraClass", $this->Media->getImage('s64', $project['User']['avatar_file'], '/img/assets/img_default_64px.png'), array('url' => User::getLink($project)));
    }

    echo $this->Html->div('content box faces-box', implode('', $faces));
}
?>