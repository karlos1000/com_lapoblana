<?php
/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/*
 * Controlador Lapoblana
 */
class LapoblanaControllerLapoblana extends JControllerAdmin
{
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana');
    }        
}

?>