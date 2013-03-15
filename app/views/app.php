<?php

    class AppView extends View {

        public function &_loadHelpers(&$loaded, $helpers, $parent = null) {
            $loaded=parent::_loadHelpers($loaded, $helpers, $parent);

            //this replaces Core Helpers with custom App helper, just load the core helper, and then the appHelper,
            //for example: Html, AppHtml.
            //took the idea from http://cakebaker.42dh.com/2008/11/07/an-idea-for-hacking-core-helpers/#comment-112961
            foreach ($loaded as $key => $item) {
                $p=strpos($key, 'App');
                if ($p !== false && $p == 0) {
                    $coreHelper=str_replace('App', '', $key);
                    if (isset($loaded[$coreHelper])) {
                        $loaded[$coreHelper]=$item;
                        unset($loaded[$key]);
                    }
                }
            }
            return $loaded;
        }
        
        

    }

?>
