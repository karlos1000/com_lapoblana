<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html'); 
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';                                
include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolUploader' . DIRECTORY_SEPARATOR . 'kooluploader.php';        

JViewLegacy::loadHelper('lapoblanahp');   
$grid = LapoblanahpHelper::GetAllImagesByDetailsInGrid();    
//
//
//echo '1: '. JURI::root() .'<br/>';
//echo '2: '. JPATH_SITE .'\hola' .'<br/>';
//echo '3: '. __FILE__ .'<br/>';
//echo '4: '. JPATH_BASE .'<br/>';
//echo '5: '. JPATH_ADMINISTRATOR .'<br/>';
//echo '6: '. JURI::base();
//

?> 

<div class="notesUllapoblana">
        <label>A continuación se enlistan las imágenes ocupadas en los detalles de las ordenes, éste grid es de solo lectura.</label>        
</div>
<br/><br/>
<style>
    .defaultKUL .kulClearAll{display:none;} .defaultKUL .kulUploadAll{display:none;}		    
</style>
 <form action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catimages');?>" method="post" id="adminForm" name="adminForm">    
     
        <?php     
            echo $koolajax->Render();
            echo $grid->Render();   
        ?>          
        <input type="hidden" name="task" value="catimages" />                    
        <?php echo JHtml::_('form.token'); ?>
</form>

<br/>
<br/>
