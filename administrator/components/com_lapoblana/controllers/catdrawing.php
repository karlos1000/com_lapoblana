<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');

class LapoblanaControllerCatdrawing extends JControllerForm {
                   
   //Metodos que reciben los datos de campos de los formularios      
    function cancel()
    {    
     $this->setRedirect( 'index.php?option=com_lapoblana&view=catdrawings');
    }
         
    public function add(){    
       //obtener variable id de catproduct.edit&id=1
       $varid = JRequest::getVar('id');
       $id = ($varid!='') ? $varid : 0; 
        
       $this->setRedirect( 'index.php?option=com_lapoblana&view=catdrawing&layout=edit&id='.$id.' ');                     
    }
    
    public function edit(){        
        $user	= JFactory::getUser();
        $cid = JRequest::getVar('cid', array(0));
        JArrayHelper::toInteger($cid);
        $id = (JRequest::getVar('id')!='') ? JRequest::getVar('id'): $cid[0];         
        $this->setRedirect( 'index.php?option=com_lapoblana&view=catdrawing&layout=edit&id='.$id.' ');               
    }        
    
    function apply(){
      $this->dataDrawings();         
    }
    function save()
    {  
     $this->dataDrawings();              
    }
    
    function saveandnew(){        
        $this->dataDrawings();       
    }
    
    public function dataDrawings(){                                                        
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));        
        $model = JModelLegacy::getInstance('Catdrawing', 'LapoblanaModel');                   
        
        //obtener valores del formulario                                                                
        $drawingName = JRequest::getVar('drawingName');                
        $active = (JRequest::getVar('active')==1) ? JRequest::getVar('active') : 0;
        $idUrl = JRequest::getVar('check_un');
        $dateCreation = date("Y-m-d");        
        
        if($idUrl==0){            
            $id = $model->insertDrawing($drawingName, $active, $dateCreation);                               
        }else{            
             $model->updateDrawing($drawingName, $active, $idUrl); 
        }        
        $idoption = ($idUrl==0) ? $id: $idUrl;
        
        $jinput = JFactory::getApplication()->input;
        $task = $jinput->get('task');
        $msg = JText::sprintf('Item successfully saved.');
        
        switch ($task) {
            case "apply":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catdrawing&layout=edit&id='.$idoption.' ', $msg); 
                break;
            case "save":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catdrawings',$msg);           
                break;
            case "saveandnew":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=catdrawing&layout=edit&id=0',$msg);           
                break;                        
        }                      
        
    }
    
}

?>
