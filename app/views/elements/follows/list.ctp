<?php /* @var $this ViewCC */ ?>
<?

$type = isset($type) ? $type : 'default';
$data = isset($data) ? $data : null;
if (isset($data['Follows']) && is_array($data['Follows'])) {
    $follows = $data['Follows'];


    foreach ($follows as $key => $follow) {
        $model = low(inflector::singularize($follow['Follow']['model']));
        echo $this->element(low(inflector::pluralize($follow['Follow']['model'])) . "/profile_" . Inflector::singularize($model), array(
                $model => $follow,
                'data' => $follow
            )
        );
        // if ($follow['Follow']['enabled'] > 0 || $owner) {



        /*
          echo $this->element("follows/$type", array(
          'follow' => $follow,
          'data' => $data
          )
          );
         */

        //     }
    }
}
?>