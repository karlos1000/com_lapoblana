<?php
/** 
 * fecha: 19-11-13
 * company: company
 * @author Karlos
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// import Joomla modelform library
//jimport('joomla.application.component.modeladmin');
//jimport('joomla.application.component.modelForm');
jimport('joomla.application.component.modellist');
 
class LapoblanaModelCatcustomers extends JModelList{
       
        public function __construct($config = array())
        {   
                $config['filter_fields'] = array(
                        'customerId',
                        'customerName',
                        'userIdJoomla',                        
                        'active',
                        'dateCreation'                        
                );
                parent::__construct($config);                               
        }
        
        protected function populateState($ordering = null, $direction = null) {
            // Initialise variables.
            $app = JFactory::getApplication('administrator');
                
            // Adjust the context to support modal layouts.
            if ($layout = JRequest::getVar('layout', 'default'))
            {
                    $this->context .= '.'.$layout;
            }
               
            $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
            $this->setState('filter.search', $search);
                                                                                                                                                                                                              
            //Load the parameters.
            $params = JComponentHelper::getParams('com_lapoblana');
            $this->setState('params', $params);

            // List state information.
            parent::populateState('customerId', 'asc');
        }
    
        public function getItems()
	{
            if (!isset($this->items))
            {
                $search	= $this->getState('filter.search');		
                $ordering = $this->getState('list.ordering');
                $direction = $this->getState('list.direction');
                $limitstart = $this->getState('list.start');                
		$limit = $this->getState('list.limit');    
                
                $this->userC = JFactory::getUser();
                $this->groups = JAccess::getGroupsByUser($this->userC->id, false);                                            
                $this->strgroupsCurrent = implode(",", $this->groups);                                                 
                
                $db = JFactory::getDbo();                                
                
                if($search){                    
                     // Compile the different search clauses.
                    $searches	= array();                                        
                    $searches[] = "b.userIdJoomla LIKE '%$search%' "; 
                    
                    $searchQuery = ' AND ' .implode(' OR ', $searches);
                }else{
                    $searchQuery = '';
                }
                
                $query = "
                        SELECT a.*, b.name, b.username
                        FROM #__cat_customerslp as a
                        LEFT JOIN #__users as b ON b.id=a.userIdJoomla
                        ";                                                  
                $db->setQuery($query);
                $db->query();    
                $rows = $db->loadObjectList();                      
                
                if ($ordering) {
                        if ($direction == 'asc') {
                                ksort($rows);                                    
                        }
                        else {
                                krsort($rows);
                        }
                }
                else {
                    if ($direction == 'asc') {
                            asort($rows);
                    }
                    else {
                            arsort($rows);
                    }
                }
                
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
        
        
        public function updateActiveByIdCustomer($idSD,$checkvalactive){
           $db = JFactory::getDbo();
           $ids = implode(',', $idSD);
           $query = "UPDATE #__cat_customerslp 
                     SET active = $checkvalactive
                     WHERE customerId IN ($ids) ";
           $db->setQuery($query);
           $db->query();              
       }
       
       //borrar cliente si no esta siendo ocupado por el sistema
       public function deleteCustomerById($idsCustomers){
             $db = JFactory::getDbo();            
             foreach($idsCustomers as $id):
                                  
                 $querySearch = " 
                         SELECT a.idCustomer 
                         FROM #__orderslp as a
                         LEFT JOIN #__cat_customerslp as b ON b.userIdJoomla = a.idCustomer
                         WHERE b.customerId = $id
                     ";                            
                 $db->setQuery($querySearch);
                 $db->query();                                     
                 $rows = $db->loadResult();
                 
                 $nameCustomer=$this->getCustomerName($id);
                 if($rows!=null){
                     $resultNoDel[] = $nameCustomer;
                 }else{
                     $query = " DELETE FROM #__cat_customerslp  
                            WHERE customerId = $id ";
                     $db->setQuery($query);
                     $db->query();                      
                     
                     $result[] = $nameCustomer;
                 }
                                                                    
             endforeach;
             return  array('notDelete'=>$resultNoDel,'deleted'=>$result); 
        }
                               
        //obtener nombre del cliente
        public function getCustomerName($id){
            $db = JFactory::getDbo(); 
            $querySearch = " SELECT customerName FROM #__cat_customerslp WHERE customerId=$id ";                            
            $db->setQuery($querySearch);
            $db->query();                                     
            $customerName = $db->loadResult();
            
            return $customerName;
        }
}

?>
