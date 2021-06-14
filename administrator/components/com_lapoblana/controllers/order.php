<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');

class LapoblanaControllerOrder extends JControllerForm {
                     
    function cancel()
    {         
        $this->setRedirect( 'index.php?option=com_lapoblana&view=orders');        
    }
    
    public function add(){           
       $varid = JRequest::getVar('id');
       $id = ($varid!='') ? $varid : 0; 
        
       $this->setRedirect( 'index.php?option=com_lapoblana&view=order&layout=edit&id='.$id.' ');                     
    }
    
    public function edit(){        
        $user	= JFactory::getUser();
        $cid = JRequest::getVar('cid', array(0));
        JArrayHelper::toInteger($cid);
        $id = (JRequest::getVar('id')!='') ? JRequest::getVar('id'): $cid[0];        
        
        $this->setRedirect( 'index.php?option=com_lapoblana&view=order&layout=edit&id='.$id.' ');               
    }        
    
    function apply(){
      $this->processOrders();         
    }
    function save()
    {  
     $this->processOrders();                
    }
    
    function saveandnew(){        
        $this->processOrders();       
    }
    
    public function processOrders(){                                                        
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        //leer el modelo correspondiente
        $model = JModelLegacy::getInstance('Order', 'LapoblanaModel');   
        $modelGM = JModelLegacy::getInstance('globalmethods', 'LapoblanaModel');   
        // Initialise variables.
        $user = JFactory::getUser();
        
        //JRequest::get( 'post' ); //lee todas las variables por post
        //obtener valores del formulario       
        $idCustomer = JRequest::getVar('idUser_hidden');
        $noOrder = JRequest::getVar('no_order');        
        $dateO =  $modelGM->convertDateToMysql(JRequest::getVar('dateO')); 
        $dateR =  $modelGM->convertDateToMysql(JRequest::getVar('dateR')); 
        $weeks = JRequest::getVar('weeks');                                                
        $dateD = $modelGM->convertDateToMysql(JRequest::getVar('dateD'));
        $idUrl = JRequest::getVar('check_un');                                                        
        
        //si $idUrl=0 se crea un nuevo nuevo registro de lo contrario se edita
        if($idUrl==0){                       
           //comprobar que la orden no exista mas de una vez
           $existNoOrder=$model->checkExistOrderNum($noOrder); //comprueba si el numero de orden existe                                 
            if($existNoOrder==0){
               $id = $model->insertOrder($noOrder, $idCustomer, $dateO, $dateR, $weeks, $dateD);                                  
               $msg = JText::sprintf('Item successfully saved. ');                
               $idoption = $id;
            }
            if($existNoOrder==1){
               $msg = JText::sprintf('No fue posible salvar/actualizar porque el n&uacute;mero de orden ya existe en base de datos. ');                                
               $idoption = $idUrl;
            }           
           //echo 'El id creado es: ' .$id;           
        }else{                                    
             $model->updateOrder($noOrder, $idCustomer, $dateO, $dateR, $weeks, $dateD, $idUrl);
             $msg = JText::sprintf('Item successfully saved. '); 
             $idoption = $idUrl;
        }        
        
        //($idUrl!=0) ? $id: $idUrl;        
        $jinput = JFactory::getApplication()->input;
        $task = $jinput->get('task');
                
        switch ($task) {
            case "apply":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=order&layout=edit&id='.$idoption.' ', $msg); 
                break;
            case "save":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=orders',$msg);                          
                break;
            case "saveandnew":                
                $this->setRedirect( 'index.php?option=com_lapoblana&view=order&layout=edit&id=0',$msg);           
                break;                        
        }                      
                
    }
    
    function checkOrderNumInDetails(){
        $orderNum = $_POST['orderNum'];
        
        //leer el modelo correspondiente        
        $modelGM = JModelLegacy::getInstance('globalmethods', 'LapoblanaModel');           
        $exist = $modelGM->checkOrderNumInDetails($orderNum); 
        
         $html .= '<response>';      
            $html .= $exist;
         $html .= '</response>';          
         echo $html;            
    }
    
    function deleteOrderByOrderID($idO){
        $idO = $_POST['orderId'];
        
        //leer el modelo correspondiente        
        $modelGM = JModelLegacy::getInstance('globalmethods', 'LapoblanaModel');           
        $del = $modelGM->deleteOrderByOrderIdDB($idO); 
        
        $html .= '<response>';      
            $html .= $del;
         $html .= '</response>';          
        echo $html;  
    }
}

?>
