<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

class LapoblanaViewCatdrawing extends JViewLegacy
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
                $this->data = $model->getDataDrawing($this->id); //obtener datos de la tabla #__cat_catdrawingslp
                             
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
                $document->addStyleDeclaration('.icon-48-catdrawing {background-image: url(../media/com_lapoblana/images/cat_dibujos.png);}');                                                    
		JToolBarHelper::title($isNew ? JText::_('Crear Dibujo') : JText::_('Editar dibujo'), 'catdrawing');		
                JToolBarHelper::apply('catdrawing.apply');
                JToolBarHelper::save('catdrawing.save');
                JToolBarHelper::save2new('catdrawing.saveandnew');
                JToolBarHelper::spacer();                                
		JToolBarHelper::cancel('catdrawing.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
	
	protected function setDocument() 
	{		
                $isNew = ($this->id == 0);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('Crear Dibujo') : JText::_('Editar Dibujo'));		
                $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
                $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');       
		$document->addScript(JURI::root() . "/administrator/components/com_lapoblana/views/catdrawing/submitbutton.js");
		JText::script('Error Inaceptable');
	}
}
