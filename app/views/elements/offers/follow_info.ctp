<?php /* @var $this ViewCC */ ?>

<?

if (!empty($data['Follow'])) {

    echo $this->Html->tag('h4', __('HAVE_JOINED_TO_THIS_OFFER', true) . $this->Html->tag('p' , sprintf( __('%s MEMBERS',true) ,$data['Offer']['follow_count'])), array('class'=>'title underline facepile-title'));

    foreach ($data['Follow'] as $key => $follow) {
        $extraClass = zebra($key, 5);
        $faces[] = $this->Html->div("thumb $extraClass", $this->Media->getImage('s64', $follow['User']['avatar_file'], '/img/assets/img_default_64px.png'), array('url' => User::getLink($follow)));
    }

    echo $this->Html->div('content box faces-box', implode('', $faces));
}
?>