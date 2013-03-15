
<?php
    /* @var $this ViewCC */
    $cols=isset($cols) ? $cols : 2;
    $rows=isset($rows) ? $rows : 4;
    $showModules=$rows !== false ? $rows * $cols : ( $rows === false ? 0 : 4 );
    $active=isset($active) ? $active : null;
    $theme=isset($theme) ? '_' . $theme : '';


    $model = isset($model) ? $model : null ;
    $modelData = isset($data[$model]) ?$data[$model] : null ;


    if($modelData) {


    
?>


<div class="module prizes-module" style="width: 100%" >
    <?
        foreach ($data['Prize'] as $key => $prize) {
            echo $this->element('prizes/offer_prize' . $theme, array(
                    'data' => array('Prize' => $prize),
                    'key' => $key,
                    'isFirst' => ($key == 0),
                    'extraClass' => ( $active == $prize['id'] ? 'active' : '' ),
                    'modelData' => $modelData
                )
            );
        }
    ?>
</div>
<cake:script>
        <script type="text/javascript">
            var showModules  = <?= $showModules ?> ;
            var moduleHeight = $('.prize-box').outerHeight(true) ;
            var marginBottom = $('.prize-box').outerHeight(true) - $('.prize-box').outerHeight();
            var prizes = $('.prizes-module .prize-box ') ; //600
            var prizesCount = prizes.length ; //600
            var fullHeight = Math.ceil(prizesCount/<?= $cols ?>) * moduleHeight  ;
            var scrollSteps = Math.ceil(fullHeight / Math.ceil(moduleHeight*showModules/<?= $cols ?>) );
            var scrollStep = 0 ;
            var scrollInterval = 7500 ;
            var scrollDuration = 1000 ;
            prizes.filter(":nth-child(<?= $cols ?>n)").css('margin-right',0);
            prizes.slice(-<?= $cols ?>).css('margin-bottom',0) ;
            if ( showModules > 0 ) {
                prizes.css('width', prizes.width() - ( 18 / ( <?= $cols ?> - 1 ) ) );
                $('.prizes-module').css({
                    height : ( <?= $rows ?> * moduleHeight ) - marginBottom
            }).jScrollPane({
                verticalGutter				: 20,
                horizontalGutter			: 20
            });
        }
    </script>
</cake:script>

<style type="text/css">
    .prizes-scrollBar { width : 10px ; background-color: #EAEAEA ; position: absolute ; top : 0px ; right: 0px ;}
    .prizes-scrollBar .scroller { width : 10px ; height: 10px ; background-color: red ; position: absolute ; top : 0px ; right: 0px ;}
    .ui-slider-handle.ui-state-default.ui-corner-all { width: 10px ; margin: 0px 4px ; padding: 0px ; }
</style>

<?
    } else {
        
    }
?>