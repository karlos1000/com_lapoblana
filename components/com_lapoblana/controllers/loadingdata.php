<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
class LapoblanaControllerLoadingdata  extends JControllerLegacy {
        
                             
    function dateConversion($date){
        list($y, $m, $d) = explode('-',$date);              
        $date = date ("d/m/Y", strtotime($y.'/'.$m.'/'.$d));    
        return $date;
    }
          
        
}

?>

