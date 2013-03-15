<?php

App::import('Lib', 'lazyModel');

class AppModel extends lazyModel {

    var $cacheQueries = true;
    var $actsAs = array('Containable');
    var $_model = null;

    function VideoUrl($field, $required=false) { // validation function
        $url = low(array_shift($field));

        if ($url == '' && $required) {
            return false;
        } else {
            $videoSource = getVideoSource($url);
            if (Validation::url($url, true) && $videoSource) {
                return true;
            }
        }
        return false;
    }

    function linkPresent($check) {
        vd($check);
    }

    function crange($check, $lower = null, $upper = null) {
        $check = array_shift($check);
        if (!is_numeric($check)) {
            return false;
        }
        if (isset($lower) && isset($upper)) {
            return ($check >= $lower && $check <= $upper);
        }
        return is_finite($check);
    }

    static function getSlug($data=null) {
        $model = get_called_class();
        $data = isset($data[$model]) ? $data : array($model => $data);
        if ($data[$model]) {
            if (isset($data[$model]['slug']) && !empty($data[$model]['slug'])) {
                return urlencode($data[$model]['slug']);
            } elseif (isset($data[$model]['id'])) {
                return $data[$model]['id'];
            }
        }
        return false;
    }

    function validateUploadedFile($data, $required = false) {
        // vd($data) ;
        // vd($required) ;
        //
        //
        // Remove first level of Array ($data['Artwork']['size'] becomes $data['size'])
        $upload_info = array_shift($data);

        // No file uploaded.
        if ($required && $upload_info['size'] == 0) {
            return false;
        }

        // Check for Basic PHP file errors.
        if ($upload_info['error'] !== 0) {
            return false;
        }

        // Finally, use PHP’s own file validation method.
        return is_uploaded_file($upload_info['tmp_name']);
    }

    static function getLink($data=null, $extra = array(), $full=false, $model=null) {

        $model = get_called_class();
        $data = isset($data[$model]) ? $data : array($model => $data);

        if ($data[$model]) {
            $extra = is_array($extra) ? $extra : array();
            $urlBase = array(
                'controller' => low(Inflector::pluralize(low($model))),
                'action' => 'view',
                low($model) => $model::getSlug($data)
            );

            $url = Set::merge($urlBase, $extra);
            return Router::url($url, $full);
        } else {
            trigger_error("Data not found for model $model");
         //   vd($data);
        }


        return false;
    }

    static function getName($data=null, $model=null) {
        $model = !$model ? get_called_class() : $model;
        $data = isset($data[$model]) ? $data : array($model => $data);
        if ($data[$model]) {
            if (isset($data[$model]['name']))
                return $data[$model]['name']; //. ' (' . $data[$model]['id'] . ')';

            if (isset($data[$model]['title']))
                return $data[$model]['title']; //. ' (' . $data[$model]['id'] . ')';
        }
        return false;
    }

    function invalidate($field, $value = true) {

        // vd($field);
        //  vd($value);

        if (strrpos($field, '.')) {
            $field = substr($field, strrpos($field, '.') + 1);
        }

        if (is_array($value)) {
            //'message' => array('Alphabets and numbers only %u %u %u ' , value,  value , value )
            $value = String::insert(__(array_shift($value), true), $value);
        } else {
            if (is_array(@$this->validate[$field]) && array_key_exists($value, $this->validate[$field])
            ) {

                $value = __($value, true);

                /*
                  // Entramos con message == validateKey ( 'validateKey' => array('message'=>'validateKey'))

                  $rule = $this->validate[$field][$value]["rule"]; // Intenta utilizar la regla que esta en el modelo y formar un string con traduccion.
                  // var_dump($rule);


                  if (is_array($rule)) {
                  $value = $rule[0];
                  } else {
                  $value = $rule;
                  }

                  switch ($value) {
                  case 'between': // :min | :max
                  case 'range':   // :min | :max
                  $args['min'] = $rule[1];
                  $args['max'] = $rule[2];
                  $formatedText = __('VALIDATION_' . up($field) . '_' . up($value) . ' :min :max', true);
                  break;
                  case 'multiple':
                  $args = $rule[1];
                  if (is_array($args)) {
                  $keys = array_map(create_function('$v', 'return ":$v";'), array_keys($args));
                  }

                  foreach ($args as $condition => $value) {
                  $args[$condition] = is_array($value) ? '(' . implode(', ', $value) . ')' : $value;
                  }
                  $formatedText = __('VALIDATION_' . up($field) . '_' . up($value) . ' ' . implode(' ', $keys), true);
                  break;
                  // rule => array(rulename , value)
                  case 'equalTo' :
                  case 'minLength' :
                  case 'maxLength' :
                  if (is_array($rule)) {
                  $args['value'] = $rule[1];
                  $formatedText = __('VALIDATION_' . up($field) . '_' . up($value) . ' :value', true);
                  } else {
                  $formatedText = __('VALIDATION_' . up($field) . '_' . up($value), true);
                  }
                  break;
                  case 'comparison'; // condition | value
                  $operator = str_replace(array(' ', "\t", "\n", "\r", "\0", "\x0B"), '', strtolower($operator)); // cleans rule condition
                  $comparision = array('>' => 'isgreater', '<' => 'isless', '>=' => 'greaterorequal', '<=' => 'lessorequal', '==' => 'equalto', '!=' => 'notequal');
                  $condition = $rule[1];
                  $condition = in_array($condition, array_keys($comparision)) ? $comparision[$condition] : $condition;
                  $args['condition'] = $condition;
                  $args['value'] = $rule[2];
                  $formatedText = __('VALIDATION_' . up($field) . '_' . up($value) . ':condition :value', true);
                  break;
                  case '/.+/':
                  $formatedText = __('VALIDATION_FIELD_REQUIRED', true);
                  $args = $rule;
                  break;
                  }

                  if (isset($formatedText) && $args) {
                  if (is_array($args)) {
                  $value = String::insert($formatedText, $args, array('clean' => true));
                  }
                  } else {
                  // $value = __m($value, true);
                  }
                 */
                // } else {
                //$value = __m($value, true, false);
            } else {
                $value = __($value, true);
            }
        }
        return parent::invalidate($field, $value);
    }

    function getViewData($model, $query, $cache=true) {
        $data = $this->getCachedData($model, $query);
        if ($data && $cache) {

        } else {
            $data = $this->find('first', $query);
            $this->setCachedData($model, $query, $data);
        }
        return $data;
    }

    function getCachedData($model, $query, $cache = true) {
        return Cache::read($this->cacheKey($model, $query), 'model_data');
    }

    function setCachedData($model, $query, $data) {
        if ($data) {
            return Cache::write($this->cacheKey($model, $query), $data, 'model_data');
        } else {
            return false;
        }
    }

    function cacheKey($model, $query) {
        return $model . '_' . Security::hash(serialize($query), 'md5');
    }
	

}

?>