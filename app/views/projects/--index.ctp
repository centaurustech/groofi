<?php
/* @var $this ViewCC */

$subtitleText = isset($status) ? sprintf(__('%s', true), $statusName) : __('DISCOVER_ALL_PROJECTS', true);
$subtitleText .= isset($category) ? ' ' . sprintf(__('CATEGORY_FROM %s', true), $categoryName) : '';
$subtitleText .= isset($country) ? ' ' . sprintf(__('CITY_IN %s', true), $cityName) : '';
$this->set('pageSubTitle', $subtitleText);


$this->Paginator->options(array('url' => $baseUrl));

$menu = '';
if ( isset($this->params['search'])  ) {
    $this->set('pageTitle' , sprintf(__('PROJECTS_SEARCH_RESULT_FOR %s',true),$this->params['search']));

    $menu .= $this->Html->tag('h2', __('SEARCH_IN', true), array('class' => 'title'));
    $searchMenu[] =  $this->Html->tag('li', $this->Html->link( __('PROJECTS',true), Router::url(array('controller'=>'projects' , 'action'=>'index'  , 'search' => $this->params['search']))), array('class' => 'active'));
    $searchMenu[] =  $this->Html->tag('li', $this->Html->link( __('OFFERS',true), Router::url(array('controller'=>'offers' , 'action'=>'index' ,  'search' => $this->params['search']))), array('class' =>  ''));
  
    $menu .= $this->Html->tag('ul', implode('', $searchMenu), array('class' => 'discover-menu'));
    $baseUrl['search'] = $this->params['search'] ;
}
/* ------------------------------------------------------------------------------ */

if (!empty($categories)) {
    $categoriesMenu[] = $this->Html->tag('li', $this->Html->link(__('ALL_CATEGORIES', true), Router::url(am($baseUrl, array('category' => null)))), array('class' => (!isset($baseUrl['category']) ? 'active' : ''))); // without categories
    foreach ($categories as $category) {
        $active = isset($baseUrl['category']) && ($category['Category']['slug'] == $baseUrl['category'] ) ? 'active' : '';
        $categoriesMenu[] = $this->Html->tag('li', $this->Html->link(Category::getName($category), Category::getLink($category, am($baseUrl, array('extra' => 'projects')))), array('class' => $active));
    }
    $menu .= $this->Html->tag('h2', __('CATEGORIES', true), array('class' => 'title'));
    $menu .= $this->Html->tag('ul', implode('', $categoriesMenu), array('class' => 'discover-menu'));
}

/**/
if (!empty($statuses)) {
    $statusesMenu[] = $this->Html->tag('li', $this->Html->link(__('ALL_PROJECTS', true), Router::url(am($baseUrl, array('status' => null)))), array('class' => (!isset($baseUrl['status']) ? 'active' : '')));
    foreach ($statuses as $slug => $status) {
        $active = ($slug == @$baseUrl['status']) ? 'active' : '';
        $statusesMenu[] = $this->Html->tag('li', $this->Html->link($status, am($baseUrl, array('status' => $slug))), array('class' => $active));
    }
    $menu .= $this->Html->tag('h2', __('SHOW_PROJECTS', true), array('class' => 'title'));
    $menu .= $this->Html->tag('ul', implode('', $statusesMenu), array('class' => 'discover-menu'));
}

if (!empty($cities)) {
    $citiesMenu[] = $this->Html->tag('li', $this->Html->link(__('ALL_COUNTRIES', true), Router::url(am($baseUrl, array('city' => null, 'country' => null)))), array('class' => (!isset($baseUrl['city']) ? 'active' : '')));
    foreach ($cities as $city) {
        $active = ($city['City']['city_slug'] == @$baseUrl['city'] && $city['City']['country_slug'] == @$baseUrl['country']) ? 'active' : '';
        $citiesMenu[] = $this->Html->tag('li', $this->Html->link(City::getName($city), City::getLink($city, am($baseUrl, array('extra' => 'projects')))), array('class' => $active));
    }
    $menu .= $this->Html->tag('h2', __('LOCATION', true), array('class' => 'title'));
    $menu .= $this->Html->tag('ul', implode('', $citiesMenu), array('class' => 'discover-menu'));
}

echo $this->Html->div('discover-menu-cntr', $menu);
/* ------------------------------------------------------------------------------ */
?>

<div class="discover-projects search-result">
    <? if ($this->data) { ?> 
        <div class="content">

            <?
            foreach ($this->data as $key => $projectData) {

                echo $this->element('projects/discover_project', array('data' => $projectData, 'extraClass' => zebra($key, 3)));
            }
            ?>
        </div>
        <? if ( $this->Paginator->hasPrev() || $this->Paginator->hasNext()) { ?>
            <div class="paging">
                <div class="content">
                    <?
                    echo $this->Paginator->prev(__('PREV_PAGE', true), array('tag' => 'div'), __('PREV_PAGE', true), array('tag' => 'div'));

                    echo $this->Html->div('numbers', $this->Paginator->numbers(array(
                                'separator' => false,
                                'tag' => 'div',
                                'modulus' => 9
                            )));
                    echo $this->Paginator->next(__('NEXT_PAGE', true), array('tag' => 'div'), __('NEXT_PAGE', true), array('tag' => 'div'));
                    ?>
                </div>
            </div>
        <? } ?>
    <?
    } else {
        echo $this->Html->div('no-result',sprintf(__('WE CAN NOT FOUND ANY PROJECT IN %s PLEASE TRY AGAIN', true), $subtitleText));
    }
    ?> 
</div>
<style type="text/css">
   
</style>