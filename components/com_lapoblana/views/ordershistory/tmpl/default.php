<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html'); 
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolAjax' . DS . 'koolajax.php';                                
$koolajax->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolAjax';
include_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_lapoblana' . DS . 'common' . DS . 'KoolControls' . DS . 'KoolGrid' . DS . 'koolgrid.php'; 

JViewLegacy::loadHelper('lapoblanahp');  
$gridAY = LapoblanahpHelper::GetAllOrdersAfterByIdUser($this->userL); 

?>

<!--Sirve para restringuir el acceso a usuarios que no tengan permiso-->
<?php if(JFactory::getUser()->authorise('core.manage', 'com_lapoblana')){ ?>            
        
<?php } ?>        

<div id="" class="item-page_micuenta">
  <h1>HISTORIAL</h1>
    <?php echo $koolajax->Render(); ?>         
        <div>La tabla de abajo muestra todos los pedidos despu&eacute;s de un a&ntilde;o con sus detalles de producto.</div>
        <br/>                    
    <?php echo $gridAY->Render(); ?>    
</div>
