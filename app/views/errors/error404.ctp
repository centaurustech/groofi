<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<? $this->set('pageTitle', false); ?>
<? $this->set('title_for_layout', __('PAGE_ERROR_'.$code , true)); ?>
<div class="generic-message" style="margin-top:20px;">
    <h1 class="title"><? __($name); ?></h1>
    <p class="TerminalDosisLight">
        <? __($message) ?>
    </p>

    <?
    if (empty($link)) {
        $link = array(
            '/' => __('BACK_TO_HOME_PAGE', true),
            'javascript:history.back();' => __('GO_BACK_TO_THE_PREVIOUS_PAGE', true)
        );
    } elseif (is_string($link)) {
        $link = array(
            $link => __('DO_CLICK_HERE', true)
        );
    }

    foreach ($link as $url => $text) {
        $li[] = "<li><a href='$url' title='$text'>$text</a></li>";
    }
    $li = implode('', $li);

    echo "<ul class='generic-message-links'>$li</ul>";
    ?>


</div>