<?php

/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * Controlador general del componente La poblana
 */
//class LapoblanaController extends JController{
class LapoblanaController extends JControllerLegacy{
     
        function display($cachable = false, $urlparams = false) 
        {
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->getCmd('view', 'Lapoblana'));
 
                // call parent behavior
                parent::display($cachable);
        }        
}

?>
