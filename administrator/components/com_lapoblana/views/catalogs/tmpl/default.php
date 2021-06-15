<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

<form action="<?php echo JRoute::_('index.php?option=com_lapoblana&task=catalogs');?>" method="post" id="adminForm" name="adminForm" >

 <div class="adminform comwrapper">
    <div class="cpanel">
        <div class="cpanel-left">
            <div class="icon-wrapper">
                <div class="icon">
                    <a href="index.php?option=com_lapoblana&amp;view=catcustomers" style="text-decoration:none;" title="Lista de clientes">
                        <img src="../media/com_lapoblana/images/cat_clientes.png" align="middle" border="0">
                        <span>Clientes</span>
                    </a>
                </div>
            </div>

            <div class="icon-wrapper">
                <div class="icon">
                    <a href="index.php?option=com_lapoblana&amp;view=catproducts" style="text-decoration:none;" title="Lista de productos">
                        <img src="../media/com_lapoblana/images/cat_productos.png" align="middle" border="0">
                        <span>Productos</span>
                    </a>
                </div>
            </div>

            <div class="icon-wrapper">
                <div class="icon">
                    <a href="index.php?option=com_lapoblana&amp;view=catdrawings" style="text-decoration:none;" title="Lista de dibujos">
                        <img src="../media/com_lapoblana/images/cat_dibujos.png" align="middle" border="0">
                        <span>Dibujo</span>
                    </a>
                </div>
            </div>

            <div class="icon-wrapper">
                <div class="icon">
                    <a href="index.php?option=com_lapoblana&amp;view=catstatus" style="text-decoration:none;" title="Lista de estatus">
                        <img src="../media/com_lapoblana/images/cat_status.png" align="middle" border="0">
                        <span>Estatus</span>
                    </a>
                </div>
            </div>

            <div class="icon-wrapper">
                <div class="icon">
                    <a href="index.php?option=com_lapoblana&amp;view=catimages" style="text-decoration:none;" title="Colecci&oacute;n de imagenes">
                        <img src="../media/com_lapoblana/images/cat_status.png" align="middle" border="0">
                        <span>Im&aacute;genes</span>
                    </a>
                </div>
            </div>

         </div>

         <div class="cpanel-right">

         </div>
    </div>
 </div>
     <input type="hidden" name="task" value="catalogs" />
</form>