<?php /* @var $this ViewCC */ ?>

<? $this->set('pageTitle', false); ?>

<? if(!$this->Session->read('Auth.User.id')) { ?>
    <div id="homeSlider">
        <div id="homeSlideShowCntr">
            <a href="http://www.adobe.com/go/getflashplayer">

                <img src="/img/assets/slideshow.png" alt="Get Adobe Flash player" />
            </a>

        </div>
    </div>
    <cake:script>
        <script type="text/javascript">
            $(document).ready(function() {

                var flashvars = {};
                var params = {'wmode' : 'opaque'};
                var attributes = {};
                attributes.id = "homeSlideShow";
                swfobject.embedSWF("/swf/slideshow.swf", "homeSlideShowCntr", "940", "300", "8.0.0", "/swf/expressInstall.swf", flashvars, params, attributes);

            });
        </script>
    </cake:script>
<? } ?>

<? if($this->data['HighlightProjects'] || $this->data['HighlightOffers']) { ?>
    <div class="home main">



        <? if($this->data['HighlightProjects']) { ?>
            <div class="discover-projects search-result">
                <?

                echo $this->element('common/page_simple_title', array(
                    'pageTitle' => __('HIGHLIGHT_PROJECTS_TITLE', true),
                    'pageSubTitle' => __('HIGHLIGHT_PROJECTS_SUBTITLE', true),
                    'tag' => 'h3'
                        )
                );

                ?>
                <div class="content">
                    <?

                    foreach($this->data['HighlightProjects'] as $key => $projectData) {
                        echo $this->element('projects/discover_project', array('data' => $projectData, 'extraClass' => zebra($key, 3)));
                    }

                    ?>
                </div>
                <a class="btn" href="/discover/most-recent/projects"><? __('DISCOVER_MORE') ?></a>
            </div>
        <? } ?>

        <? if($this->data['HighlightOffers']) { ?>
            <div class="clearfix"></div>
            <div class="discover-offers search-result">
                <?

                echo $this->element('common/page_simple_title', array(
                    'pageTitle' => __('HIGHLIGHT_OFFERS_TITLE', true),
                    'pageSubTitle' => __('HIGHLIGHT_OFFERS_SUBTITLE', true),
                    'tag' => 'h3'
                        )
                );

                ?>
                <div class="content">
                    <?

                    foreach($this->data['HighlightOffers'] as $key => $offerData) {
                        echo $this->element('offers/discover_offer', array('data' => $offerData, 'extraClass' => zebra($key, 3)));
                    }

                    ?>
                </div>

                <a class="btn" href="/discover/most-recent/offers"><? __('DISCOVER_MORE') ?></a>
            </div>
        <? } ?>


    </div>


    <div class="home right">


        <? if(!$this->Session->read('Auth.User')) { ?>
            <div class="home login form" id="loginForm" > <? // Do not show login errors on fields                    ?>
                <?

                echo $this->element('common/page_simple_title', array(
                    'pageTitle' => __('LOGIN_TITLE', true),
                    'pageSubTitle' => __('LOGIN_SUBTITLE', true),
                    'tag' => 'h5'
                        )
                );
                if($this->params['url']['url'] != 'login') {
                    $opt['error'] = false;
                    $opt['value'] = false;
                } else {
                    $opt = array();
                }

                echo $this->Form->create('User', array('url' => '/login'));

                ?><div class="padding"><?

        if(isset($error) && $error === true) {

            echo $this->Html->div('error-message', __('INVALID_LOGIN_INFORMATION', true));
        }

        echo $this->Form->input('User.email', $opt);

        echo $this->Form->input('User.password', $opt);

        echo $this->Form->submit(__('LOGIN', true));

                ?></div><?

            echo $this->Form->end();

                ?>
            </div>


            <div class="home register form" id="registerForm"  style="margin-top:30px">

                <?

                echo $this->element('common/page_simple_title', array(
                    'pageTitle' => __('REGISTER_TITLE', true),
                    'pageSubTitle' => __('REGISTER_SUBTITLE', true),
                    'tag' => 'h5'
                        )
                );

                if($this->params['url']['url'] != 'signup') {
                    $opt['error'] = false;
                    $opt['value'] = false;
                } else {
                    $opt = array();
                }

                echo $this->Form->create('User', array('url' => '/signup'));

                ?><div class="padding"><?

        echo $this->Form->input('User.facebook_id', am($opt, array('type' => 'hidden')));
        echo $this->Form->input('User.display_name', $opt);
        echo $this->Form->input('User.email', $opt); // if facebook account it's active, mail addres must be facebook email.
        echo $this->Form->input('User.password', $opt);
        echo $this->Form->input('User.password_confirmation', am($opt, array('type' => 'password')));

        if($this->Session->read('FB')) {
            echo $this->Form->input('User.slug');
            echo $this->Form->autoComplete('User.city', array(
                'url' => '/services/cities/query.php'
                    ), array(
                'after' => $this->Form->error('location_id')
                , 'label' => 'USER_LOCATION_LABEL'
                    )
            );
        }

        echo $this->Html->div('terms-of-user', sprintf(__('TERMS_OF_USER_BODY %s', true), $this->Html->link(__('TERMS_OF_USE_LINK', true), '/page/terminos-de-uso')));

        echo $this->Form->submit(__('REGISTER_ME', true));

                ?></div><?

            echo $this->Form->end();

                ?>
            </div>


        <? } else { ?>
            <div class="home faq slide" >
                <img src="/img/assets/minifaq_proyecto.png"     />
                <img src="/img/assets/minifaq_patrocinar.png"   />
                <img src="/img/assets/minifaq_ofrecimiento.png" />
                <div class="pagin prev">&nbsp;</div>
                <div class="pagin next">&nbsp;</div>
            </div>
        <? } ?>
        <? if($this->data['HighlightUsers']) { ?>



            <div class="highlight-users facepile"  style="margin-top:30px">
                <?

                echo $this->element('common/page_simple_title', array(
                    'pageTitle' => __('HIGHLIGHT_USERS_TITLE', true),
                    'pageSubTitle' => __('HIGHLIGHT_USERS_SUBTITLE', true),
                    'tag' => 'h4'
                        )
                );

                ?>
                <div class="clearfix"></div>
                <div class="content">
                    <?

                    foreach($this->data['HighlightUsers'] as $key => $userData) {
                        echo $this->Html->div('thumb ' . zebra($key, 5), $this->Media->getImage('s50', $userData['User']['avatar_file'], '/img/assets/img_default_50px.png'), array('url' => User::getLink($userData)));
                    }

                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        <? } ?>
        <div class="clearfix"></div>
        <? if($this->data['NewestUsers'] && $this->Session->read('Auth.User')) { ?>
            <div class="highlight-users facepile" style="margin-top:20px">
                <?

                echo $this->element('common/page_simple_title', array(
                    'pageTitle' => __('NEWEST_USERS_TITLE', true),
                    'pageSubTitle' => __('NEWEST_USERS_SUBTITLE', true),
                    'tag' => 'h4'
                        )
                );

                ?>
                <div class="clearfix"></div>
                <div class="content">
                    <?

                    foreach($this->data['NewestUsers'] as $key => $userData) {
                        echo $this->Html->div('thumb ' . zebra($key, 5), $this->Media->getImage('s50', $userData['User']['avatar_file'], '/img/assets/img_default_50px.png'), array('url' => User::getLink($userData)));
                    }

                    ?>
                    <div class="clearfix"></div>
                </div>

            </div>
        <? } ?>
    </div>
<? } ?>

<cake:script>
    <script type="text/javascript">
        var homeFaqSlideInterval = false ;
        var slideTimeout = 15000 ;
        var homeSlides = $('.home.faq.slide img').css('display' , 'none') ;
        var slidePos = 0 ;
        // ---------------------------------------------------------------

        function homeFaqSlide(direction) {
            slidePos = slidePos + direction ;
            slidePos = slidePos > homeSlides.length ? 1 : slidePos ;
            slidePos = slidePos <= 0 ? homeSlides.length : slidePos ;
            homeSlides.filter(':visible').hide('fade',500);
            homeSlides.eq(slidePos-1).show('fade',500);
            // ---------------------------------------------------------------
            clearInterval(homeFaqSlideInterval);
            homeFaqSlideInterval = setInterval( homeFaqSlide, slideTimeout , 1);
        }

        $('.home.faq.slide .pagin').click(function(){
            direction = $(this).hasClass('next') ? 1 : -1 ;
            homeFaqSlide(direction);
        });

        $('.home.faq.slide').hover(function(){
            clearInterval(homeFaqSlideInterval);
        }, function(){
            homeFaqSlideInterval = setInterval( homeFaqSlide, slideTimeout , 1);
        });

        homeFaqSlide(1);
    </script>
</cake:script>

