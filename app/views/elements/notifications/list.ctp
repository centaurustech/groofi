<?php /* @var $this ViewCC */ ?>
<div class="user_feed notifications">
<?

$type=isset($type) ? $type : 'default';
$data = isset($data) ? $data : null;
if ( !empty($data['Notifications']) && is_array($data['Notifications'])) {
    $notifications = $data['Notifications'];
    foreach ($notifications as $key => $notification) {
     //   vd($notification['Notificationtype']);

        $elementPath = 'notifications'.DS.$type.DS.Inflector::pluralize($notification['Notificationtype']['model']) . DS .low($notification['Notificationtype']['name']);

        echo $this->element($elementPath,array('data' => unserialize($notification['Notification']['data'])));

    }
} else {
    ?>
    <div class="not-found-msg">
	        <?__('THIS_USER_HAS_NOT_ANY_ACTIVITY_YET');?>
    </div>
    <?
}

/*



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
 */
?>
</div>