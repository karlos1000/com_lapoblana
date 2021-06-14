<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?> 
 <form action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=information');?>" method="post" id="adminForm" name="adminForm" >
     <div class="boxInfoComp">
         <!--
         <div>
             <div>
                 <h2>Componente de consulta de estado de pedidos de clientes de la poblana</h2>
             </div>         
         </div>                                       
         -->
         <div class="infoComp">
             <div>
                 <label>Desarrollado por</label>
             </div>    
             <div>               
                 <span>Framelova S.A de C.V</span>
             </div>            
         </div>                         
         <div class="infoComp">
             <div>
                 <label>Soporte</label>
             </div>
             <div>
                 <span>soporte@framelova.com</span>
             </div>     
         </div>         
         <div class="infoComp">
             <div>
                 <label>Version</label>
             </div>
             <div>
                 <span><?php echo JText::_('COM_LAPOBLANA_VERSION_LB'); ?></span>
             </div>     
         </div>
     </div>    
     
     <input type="hidden" name="task" value="information" />                    
        <?php echo JHtml::_('form.token'); ?>
</form>