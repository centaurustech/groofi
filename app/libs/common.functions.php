<?php

function getVideoSource($url) {
    $videoSources = array('youtu.be', 'youtube.com', 'vimeo.com');
    $ret = false;
    foreach ($videoSources as $key => $value) {
        $ret = strstr(low(parse_url($url, PHP_URL_HOST)), $value) ? $value : $ret;
    }

    return preg_replace('/\..*$/', '', $ret);
}

function truncate($text, $length = 100, $options = array()) {
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => false
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending));
        $openTags = array();
        $truncate = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }

    return $truncate;
}

//define('YOUTUBE_EMBED_URL', 'http://www.youtube.com/v/{::v::}&theme=light&color=red&hl=en&fs=1&showsearch=0&rel=0&fmt=22&ap=%2526fm');
//define('YOUTUBE_EMBED_CODE', '<object width="{::w::}" height="{::h::}"><param name="movie" value="{::url::}"></param>	<param name="allowFullScreen" value="true"></param>	<param name="allowscriptaccess" value="always"></param>	<embed src="{::url::}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="{::w::}" height="{::h::}"></embed></object>');


define('YOUTUBE_EMBED_URL', 'http://www.youtube.com/embed/{::v::}?theme=dark&color=red&rel=0&showsearch=0&wmode=transparent'); //&hl=en&fs=1&showsearch=0&rel=0&fmt=22&ap=%2526fm


define('YOUTUBE_EMBED_CODE', '<iframe src="{::url::}"  width="{::w::}" height="{::h::}" frameborder="0" allowfullscreen ></iframe>');

define('VIMEO_API_URL', 'http://vimeo.com/api/oembed.json?url={::url::}&iframe=True&wmode=transparent&width={::w::}&height={::h::}');

function getVideoEmbed($url, $w = 560, $h= 420) {
    $videoSource = getVideoSource($url);
    switch (getVideoSource($url)) {
        case 'youtu':
            //parse_str(parse_url($url, PHP_URL_QUERY), $qstring);
            $vId = preg_replace("/\?.*$/", '', preg_replace("/^.*\//", '', $url));
            $url = str_replace('{::v::}', $vId, YOUTUBE_EMBED_URL);
            $ret = str_replace('{::url::}', $url, YOUTUBE_EMBED_CODE);
            break;
        case 'youtube':
            parse_str(parse_url($url, PHP_URL_QUERY), $qstring);
            $url = str_replace('{::v::}', $qstring['v'], YOUTUBE_EMBED_URL);
            $ret = str_replace('{::url::}', $url, YOUTUBE_EMBED_CODE);

            break;
        case 'vimeo':
            include_once CAKE . DS . 'libs/http_socket.php';
            $url = str_replace('{::url::}', $url, VIMEO_API_URL);
            $url = str_replace('{::w::}', $w, $url);
            $url = str_replace('{::h::}', $h, $url);

            $http = new HttpSocket();
            $response = json_decode($http->get($url));
            // vd($response);
            $ret = @$response->html;
            break;
        default:
            return false;
    }
    $ret = str_replace('{::w::}', $w, $ret);
    $ret = str_replace('{::h::}', $h, $ret);



    return $ret;
}

function itinerateExtencions($extencions) {
    $ret = array();
    foreach ($extencions as $extencion) {
        $ext = str_split($extencion, 1);
        for ($a = 0; $a < pow(2, count($ext)); $a++) {
            $newExt = '';
            $convert = str_split(str_pad(base_convert($a, 10, 2), count($ext), 0, STR_PAD_LEFT), 1);
            foreach ($ext as $key => $letter) {
                $newExt .= $convert[$key] == 1 ? strtoupper($letter) : strtolower($letter);
            }

            $ret[] = $newExt;
        }
    }
    return $ret;
}

function vd($var) {
    //if (Configure::read() > 0) {
    echo '<pre class="cake-debug">';
    echo var_dump($var);
    echo '</pre>';
    //}
}

