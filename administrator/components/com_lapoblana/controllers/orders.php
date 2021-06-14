<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');

class LapoblanaControllerOrders extends JControllerForm {
    
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana');
    }    
    
    function delete(){                      
         // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));                
        $idsOrder = JRequest::getVar('cid', array(), '', 'array');                
        // Sanitize the input
        JArrayHelper::toInteger($idsOrder);                       
                
        //Al borrar un numero de orden tambien se borrara los datos relacionados en tabla productos         
        //print_r($idsOrder);
        
        $model = JModelLegacy::getInstance('Orders', 'LapoblanaModel');                                    //                              
        $result = $model->deleteOrderById($idsOrder); //Borra orden y sus productos relacionados
                       
        if($result){            
            $msn = (count($result)>1) ? 'Items deleted' : 'Item deleted';            
            $text = JText::sprintf($msn);                
            $this->setRedirect('index.php?option=com_lapoblana&view=orders', $msn);                        
        }
        else{            
            $text = JText::sprintf('Item not removed');                
            $this->setRedirect('index.php?option=com_lapoblana&view=orders', $text);                        
        }                        
                       
    }         
    
}

?>
