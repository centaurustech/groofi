<?


    if (!defined('CAKE_CORE_INCLUDE_PATH')) {
            header('HTTP/1.1 404 Not Found');
            exit('File Not Found');
    }

    if (!class_exists('File')) {
        uses('file');
    }

    function make_clean_js($path, $name,$minify=true){
        App::import('Vendor', 'cjspp' . DS . 'cjspp');
        $data = file_get_contents($path);
        $output = '' ;
        $lines =  preg_split("/\r\n|\n/",$data);
        $includeFiles = preg_grep("/^(\/\*\s*@include\s*(?P<filename>[\w|\/|\d|\-|_|\.]+)\s*\*\/\s*)/", $lines ); 
        $rest = implode("\r\n", preg_grep("/^(\/\*\s*@include\s*(?P<filename>[\w|\/|\d|\-|_|\.]+)\s*\*\/\s*)/", $lines ,PREG_GREP_INVERT ));
        $jsPath = (str_replace(str_replace('js/','',$name),'',$path));
        if (is_array($includeFiles)){
            foreach($includeFiles as $k => $includeFile){
                preg_match_all("/^(\/\*\s*@include\s*(?P<filename>[\w|\/|\d|\-|_|\.]+)\s*\*\/\s*)/", $includeFile , $includeFile );
                if ( array_key_exists('filename', $includeFile) ) {
                    $cont =  file_get_contents( $jsPath.$includeFile['filename'][0] ) ;
                    if ($minify) {
                        $out = JSMin::minify($cont) ;
                    } else {
                        $out = $cont ;
                    }

                    $ratio = 100 - (round(strlen($out) / strlen($cont), 3) * 100);
                    $i[] = "\r\n /* file: {$includeFile['filename'][0]}, ratio: $ratio%  */ \r\n " . $out;

                }
            }
        }

        $rest_output =  $minify ? JSMin::minify($rest) : $rest ;
        $ratio = 100 - (round(strlen($rest_output) / strlen($rest), 3) * 100);
        $output .= "\r\n /* file: $name, ratio: $ratio%  */ \r\n " . $output;

        $output = $rest . implode("\r\n",$i);

        //$output .= $minify ? JSMin::minify($data) : $data ;


        $output .= empty($output) ? $data : $output ;



        return $output;
    }

    function write_js_cache($path, $content){
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path));
        }
        $cache = new File($path);
        return $cache->write($content);
    }



    if (preg_match('|\.\.|', $url) || !preg_match('|^cjs/(.+)$|i', $url, $regs)) {
        die('Wrong file name.');
    }

    $filename = 'js/' . $regs[1];
    $filepath = JS . $regs[1];
    $cachepath = CACHE . 'js' . DS . str_replace(array('/','\\'), '-', $regs[1]);

    if (!file_exists($filepath)) {
            die('Wrong file name.');
    }

    $HTTP_ACCEPT_ENCODING = $_SERVER['HTTP_ACCEPT_ENCODING'];

    if( headers_sent() ){
        $encoding = '';
    }elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
        $encoding = 'x-gzip';
    }elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
        $encoding = 'gzip';
    }else{
        $encoding = '' ;
    }

    $encoding = '' ;

    $cachepath = str_replace('.js','',$cachepath) . $encoding . '.js' ;

    $minify = strstr(low($filename) ,'.min') ? false : true ; // false ;

    if (file_exists($cachepath)) { //
        $templateModified = filemtime($filepath);
        //echo '//' .   date("D, j M Y G:i:s ", $templateModified) . "\r\n" ;
        $cacheModified = filemtime($cachepath);
        if ($templateModified > $cacheModified ) {
                // Update cache file
                $output = make_clean_js($filepath, $filename,$minify);
                if( $encoding != '' ){
                    $size = strlen($output);
                    $output = gzcompress($output, 9);
                    $output = substr($output, 0, $size);
                }
                write_js_cache($cachepath, $output);
        } else {
                // Use cache file
                $output = file_get_contents($cachepath);
        }
    } else {
        // Create a new cache file
        $output = make_clean_js($filepath, $filename,$minify);
        if( $encoding != '' ){
            $size = strlen($output);
            $output = gzcompress($output, 9);
            $output = substr($output, 0, $size);
        }
        write_js_cache($cachepath, $output);
        $templateModified = time();
    }


 //   header("Content-Type: text/js");

    header("Date: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
    header("Last-modified: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
    header("Expires: " . gmdate("D, d M Y H:i:s",strtotime('+1 month')) . " GMT");
    header("Cache-Control: max-age=".(DAY*30).", public"); // HTTP/1.1

   // var_dump($_SERVER);
    if( $encoding != '' ){
        header('Content-Encoding: '.$encoding);
        print  "\x1f\x8b\x08\x00\x00\x00\x00\x00" ;
        print($output);
    }else{
        print $output;
    }



?>