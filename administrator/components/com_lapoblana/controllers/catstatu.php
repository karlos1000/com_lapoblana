<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');

class LapoblanaControllerCatstatu extends JControllerForm {
                   
   //Metodos que reciben los datos de campos de los formularios      
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana&view=catstatus');
    }
         
    public function add(){    
       //obtener variable id de catproduct.edit&id=1
       $varid = JRequest::getVar('id');
       $id = ($varid!='') ? $varid : 0; 
        
       $this->setRedirect( 'index.php?option=com_lapoblana&view=catstatu&layout=edit&id='.$id.' ');                     
    }
    
    public function edit(){        
        $user	= JFactory::getUser();
        $cid = JRequest::getVar('cid', array(0));
        JArrayHelper::toInteger($cid);
        $id = (JRequest::getVar('id')!='') ? JRequest::getVar('id'): $cid[0];         
        $this->setRedirect( 'index.php?option=com_lapoblana&view=catstatu&layout=edit&id='.$id.' ');               
    }        
    
    function apply(){
      $this->dataStatus();         
    }
    function save()
    {  
     $this->dataStatus();              
    }
    
    function saveandnew(){        
        $this->dataStatus();       
    }
    
    public function dataStatus(){                                                        
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));        
        $model = JModelLegacy::getInstance('Catstatu', 'LapoblanaModel');                   
        
        //obtener valores del formulario                                                                
        $statusName = JRequest::getVar('statusName');                
        $active = (JRequest::getVar('active')==1) ? JRequest::getVar('active') : 0;
        $idUrl = JRequest::getVar('check_un');
        $dateCreation = date("Y-m-d");        
        
        if($idUrl==0){            
            $id = $model->insertStatus($statusName, $active, $dateCreation);                               
        }else{            
             $model->updateStatus($statusName, $active, $idUrl); 
        }        
        $idoption = ($idUrl==0) ? $id: $idUrl;
        
        $jinput = JFactory::getApplication()->input;
        $task = $jinput->get('task');
        $msg = JText::sprintf('Item successfully saved.');
        
        switch ($task) {
            case "apply":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catstatu&layout=edit&id='.$idoption.' ', $msg); 
                break;
            case "save":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catstatus',$msg);           
                break;
            case "saveandnew":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catstatu&layout=edit&id=0',$msg);           
                break;                        
        }                      
        
    }
    
}

?>
