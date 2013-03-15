<?php /* @var $this ViewCC */ ?>
<div class="generic-message">
    <h1> <?php echo nl2br($this->data['Staticpage']['title']);?> </h1>
    <p class='TerminalDosisLight'>
    <?php 
        echo nl2br(String::insert($this->data['Staticpage']['content'], am(
                    $this->Session->read('Message.variables'),
                    $this->data['Staticpage']['variables']
                )
            )
        );
    ?>
    </p>
</div>