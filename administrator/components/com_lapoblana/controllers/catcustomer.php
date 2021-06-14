<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class LapoblanaControllerCatcustomer extends JControllerForm
{      
    public function add(){           
       $varid = JRequest::getVar('id');
       $id = ($varid!='') ? $varid : 0; 
        
       $this->setRedirect( 'index.php?option=com_lapoblana&view=catcustomer&layout=edit&id='.$id.' ');                     
    }
            
    public function edit(){             
        $cid = JRequest::getVar('cid', array(0));
        JArrayHelper::toInteger($cid);
        $id = (JRequest::getVar('id')!='') ? JRequest::getVar('id'): $cid[0];        
                
        $this->setRedirect( 'index.php?option=com_lapoblana&view=catcustomer&layout=edit&id='.$id.' ');               
    }   
    
    
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana&view=catcustomers' );
    }    
    
    function apply(){
      $this->dataCustomer();         
    }
    function save()
    {  
     $this->dataCustomer();                
    }
    
    function saveandnew(){        
        $this->dataCustomer();       
    }
    
    public function dataCustomer(){                                                        
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        // Initialise variables.
        $user	= JFactory::getUser();                                                                                                   

        //obtener valores del formulario                                    
        $idUser = (JRequest::getVar('idUser_hidden')!='') ? JRequest::getVar('idUser_hidden') : null;
        $customerName = JRequest::getVar('clientName');
        $active = (JRequest::getVar('active')==1) ? JRequest::getVar('active') : 0;
        $idUrl = JRequest::getVar('check_un');
                
        //echo '$idUser: ' .$idUser .' - $active. ' .$active .' - $idUrl: ' .$idUrl;
        
        $model = JModelLegacy::getInstance('Catcustomer', 'LapoblanaModel'); 
        if($idUrl==0){           
           $id = $model->insertCustomer($idUser,$active,$customerName);           
           
        }else{            
            $model->updateCustomer($idUser,$active,$customerName,$idUrl);           
        }
       
        $idoption = ($idUrl==0) ? $id: $idUrl;  //Esta se aplica para cuando se regresa a la misma pantalla
        
        $jinput = JFactory::getApplication()->input;
        $task = $jinput->get('task');
        $msg = JText::sprintf('Item successfully saved.');
        
        switch ($task) {
            case "apply":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catcustomer&layout=edit&id='.$idoption.' ', $msg); 
                break;
            case "save":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catcustomers',$msg);           
                break;
            case "saveandnew":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catcustomer&layout=edit&id=0',$msg);           
                break;                        
        }                      
        
    }
     
}
