<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';
$koolajax->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolAjax';
include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'koolgrid.php';
$dateC = date("d/m/Y"); //fecha actual

JViewLegacy::loadHelper('lapoblanahp');
$grid = LapoblanahpHelper::GetAllOrdersByIdUser($this->userL);
?>

<!--Sirve para restringuir el acceso a usuarios que no tengan permiso-->
<?php if(JFactory::getUser()->authorise('core.manage', 'com_lapoblana')){ ?>

<?php } ?>



<div id="" class="item-page_micuenta">
	<h1>MIS PEDIDOS</h1>
    <?php echo $koolajax->Render(); ?>
    <div>La tabla de abajo muestra todos los pedidos de un año con sus respectivos detalle de cada uno.</div>
    <br/>
     <?php echo $grid->Render();  ?>
</div>
