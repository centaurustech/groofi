<? $isNotCache = true ; ?>

<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
	<head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?
                if ( low($title_for_layout) == low($this->params['controller']) ) {
                    $title_for_layout = up($this->params['controller']) .'_' . up($this->params['action'])  ;
                }

            ?>
            <?php echo __($title_for_layout,true); ?> | <?=SITE_NAME?>
        </title>

        <!--  Mobile viewport optimized: j.mp/bplateviewport -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <meta http-equiv="x-ua-compatible" content="IE=8" />

        <? if (FB_APPLICATION_ID) { ?>
            <meta property="fb:app_id" content="<?=FB_APPLICATION_ID?>" />
        <? } ?>
        <? if ( GOOGLE_SITE_VERIFICATION ) { ?>
            <meta name="google-site-verification" content="<?=GOOGLE_SITE_VERIFICATION?>" />
        <? } ?>

        <!-- meta info -->
        <?

            echo $html->meta('icon', ASSETS_SERVER . '/favicon.ico', array('type' =>'icon'));

            if (!isset($short_description_for_layout)) {
                $short_description_for_layout = __('DEFAULT_SITE_SHORT_DESCRIPTION' , true) ;
            }

            if (!isset($description_for_layout)) {
                $description_for_layout = __('DEFAULT_SITE_DESCRIPTION' , true) ;
            }

            if (!isset($author_for_layout)) {
                $author_for_layout = __('DEFAULT_SITE_AUTHOR' , true) ;
            }
        ?>
        <?php
            if (isset($facebook_info) && FB_APPLICATION_ID) {
                foreach ($facebook_info as $name => $content ) {
                    echo $html->meta(array('property' => $name, 'content' => $content)) . "\r\n";
                }
            }

            echo $html->meta(array('name' => 'title', 'content' =>  __($title_for_layout,true))) . "\r\n";
            echo $html->meta(array('name' => 'subject', 'content' =>  __($title_for_layout,true))) . "\r\n";
            echo $html->meta(array('name' => 'Classification', 'content' =>  __($short_description_for_layout,true))) . "\r\n";
            echo $html->meta(array('name' => 'author', 'content' =>  __($author_for_layout,true))) . "\r\n";
            echo $html->meta(array('name' => 'author', 'content' =>  __($author_for_layout,true))) . "\r\n";
            echo $html->meta(array('name' => 'keywords', 'content' =>  generateKeywords(__($description_for_layout .' ' . $author_for_layout .' '. $title_for_layout ,true)))) . "\r\n";
            echo $html->meta(array('name' => 'description', 'content' => __($description_for_layout,true))) . "\r\n";
            echo $html->meta(array('HTTP-EQUIV' => 'Expires', 'content' => date( 'D, j M G:i:s ',  strtotime('+1 day')))) . "\r\n";
            echo $html->meta(array('name' => 'Revisit-After', 'content' => '1')) . "\r\n";
            echo $html->meta(array('name' => 'distribution', 'content' =>'Global')) . "\r\n";
            echo $html->meta(array('name' => 'Robots', 'content' => 'INDEX,FOLLOW')) . "\r\n";


        ?>
        <!-- meta info -->


        <?=$this->Html->css('/css/default');?>
        <!--[if IE]><?=$this->Html->css('/css/ie');?><![endif]-->

        <?
            // Don't include handheld in asset because it needs media="handheld"
            echo $this->Html->css(array('handheld'),null,array('media'=>'handheld'));

            // Example of how to use google webfonts - see webroot/css/custom.css
            // echo $this->Html->css('http://fonts.googleapis.com/css?family=Lobster',NULL,array('inline'=>true));
        ?>
    </head>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->
 

    <div id="content" class="content <?=$this->params['controller'] ?> <?=$this->params['action'] ?>" >
        <div class="padding">
            <?php echo $this->Session->flash(); ?>
            <div id="<?=Inflector::classify(trim(@$this->params['prefix'] . ' ' . $this->params['controller'] . ' ' . $this->params['action'])); ?>" class="full">
                <?php  echo $content_for_layout; ?>
            </div>
        </div>
    </div>


    <? if (FB_APPLICATION_ID) { ?>
        <script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
        <script type="text/javascript">
          FB.init({appId: '<?=FB_APPLICATION_ID?>', status: true, cookie: true, xfbml: true});
          FB.Event.subscribe('auth.sessionChange', function(response) {
            if (response.session) {
                window.location = window.location ;
            } else { // The user has logged out, and the cookie has been cleared
              //  window.location = window.location ;
                window.location = '/users/logout' ;
            }
          });
        </script>
    <? } ?>

        <script type="text/javascript">
            //<![CDATA[
            var langTexts = {
                confirm : {
                    ok      : '<?=__('OK')?>' ,
                    cancel  : '<?=__('CANCEL')?>' ,
                    title   : '<?=__('CONFIRM_TITLE')?>',
                    body    : '<?=__('ARE_YOU_SURE_DO_THIS_ACTION')?>'
                },
                alert : {
                    ok      : '<?=__('OK')?>' ,
                    title   : '<?=__('ALERT_TITLE')?>'
                },
                media : {
                    image : '<?=__('MEDIA_IMAGE')?>' ,
                    video : '<?=__('MEDIA_VIDEO')?>' ,
                    audio : '<?=__('MEDIA_AUDIO')?>'
                }
            };
             //]]>
        </script>
    <?
        if ( $this->params['controller'] != 'staticpages' ){ //
            if (Configure::read('debug') > 0 ){ //
                echo $this->Html->script( 'jquery/main.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'jquery/ui.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'jquery/extras.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'jquery/extend.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'jquery/uploadify.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'jquery/i18n/ui-i18n.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'jquery/colortip.js' ,array('once'=>true,'inline'=>true));
                echo $this->Html->script( 'swfobject' ,array('once'=>true,'inline'=>true));
            } else {
                echo $this->Html->script( 'framework' ,array('once'=>true,'inline'=>true));
            }


            $this->Js->buffer(
                "$.datepicker.setDefaults( $.datepicker.regional['".Configure::read('Config.language')."']);"
            );
        } else {
            echo $this->Html->script( 'jquery/main.js' ,array('once'=>true,'inline'=>true));
        }


        echo $scripts_for_layout;
        echo $this->Js->writeBuffer();

    ?>


        <script type="text/javascript">
            //<![CDATA[
            var uID         = <?=(isset($authUser['User']['id'])?$authUser['User']['id']:'false')?> ;
            var l           =  $('<?=str_replace("\r\n",' ',$this->element('common/loader'))?>');
            var ajaxLoader  =  $('<?=str_replace("\r\n",' ',$this->element('common/loader'))?>');
            //]]>
        </script>

    <? if ( GOOGLE_ANALITYCS_ACCOUNT ) { ?>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-1576033-2']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    <? } ?>

    </body>
</html>