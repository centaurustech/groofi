<?php /* @var $this ViewCC */ ?>
<?
foreach ($this->data as $key => $commentData) {
    if (!isset($commentData['Comment'])) {
        $commentData['Comment'] = $commentData;
    }
    echo $this->element('comments/comment', array('data' => $commentData));
}
?>
 




