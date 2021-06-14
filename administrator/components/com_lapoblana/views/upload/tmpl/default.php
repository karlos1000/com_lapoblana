<?php
// no direct access
defined('_JEXEC') or die('Restricted access'); 
// load tooltip behavior
JHtml::_('behavior.tooltip');
jimport('joomla.filesystem.file'); 

?>
<div class="notesUllapoblana">
        <label>Para subir correctamente una ó mas imagenes siga las siguientes indicaciones.</label>
        <ul>
            <li>Solo se permiten imagenes con la extensión png, jpg ó gif.</li>
            <li>Deben tener un peso menor a 1 mb.</li>                            
            <li><strong>Importante:</strong> La ó las imagenes a subir deben de tener el mismo nombre que la del archivo xls.</li>
            <li>Se puede seleccionar mas de una imagen a la vez.</li>                
            <li>Por último solo presioné el botón de "Subir imagenes".</li>
        </ul>
</div>
<br/>
<form  action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=uploadImg'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data"> 
        <input type="file" name="file_upload[]" size="10" multiple="multiple" />
        <br/><br/>

        <button id="btnUpload" type="button">Subir imagenes</button>       
        <input type="hidden" name="task" value="" />        
        <?php echo JHtml::_('form.token'); ?>
</form>
 