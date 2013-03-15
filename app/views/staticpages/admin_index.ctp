<?
echo $this->element('paginator/common');
echo $this->element('paginator/filters');
?>
<?
if (!empty($this->data['results'])) {
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'top'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'top'));
    ?>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
            <th><?php echo $this->Paginator->sort('section'); ?></th>
            <th><?php echo $this->Paginator->sort('slug'); ?></th>
            <th><?php echo $this->Paginator->sort('subtitle'); ?></th>
            <th><?php echo $this->Paginator->sort('template'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->data['results'] as $staticpage):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $staticpage['Staticpage']['id']; ?>&nbsp;</td>
                <td><?php echo $staticpage['Staticpage']['title']; ?>&nbsp;</td>
                <td><?php echo $staticpage['Staticpage']['section']; ?>&nbsp;</td>
                <td><?php echo $staticpage['Staticpage']['slug']; ?>&nbsp;</td>
                <td><?php echo $staticpage['Staticpage']['subtitle']; ?>&nbsp;</td>
                <td><?php echo $staticpage['Staticpage']['template']; ?>&nbsp;</td>
                <td class="actions">
				
                    <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $staticpage['Staticpage']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?
    echo $this->element('paginator/common', array('module' => 'legend', 'extraClass' => 'bottom'));
    echo $this->element('paginator/common', array('module' => 'paginator', 'extraClass' => 'bottom'));
    ?>
<? } else {
    ?>

    <p class="alert-message info"><?= __('NO_RESULTS_FOUND', true) ?></p>
<? } ?>