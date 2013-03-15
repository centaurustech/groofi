<?php /* @var $this ViewCC */ ?>
<?

    $type=isset($type) ? $type : 'default';
    $data=isset($data) ? $data : null;
    if ( isset($data['Projects']) && is_array($data['Projects'])) {
        $projects = $data['Projects'];


        foreach ($projects as $key => $project) {

            $owner=($this->Session->read('Auth.User.id') == $project['Project']['user_id']);

            if ($project['Project']['enabled'] > 0 || $owner) {
                echo $this->element("projects/$type", array(
                        'project' => $project,
                        'data' => $data 
                    )
                );
            }
        }
    }
?>