<?php /* @var $this ViewCC */ ?>
<script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script type="text/javascript"> //<!-- FACEBOOK LOGIN -->
    //<![CDATA[
    FB.init({appId: '<?= FB_APPLICATION_ID ?>', status: true, cookie: true, xfbml: true});
    FB.Event.subscribe('auth.sessionChange', function(response) {
        if (response.session) {
            window.location = window.location ;
        } else { // The user has logged out, and the cookie has been cleared
            //  window.location = window.location ;
            window.location = '/users/logout' ;
        }
    });
    //]]>
</script>
