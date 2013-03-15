<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**

 * @property Project $Project
 * @property Offer $Offer
 */
class Search extends AppModel {

    var $belongsTo = array(
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'model_id',
            'conditions' => array('Search.model' => 'Project'),
            'counterCache' => true,
            'dependent' => true,
        ),
        'Offer' => array(
            'className' => 'Offer',
            'conditions' => array('Search.model' => 'Offer'),
            'foreignKey' => 'model_id',
            'counterCache' => true,
            'dependent' => true,
        )
    );

    function customSearch($term, $model) {

        $searchQuery['contain'] = array();
        $searchQuery['conditions']['model'] = $model;
        if (strstr($term, ' ')) {
            $terms = array_unique(explode( ' ',$term));
            foreach ($terms as $term) {
                $searchQuery['conditions'][]['searchtext like'] = "%{$term}%";
                //$searchQuery['conditions']['or'][]['searchtext like'] = "%{$term}%";
            }
        } else {
            $searchQuery['conditions'] = array(
                'searchtext like' => "%{$term}%"
            );
        }
		return array_unique(Set::extract('/Search/model_id', $this->find('all', $searchQuery)));
    }

    function indexInfo() {

        App::import('Sanitize');
        App::import('helper', 'Html');


        //        App::import('helper', 'MagickConvert');
        //    $this->MagickConvert = new MagickConvertHelper;
        //   $this->Html = new HtmlHelper;

        /* ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

        $stopWords = Configure::read('Common.stopwords');
        $searchModelsExtract = array(
            'Project' => array(
                '/User/display_name',
                '/Project/title',
                '/Project/short_description',
            ),
            'Offer' => array(
                '/User/display_name',
                '/Offer/title',
                '/Offer/short_description',
            )
        );

        /* ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

        $query = "DELETE FROM searches;";
        $this->query($query);

        /* ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

        $searchModels = array(
            //'type::artist' => 'user',
            //'type::user' => 'user',
            //'playlist_type::project' => 'playlist',
            // 'playlist_type::collection' => 'playlist',
            'project' => 'project',
            'offer' => 'offer',
        );





        foreach ($searchModels as $alias => $model) {
            $type = $alias == $model ? false : preg_replace('/(::.+)/', '', $alias);
            $alias = str_replace("$type::", '', $alias);
            $model = Inflector::classify($model);

            echo "</br></br></br><h1>Procesando tabla  $model" . ($type ? "<i> ($model.$type = $alias) </i>" : '') . "</h1></br>";

            $query = $this->{$model}->queryStandarSet(false); // only public projects...



            $results = $this->{$model}->find('all', $query);


            foreach ($results as $result) {
                if (array_key_exists($model, $searchModelsExtract)) {
                    $a = ''; //low(__(up('SEARCH_AUTOSUGGEST_' . $alias), true)) . ' ';
                    //  $a .= __(low(Inflector::pluralize($model))) .' ';
                    //  $a .= __(low(Inflector::singularize($model))) .' ';

                    foreach ($searchModelsExtract[$model] as $extract) {
                        $values = Set::extract($extract, $result);
                        $values = $extract != '/Category/slug_name' ? implode(' ', $values) : implode(' ', __array($values));
                        $values = searchNormalize($values);
                        $values = str_replace($stopWords, '', $values);
                        $values = preg_replace('/\W/', ' ', $values);
                        $values = preg_replace('/\s\w{1,2}\s/', ' ', $values);
                        $values = preg_replace('/\s\d+\s/', ' ', $values);
                        $values = preg_replace('/\s\s/', ' ', $values);
                        $values = preg_replace('/"|\'/', ' ', $values);
                        if (!empty($values)) {
                            $a .= low($values) . ' ';
                        }
                    }

                    $search_index = implode(' ', array_unique(explode(' ', $a)));
                    if (!empty($a)) {
                        $data['Search']['model'] = low($model);
                        // $data['SearchIndex']['model_alias'] = $alias;
                        $data['Search']['model_id'] = array_shift(set::extract("/$model/id", $result));
                        $data['Search']['searchtext'] = $search_index;
                        // $data['SearchIndex']['model_alias_text'] = Sanitize::escape(Sanitize::stripAll(__(up('SEARCH_AUTOSUGGEST_' . $alias), true)));
                        // $insname = $this->{$model}->getTitle($result[$model]);
                        // $data['SearchIndex']['model_value'] = Sanitize::stripAll($insname);
                        // $data['SearchIndex']['model_image'] = $this->MagickConvert->resizeAndCrop($this->{$model}->getImage($result[$model]), 32, 32, false);
                        // $image = $this->Html->image($data['SearchIndex']['model_image']);
                        // $tag = $this->Html->tag('span', $data['SearchIndex']['model_value']);
                        // $data['SearchIndex']['model_label'] = $this->Html->tag('span', $image . $tag, array('class' => 'result result-' . $model));
                        // $data['SearchIndex']['model_url'] = $this->{$model}->getLink($result[$model]);

                        echo "generando indice para $alias <b>{$data['Search']['model_id']}</b> </br>";
                        $this->create($data);
                        $this->save();
                    }
                }
            }
        }
    }

}

?>