function vdd($var) {
    if (Configure::read() > 0) {
        die(var_dump($var));
    }
}

function getUrlDomain($url) {
    return( preg_replace('/^[w]+.(\d)*\./', '', (preg_replace('/^\w+:\/\//', '', preg_replace('/(\?.*)$/', '', preg_replace('/(\w)(\/.*)$/', '\1', $url))))));
}

function generateKeywords($text) {
    $text = preg_replace('/\t/', ' ', $text);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = preg_replace('/,|\(|\)|\./', ' ', $text);
    $text = explode(' ', $text);
    $text = array_unique(array_filter(array_map(create_function('$var', '$var = strtolower(trim($var));return ( strlen($var) >= 3 ) ? $var : false ;'), $text), create_function('$var', ' return is_string($var);')));
    return implode(',', $text);
}

function highlight($text, $phrase, $highlighter = '<span class="highlight">\1</span>', $considerHtml = false) {
    if (empty($phrase)) {
        return $text;
    }

    if (is_array($phrase)) {
        $replace = array();
        $with = array();

        foreach ($phrase as $key => $value) {
            $key = $value;
            $value = $highlighter;
            $key = '(' . $key . ')';
            if ($considerHtml) {
                $key = '(?![^<]+>)' . $key . '(?![^<]+>)';
            }
            $replace[] = '|' . $key . '|iu';
            $with[] = empty($value) ? $highlighter : $value;
        }

        return preg_replace($replace, $with, $text);
    } else {
        $phrase = '(' . $phrase . ')';
        if ($considerHtml) {
            $phrase = '(?![^<]+>)' . $phrase . '(?![^<]+>)';
        }

        return preg_replace('|' . $phrase . '|iu', $highlighter, $text);
    }
}

function fillUrl($Url) {
    $Url = ltrim(rtrim($Url));

    if (strlen($Url) == 0) {
        return '';
    }

    $Url = strtolower($Url);
    if (startsWith($Url, 'http://')) {
        return $Url;
    }

    if (startsWith($Url, 'https://')) {
        return $Url;
    }

    $Url = 'http://' . $Url;
    return $Url;
}

function zebra($dividend, $divisor, $type='first-last') {




    if (is_string($divisor)) {
        $divisor = $divisor == 'even-odd' ? 2 : $divisor;
        $type = 'even-odd';
    }

    $fmod = fmod($dividend, $divisor);

    if (is_array($type)){
          if ($fmod == 0) {
            return $type[0];
        } elseif ($fmod == ($divisor - 1)) {
            return $type[1];
        }
    } elseif ($type == 'first-last') {
        if ($fmod == 0) {
            return 'first';
        } elseif ($fmod == ($divisor - 1)) {
            return 'last';
        }
    } elseif ($type == 'even-odd') {
        if ($fmod == 0) {
            return 'odd';
        } else {
            return 'even';
        }
    }
    return '';
}

function get_user_browser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if (preg_match('/MSIE/i', $u_agent)) {
        $ub = "ie";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $ub = "firefox";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $ub = "safari";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $ub = "chrome";
    } elseif (preg_match('/Flock/i', $u_agent)) {
        $ub = "flock";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $ub = "opera";
    }

    return $ub;
}

function getIeVersion() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if (preg_match('/MSIE/i', $u_agent)) {
        $match = preg_match('/MSIE ([0-9]\.[0-9])/', $u_agent, $reg);
        if ($match == 0)
            return -1;
        else
            return floatval($reg[1]);
    }
}

function getFileExtension($file) {
    $path_parts = pathinfo($file);
    return $path_parts['extension'];
}

function timeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s') {
    $difference = time() - $timestamp;
    if ($difference < 0)
        return '0 seconds ago';
    elseif ($difference < 864000) {
        $periods = array('week' => 604800, 'day' => 86400, 'hr' => 3600, 'min' => 60, 'sec' => 1);
        $output = '';
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = round($difference / $value);
                $difference %= $value;
                $output .= ( $output ? ' ' : '') . $time . ' ';
                $output .= ( ($time > 1 && $key == 'day') ? $key . 's' : $key);
                $granularity--;
            }
            if ($granularity == 0)
                break;
        }
        return ($output ? $output : '0 seconds') . ' ago';
    }
    else
        return date($format, $timestamp);
}

function pre_entities($matches) {
    return str_replace($matches[1], htmlentities($matches[1]), $matches[0]);
}

function daysDifference($endDate, $beginDate) {
    $date_parts1 = explode("-", $beginDate);
    $date_parts2 = explode("-", $endDate);
    $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
    $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
    return $end_date - $start_date;
}

function fillData($original=array(), $new = array()) {
    $args = func_get_args();

    $r = (array) current($args);

    while (($arg = next($args)) !== false) {
        foreach ((array) $arg as $key => $val) {

            if (is_array($val) && isset($r[$key]) && is_array($r[$key])) {
                $r[$key] = fillData($r[$key], $val);

                if (empty($r[$key])) {

                } else {

                }
            } elseif (is_int($key)) {
                $r[] = $val;
            } else {
                if (empty($r[$key])) {
                    $r[$key] = $val;
                } else {

                }
            }
        }
    }


    return $r;
}

function searchNormalize($string) {
    $search = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    return str_replace($search, $replace, $string);
}

function splitText($text, $size=50) {
    $words = explode(' ', $text);
    array_walk($words, create_function('&$word,$pos,$size', '$word=implode("- ",str_split($word, $size));'), 50);
    return implode(' ', $words);
}

/**
 * $interval can be:
 * yyyy - Number of full years
 * q - Number of full quarters
 * m - Number of full months
 * y - Difference between day numbers
 * (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
 * d - Number of full days
 * w - Number of full weekdays
 * ww - Number of full weeks
 * h - Number of full hours
 * n - Number of full minutes
 * s - Number of full seconds (default)
 * */
function datediff($datefrom, $dateto, $interval='d', $using_timestamps = false) {

    vd($datefrom);
    vd($dateto);
    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds

    switch ($interval) {

        case 'yyyy': // Number of full years

            $years_difference = floor($difference / 31536000);
            if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom) + $years_difference) > $dateto) {
                $years_difference--;
            }
            if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto) - ($years_difference + 1)) > $datefrom) {
                $years_difference++;
            }
            $datediff = $years_difference;
            break;

        case "q": // Number of full quarters

            $quarters_difference = floor($difference / 8035200);
            while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($quarters_difference * 3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                $months_difference++;
            }
            $quarters_difference--;
            $datediff = $quarters_difference;
            break;

        case "m": // Number of full months

            $months_difference = floor($difference / 2678400);
            while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                $months_difference++;
            }
            $months_difference--;
            $datediff = $months_difference;
            break;

        case 'y': // Difference between day numbers

            $datediff = date("z", $dateto) - date("z", $datefrom);
            break;

        case "d": // Number of full days

            $datediff = floor($difference / 86400);
            break;

        case "w": // Number of full weekdays

            $days_difference = floor($difference / 86400);
            $weeks_difference = floor($days_difference / 7); // Complete weeks
            $first_day = date("w", $datefrom);
            $days_remainder = floor($days_difference % 7);
            $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
            if ($odd_days > 7) { // Sunday
                $days_remainder--;
            }
            if ($odd_days > 6) { // Saturday
                $days_remainder--;
            }
            $datediff = ($weeks_difference * 5) + $days_remainder;
            break;

        case "ww": // Number of full weeks

            $datediff = floor($difference / 604800);
            break;

        case "h": // Number of full hours

            $datediff = floor($difference / 3600);
            break;

        case "n": // Number of full minutes

            $datediff = floor($difference / 60);
            break;

        default: // Number of full seconds (default)

            $datediff = $difference;
            break;
    }

    return $datediff;
}

?>
