<?php /* @var $this ViewCC */ ?>
<?
    $url=array('controller' => $this->params['controller'], 'action' => $this->params['action'], 'admin' => true);
    $model=Inflector::classify($this->params['controller']);
    $url=am($url
            , array(
            'sort' => $this->data[$model]['sort'],
            'direction' => $this->data[$model]['direction'],
            'limit' => $this->data[$model]['limit'],
            'filter' => $this->data[$model]['filter'],
            'search' => $this->data[$model]['search']
            )
    );
	
    $this->Paginator->options(array('url' => $url));
    $module=isset($module) ? $module : null;
    $extraClass=isset($extraClass) ? $extraClass : '';
    if ($module == 'legend') {
        echo $this->Html->div("box paginator legend $extraClass", $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))));
    } elseif ($module == 'paginator') {


        if ($this->params['paging'][$model]['pageCount'] > 1 ) {
?>  
            <div class="box paginator <?=$extraClass?>">
                <div class="box prev left"><?php echo $this->Paginator->prev(__('previous', true), array(), null, array('class' => 'disabled')); ?></div>
                <div class="box numbers center"><?php echo $this->Paginator->numbers(array('modulus' => 10, 'separator' => false)); ?></div>
                <div class="box next right"><?php echo $this->Paginator->next(__('next', true), array(), null, array('class' => 'disabled')); ?></div>
            </div>                        
<?
        }
    }
?>