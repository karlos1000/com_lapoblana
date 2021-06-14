<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
 
class LapoblanaModelCatstatus extends JModelList{
       
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
                        FROM #__cat_statuslp as a                        
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
         
        
        public function updateActiveByIdStatus($idsStatus,$checkvalactive){
           $db = JFactory::getDbo();
           $ids = implode(',', $idsStatus);
           $query = "UPDATE #__cat_statuslp 
                     SET active = $checkvalactive
                     WHERE statusId IN ($ids) ";
           $db->setQuery($query);
           $db->query();              
       }
        
        public function deleteStatusById($idsStatus){
             $db = JFactory::getDbo();            
             foreach($idsStatus as $idS):
                                  
                 $querySearch = " SELECT * FROM #__productslp WHERE status IN ($idS) ";                            
                 $db->setQuery($querySearch);
                 $db->query();                                     
                 $rows = $db->loadResult();
                 
                 $nameStatus=$this->getStatusName($idS);
                 if($rows!=null){
                     $resultNoDel[] = $nameStatus;
                 }else{
                     $query = " DELETE FROM #__cat_statuslp  
                            WHERE statusId IN ($idS) ";
                     $db->setQuery($query);
                     $db->query();  
                     //$result[] = $db->query();                                         
                     
                     $result[] = $nameStatus;
                 }
                                                                    
             endforeach;
             return  array('notDelete'=>$resultNoDel,'deleted'=>$result); 
        }
                               
        //obtener nombre del estatus
        public function getStatusName($idStatus){
            $db = JFactory::getDbo(); 
            $querySearch = " SELECT statusName FROM #__cat_statuslp WHERE statusId=$idStatus ";                            
            $db->setQuery($querySearch);
            $db->query();                                     
            $statusName = $db->loadResult();
            
            return $statusName;
        }
       
}

?>
