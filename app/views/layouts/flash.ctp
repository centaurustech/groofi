<?= $this->Html->docType(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
        <head>
            <?echo $this->Html->charset() . "\r\n";?>
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
            <title><?php echo $title_for_layout; ?></title>
        <?php if (Configure::read() == 0) {
        ?>
                <meta http-equiv="Refresh" content="<?php echo $pause ?>;url=<?php echo $url ?>"/>
        <?php } ?>
        </head>
        <body>
            <div id="container">
                <div id="content">
                    <h3><?php echo $message ?></h3>
                    <p><a href="<?php echo $url ?>"><?php
            __('Click here if not automatically forwarded in');
            echo $pause;
            __('seconds')
        ?>.</a></p>
            </div>
        </div>
    </body>
</html>