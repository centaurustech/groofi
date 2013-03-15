<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property Search $Search
 */
class SearchesController extends AppController {

    function beforeFilter() {
        $this->Auth->allow('indexData', 'index', 'index', 'cron_indexData');
        parent::beforeFilter();
    }

    function cron_indexData() {
        $this->Search->indexInfo();
        $this->render('/common/ajax', 'ajax');
    }

    function index($model) {
        $model = Inflector::classify($model);



        $statuses = array(
            'most-popular' => __('MOST_POPULAR', true),
            'most-recent' => __('MOST_RECENT', true),
            'by-end' => __('BY_END', true),
            'finished' => __('FINISHED', true),
        );

        $this->set('statuses', $statuses);

        $this->set('categories', $this->Search->{$model}->Category->find('all', array('conditions' => array('Category.' . low($model) . '_count >' => 0), 'contain' => array())));

        $cities = $this->Search->{$model}->City->find('all', array(
                    'conditions' => array('City.' . low($model) . '_count >' => 0),
                    'contain' => array()
                        )
        );
        if (!empty($cities)) {
            $this->set('cities', $cities);
        }

        $baseUrl = array_filter(array(
            'city' => isset($this->params['city']) ? $this->params['city'] : null,
            'country' => isset($this->params['country']) ? $this->params['country'] : null,
            'category' => isset($this->params['category']) ? $this->params['category'] : null,
            'status' => isset($this->params['status']) ? $this->params['status'] : null,
                ), function ($element) {
                    return!is_null($element);
                });

        extract($baseUrl);
        $this->set(compact(array_keys($baseUrl)));

        /* -------------------------------------------------------------------- */



        $this->paginate = $this->Search->{$model}->queryStandarSet(false);
        $searchQuery['contain'] = array();
        $searchQuery['conditions'] = array(
            'model' => $model,
            'searchtext like' => "%{$this->params['search']}%"
        );

        $searchResults = Set::extract('/Search/model_id', $this->Search->find('all', $searchQuery));

        $this->paginate['conditions'][$model . '.id'] = $searchResults;


        ;
        $this->paginate['limit'] = 6;

        if (isset($category)) {
            $category_info = $this->Search->{$model}->Category->getFromSlug($category);
            $this->paginate['conditions'][$model . '.category_id'] = @array_shift(Set::extract('/Category/id', $category_info));
            $this->set('categoryName', Category::getName($category_info));
        }

        if (isset($country) && !isset($city)) {
            $cities = $this->Search->{$model}->City->find('all', array(
                        'conditions' => array(
                            'City.country_slug' => $country
                        ),
                        'contain' => array()
                            )
            );
            $this->set('cityName', array_shift(Set::extract('/City/country', $cities)));
        } elseif (isset($city)) {
            $cities = $this->Search->{$model}->City->find('all', array(
                        'conditions' => array(
                            'City.country_slug' => $country,
                            'City.city_slug' => $city
                        ),
                        'contain' => array()
                            )
            );
            $city_name = array_shift(Set::extract('/City/city_name', $cities));
            $this->set('cityName', array_shift(Set::extract('/City/city_name', $cities)));
        }

        if (isset($status)) {
            switch ($status) {
                case 'most-recent' :
                    $this->paginate['order'] = $model . '.publish_date DESC'; // mas recientemente publicados , no filtra
                    $this->paginate['conditions'][$model . '.end_date >'] = date('Y-m-d');
                    break;
                case 'most-popular' :
                    if (low($model) == 'offer') {
                        $this->paginate['order'] = 'Offer.project_count DESC , Offer.follow_count DESC';
                    } else {
                        $this->paginate['order'] = 'Project.sponsorships_count DESC , User.score , Project.follow_count DESC'; // mas recientemente publicados , no filtra
                    }

                    break;
                case 'by-end' :  // muestra los proyectos que terminan dentro de los proximos 15 dias ordenados por fecha de finalizacion.
                    $this->paginate['conditions'][$model . '.end_date >'] = date('Y-m-d');
                    $this->paginate['conditions'][$model . '.end_date <'] = date('Y-m-d', strtotime('+10 days'));
                    $this->paginate['order'] = $model . '.end_date ASC';
                    break;
                case 'finished' :  // muestra los proyectos que terminan dentro de los proximos 15 dias ordenados por fecha de finalizacion.

                    $this->paginate['conditions'][$model . '.end_date <'] = date('Y-m-d');

                    $this->paginate['order'] = $model . '.end_date DESC';
                    break;
            }
            $this->set('statusName', $statuses[$status]);
        }



        $this->data = $this->paginate($model);
        $this->set('baseUrl', $baseUrl);







        $this->render('/' . low(Inflector::pluralize($model)) . '/index');
    }

}

?>
