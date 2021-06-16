<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');
JHTML::_('behavior.formvalidation');

$productId = (isset($this->data[0]->productId))?$this->data[0]->productId:'';
$productName = (isset($this->data[0]->productName))?$this->data[0]->productName:'';
$active = (isset($this->data[0]->active))?$this->data[0]->active:'';
$dateCreation = (isset($this->data[0]->dateCreation))?$this->data[0]->dateCreation:'';

//echo '<pre>';
//print_r($this->data);
//echo '</pre>';

?>
<style>
.defaultKCD{ position: absolute;margin: 0px;padding: 0px;} label{ width: 170px; } 
.adminform label{
    min-width: 170px;
    padding: 0 5px 0 0; 
}    
</style>
<form class="form-validate form-horizontal" action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catproduct'); ?>" method="post" name="adminForm" id="adminForm">
    <div style="">
        <fieldset class="adminform">
            <div class="control-group">
                <div class="control-label">
                    <label for="productName">Nombre de producto: <span class="star">&nbsp;*</span></label>
                </div>
                <div class="controls">
                    <input type="text" name="productName" id="productName" value="<?php echo $productName; ?>" class="required" />
                </div>
            </div>
            <!-- <div>
                <label for="productName">Nombre de producto: <span class="star">&nbsp;*</span></label>
                <input type="text" name="productName" id="productName" value="<?php echo $productName; ?>" class="required" />
            </div> -->
            <div class="control-group">
                <div class="control-label">
                    <label for="active">Activo:</label>
                </div>
                <div class="controls">
                    <input type="checkbox" name="active" id="active" value="<?php echo $active; ?>" <?php echo ($active==1)?'checked':''; ?> />
                </div>
            </div>
            <!-- <div>
                <label for="active">Activo:</label>
                <input type="checkbox" name="active" id="active" value="<?php echo $active; ?>" <?php echo ($active==1)?'checked':''; ?> />
            </div> -->
        </fieldset>
    </div> 
        
        <input type="hidden" name="task" value="catproduct.edit" />
        <input type="hidden" name="check_un" value="<?php echo $this->id; ?>" />                        
        <?php echo JHtml::_('form.token'); ?>    
    
</form>

