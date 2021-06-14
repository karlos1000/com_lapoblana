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

class LapoblanaViewUpload extends JViewLegacy{
            
        function display($tpl = null) 
        {                              
                // Get data from the model                
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
                
        protected function addToolBar() 
        {                
            $document = JFactory::getDocument();                    
            $document->addStyleDeclaration('.icon-48-uploadicon {background-image: url(../media/com_lapoblana/images/reg_masivo_img.png);}');                    
            JToolBarHelper::title(JText::_('Subir imagen/es'),'uploadicon');             
            JToolBarHelper::cancel('upload.cancel');                                   
            //submenu
            JSubMenuHelper::addEntry('Escritorio', 'index.php?option=com_lapoblana', false);
            JSubMenuHelper::addEntry('Pedidos', 'index.php?option=com_lapoblana&view=orders', false);
            JSubMenuHelper::addEntry('Registro Masivo', 'index.php?option=com_lapoblana&view=massive', false);       
            JSubMenuHelper::addEntry('Subir imagenes', 'index.php?option=com_lapoblana&view=upload', true);            
            JSubMenuHelper::addEntry('Catálogos', 'index.php?option=com_lapoblana&view=catalogs', false);                        
        }
        
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {                               
            jimport('joomla.environment.uri');        
            $document = JFactory::getDocument();
            $document->setTitle(JText::_('Subir imagenes de productos la poblana'));                                
            $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
            $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');    
            $document->addScript(JURI::root().'administrator/components/com_lapoblana/views/upload/submitbutton.js'); 
        }
}

?>
