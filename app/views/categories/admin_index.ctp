<?php

    /* @var $this ViewCC */




    echo $html->link(__("ADD_CATEGORY",true), array('action' => 'add'));

    echo "<ul>";
    
    foreach ($categorylist as $key => $value) {
        
        $editurl=$html->link(__('EDIT',true), array('action' => 'edit', $key));
        
        $upurl=$html->link(__('MOVE_UP',true), array('action' => 'moveup', $key));
        
        $downurl=$html->link(__('MOVE_DOWN',true), array('action' => 'movedown', $key));
        
        $deleteurl=$html->link(__('DELETE',true), array('action' => 'delete', $key));
        
        echo "<li>[$editurl|$upurl|$downurl|$deleteurl] ". __('CATEGORY_'.up($value),true) ."</li>";
    }
    
    echo "</ul>";
?>
