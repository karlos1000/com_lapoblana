<?php

defined('_JEXEC') or die;

class LapoblanaViewOrders extends JViewLegacy
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
            $document->addStyleDeclaration('.icon-48-orders {background-image: url(../media/com_lapoblana/images/pedidos.png);}');                
            JToolBarHelper::title(JText::_('Pedidos'), 'orders');            
            JToolBarHelper::deleteList('', 'orders.delete');//JToolBarHelper::deleteListX('', 'orders.delete');
            JToolBarHelper::editList('order.edit');//JToolBarHelper::editListX('order.edit');                       
            JToolBarHelper::addNew('order.add');//JToolBarHelper::addNewX('order.add');
            JToolBarHelper::spacer();
            JToolBarHelper::cancel('orders.cancel');
            //submenu
            JSubMenuHelper::addEntry('Escritorio', 'index.php?option=com_lapoblana', false);
            JSubMenuHelper::addEntry('Pedidos', 'index.php?option=com_lapoblana&view=orders', true);
            JSubMenuHelper::addEntry('Registro Masivo', 'index.php?option=com_lapoblana&view=massive', false);            
            JSubMenuHelper::addEntry('Subir imagenes', 'index.php?option=com_lapoblana&view=upload', false);            
            JSubMenuHelper::addEntry('Catálogos', 'index.php?option=com_lapoblana&view=catalogs', false);            
        }
                
        protected function setDocument() 
        {
            jimport('joomla.environment.uri');        
            $document = JFactory::getDocument();                                
            $document->setTitle(JText::_('Pedidos'));                                
            $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
            $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
            $document->addScript(JURI::root().'media/com_lapoblana/js/function.js'); 
            $document->addScript(JURI::root().'administrator/components/com_lapoblana/views/orders/submitbutton.js'); 
        }
}
