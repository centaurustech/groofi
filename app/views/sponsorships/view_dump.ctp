<div style="width:29%;float:left;" >
    <div style="" ><?
foreach ($files as $filename) {
    echo $this->Html->link($filename, '/sponsorships/view_dump/' . $filename) . '<br />';
}
?>
    </div>

    <div style="margin-top:15px" ><?
        if ($logs) {
            foreach ($logs as $log) {
                echo $this->Html->link($log['date'], '/sponsorships/view_dump/' . $file . DS . $log['data']) . '<br />';
            }
        }
?>
    </div>
</div>


<div style="width:70%;float:right;" >

    <?
    if (isset($response)) {
        vd(serialize($response));
        vd($response);
    }
    ?>
</div>
