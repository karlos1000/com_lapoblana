<?php

defined('_JEXEC') or die;

class LapoblanaViewCatcustomers extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;        

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
                        
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');                
                               
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
                              
                $this->addToolBar();                
                $this->setDocument();
                
		parent::display($tpl);                
	}
        
        protected function addToolBar() 
        {                          
            $document = JFactory::getDocument();                                
            $document->addStyleDeclaration('.icon-48-catcustomer {background-image: url(../media/com_lapoblana/images/cat_clientes.png);}');                                                    
            JToolBarHelper::title(JText::_('Catálogo de Clientes'), 'catcustomer');
            JToolBarHelper::deleteList('', 'catcustomers.delete');	
            JToolBarHelper::editList('catcustomer.edit');                        
            JToolBarHelper::addNew('catcustomer.add');               
            JToolBarHelper::spacer();
            JToolBarHelper::cancel('catcustomers.cancel');
            //submenu
            JSubMenuHelper::addEntry('Escritorio', 'index.php?option=com_lapoblana', false);
            JSubMenuHelper::addEntry('Clientes', 'index.php?option=com_lapoblana&view=catcustomers', true);
            JSubMenuHelper::addEntry('Productos', 'index.php?option=com_lapoblana&view=catproducts', false);
            JSubMenuHelper::addEntry('Dibujos', 'index.php?option=com_lapoblana&view=catdrawings', false);
            JSubMenuHelper::addEntry('Estatus', 'index.php?option=com_lapoblana&view=catstatus', false);
            JSubMenuHelper::addEntry('Imágenes', 'index.php?option=com_lapoblana&view=catimages', false);
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
		$document->setTitle(JText::_('Catálogo de clientes la poblana'));                                
                $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
                $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');                                   
        }
}
