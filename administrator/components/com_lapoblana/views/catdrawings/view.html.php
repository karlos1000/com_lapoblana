<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

class LapoblanaViewCatdrawings extends JViewLegacy
{	
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

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
                $document = JFactory::getDocument();            
                $document->addStyleDeclaration('.icon-48-catdrawing {background-image: url(../media/com_lapoblana/images/cat_dibujos.png);}');                            
		JToolBarHelper::title(JText::_('Catálogo Dibujos'), 'catdrawing');
                JToolBarHelper::deleteList('', 'catdrawings.delete');	
		JToolBarHelper::editList('catdrawing.edit');
		JToolBarHelper::addNew('catdrawing.add');
                JToolBarHelper::spacer();
                JToolBarHelper::cancel('catdrawings.cancel');
                //submenu                
                JSubMenuHelper::addEntry('Escritorio', 'index.php?option=com_lapoblana', false);
                JSubMenuHelper::addEntry('Clientes', 'index.php?option=com_lapoblana&view=catcustomers', false);
                JSubMenuHelper::addEntry('Productos', 'index.php?option=com_lapoblana&view=catproducts', false);
                JSubMenuHelper::addEntry('Dibujos', 'index.php?option=com_lapoblana&view=catdrawings', true);
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
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Catálogo de dibujos la poblana'));
	}
}
