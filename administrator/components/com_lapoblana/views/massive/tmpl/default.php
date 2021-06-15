<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
//$lg = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolGrid/localization/es.xml';
include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';
include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolUploader' . DIRECTORY_SEPARATOR . 'kooluploader.php';

$scritFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolUploader';
//$pahtHandle = JPATH_SITE.'/administrator/components/com_lapoblana/common/handle.php';
$pahtHandle = JURI::root().'administrator/components/com_lapoblana/common/handle.php';
//$pahtHandle = 'index.php?option=com_lapoblana&view=massive&layout=handle';
//$pahtHandle = JURI::root().'administrator/components/com_lapoblana/views/massive/tmpl/handle.php';
$styleFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolUploader/styles/default';

//echo JPATH_BASE .'<br/>';
//echo JPATH_SITE .'<br/>';
//echo JPATH_ADMINISTRATOR .'<br/>';
//echo JURI::base().'components/com_lapoblana/common' .'<br/>';
//echo JURI::root().'media/com_lapoblana/upload_files_xls' .'<br/>';

$kul = new KoolUploader("kul");
$kul->scriptFolder = $scritFolder;
$kul->handlePage = $pahtHandle;
$kul->styleFolder=$styleFolder;
$kul->allowedExtension = "gif,jpg,png";
$kul->progressTracking = true;
$kul->maxFileSize = 1024*1024; //500KB

?>

<style>
    .defaultKUL .kulClearAll{display:none;}
    .defaultKUL .kulUploadAll{display:none;}
</style>
 <form action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=massive.uploadXlsXlsx');?>" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" >
    <div id="progressBar"><?php echo $this->imgLoading;?></div>
    <div id="boxMassiveRecord">
        <div>
            <label for="fileToUp">Archivo: </label>
            <input type="file" name="nameFile" id="namefile" class="required"/>
        </div>
    </div>

        <input type="hidden" name="task" value="massive.uploadXlsXlsx" />
        <?php echo JHtml::_('form.token'); ?>
</form>

<br/>
<br/>
<!--<form id="form1" method="post">
	?php echo $koolajax->Render();?>
	?php echo $kul->Render();?>
	<div style="padding-top:20px;">
		<i>*Nota:</i> Solo se  permiten archivos .jpg, *.png, *.gif
	</div>
	<div style="padding-top:5px;">
		<i>*Nota:</i> Peso maximo de imagen 1mb
	</div>
</form>-->