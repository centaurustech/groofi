<LINK REL='StyleSheet' HREF="/js/imgareaselect/css/imgareaselect-animated.css" TYPE="text/css" MEDIA='screen'>

<?php

if(isset($javascript)):
    echo $javascript->link('jquery.min.js');
    echo $javascript->link('jquery.imgareaselect.pack.js');
endif;

?>
<div>
    <?php echo $form->create('projects', array('action' => 'prueba', "enctype" => "multipart/form-data"));?>
    <?php
    echo $cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],151,151);
    //echo $cropimage->createForm($uploaded["imagePath"], $width, $height);
    echo $form->input('name');
    echo $form->input('image',array("type" => "file"));
    echo $cropimage->createForm($uploaded["imagePath"], 151, 151);
    echo $form->submit('Done', array("id"=>"save_thumb"));
    echo $form->end('Upload');
    ?>
</div>