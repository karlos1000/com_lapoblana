<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');
JHTML::_('behavior.formvalidation');

$customerId = (isset($this->data[0]->customerId))?$this->data[0]->customerId:'';
$customerName = (isset($this->data[0]->customerName))?$this->data[0]->customerName:'';
$userIdJoomla = (isset($this->data[0]->userIdJoomla))?$this->data[0]->userIdJoomla:'';
$active = (isset($this->data[0]->active))?$this->data[0]->active:'';
$dateCreation = (isset($this->data[0]->dateCreation))?$this->data[0]->dateCreation:'';
$name = (isset($this->data[0]->name))?$this->data[0]->name:'';
$username = (isset($this->data[0]->username))?$this->data[0]->username:'';

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
<form class="form-validate" action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catcustomer'); ?>" method="post" name="adminForm" id="adminForm">    
    <div class="notesUllapoblana">
        <label>Para actualizar y crear nuevos usuarios de joomla siga los siguentes pasos:</label>
        <ul>
            <li>Seleccion&eacute; el enlace de actualizar &oacute; crear usuario.</li>
            <li>Despu&eacute;s solo de clic en refrescar.</li>                
        </ul>
    </div>
    <div>
        <ul>
            <li><a href="index.php?option=com_users&view=users" target="_blank">Actualizar &oacute; crear usuario</a></li>
            <li><a href="index.php?option=com_lapoblana&view=catcustomer&layout=edit&id=<?php echo $this->id;?>">Refrescar</a></li>
        </ul>
    </div> 
    
    
    <div style="">
        <fieldset class="adminform">
            <div>
                <ul class="adminformlist">                            
                    <li><label id="jform_customer-lbl" for="for_customer" class="hasTip" title="Obtener cliente" aria-invalid="false">Asociar usuario joomla</label>			
                        <div class="fltlft">
                            <input type="text" name="customerName" id="customerName" value="<?php echo $name; ?>" maxlength="100" class="" aria-invalid="false" size="36" readonly="readonly" class="required">                            
                        </div>                        
                        <div class="button2-left">
                            <div class="blank">  
                                <a id="btnsearch_customer" class="modal" title="Buscar Cliente" href="index.php?option=com_lapoblana&view=listuser&layout=modal&tmpl=component&function=jSelectCustomer&" rel="{handler: 'iframe', size: {x: 800, y: 450}}">Buscar usuario</a>                                
                            </div>
                        </div>
                    </li>                              
                </ul>
            </div>
            <div>
                <label for="clientName">Nombre Cliente: <span class="star">&nbsp;*</span></label>
                <input type="text" name="clientName" id="clientName" value="<?php echo $customerName; ?>" class="required"/>                        
            </div>
            
            <!--
            <div>
                <label for="lbUserName">Nombre usuario: <span class="star">&nbsp;*</span></label>
                <input type="text" name="userName" id="userName" value="?php echo $username; ?>" class="required" readonly="readonly"/>                        
            </div>
            -->
            
            <div>
                <label for="lbActive">Activo:</label>                                
                <input type="checkbox" name="active" id="active" value="<?php echo $active; ?>" <?php echo ($active==1)?'checked':''; ?> />                                       
            </div>                               
        </fieldset>
    </div> 
        
        <input type="hidden" name="task" value="catcustomer.edit" />
        <input type="hidden" name="check_un" value="<?php echo $this->id; ?>" />                
        <input type="hidden" name="idUser_hidden" id="idUser_hidden" value="<?php echo $userIdJoomla; ?>" maxlength="20" class="" aria-invalid="false">                                    
        <?php echo JHtml::_('form.token'); ?>    
    
</form>
