<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla modelform library
//jimport('joomla.application.component.modeladmin');
jimport('joomla.application.component.model');

class LapoblanaModelCatcustomer extends JModelLegacy
{
     
       public function getDataCustomer($idCustomer){                      
           
           if($idCustomer>0){ 
            //ir a la tabla #__cat_customerslp  para traer todos sus datos dependiendo de su id                           
            $db = JFactory::getDbo();                                                    
            $query = "
                    SELECT a.*, b.name, b.username
                    FROM #__cat_customerslp as a
                    LEFT JOIN #__users as b ON b.id=a.userIdJoomla
                    WHERE a.customerId=$idCustomer
                    ";
            $db->setQuery($query);
            $db->query();
            $rows = $db->loadObjectList();                                                                                
           }
           else{
                $rows = array();  
           }
           
           return $rows;
       }
                    
       
      public function insertCustomer($idUser,$active,$customerName){
           $date = date("Y-m-d");
           //$idUser = ($idUser!=null) ? $idUser : 'NULL';
           $db = JFactory::getDbo();                                        
           $query = "INSERT INTO #__cat_customerslp (userIdJoomla, active, dateCreation, customerName) 
                     VALUES ('$idUser', '$active', '$date', '$customerName')";              
           $db->setQuery($query);
           $db->query();
           $id = $db->insertid();                
            
           return $id;
      }
      
      public function updateCustomer($idUser,$active,$customerName,$idUrl){
           $db = JFactory::getDbo();                                        
           $query = "UPDATE #__cat_customerslp SET userIdJoomla='$idUser', active='$active', customerName='$customerName' 
                      WHERE customerId = $idUrl ";                          
           $db->setQuery($query);
           $db->query();                
      }
      
}
