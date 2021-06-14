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

class LapoblanaViewOrder extends JViewLegacy{
   
        /**
         * La poblana view display method
         * @return void
         */
        protected $form;        
                
        function display($tpl = null) 
        {
                $form = $this->get('Form');
                $items = $this->get('State');                
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');                                
                
                $this->user = JFactory::getUser();
                $this->groups = JAccess::getGroupsByUser($this->user->id, false);                                            
                $this->strgroupsCurrent = implode(",", $this->groups); //-LN                
                $this->id = JRequest::getVar('id'); //obtiene id de la url                               
                
                //mandar a llamar metodo en ModelOrder
                $model = $this->getModel();                  
                $this->data = $model->getDataOrder($this->id);                                
               
                //Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }                
                // Assign data to the view            
                $this->form = $form;                
                $this->items = $items;
                $this->pagination = $pagination;
                                                 
                // Set the toolbar
                //$this->addToolBar($this->pagination->total);
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
            $document->addStyleDeclaration('.icon-48-orders {background-image: url(../media/com_lapoblana/images/pedidos.png);}');                
            JToolBarHelper::title(JText::_('Registro de pedidos'),'orders');                               
            //apply,save,save2new
            JToolBarHelper::apply('order.apply');
            if($this->id>0){
                JToolBarHelper::save('order.save');
                JToolBarHelper::save2new('order.saveandnew');
            }
            JToolBarHelper::spacer();            
            JToolBarHelper::cancel('order.cancel');           
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
                $document->setTitle(JText::_('Registro de pedidos la poblana'));
                $document->addStyleSheet(JURI::root().'media/com_lapoblana/css/style.css');                            
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.js');     
                $document->addScript(JURI::root().'media/com_lapoblana/js/jquery.validate.js');                 
                $document->addScript(JURI::root().'media/com_lapoblana/js/function.js');     
                
                $document->addScript(JURI::root().'administrator/components/com_lapoblana/views/order/submitbutton.js');                                                
        }
}

?>
