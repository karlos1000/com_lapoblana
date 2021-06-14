<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

class LapoblanaViewCatproduct extends JViewLegacy
{	
        protected $id; 
        public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');		

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;	                
                                
                $this->id = JRequest::getVar('id'); //obtiene id de la url                                               
               
                $model = $this->getModel();  
                $this->data = $model->getDataProduct($this->id); //obtener datos de la tabla #__cat_productslp
                             
                // Set the toolbar
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
		// Set the document
		$this->setDocument();
	}
	
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);	                
                $isNew = ($this->id == 0);
                $document = JFactory::getDocument();                                
                $document->addStyleDeclaration('.icon-48-catproduct {background-image: url(../media/com_lapoblana/images/cat_productos.png);}');                                                    
		JToolBarHelper::title($isNew ? JText::_('Crear Producto') : JText::_('Editar Producto'), 'catproduct');		
                JToolBarHelper::apply('catproduct.apply');
                JToolBarHelper::save('catproduct.save');
                JToolBarHelper::save2new('catproduct.saveandnew');
                JToolBarHelper::spacer();                                
		JToolBarHelper::cancel('catproduct.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
	
	protected function setDocument() 
	{		
                $isNew = ($this->id == 0);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('Crear Producto') : JText::_('Editar Producto'));		
                $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
                $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');       
		$document->addScript(JURI::root() . "/administrator/components/com_lapoblana/views/catproduct/submitbutton.js");
		JText::script('Error Inaceptable');
	}
}
