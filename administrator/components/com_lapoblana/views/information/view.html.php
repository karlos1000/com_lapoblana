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
//class LapoblanaViewInformation extends JView{
class LapoblanaViewInformation extends JViewLegacy{
           
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
                
        protected function addToolBar($total=null) 
        {                                            
            jimport('joomla.environment.uri');        
            $document = JFactory::getDocument();                    
            $document->addStyleDeclaration('.icon-48-information {background-image: url(../media/com_lapoblana/images/informacion.png);}');        
            JToolBarHelper::title(JText::_('Informaci&oacute;n de Componente'),'information');             
            JToolBarHelper::cancel('lapoblana.cancel');                                   
            //submenu            
            JSubMenuHelper::addEntry('Escritorio', 'index.php?option=com_lapoblana', false);
            JSubMenuHelper::addEntry('Pedidos', 'index.php?option=com_lapoblana&view=orders', false);
            JSubMenuHelper::addEntry('Registro Masivo', 'index.php?option=com_lapoblana&view=massive', false);            
            JSubMenuHelper::addEntry('Catálogos', 'index.php?option=com_lapoblana&view=catalogs', false);                         
            JSubMenuHelper::addEntry('Información', 'index.php?option=com_lapoblana&view=information', true);
        }
        
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {                               
            $document = JFactory::getDocument();
            $document->setTitle(JText::_('Información de Componente La poblana'));                                
            $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                                                               
        }
}

?>
