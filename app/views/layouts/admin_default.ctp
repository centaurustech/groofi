<?php /* @var $this ViewCC */ ?>
<? 
$isNotCache = true; ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<style>
#addVideo{z-index:21000;display:none; width:333px; height:186px; position:fixed; top:50px; left:50%; margin-left:-166px; background:url(/2012/images/bgAlert.png);}
#bglightbox2{width:100%; height:2000px; position:fixed; background:#000 !important; opacity:.95; filter:alpha(opacity=95); z-index:20000;display:none; margin:0; padding:0; left:0;top:0}
ul li ul{ max-width:250px;}
</style>
    <head>
        <?
        if (low($title_for_layout) == low($this->params['controller'])) {
            $title_for_layout =!isset($tituloadmin)? up($this->params['controller']) . '_' . up($this->params['action']):$tituloadmin;
        }
        ?><title><?= __($title_for_layout, true) . ' | ' . SITE_NAME; ?></title><?
        echo $this->Html->charset() . "\r\n";
        /* -------------------------------------------------------------- */
        echo $this->Html->meta('icon', ASSETS_SERVER . '/favicon.ico', array('type' => 'icon')) . "\r\n";
        echo $this->Html->meta('icon', null, array('type' => 'icon', 'rel' => 'apple-touch-icon', 'link' => ASSETS_SERVER . '/apple-touch-icon.png')) . "\r\n";
        /* -------------------------------------------------------------- */
        $siteMeta = array(
            'title' => __($title_for_layout, true),
            'subject' => __($title_for_layout, true),
            //    'classification' => __($short_description_for_layout, true),
            //  'author' => __($author_for_layout, true),
            // 'keywords' => generateKeywords(__($description_for_layout . ' ' . $author_for_layout . ' ' . $title_for_layout, true)),
            // 'description' => __($description_for_layout, true),
            'revisit-after' => '1',
            'distribution' => 'Global',
            'Robots' => 'INDEX,FOLLOW',
        );
        echo $this->Html->meta(array('HTTP-EQUIV' => 'Expires', 'content' => date('D, j M G:i:s ', strtotime('+1 day')))) . "\r\n";
        /* -------------------------------------------------------------- */
        /*
          if (FacebookInfo::getConfig('appId')) {
          echo $this->Html->meta(array('property' => 'fb:app_id', 'content' => FacebookInfo::getConfig('appId'))) . "\r\n";
          if (isset($facebook_info)) {
          foreach ($facebook_info as $name => $content) {
          echo $this->Html->meta(array('property' => $name, 'content' => $content)) . "\r\n";
          }
          }

          echo $this->Facebook->init();
          }
         */
        /* -------------------------------------------------------------- */

        /* -------------------------------------------------------------- */
        /*
          if (GOOGLE_SITE_VERIFICATION) {
          echo $this->Html->meta(array('name' => 'google-site-verification', 'content' => GOOGLE_SITE_VERIFICATION)) . "\r\n";
          } */
        /* -------------------------------------------------------------- */

        /* -------------------------------------------------------------- */
        echo $this->Html->css('/css/admin_default');
        //    echo $this->Html->css('/css/dropmenu');
        if (get_user_browser() == 'ie') {
            echo $this->Html->meta(array('http-equiv' => 'x-ua-compatible', 'content' => "IE=8")) . "\r\n";
            echo $this->Html->css('/css/ie');
            $bodyIeClass = getIeVersion() ? "ie ie" . getIeVersion() : '';
        }
        /* -------------------------------------------------------------- */
        ?>
    </head>
    <body class="<?= @$bodyIeClass ?>">
	<div id="bglightbox2"></div>
	<div id="addVideo"></div>
        <div id="loading" style="width:100%;height:9000px;position:absolute;z-index:99;background:#E2E2E2 url(/img/assets/saving.gif) center 50px no-repeat ;" >
            &nbsp;
        </div>
        <!-- main site -->
        <div id="content" class="content <?= $this->params['controller'] ?> <?= $this->params['action'] ?>" style="min-width:1024px;z-index:0;">
            <div id="header">

                <a href="/admin/" class="logo">&nbsp</a>


                <div id="menuCntr">
                    <?
                    $authUser = true;
					
                    if (!empty($authUser) && !empty($adminMenu)) {
                        echo $modules->adminMenu($adminMenu);
						
                    }
                    $this->Js->buffer("$('ul#admin_menu').superfish({dropShadows : false});");
                    ?>
                </div>

            </div>
            <div id="main">
                <div class="padding">
                    <?php echo $this->Session->flash(); ?>
                    <?
                    $extra = array();
                    if (strstr(low($this->params['action']), 'edit') || strstr(low($this->params['action']), 'add')) {
                        $extra[] = 'form';
                    }


                    $viewParams = am($extra, array($this->params['controller'], $this->params['action'], str_replace(@$this->params['prefix'], '', Inflector::humanize($this->params['action']))));
                    $viewParams = array_unique(array_map('low', $viewParams));
                    $viewID = Inflector::classify(implode(' ', $viewParams));
                    $viewClass = low(implode(' ', $viewParams));
                    $model = Inflector::classify($this->params['controller']); 
                    ?>

                    <?
					if(!isset($nobreadcrumb) || $nobreadcrumb!=1)
                    echo $this->Modules->breadcrumbs(
                        $this->params['url']['url'], array(
                        'prefix' => isset($this->params['prefix']) ? $this->params['prefix'] : null,
                        'view' => isset($this->params['action']) ? $this->params['action'] : null,
                        'filter' => isset($this->data[$model]['filter'] ) ? 'VIEW_' . $this->data[$model]['filter'] : null,
                        )
                    );
					
                    ?>
                    <div id="<?= $viewID; ?>" class="<?= $viewClass ?> full">
                        <?php echo $content_for_layout; ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <a href="/admin/" class="logo">&nbsp</a>
        </div>


        <!-- main site -->
        <? echo $this->element('common/scripts', array('cache' => '1 day')); ?>

        <? echo $this->Html->script('jquery/superfish', array('once' => true, 'inline' => true)); ?>

        <cake:viewscripts></cake:viewscripts>

        <script type="text/javascript">
            $(document).ready(function(){

                /* Actions */
                $('.actions li a, .actions > a').addClass( 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only').hover(function(){
                    $(this).addClass('ui-state-hover');
                },
                function(){
                    $(this).removeClass('ui-state-hover');
                }).children('span').addClass('ui-button-text').filter('.disabled').addClass('ui-state-disabled') ;


                $('.actions li a').each(function(k,e){
                    e = $(e);
                    text = e.text() ;

                    e.text('').append( $('<span>').text(text).addClass('ui-button-text') );


                });


                $('.auto-process').click(function(){
                    var e = $(this) ;
                  
                    var eType = String( e.get(0).tagName ).toLowerCase();
                    
                    reload = removeElement = function() {};
                    
                    if ( e.hasClass('remove') ){
                        removeElement = function() {
                            e.remove();
                        }
                    }
                    
                    if ( e.hasClass('reload') ){
                        reload = function() {};
                    } 
                    
                    
                    
                    if ( eType == 'a' && e.hasClass('ajax') ) {
                        h = function () { 
                            $.get(e.attr('href'),function(){
                                removeElement();
                                reload();
                            }); 
                        }
                    } else if (eType == 'a'  ) {
                        h = function () {
                            window.location = e.attr('href');
                        }
                    }
                    
                    if ( e.hasClass('confirm') && confirm('<? __('ARE_YOU_SURE_THIS_CAN_NO_BE_UNDONE') ?>')   ){
                        h(); 
                    }  else if ( !e.hasClass('confirm')){
                        h(); 
                    }
                    

                    return false ;
                });
                /*

                $("#order fieldset , #sort fieldset , #filter fieldset , #direction fieldset , #limit fieldset ").buttonset();


                $("#order fieldset input[type=radio],#sort fieldset input[type=radio] , #filter fieldset input[type=radio], #direction fieldset input[type=radio],#limit fieldset input[type=radio]").change(function(){
                    $('#searchForm').submit();
                });

                 */





                $('.filters a.ui-button').hover(function(){
                    $(this).addClass('ui-state-hover');
                },
                function(){
                    $(this).removeClass('ui-state-hover');
                }) ;



                $('.filters input[type=submit],.btn , div.submit button , div.submit input ').addClass('ui-button ui-state-default ui-button-text-only ui-corner-right').css({padding:'.4em 1em'}).hover(function(){
                    $(this).addClass('ui-state-hover');
                },
                function(){
                    $(this).removeClass('ui-state-hover');
                }) ;

                $('.filters #search input[type=text]').addClass('ui-corner-left').parent('div').addClass('ui-widget'); /*.css({padding:'.4em 1em'})*/


                paginator = $('.box.paginator');
                paginatorBox = paginator.children('.box').css({ display :'inline-block'  });
                paginatorBox.filter('.box.prev,.box.next').addClass( 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only').hover(function(){
                    $(this).addClass('ui-state-hover');
                },
                function(){
                    $(this).removeClass('ui-state-hover');
                }).children('span').addClass('ui-button-text').filter('.disabled').addClass('ui-state-disabled') ;
                paginatorNumbers = paginatorBox.filter('.box.numbers').children('span').addClass( 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only').hover(function(){
                    $(this).addClass('ui-state-hover');
                },
                function(){
                    $(this).removeClass('ui-state-hover');
                });
                paginatorNumbers.filter('.current').addClass('ui-state-active').css({'padding':'.4em 1em' , 'line-height' : '1.4'}) ;
                paginatorNumbers.children('a').addClass('ui-button-text');








                /*




                $('a.btn.toggler').click(function(){
                    $(this).parent('form').parent('div').hide();
                    $( $(this).attr('href') ).show('blind') ;
                });

                $('.actions button, .actions .btn , .btn.process').click(function(){
                    var e = $(this);
                    if ( e.hasClass('ui-state-disabled') ){
                        return false ;
                    }


                    var url = $(this).is('a') ? e.attr('href') : e.val() ;
                    $(this).addClass('ui-state-disabled');
                    var handler = function (){
                        $.post( url , $('#searchForm').serialize() ,function(r){
                            if ( String(r).replace(/(\s|\t|\r|\n)+/g,'') != '' && !e.hasClass('no-redirect') && !e.hasClass('reload') ){
                                window.location = r ;
                            } else if ( e.hasClass('reload')  ) {
                                window.location = window.location ;
                            } else if ( e.hasClass('successAlert')  ) {

                                alert('La operacion se ha completado.');
                            } else {
                                if ( e.hasClass('remove') ) {
                                    e.remove();
                                } else if (e.hasClass('remove-tr')) {
                                    e.parents('tr').remove();
                                }

                            }
                            $(e).removeClass('ui-state-disabled').addClass('ui-state-default');
                        });
                    }

                    if ( e.hasClass('no-ajax') || e.hasClass('follow')  ) {
                        return true;
                    } else if (e.hasClass('confirm')    ) {
                        confirm( langTexts.confirm.title , langTexts.confirm.body  , handler );
                    } else if (  !e.hasClass('confirm') ) {
                        handler();
                    } else {
                        $(e).removeClass('ui-state-disabled').addClass('ui-state-default');
                    }

                    return false ;
                });




                /**/
                /**/

                /*
            function sizeContent() {

                h = $('#header').height();
                f = $('#footer').height();
                w = $(window).height() ;

                $('#main').height((w-(h+f)-25)+ 'px') ;

            }

            sizeContent();

            $(window).resize(function() { sizeContent() })
            $(document).resize(function() {  sizeContent() })
                 */
                    
                $('form.ajax').live('submit',function(){
                    update = $(this).parent('div');
                    $.post( $(this).attr('action') , $(this).serialize() , function(response){
                        update.html(response);
                    });
                    return false ;
                });

                $('#loading').remove();
            });
        </script>


        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
