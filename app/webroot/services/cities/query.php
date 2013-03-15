<?

    /*
      header('Content-Type: text/javascript; charset=utf8');
      header('Content-type: text/json');
      header('Content-type: application/json');

     */
    //error_reporting(E_ALL);
    // Same as error_reporting(E_ALL);
    //ini_set('error_reporting', E_ALL);

    include '../common/init.php';

    $location=escape($_GET['q']);




    $debug=false;
    $limit=isset($_GET['maxRows']) ? $_GET['maxRows'] : 30;

    include_once APP . '../cake' . DS . 'libs' . DS . 'sanitize.php';


    $other=false;
    if (strstr($location, ',')) {
        list( $city, $other )=explode(',', $location);
        $other=trim($other);
        $location=preg_replace('/,.*/', '', $location);
    }



    $words=explode(' ', $location);

    // var_dump($words);

    $match1=$match2=$match3='"';
    //$match1='"';
    foreach ($words as $n => $word) {

        if ($n == 0) {
            //$word = ">$word" ;
            //    $match1 .= "$word + \"" ;
        }

        // $match1 .= $n + 1 < count($words) ? "$word " : "\" $word*";

        $match1 .= $n + 1 < count($words) ? "$word " : "$word\"";


        $match2 .= $n + 1 < count($words) ? "$word " : "\" $word*";

        $match3 .= "$word ";
    }


    if (count($words) == 1) {
        $match1=str_replace('"', '', $match1);
    }






    if (strlen($location) <= 5) {
        //  $match[]=" city like '{$words[0]}%' ";
    } else {
        $e="";
    }

    // $match[]=" city like '{$words[0]}%' ";

    $match[]="MATCH (search_text) AGAINST ( '$match1'  IN BOOLEAN MODE )";
    //  $match[]="MATCH (search_text,search_text_other) AGAINST ( '$match1'  IN BOOLEAN MODE )";
    //$match[]="MATCH (admin_code) AGAINST ( '\"$other\"'  IN BOOLEAN MODE )";
    if ($other) {
        $match[]="MATCH (search_text_other) AGAINST ( '\"$other\"'  IN BOOLEAN MODE )";
    }



    //$match[]="MATCH (search_text_other) AGAINST ( '\"".implode(' ', $words_other)."\"' IN BOOLEAN MODE  )";


    /*
      var_dump(trim($match1));
      var_dump(trim($match2));
      var_dump(trim($match3));
     */

    $scores='';
    foreach ($match as $key => $score) {
        $scores .= ', ' . $score . ' as score' . $key . ' ';
    }


//    $match[]="MATCH (search_text) AGAINST ( '$match2'  IN BOOLEAN MODE )";
    //$match[]="MATCH (city_name) AGAINST ( '\"$match3\"'  IN BOOLEAN MODE )";
    //  $match[]="MATCH (search_text) AGAINST ( '$match3'  IN BOOLEAN MODE )";
    $s=implode(' + ', $match);
    $match=implode(' AND ', $match);

    $match=strstr($match, '+') ? str_replace('*', '', str_replace('" ', '"', str_replace('+', '"+"', $match))) : $match;

    //$debug=true;
    $sql="SELECT *  :scores  FROM cities c WHERE :where  ORDER BY score0 LIMIT $limit;";


    $q=str_replace(':scores', $scores, $sql);
    $q=str_replace(':where', $match, $q);

    $result=mysql_query($q);
    $json=array();

    function fillJson($result, &$json) {
        $aux=0;
        while ($fila=mysql_fetch_assoc($result)) {

            if ($debug) {

                echo "<pre>";
                print_r($fila);
                echo "</pre>";
            }
            $json[$aux]['id']=$fila['id'];

            $json[$aux]['label']         =$fila['city_full_name'];

            $json[$aux]['value']         =$fila['city_full_name'];

            $json[$aux]['country']      =$fila['country'];

            $json[$aux]['country_id']   =$fila['country_code'];
            $aux++;
        }
        return $aux;
    }

    if (fillJson($result, $json) == 0) {
        if ($debug) {
            echo "<pre>";
            echo ( $q) . "\r\n\r\n\r\n";
            echo "</pre>";
        }
        $match=" city like '" . implode(' ', $words) . "%' ";
        $q=str_replace(':where', $match, $sql);
        $q=str_replace(':scores', $scores, $q);
        $result=mysql_query($q);
        fillJson($result, $json);
    }






    if (!$debug) {
        if (!empty($json)) {
            $json='(' . json_encode($json) . ')'; //must wrap in parens and end with semicolon
        } else {
            $json='({})';
        }
        print_r($_GET['callback'] . $json); //callback is prepended for json-p
    } else {

        echo "<pre>";

        echo ( $q) . "\r\n\r\n\r\n";

        print_r($json);

        echo "</pre>";
    }


    /*
      //$r = "SELECT count(*) FROM cities ;";
      //$result = mysql_query($r);
      //var_dump(mysql_fetch_assoc($result));
      $location=$_GET['q'];
      $limit=isset($_GET['maxRows']) ? $_GET['maxRows'] : 20;
      if (strlen($location) > 3) {
      $e="AND ( ( full_name like '%$location%' ) )";
      } else {
      $e="";
      }
      $r="SELECT * FROM cities
      WHERE
      ( city_name like '$location%' OR country_name like '$location%' ) $e
      ORDER BY score DESC , city_name ASC
      LIMIT $limit "
      ;

      //  OR full_name like '$location%'
      //  OR MATCH (country_name) AGAINST ('$location*' IN NATURAL LANGUAGE MODE)
      //IN NATURAL LANGUAGE MODE
      // echo $r ;
      $result=mysql_query($r);
      if ($result) {

      $aux=0;
      while ($fila=mysql_fetch_assoc($result)) {
      $json[$aux]['id']=$fila['id'];
      $json[$aux]['label']=$fila['full_name'];
      $json[$aux]['value']=$fila['full_name'];
      $aux++;
      }
      }

      //echo json_encode($json);
      //flush();

      if (!empty($json)) {
      $json='(' . json_encode($json) . ')'; //must wrap in parens and end with semicolon
      } else {
      $json='({})';
      }


      print_r($_GET['callback'] . $json); //callback is prepended for json-p
     *
     *
     */
?>