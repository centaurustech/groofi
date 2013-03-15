<?php /* @var $this ViewCC */ ?>
<div class="filters">



    <?
    $url = array('controller' => $this->params['controller'], 'action' => $this->params['action'], 'admin' => true);

    $model = Inflector::classify($this->params['controller']);
    $url = am($url, array(
        'sort' => $this->data[$model]['sort'],
        'direction' => $this->data[$model]['direction'],
        'limit' => $this->data[$model]['limit'],
        'filter' => $this->data[$model]['filter'],
        'search' => $this->data[$model]['search']
            )
    );


    foreach ($url as $key => $value) {
        if (empty($value)) {
            unset($url[$key]);
        }
    }

    echo $this->Form->create($model, array('url' => $url, 'id' => 'searchForm'));
    ?> <div class="options" style="display:none;"><?
    foreach ($this->data['autoPaginateOptions'] as $field => $autoPaginateOption) {
        $options = array();
        $filters = array();



        if ($field == 'direction') {
            $autoPaginateOption = array(
                'DESC' => '<span class="ui-icon ui-icon-triangle-1-n" style="display:inline-block">&nbsp;</span>',
                'ASC' => '<span class="ui-icon ui-icon-triangle-1-s" style="display:inline-block">&nbsp;</span>',
            );
            $options['legend'] = '&nbsp;';
            foreach ($autoPaginateOption as $option => $foo) {

                $filters[$option] = $foo;
            }
        } else {
            if (is_array($autoPaginateOption)) {
                foreach ($autoPaginateOption as $key => $value) {
                    if ($key != 'default') {
                        if (is_numeric($key) && !is_numeric($value)) {
                            $filters[$value] = __(up('ADMIN_' . $this->name . '_FILTER_' . $field . '_' . $value), true);
                        } elseif (!is_numeric($value)) {
                            $filters[$key] = __(up('ADMIN_' . $this->name . '_FILTER_' . $field . '_' . $key), true);
                        } else {
                            $filters[$key] = $value;
                        }
                    } else {
                        $filters[$value] = __(up('ADMIN_' . $this->name . '_FILTER_' . $field . '_' . up($value)), true);
                    }
                }
            }
        }

        if (!empty($filters)) {
            echo $this->Modules->paginationFilters($field, $filters, $url, $options);
        }
    }
    ?>
    </div>
    <?
    $searchBox = $this->Form->input('page', array('type' => 'hidden', 'value' => $this->Paginator->current()));
    $searchBox .= $this->Form->input(
                    'search', array(
                'label' => __('SEARCH_INPUT', true),
                'after' => $this->Form->submit(__('SEARCH', true), array('div' => false, 'class' => 'ui-button')).
                        $this->Form->button(__('OPTIONS', true), array( 'class'=>'btn ui-corner-all' , 'style'=>'margin-left:10px;' ,'type'=>'button', 'onclick' => "$('.filters .options').toggle();" ))
                    )
    );

    
    echo $this->Html->div('filterBox ui-widget', $searchBox, array('id' => 'search'));


    echo $this->Form->end();
    ?>
</div>



