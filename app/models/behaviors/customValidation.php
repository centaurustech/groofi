<?

    class CustomValidationBehavior extends ModelBehavior {

        var $default=array(
            'merge' => false,
        );
        var $config=array();

        function setup(Model $Model, $config = array()) {
            $this->config[$Model->alias]=$this->default;
            $this->config[$Model->alias]=array_merge($this->config[$Model->alias], $config);

            // We do this in setup so the form reflects the changes of the model's custom validation
            $varName='validate' . Inflector::camelize(Router::getParam('action')); 

            if (property_exists($Model, $varName)) {
                if ($this->config[$Model->alias]['merge']) {
                    $Model->validate=array_merge($Model->validate, $Model->{$varName});
                } else {
                    $Model->validate=$Model->{$varName};
                }
            }
        }

    }
?>