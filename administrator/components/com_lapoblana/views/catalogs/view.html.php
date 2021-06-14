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

//class LapoblanaViewCatalogs extends JView{
class LapoblanaViewCatalogs extends JViewLegacy{    
   
        /**
         * HolaMundo view display method
         * @return void
         */
        function display($tpl = null) 
        {                              
                // Get data from the model
                $items = $this->get('State');
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;
 
                // Set the toolbar              
                $this->addToolBar();
                // Display the template
                parent::display($tpl);
                
                // Set the document
                $this->setDocument();
        }
        
        /**
         * Setting the toolbar
         */
        protected function addToolBar($total=null) 
        {
            jimport('joomla.environment.uri');        
            $document = JFactory::getDocument();        
            $document->addStyleDeclaration('.icon-48-catalogs {background-image: url(../media/com_lapoblana/images/catalogos.png);}');                
            $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');                                     
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');     
            $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');  
            JToolBarHelper::title(JText::_('Cat&aacute;logos'),'catalogs');                                          
            JToolBarHelper::cancel('lapoblana.cancel');                    
            //submenu
            JSubMenuHelper::addEntry('Escritorio', 'index.php?option=com_lapoblana', false);
            JSubMenuHelper::addEntry('Pedidos', 'index.php?option=com_lapoblana&view=orders', false);            
            JSubMenuHelper::addEntry('Registro masivo', 'index.php?option=com_lapoblana&view=massive', false);            
            JSubMenuHelper::addEntry('Subir imagenes', 'index.php?option=com_lapoblana&view=upload', false);            
            JSubMenuHelper::addEntry('Catálogos', 'index.php?option=com_lapoblana&view=catalogs', true);            
        }
        
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $document = JFactory::getDocument();
                $document->setTitle(JText::_('Catálogos'));
        }
}

?>
