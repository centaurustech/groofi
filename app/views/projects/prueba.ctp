<LINK REL='StyleSheet' HREF="/js/imgareaselect/css/imgareaselect-animated.css" TYPE="text/css" MEDIA='screen'>

<?php
    $ID = $_GET['ID'];

echo $javascript->link('/js/imgareaselect/jquery.min.js');
    echo $javascript->link('/js/imgareaselect/jquery.imgareaselect.pack.js');


?>
<div id="loading">
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
    <!--script type="text/javascript">
        $(function(){
            $("#projectsPruebaForm").submit(function(){
                $.ajax({
                    type:"POST",
                    url:"groofi.bo/send.php",
                    dataType:"html",
                    data:$(this).serialize(),
                    beforeSend:function(){
                        $("#loading").show();
                    },
                    success:function(response){
                        $("#response").html(response);
                        $("#loading").hide();
                    }

                })
                return false;
            })

        })
    </script-->



<div id="response"></div>
