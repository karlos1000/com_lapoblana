<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php 
    //if($this->managerUsr==true):             
?>
<?php if(JFactory::getUser()->authorise('core.manage', 'com_lapoblana')): ?>                    
<div class="adminform">
    <div class="cpanel">
        <div class="cpanel-left">
            <h2>Apartado de Registros</h2>
            <div class="icon-wrapper">
                    <div class="icon"> 
                        <a href="index.php?option=com_lapoblana&amp;view=orders" style="text-decoration:none;" title="Registro de pedidos">
                            <img src="../media/com_lapoblana/images/pedidos.png" align="middle" border="0">
                            <span>Pedidos</span>
                        </a>
                    </div>        
                </div>                  
                
                <div class="icon-wrapper">
                    <div class="icon">                         
                        <a href="index.php?option=com_lapoblana&amp;view=massive" style="text-decoration:none;" title="Registro Masivo">
                            <img src="../media/com_lapoblana/images/reg_masivo.png" align="middle" border="0">
                            <span>Registro Masivo</span>
                        </a>
                    </div>
                </div>
                
                <div class="icon-wrapper">
                    <div class="icon">                         
                        <a href="index.php?option=com_lapoblana&amp;view=upload" style="text-decoration:none;" title="Subir Imagenes">
                            <img src="../media/com_lapoblana/images/reg_masivo_img.png" align="middle" border="0">
                            <span>Subir Imagenes</span>
                        </a>
                    </div>
                </div>
            
         <br/><br/>          
        </div>
                
        <div class="cpanel-right">
            <h2>Registro de Catálogos e Información del componente</h2>
                <div class="icon-wrapper">
                    <div class="icon">                        
                        <a href="index.php?option=com_lapoblana&amp;view=catalogs" style="text-decoration:none;" title="Catálogos">
                            <img src="../media/com_lapoblana/images/catalogos.png" align="middle" border="0">
                            <span>Catálogos</span>
                        </a>
                    </div>
                </div>                           
                <div class="icon-wrapper">
                    <div class="icon">                        
                        <a href="index.php?option=com_lapoblana&amp;view=information" style="text-decoration:none;" title="Información">
                            <img src="../media/com_lapoblana/images/informacion.png" align="middle" border="0">
                            <span>Información</span>
                        </a>
                    </div>
                </div>
         </div>
                 
        
	</div>
</div>   
       
<?php 
    else:
        echo 'Restricted Access';
    endif;
?>
