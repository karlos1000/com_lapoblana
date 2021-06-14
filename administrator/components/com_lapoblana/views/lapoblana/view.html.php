<?php
/** 
 * fecha: 23-06-14
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Vista Lapoblana
 */
//class LapoblanaViewLapoblana extends JView{
class LapoblanaViewLapoblana extends JViewLegacy{
           
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
                
                $this->user = JFactory::getUser();                
                //obtiene grupo/s por id de usuario 
                $this->groups = JAccess::getGroupsByUser($this->user->id, true);                            
            
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;
                 
                 // Set the toolbar and number of found items
                $this->addToolBar($this->pagination->total);
                
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
                JToolBarHelper::title(JText::_('COM_LAPOBLANA_ADMIN'),'lapoblana');                
                // Options button.
                if (JFactory::getUser()->authorise('core.admin', 'com_lapoblana')) {
                        JToolBarHelper::preferences('com_lapoblana');
                }
                //submenu
            if(JFactory::getUser()->authorise('core.manage', 'com_lapoblana')):                     
                JSubMenuHelper::addEntry('Pedidos', 'index.php?option=com_lapoblana&view=orders', false);
                JSubMenuHelper::addEntry('Registro Masivo', 'index.php?option=com_lapoblana&view=massive', false);
                JSubMenuHelper::addEntry('Subir imagenes', 'index.php?option=com_lapoblana&view=upload', false);
                JSubMenuHelper::addEntry('Catálogos', 'index.php?option=com_lapoblana&view=catalogs', false);                   
            endif;
        }
        
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $document = JFactory::getDocument();                
                $document->setTitle(JText::_('Sistema de consulta de estado de pedidos de clientes la poblana'));
        }
}

?>
