<?php
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('behavior.modal');
//JHTML::_('behavior.formvalidation');
$ordering	= $this->escape($this->state->get('list.ordering'));
$direction	= $this->escape($this->state->get('list.direction'));

?>
<div class="notesUllapoblana">
        <label>Todas las filas donde su columna cliente se encuentre vacía le falta asociar con un usuario de joomla.</label>
        <ul>
            <li>Solo presioné el vínculo de número de orden ó seleccioné la fila y pulse editar.</li>
            <li>De clic en el botón "Buscar cliente" dentro de la vista de edición para asociarlo.</li>                
        </ul>
</div>
<form action="<?php echo JRoute::_('index.php?option=com_lapoblana&view=orders'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="left">
        <label for="filter_search">
                <?php echo JText::_('JSearch_Filter_Label'); ?>
        </label>
        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" size="30" title="<?php echo JText::_('Filtro'); ?>" />

        <button type="submit">
                <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
        <button type="button" onclick="document.id('filter_search').value='';this.form.submit();">
                <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">                    
                    <?php echo JHtml::_('grid.sort', 'ID', 'idOrder', $direction, $ordering); ?>                    
                </th>
                <th width="20">
                    <?php echo JText::_('Sel'); ?>                    
                </th>			
                <th>                    
                    <?php echo JHtml::_('grid.sort', 'Número de orden', 'orderNum', $direction, $ordering); ?>  
                </th>
                <th>                    
                    <?php echo JHtml::_('grid.sort', 'Cliente', 'idCustomer', $direction, $ordering); ?>  
                </th>                
                <th>                    
                    <?php echo JHtml::_('grid.sort', 'Fecha Orden', 'dateOrder', $direction, $ordering); ?>  
                </th>
                <th width="80">                    
                    <?php echo JHtml::_('grid.sort', 'Fecha Recepción', 'dateReceipt', $direction, $ordering); ?>  
                </th>
                <th>                    
                    <?php echo JHtml::_('grid.sort', 'Semanas', 'weeks', $direction, $ordering); ?>  
                </th>
                <th width="80">                    
                    <?php echo JHtml::_('grid.sort', 'Fecha Estimada', 'dateEstimated', $direction, $ordering); ?>  
                </th>                                
            </tr>
        </thead>
        <tbody>            
            <?php foreach ($this->items as $i => $item): ?>
            
                <tr class="row<?php echo $i % 2; ?>">
                    <td>
                        <?php echo $item->idOrder; ?>
                    </td>
                    <td>
                        <?php echo JHtml::_('grid.id', $i, $item->idOrder); ?>
                    </td>
                    <td class="center">
                        <a href="<?php echo JRoute::_('index.php?option=com_lapoblana&task=order.edit&id=' . $item->idOrder); ?>">
                            <?php echo $item->orderNum; ?>
                        </a>
                    </td>
                    <td class="center">
                        <?php echo $item->name_user;?>
                    </td>
                    <td class="center">
                        <?php echo date ("d/m/Y", strtotime($item->dateOrder)); ?>
                    </td>                    
                    <td class="center">
                        <?php echo date ("d/m/Y", strtotime($item->dateReceipt)); ?>
                    </td>                    
                    <td class="center">
                        <?php echo $item->weeks;?>
                    </td>
                    <td class="center">
                        <?php echo date ("d/m/Y", strtotime($item->dateEstimated)); ?>
                    </td>                    
                </tr>                
            <?php endforeach; ?>
                         
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
            </tr>
        </tfoot>        			
    </table>
    <div>        
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />        
        <input type="hidden" name="filter_order" value="<?php echo $ordering; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $direction; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
