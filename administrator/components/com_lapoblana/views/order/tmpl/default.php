<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html'); 
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
//JHTML::_('behavior.formvalidation');

include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolAjax' . DS . 'koolajax.php';                                
include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolCalendar' . DS . 'koolcalendar.php';        
$koolajax->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolAjax';
include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolGrid' . DS . 'koolgrid.php'; 
$base = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolGrid/localization/es.xml';     
$calLangueaje = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolCalendar/localization/es.xml';     

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');
JHTML::_('behavior.formvalidation');

$dateC = date("d/m/Y"); //fecha actual

$idOrder = (isset($this->data[0]->idOrder))?$this->data[0]->idOrder:'';
$orderNum = (isset($this->data[0]->orderNum))?$this->data[0]->orderNum:'';
$idCustomer = (isset($this->data[0]->idCustomer))?$this->data[0]->idCustomer:'';
$dateOrder = (isset($this->data[0]->dateOrder))?$this->data[0]->dateOrder:'';
$dateReceipt = (isset($this->data[0]->dateReceipt))?$this->data[0]->dateReceipt:'';
$weeks = (isset($this->data[0]->weeks))?$this->data[0]->weeks:'';
$dateEstimated = (isset($this->data[0]->dateEstimated))?$this->data[0]->dateEstimated:'';
$name_user = (isset($this->data[0]->name_user))?$this->data[0]->name_user:'';

//Fecha orden de datos generales
$calO = new KoolDatePicker("dateO"); //Create calendar object
//$cal->scriptFolder = "../objects/KoolControls/KoolCalendar";//Set scriptFolder
$calO->styleFolder="default";
$calO->DateFormat = "d/m/Y";
$calO->Width="100px";
$calO->id="dateO";
$calO->Localization->Load($calLangueaje);
$calO->Init();
$calO->Value = ($dateOrder!='') ? date("d/m/Y", strtotime($dateOrder)) :$dateC;

//Fecha recepcion de datos generales
$calR = new KoolDatePicker("dateR"); //Create calendar object
$calR->styleFolder="default";
$calR->DateFormat = "d/m/Y";
$calR->Width="100px";
$calR->id="dateR";
$calR->Localization->Load($calLangueaje);
$calR->Init();
$calR->Value = ($dateReceipt!='') ? date("d/m/Y", strtotime($dateReceipt)) :$dateC;

//Fecha de datos de entrega
$calD = new KoolDatePicker("dateD"); //Create calendar object
$calD->styleFolder="default";
$calD->DateFormat = "d/m/Y";
$calD->Width="100px";
$calD->id="dateD";
$calD->Localization->Load($calLangueaje);
$calD->Init();
$calD->Value = ($dateEstimated!='') ? date("d/m/Y", strtotime($dateEstimated)) :$dateC;

Jview::loadHelper('lapoblanahp');                
//if($this->id!=0){ 
    $orderN = ($orderNum!='') ? $orderNum : $this->id;
    //obtener todos los productos relacionados al la orden    
    $grid = LapoblanahpHelper::GetAllProductsByOrderGrid($orderN);    
//}
//echo '<pre>';
//print_r($this->data);
//echo '</pre>';

?>
<!--class="form-validate"-->
<div class="notesUllapoblana">
        <label>Para crear correctamente una orden siga los siguientes pasos.</label>
        <ul>
            <li>1.- Rellene los campos requeridos marcados con *.</li>
            <li>2.- De clic en el botón de save.</li>                
            <li><strong>Nota importante:</strong> Si no ha realizado los pasos anteriores no podrá salvar el detalle de la orden</li>
            <li>Si ha seguido correctamente los pasos puede crear/editar un nuevo detalle.</li>
        </ul>
</div>
<style>.defaultKCD{ position: absolute;margin: 0px;padding: 0px;}</style>
<form class="form-validate" action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=order');?>" method="post" id="adminForm" name="adminForm" >                        
            <div style="">
                <fieldset class="adminform record_order">			
                    <legend>Datos generales</legend>                                        
                    
                    <div>
                        <ul class="adminformlist">                            
                            <li><label id="jform_client-lbl" for="for_client" class="hasTip" title="Obtener cliente" aria-invalid="false">Cliente</label>			
                                <div class="fltlft">
                                    <input type="text" name="jform_client" id="jform_client" value="<?php echo $name_user;?>" maxlength="100" class="" aria-invalid="false" size="36" readonly="readonly" class="required">                                    
                                </div>                                
                                <div class="button2-left">
                                    <div class="blank">                                                                               
                                        <a id="btnsearch_customerOrder" class="modal" title="Buscar Cliente" href="index.php?option=com_lapoblana&view=listcustomers&layout=modal&tmpl=component&function=jSelectCustomerlp" rel="{handler: 'iframe', size: {x: 800, y: 450}}">Buscar cliente</a>                                
                                    </div>
                                </div>
                            </li>                              
                        </ul>
                    </div>
                                        
                    <div>
                        <label for="no_order">No. de pedido: <span class="star">&nbsp;*</span></label>
                        <input type="text" name="no_order" id="no_order" value="<?php echo $orderNum; ?>" class="required validate-numeric" <?php echo ($orderNum!='')? "readonly='readonly'": '';  ?> />                        
                    </div>                                                            
                    <div style="clear: both;">
                        <label for="dateKool">Fecha Orden:</label>                                     
                        <?php echo $calO->Render();?>
                    </div>
                    <div style="clear: both;">
                        <label for="dateKool">Fecha Recepción:</label>                                     
                        <?php echo $calR->Render();?>
                    </div>                                        
                </fieldset>
                
                <fieldset class="adminform record_order">
                    <legend>Datos entrega</legend>                    
                    <div>                                                
                        <label for="weeks">Semanas: <span class="star">&nbsp;*</span></label>
                        <input type="text" name="weeks" id="weeks" value="<?php echo $weeks;?>" class="required validate-numeric" />                                                                        
                    </div>
                    <div style="clear: both;">
                        <label for="dateKool">Fecha:</label>                                     
                        <?php echo $calD->Render();?>
                    </div>
                </fieldset>
            </div> 
    
            <div id="kool_Grid">
                <?php            
                    //if ($this->id!=0) {                                
                        echo $koolajax->Render();
                        echo $grid->Render();                        
                    //}
                ?>    
            </div>
                        
            <input type="hidden" name="task" value="order.edit" />
            <input type="hidden" name="idUser_hidden" id="idUser_hidden" value="<?php echo $idCustomer;?>" maxlength="20" class="" aria-invalid="false">                                                                        
            <input type="hidden" name="check_un" value="<?php echo JRequest::getVar('id'); ?>">                                        
            <input type="hidden" id="idOrder" value="<?php echo $idOrder; ?>"/>           
            <?php echo JHtml::_('form.token'); ?>
        </form>
