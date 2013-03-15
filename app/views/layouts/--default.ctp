<?php /* @var $this ViewCC */?>
<?php

if (!isset ($short_description_for_layout)) {
    $short_description_for_layout = __ ('DEFAULT_SITE_SHORT_DESCRIPTION', true);
}
if (!isset ($description_for_layout)) {
    $description_for_layout = __ ('DEFAULT_SITE_DESCRIPTION', true);
}
if (!isset ($author_for_layout)) {
    $author_for_layout = __ ('DEFAULT_SITE_AUTHOR', true);
}
$page = ( isset ($this->params['prefix']) ? $this->params['prefix'] . '_' : '' ) . $this->params['controller'] . '_' . $this->params['action'];

?>
<?= $this->Html->docType ();?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
    <head>
		<SCRIPT LANGUAGE="JavaScript">
		<!-- Limit the number of characters per textarea -->
		<!-- Begin
		function textCounter(field,cntfield,maxlimit) {
		if (field.value.length > maxlimit)
			field.value = field.value.substring(0, maxlimit);
		else
			cntfield.value = maxlimit - field.value.length;
		}
		//  End -->
		</script>
        <?

        /* -------------------------------------------------------------- */
        echo $this->Html->css ('/css/default');
        if (get_user_browser () == 'ie') {
            echo $this->Html->meta (array ('http-equiv' => 'x-ua-compatible', 'content' => "IE=8")) . "\r\n";
            echo $this->Html->css ('/css/ie');
            $bodyIeClass = getIeVersion () ? "ie ie" . getIeVersion () : '';
        }
        /* -------------------------------------------------------------- */

        if (low ($title_for_layout) == low ($this->params['controller'])) {
            $title_for_layout = up ($this->params['controller']) . '_' . up ($this->params['action']);
        }

        ?><title><?= __ ($title_for_layout, true) . ' | ' . SITE_NAME;?></title>
		
		<?

        echo $this->Html->charset () . "\r\n";
        /* -------------------------------------------------------------- */
        echo $this->Html->meta ('icon', ASSETS_SERVER . '/favicon.ico', array ('type' => 'icon')) . "\r\n";
        // echo $this->Html->meta('icon', null, array('type' => 'icon', 'rel' => 'apple-touch-icon', 'link' => ASSETS_SERVER . '/apple-touch-icon.png')) . "\r\n";
        /* -------------------------------------------------------------- */
        $siteMeta = array (
            'title' => __ ($title_for_layout, true),
            'subject' => __ ($title_for_layout, true),
            'classification' => __ ($short_description_for_layout, true),
            'author' => __ ($author_for_layout, true),
            'keywords' => generateKeywords (__ ($description_for_layout . ' ' . $author_for_layout . ' ' . $title_for_layout, true)),
            'description' => __ ($description_for_layout, true),
            'revisit-after' => '1',
            'distribution' => 'Global',
            'Robots' => 'INDEX,FOLLOW',
        );
        echo $this->Html->meta (array ('HTTP-EQUIV' => 'Expires', 'content' => date ('D, j M G:i:s ', strtotime ('+1 day')))) . "\r\n";


        /* -------------------------------------------------------------- */
        if (GOOGLE_SITE_VERIFICATION) {
            echo $this->Html->meta (array ('name' => 'google-site-verification', 'content' => GOOGLE_SITE_VERIFICATION)) . "\r\n";
        }
        /* -------------------------------------------------------------- */

        ?>
        <link href='http://fonts.googleapis.com/css?family=Terminal+Dosis+Light' rel='stylesheet' type='text/css' />

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-27693751-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
    <body class="<?= @$bodyIeClass?>">

        <?php echo $this->Session->flash ('email');?>
        <!-- main site -->

        <div  id="content" class="<?= $this->params['controller']?> <?= $this->params['action']?>" >

            <div style="z-index:5000; position:relative" id="header" class="block">
                <div class="bg">
                    <div class="content">



                        <? if (isset ($pageTitle) && $pageTitle === false) {?>
                            <h1 id="logo">
                                <a title="Groofi" href="/">Groofi</a>
                            </h1>

                        <? } else {?>
                            <a title="Groofi" href="/"  id="logo">
                                <img alt="Groofi" src="/img/assets/logo_groofi_header.png">
                            </a>
                        <? }?>




                        <div id="menu">

                            <ul class="menu menu-black create">
                                <li><span class="text TerminalDosisLight"> <? __ ('CREATE')?> </span>
                                    <ul>
                                        <li><a  class=" TerminalDosisLight" href="<?= Router::url (array ('controller' => 'projects', 'action' => 'add'))?>"><? __ ('PROJECT')?> </a></li>
                                        <li><a  class=" TerminalDosisLight" href="<?= Router::url (array ('controller' => 'offers', 'action' => 'add'))?>"><? __ ('OFFER')?> </a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="menu menu-black discover">
                                <li><span class="text TerminalDosisLight"><? __ ('DISCOVER')?></span>
                                    <ul>
                                        <li><a  class=" TerminalDosisLight" href="/discover/projects"><? __ ('PROJECT')?> </a></li>
                                        <li><a  class=" TerminalDosisLight" href="/discover/offers"><? __ ('OFFER')?> </a></li>
                                    </ul>
                                </li>

                            </ul>




                            <?

                            if ($this->Session->read ('Auth.User.id')) {
                                $user = $this->Session->read ('Auth');



                                $file = $this->Media->file ('s50/' . $user['User']['avatar_file']);
                                // vd($user['User']['avatar_file']);
                                $file = $this->Media->embed ($file, array ('width' => '31px', 'height' => '31px'));
                                $file = ( empty ($file) ? $this->Html->image ('/img/assets/img_default_50px.png', array ('width' => '31px', 'height' => '31px')) : $file );


                                //$file = $this->Media->getImage('s50', $user['User']['avatar_file'], '/img/assets/img_default_50px.png');
                                // $file = $this->Html->link($file, User::getLink($user), array('class' => 'thumb', 'escape' => false));

                                ?>
                                <ul class="menu menu-white" style="padding-right:0px" >
                                    <li>  <a href="<?= Router::url (array ('controller' => 'notifications', 'action' => 'wall'));?>"><? __ ('ACTIVITY')?></a></li>
                                    <li>  <a href="/messages"><?= __ ('MESSAGES', true) . ($user['User']['message_count'] > 0 ? sprintf (' (<span class="highlight">%s</span>)', $user['User']['message_count']) : '');?></a></li>
                                    <li>  <a href="/page/faq"><? __ ('FAQ')?></a></li>
                                    <li id="userProfile">
                                        <a href="<?= User::getLink ($user)?> " >
                                            <?

                                            echo $file;
                                            //echo User::getName($user);

                                            ?>
                                        </a>

                                        <?

                                        $offerCount = (($user['User']["offer_count"] + $user['User']["offer_proposal_count"]) > 0 );
                                        $projectCount = (($user['User']["project_count"] + $user['User']["project_proposal_count"]) > 0 );
                                        $backesCount = (($user['User']["sponsorships_count"] ) > 0 );

                                        ?>
                                        <ul>
                                            <li><?= $this->Html->link (__ ('USER_PROFILE', true), User::getLink ($user));?></li>
                                            <? if ($projectCount) {?><li><?= $this->Html->link (__ ('USER_PROJECTS', true), User::getLink ($user, 'projects'));?></li><? }?>
                                            <? if ($offerCount) {?><li><?= $this->Html->link (__ ('USER_OFFERS', true), User::getLink ($user, 'offers'));?></li><? }?>
                                            <? if ($backesCount) {?> <li><?= $this->Html->link (__ ('USER_BAKES', true), User::getLink ($user, 'bakes'));?></li><? }?>
                                            <li><?= $this->Html->link (__ ('USER_SETTINGS', true), User::getLink ($user, 'settings'));?></li>
                                            <li>
                                                <b>
                                                    <?

                                                    if ($facebookUser) {
                                                        echo $this->Facebook->logout (array (
                                                            'redirect' => Router::url (array ('controller' => 'users', 'action' => 'logout')),
                                                            'label' => __ ('USER_LOGOUT', true)
                                                        ));
                                                    } else {
                                                        echo $this->Html->link (__ ('USER_LOGOUT', true), Router::url (array ('controller' => 'users', 'action' => 'logout')));
                                                    }

                                                    ?>
                                                </b>
                                            </li>
                                        </ul>
                                    </li>



                                </ul>
                            <? } else {?>
                                <ul class="menu menu-white">
                                    <li>  <a href="/signup"><? __ ('REGISTER')?></a></li>
                                    <li>  <a href="/signup"><? __ ('LOGIN')?></a></li>
                                    <li>  <a href="/page/faq"><? __ ('FAQ')?></a></li>
                                </ul>
                            <? }?>



                            <ul class="menu menu-white" id="searchBox" >
                                <?

                                echo $this->Form->create ('Search', array ('url' => '/search/projects', 'id' => 'searchForm'));
                                echo $this->Form->input ('q', array (
                                    'default' => ( isset ($this->params['search']) ? $this->params['search'] : __ ('SEARCH_SOMETHING', true)),
                                    'div' => false,
                                    'label' => false,
                                    'before' => $this->Form->submit (
                                            ' ', array ('div' => false)
                                    )
                                        )
                                );
                                echo $this->Form->end ();

                                ?>
                            </ul>

                            <?

                            /*
                              if ($this->Session->read('Auth.User.id')) {
                              echo $this->Html->link(__('USER_PROFILE', true), Router::url(array('controller' => 'users', 'action' => 'index')));
                              echo $this->Html->link(__('EDIT_PROFILE', true), Router::url(array('controller' => 'users', 'action' => 'edit', 'tab' => 'profile')));
                              echo $this->Html->link(__('CREATE_PROJECT', true), Router::url(array('controller' => 'projects', 'action' => 'add')));
                              echo $this->Html->link(__('CREATE_OFFER', true), Router::url(array('controller' => 'offers', 'action' => 'add',)));
                              echo $this->Html->link(__('DISCOVER_PROJECTS', true), Router::url(array('controller' => 'projects', 'action' => 'index')));
                              echo $this->Html->link(__('DISCOVER_OFFERS', true), Router::url(array('controller' => 'offers', 'action' => 'index')));
                              echo $this->Html->link(__('USER_ACTIVITY', true), Router::url(array('controller' => 'users', 'action' => 'activity')));


                              } else {

                              echo $this->Html->link(__('USER_LOGIN', true), Router::url(array('controller' => 'users', 'action' => 'login')));
                              echo $this->Html->link(__('USER_SIGNUP', true), Router::url(array('controller' => 'users', 'action' => 'add')));
                              echo $this->Html->link(__('HOME', true), '/');
                              } */

                            ?>





                        </div>
                    </div>
                </div>
            </div>




            <div id="main" class="block <?= low ($page)?>">

                <?php

                echo $this->element ('common/page_title', array (
                    'pageTitle' => isset ($pageTitle) ? $pageTitle : __ (up ($page . '_TITLE'), true),
                    'pageSubTitle' => isset ($pageSubTitle) ? $pageSubTitle : null,
                    'titleClass' => isset ($titleClass) ? $titleClass : null,
                        )
                );

                ?>

                <div class="content">
                    <div class="padding">
                        <div id="flashMessage">
                            <?php echo $this->Session->flash ();?>
                            <?php echo $this->Session->flash ('auth');?>
                        </div>

                        <div class="full">
                            <?php echo $content_for_layout;?>
                            <div class="clearfix">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix">&nbsp;</div>


            <div id="footer" class="block">
                <div class="bg">
                    <div class="content">
                        <div class="padding">
                            <div class="top">
                                <? if (isset ($site_categories) && !empty ($site_categories)) {?>
                                    <div class="col col-footer">

                                        <h5><? __ ('SEARCH_BY_CATEGORY')?></h5>
                                        <ul>
                                            <? foreach ($site_categories as $key => $category) {?>

                                                <li><?= $this->Html->link (Category::getName ($category), Category::getLink ($category))?></li>

                                            <? }?>

                                        </ul>
                                    </div>
                                <? }?>
                                <div class="col col-footer">
                                    <iframe
                                        src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FGroofi%2F214971778526056&amp;width=300&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false&amp;height=250"
                                        carolingio="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:250px;background-color: #FFFFFF" allowTransparency="true">

                                    </iframe>

                                </div>
                                <div class="col col-footer right">
                                    <h5><? __ ('CONNECT_WITH_US')?></h5>
                                    <a href="/page/acerca-de-groofi" rel="no-follow"><span class="site-icon misc-icon about-us"></span><? __ ('ABOUT_US_LINK')?></a>
                                    <a href="/page/contacto" rel="no-follow"><span class="site-icon misc-icon contact"></span><? __ ('CONTACT_US_LINK')?></a>
                                    <a href="http://www.facebook.com/pages/Groofi/214971778526056" rel="no-follow" target="_blank"><span class="site-icon social-icon facebook"></span>Facebook</a>
                                    <a href="http://twitter.com/grooficom" rel="no-follow" target="_blank"><span class="site-icon social-icon twitter"></span>Twitter</a>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="bottom">
                        <div class="content">
                            <div class="left">
                                <ul>
                                    <li><a href="/page/terminos-de-uso"   ><? __ ('TERMS')?></a></li>
                                    <li><a href="/page/politica-de-privacidad" ><? __ ('PRIVACY')?></a></li>
                                    <li><a href="/page/contacto" ><? __ ('CONTACT')?></a></li>
                                </ul>
                            </div>
                            <div class="right">
                                <span><? __ ('SITE_COPYRIGHT')?></span>
                                <a href="">
                                    <img src="/img/assets/logo_groofi_footer.png" alt="logo" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>




        <!-- main site -->
        <? echo $this->element ('common/scripts', array ('cache' => '1 day'));?>

    <cake:viewscripts></cake:viewscripts>
    <script type="text/javascript">

        function publishProject(h) {
            $("<div>")
            .attr('title','<? __ ('DO_U_WANT_TO_PUBLISH_THIS_PROJECT_TITLE')?>')
            .append( $('<p>').text('<? __ ('DO_U_WANT_TO_PUBLISH_THIS_PROJECT_BODY')?>'))
            .dialog({
                resizable: false,
                height:200,
                modal: true,
                buttons: {
                    "<? __ ('DO_U_WANT_TO_PUBLISH_THIS_PROJECT_YES')?>": function() {
                        h();
                        $( this ).dialog( "close" );
                    },
                    "<? __ ('DO_U_WANT_TO_PUBLISH_THIS_PROJECT_NO')?>": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }

        function publishOffer(h) {
            $("<div>")
            .attr('title','<? __ ('DO_U_WANT_TO_PUBLISH_THIS_OFFER_TITLE')?>')
            .append( $('<p>').text('<? __ ('DO_U_WANT_TO_PUBLISH_THIS_OFFER_BODY')?>'))
            .dialog({
                resizable: false,
                height:200,
                position : ['right','top'],
                modal: true,
                buttons: {
                    "<? __ ('DO_U_WANT_TO_PUBLISH_THIS_OFFER_YES')?>": function() {
                        h();
                        $( this ).dialog( "close" );
                    },
                    "<? __ ('DO_U_WANT_TO_PUBLISH_THIS_OFFER_NO')?>": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }



        function deleteProject(h) {
            $("<div>")
            .attr('title','<? __ ('DO_U_WANT_TO_DELETE_THIS_PROJECT_TITLE')?>')
            .append( $('<p>').text('<? __ ('DO_U_WANT_TO_DELETE_THIS_PROJECT_BODY')?>'))
            .dialog({
                resizable: false,
                height:200,
                position : ['right','top'],
                modal: true,
                buttons: {
                    "<? __ ('DO_U_WANT_TO_DELETE_THIS_PROJECT_YES')?>": function() {
                        h();
                        $( this ).dialog( "close" );
                    },
                    "<? __ ('DO_U_WANT_TO_DELETE_THIS_PROJECT_NO')?>": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        function deleteOffer(h) {
            $("<div>")
            .attr('title','<? __ ('DO_U_WANT_TO_DELETE_THIS_OFFER_TITLE')?>')
            .append( $('<p>').text('<? __ ('DO_U_WANT_TO_DELETE_THIS_OFFER_BODY')?>'))
            .dialog({
                resizable: false,
                height:200,
                position : ['right','top'],
                modal: true,
                buttons: {
                    "<? __ ('DO_U_WANT_TO_DELETE_THIS_OFFER_YES')?>": function() {
                        h();
                        $( this ).dialog( "close" );
                    },
                    "<? __ ('DO_U_WANT_TO_DELETE_THIS_OFFER_NO')?>": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }

        function defaultValue(e){
            $(e).bind('blur focus',function(){
                if ( $(this).val() == $(this).attr('default') ) {
                    $(this).val('').removeClass('no-search');
                } else if ( $(this).val() ==  '' ) {
                    $(this).val($(this).attr('default')).addClass('no-search');
                }
            }).attr('default', $(e).val()).addClass('no-search');
        }




        function hideMenus() {
            $('li.active ul:visible').hide().parent('li').removeClass('active');
        }

        $(window).resize(function() {
            mH = $(window).height() - $('#header').outerHeight() - $('#footer').outerHeight() ;
            mH = mH < 0 ? 0 : mH ;
            mH =  $('#main').outerHeight() <= mH ? mH : mH ;//'auto' ;
            $('#main').css('min-height' , mH) ;
        }).resize();
        $(document).ready(function(){


            $(document).click(function(e) {
                if(e.ctrlKey) {
                    e.stopPropagation();
                    return true ;
                } else if(e.altKey) {
                    e.stopPropagation();
                    return true ;
                } else if(e.shiftKey) {
                    e.stopPropagation();
                    return true ;
                } else if ($(e.target).is('.content #menu a') ) {
                    //   $(this).trigger('click');
                    //  window.location = $(this).attr('href');
                }
            });

            $('#searchForm').submit(function(){
                if ( $('#searchForm input#SearchQ').val() != '<?= ( isset ($this->params['search']) ? $this->params['search'] : __ ('SEARCH_SOMETHING', true))?>' ) {
                    window.location = $(this).attr('action') +'/'+ $('#searchForm input#SearchQ').val() ;
                }
                return false;
            });

            defaultValue('#SearchQ');


            $('a.toggle').click(function(){

                $($(this).attr('href')).toggle();
                return false ;
            });

            $('body').click( function() { hideMenus() ; }) ; // click outside close... all

            // items with submenu
            $('.content #menu ul.menu ul').parent('li').each(function(ev){
                indicator = $('<span>').text('').addClass('indicator-down');

                indicatorCntr = $('<div class="indicator-down-cntr">') ;

                indicatorCntr.append(indicator);
                indicator = indicatorCntr ;
                el =  $(this).children(':first');
				
                $(indicator).insertAfter(el);
                if ( el.is('a')  ) {
                    indicator.click(function(ev){
                        ul = $(this).parents('li').children('ul')
                        if ( ul.find(':visible').length > 0 ) {
                            hideMenus() ;
                        }  else {
                            hideMenus() ;
                            w = parseInt(ul.parents('li').outerWidth())  ;
                            w = w > 160 ? w : 160 ;
                            ul.show().width( w ).parents('li').addClass('active');
                            ev.stopPropagation();
                            return true ;
                        }
                    });
                } else {
                    $(this).hover(function(ev){
					   if($(this)[0].firstChild.nodeName.toLowerCase()=='span')hideMenus();
                       clearTimeout( window.algo);
                        $(ev.currentTarget).children('ul').show('fade').parents('li').addClass('active');
                    },function(ev){
                         window.algo=setTimeout(hideMenus,300) ;
                    });
                }
            });
        });
    </script>

    <?

    /* -------------------------------------------------------------- */
    if (FacebookInfo::getConfig ('appId')) {
        echo $this->Html->meta (array ('property' => 'fb:app_id', 'content' => FacebookInfo::getConfig ('appId'))) . "\r\n";
        if (isset ($facebook_info)) {
            foreach ($facebook_info as $name => $content) {
                echo $this->Html->meta (array ('property' => $name, 'content' => $content)) . "\r\n";
            }
        }

        echo $this->Facebook->init ();
    }
    /* -------------------------------------------------------------- */

    ?>
</body>
</html>
