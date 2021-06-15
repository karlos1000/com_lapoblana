<?php
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');
JHtml::_('behavior.multiselect');
JHTML::_('behavior.formvalidation');

//$script1 = "
//    JQ(document).ready(function(){
//        JQ('input[name=\"cid[]\"]').click(function(){
//           var v = JQ(this).val();
//           var id = JQ(this).attr('id');
//           JQ('#checked').val(v);
//        });
//
//        //Reemplazar evento onclick
////        JQ('#toolbar-delete a').attr('onclick','').unbind('click');
////        JQ('#toolbar-delete a').click(function(){
////            if (document.adminForm.boxchecked.value==0){
////                alert('Please first make a selection from the list');
////            }else{
////                var r=confirm('No es posible eliminar Fraccionamiento(s), al hacerlo se borrara los Condominios vinculados y sus pagos respectivamente, ¿Realmente estás seguro?');
////                if (r==true){
////                    Joomla.submitbutton('catsubdivisions.delete');
////                }else{
////                    return false;
////                }
////            }
////
////        });
//
//    });
//    ";
//
//// Add the script to the document head.
//JFactory::getDocument()->addScriptDeclaration($script1);

?>
<form action="<?php echo JRoute::_('index.php?option=com_lapoblana&view=catcustomers'); ?>" method="post" name="adminForm" id="adminForm">
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
                    <?php echo JText::_('Nombre Cliente'); ?>
                </th>
                <th>
                    <?php echo JText::_('Nombre Usuario Joomla'); ?>
                </th>
                <!--
                <th>
                    ?php echo JText::_('Usuario'); ?>
                </th>
                -->
                <th>
                    <?php echo JText::_('Activo'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->items as $i => $item): ?>

                <tr class="row<?php echo $i % 2; ?>">
                    <td>
                        <?php echo $item->customerId; ?>
                    </td>
                    <td>
                        <?php echo JHtml::_('grid.id', $i, $item->customerId); ?>
                    </td>
                    <td class="center">
                        <a href="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catcustomer.edit&id=' . $item->customerId); ?>">
                            <?php echo $item->customerName; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a href="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catcustomer.edit&id=' . $item->customerId); ?>">
                            <?php echo $item->name; ?>
                        </a>
                    </td>
                    <!--
                    <td class="center">
                        ?php echo $item->username; ?>
                    </td>
                    -->
                    <td class="center">
                        <?php echo JHtml::_('jgrid.published', $item->active, $i, 'catcustomers.',  'cb'); ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"><?php echo $this->pagination->getListFooter(); ?></td>
            </tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="checked" id="checked" value="" />

        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
