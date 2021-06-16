<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_lapoblana&view=catstatus'); ?>" method="post" name="adminForm" id="adminForm">
	<table class="table table-striped">
            <thead>
                <tr>
                    <th width="5">
                        <?php echo JText::_('id'); ?>
                    </th>
                    <th width="20">
                        <?php echo JText::_('Sel'); ?>                                                  
                    </th>			
                    <th>
                        <?php echo JText::_('Nombre Estatus'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('Activo'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->items as $i => $item): ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td>
                            <?php echo $item->statusId; ?>
                        </td>
                        <td>
                            <?php echo JHtml::_('grid.id', $i, $item->statusId); ?>
                        </td>
                        <td class="center">
                            <a href="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catstatu.edit&id=' . $item->statusId); ?>">
                                <?php echo $item->statusName; ?>
                            </a>
                        </td>
                        <td class="center">                            
                            <?php echo JHtml::_('jgrid.published', $item->active, $i, 'catstatus.',  'cb'); ?>  
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"><?php echo $this->pagination->getListFooter(); ?></td>
                </tr>
            </tfoot>
		
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
