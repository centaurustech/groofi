<?


    http://simpledesktops.com/browse/29/
    $download = array();
    $download2 = array();
    for ( $a=1 ; $a <= 29 ; $a++ ){

        $contents = file_get_contents( "http://simpledesktops.com/browse/$a" );

         preg_match_all('#http:\/\/(.*)\.(gif|png|jpg)#', $contents , $images );
        //var_dump($images);
        foreach( $images[0] as $image ) {

       //     $download[] = 'wget ' . preg_replace( '/".*$/',  '' ,  $image)   . ';'  ;
            //$download2[] =  preg_replace( '/".*$/',  '' ,  $image)    ;
             
            echo preg_replace( '/".*$/',  '' ,  $image) . "\r\n <br />"  ;
            flush();
        }

        
        //http://static.simpledesktops.com/desktops/2011/04/29/headphones.png.295x184_q100.png
        //echo $contents ;
    }


  //  echo implode ("\r\n" , $download);
    
 //   echo implode ( $download2 , "\r\n" );
?>