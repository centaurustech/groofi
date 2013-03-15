<?php /* @var $this ViewCC */ ?>
<?

    if (!empty($pageTitle)) {
        $tag=!empty($tag) ? $tag : 'h1';


        $class=(!empty($class) ? $class : '' ) . ' title TerminalDosisLight ';

        $pageTitle=$this->Html->tag($tag, $pageTitle);



        $pageSubTitle=!empty($pageSubTitle) ? $pageSubTitle : '';

        $titleClass = (!empty($titleClass) ? $titleClass : ' ' ) . (!empty($pageSubTitle) ? ' double-line' : ' single-line');


        $content=$this->Html->div($class, $pageTitle . ' ' . $pageSubTitle);
        $content=$this->Html->div('padding', $content);
        $content=$this->Html->div('content', $content);
        $content=$this->Html->div('titleBlock ' . $titleClass, $content);
        echo $content;
    }
?>