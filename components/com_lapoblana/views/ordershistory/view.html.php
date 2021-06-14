<?php

/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
//jimport('joomla.application.component.controller');
/**
 * Vista html para el componente lapoblana desde el site
 */

class LapoblanaViewOrdershistory extends JViewLegacy{
   // Overwriting JView display method
        function display($tpl = null) 
        {
                // Assign data to the view                               
                $this->id = JRequest::getVar('id'); //obtiene id de la url                               
                $this->Itemid= JRequest::getVar('Itemid'); //obtiene id de la url 
                
                $this->user = JFactory::getUser();                
                $idUserLogin = $this->user->id; //id de usuario logueado                
                $this->userL = $idUserLogin;
                
                //$model = JModel::getInstance('Loadingdata', 'LapoblanaModel');                                    
                                
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
                        return false;
                }                               
                // Display the view
                parent::display($tpl);
                $this->setDocument();
        }                
        
        protected function setDocument() 
        {
            $document = JFactory::getDocument();
            $document->setTitle(JText::_('Historial de mis pedidos'));                                
            $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
            $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');    
            $document->addScript(JURI::root().'components/com_lapoblana/views/com_lapoblana/submitbutton.js');  
        }
}

?>
