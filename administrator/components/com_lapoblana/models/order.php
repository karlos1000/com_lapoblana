<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// import Joomla modelform library
jimport('joomla.application.component.model');

class LapoblanaModelOrder extends JModelLegacy{
    /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
    
        public function insertOrder($orderNum, $idCustomer=null, $dateO, $dateR, $weeks, $dateD){           
           $idCustomer = ($idCustomer!=null) ? $idCustomer : ''; 
            
           $db =& JFactory::getDBO();                                        
           $query = "INSERT INTO #__orderslp (orderNum, idCustomer, dateOrder, dateReceipt, weeks, dateEstimated) 
                     VALUES ($orderNum, '$idCustomer', '$dateO', '$dateR', $weeks, '$dateD')";              
           $db->setQuery($query);                     
           $db->query();
           $id = $db->insertid();                
           
           return $id;                                             
       }
                              
       public function updateOrder($orderNum, $idCustomer, $dateO, $dateR, $weeks, $dateD, $idUrl){                                                                        
           $db =& JFactory::getDBO();                                        
            $query = "UPDATE #__orderslp SET orderNum=$orderNum, idCustomer='$idCustomer', dateOrder='$dateO', dateReceipt='$dateR', weeks=$weeks, dateEstimated='$dateD'
                     WHERE idOrder = $idUrl ";              
           $db->setQuery($query);                     
           $db->query();           
       }
       
        public function getDataOrder($idOrder){                      
           
           if($idOrder>0){ 
            //ir a la tabla #__orderslp para traer todos sus datos dependiendo de su id                           
            $db = JFactory::getDbo();
            $query = "
                        SELECT a.*, b.name as name_user
                        FROM #__orderslp as a
                        LEFT JOIN #__users as b ON b.id=a.idCustomer
                        WHERE a.idOrder=$idOrder
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
                                                    
       public function checkExistOrderNum($noOrder){
           $db = JFactory::getDbo();   
           $tbl_orderslp = $db->getPrefix().'orderslp';
           
           $query = "   
                     SELECT orderNum FROM $tbl_orderslp                        
                     WHERE orderNum = $noOrder                     
                    ";
           $db->setQuery($query);
           $db->query();    
           $rows = $db->loadResult();
            
           $exist = ($rows!=null) ? '1': '0';
           return $exist;              
       }
              
}

?>
