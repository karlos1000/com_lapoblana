<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
 
class LapoblanaModelCatproducts extends JModelList{
       
        public function getItems()
	{
            
            if (!isset($this->items))
            {
                $limitstart = $this->getState('list.start');                
		$limit = $this->getState('list.limit');    
                                                      
                $this->userC = JFactory::getUser();
                $this->groups = JAccess::getGroupsByUser($this->userC->id, false);                                            
                $this->strgroupsCurrent = implode(",", $this->groups); 
            
                $db = JFactory::getDbo();                                                
                $query = "
                        SELECT a.*
                        FROM #__cat_productslp as a                        
                      ";                                                           
                $db->setQuery($query);
                $db->query();    
                $rows = $db->loadObjectList();                      
                
                $this->total = count($rows);
                if ($limitstart >= $this->total) {
                        $limitstart = $limitstart < $limit ? 0 : $limitstart - $limit;
                        $this->setState('list.start', $limitstart);
                }
                
                $this->items = array_slice($rows, $limitstart, $limit ? $limit : null);
                
            }
            return $this->items;                                  								                
	}

	/**
	 * Method to get the total number of items.
	 *
	 * @return	int	The total number of items.
	 * @since	1.6
	 */
	public function getTotal()
	{
		if (!isset($this->total))
		{
			$this->getItems();
		}
		return $this->total;             
	}        
         
        
        public function updateActiveByIdProduct($idProducts,$checkvalactive){
           $db = JFactory::getDbo();
           $ids = implode(',', $idProducts);
           $query = "UPDATE #__cat_productslp 
                     SET active = $checkvalactive
                     WHERE productId IN ($ids) ";
           $db->setQuery($query);
           $db->query();              
       }
        
//        public function deleteProductById($idsProducts){
//             $db = JFactory::getDbo();            
//             foreach($idsProducts as $idP):    
//                 $query = " DELETE FROM #__cat_productslp  
//                            WHERE productId IN ($idP) ";
//                 $db->setQuery($query);
//                 $result[] = $db->query();                    
//             endforeach;
//             return $result;
//        } 
       
       public function deleteProductById($idsProducts){
             $db = JFactory::getDbo();            
             foreach($idsProducts as $id):
                                  
                 $querySearch = " SELECT * FROM #__productslp WHERE prodName IN ($id) ";                            
                 $db->setQuery($querySearch);
                 $db->query();                                     
                 $rows = $db->loadResult();
                 
                 $nameProduct=$this->getProductName($id);
                 if($rows!=null){
                     $resultNoDel[] = $nameProduct;
                 }else{
                     $query = " DELETE FROM #__cat_productslp  
                            WHERE productId IN ($id) ";
                     $db->setQuery($query);
                     $db->query();                      
                     
                     $result[] = $nameProduct;
                 }
                                                                    
             endforeach;
             return  array('notDelete'=>$resultNoDel,'deleted'=>$result); 
        }
                               
        //obtener nombre del producto
        public function getProductName($id){
            $db = JFactory::getDbo(); 
            $querySearch = " SELECT productName	FROM #__cat_productslp WHERE productId=$id ";                            
            $db->setQuery($querySearch);
            $db->query();                                     
            $drawName = $db->loadResult();
            
            return $drawName;
        }
       
}

?>
