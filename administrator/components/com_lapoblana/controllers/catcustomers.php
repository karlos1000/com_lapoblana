<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');
//require_once(JPATH_COMPONENT.DS.'controllers.record.php' );

class LapoblanaControllerCatcustomers extends JControllerForm {
    
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana&view=catalogs');
    }    
    
    function delete(){                
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));                
        $idsClients = JRequest::getVar('cid', array(), '', 'array');                
        // Sanitize the input
        JArrayHelper::toInteger($idsClients);
                                                                       
        $model = JModelLegacy::getInstance('Catcustomers', 'LapoblanaModel');                            
        $result = $model->deleteCustomerById($idsClients);
                
        if(count($result['notDelete'])>0){
            $text = JText::sprintf('Elementos no borrados porque se encuentran ocupados en la vista ordenes.');                
            $tableNotDel = $this->printTable($result['notDelete'],$text);
        }else{
            $tableNotDel = '';
        }
        
        if(count($result['deleted'])>0){          
            $text = JText::sprintf('Elementos borrados correctamente.');                
            $tableDel = $this->printTable($result['deleted'],$text);
        }else{
            $tableDel = '';
        }
        
        $msn = $tableNotDel.$tableDel;
   
        $this->setRedirect('index.php?option=com_lapoblana&view=catcustomers', $msn);
        
        //$result = $model->deleteCondoById($idsClients);
        
//        if($result){
//            $msn = (count($result)>1) ? 'Items deleted' : 'Item deleted';            
//            $text = JText::sprintf($msn);                
//            $this->setRedirect('index.php?option=com_lapoblana&view=catcustomers', $text);            
//        } 
//        else{            
//            $text = JText::sprintf('Item not removed');                
//            $this->setRedirect('index.php?option=com_lapoblana&view=catcustomers', $text);                        
//        }
        
    }
    
    function unpublish(){
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        // Initialise variables.        
        $ids	= JRequest::getVar('cid', array(), '', 'array');
        $values	= array('publish' => 1, 'unpublish' => 0);
        $task	= $this->getTask();
        $value	= JArrayHelper::getValue($values, $task, 0, 'int');
        
        $model = JModel::getInstance('Catcustomers', 'LapoblanaModel');
        $model->updateActiveByIdCustomer($ids, $value);  
        
        $msn= 'item successfully unpublished';
        $this->setRedirect('index.php?option=com_lapoblana&view=catcustomers',$msn);
    }
    
    function publish(){
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        // Initialise variables.        
        $ids	= JRequest::getVar('cid', array(), '', 'array');
        $values	= array('publish' => 1, 'unpublish' => 0);
        $task	= $this->getTask();
        $value	= JArrayHelper::getValue($values, $task, 0, 'int');
        
        $model = JModelLegacy::getInstance('Catcustomers', 'LapoblanaModel');
        $model->updateActiveByIdCustomer($ids, $value);  
        
        $msn= 'item successfully published';
        $this->setRedirect('index.php?option=com_lapoblana&view=catcustomers',$msn);                
    }
    
    function printTable($array,$text){       
        $html = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
        $html .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                    <tr>
                        <td colspan="1"><div style="font-weight:bold;padding:5px;margin-bottom:5px;">'.$text.'</div></td>
                    </tr>
                    <tr><td>NOMBRE CLIENTE</td></tr>
                    ';
         foreach($array as $item){                                
             $html .= '<tr><td>'.$item.'</td></tr>';
         }                                             
         $html .= '</table></div><br/>';   
         
         return $html;
    }
    
}

?>
