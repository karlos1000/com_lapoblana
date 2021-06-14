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

//metodos globales para el componente lapoblana
class LapoblanaModelGlobalmethods extends JModelLegacy{
           
       public function convertDateToMysql($date){                                                            
           list($d,$m,$y) = explode('/', $date);
           $date = $y.'-'.$m.'-'.$d;
                
           return $date;
       }
       
       //obtener todos los productos relacionados a la orden
       public function GetAllProductsToGridByOrder($ds,$orderNum=null)
       {	                                 
           $db = JFactory::getDbo();   
           $tbl_productslp = $db->getPrefix().'productslp';
           $tbl_cat_statuslp = $db->getPrefix().'cat_statuslp';
           
           $query = "   
                        SELECT a.prodId, a.orderNum, a.prodName, a.prodDrawing, a.prodImg, a.amount, a.whoRequested, b.statusName as status, a.cloth, a.weaveCloth, a.dateStock, a.progress
                        FROM $tbl_productslp as a   
                        LEFT JOIN $tbl_cat_statuslp as b on b.statusId=a.status     
                        WHERE a.orderNum = $orderNum
                        ORDER BY a.prodId DESC                                                  
                    ";                                     
           
           $queryIns = "
                        INSERT INTO $tbl_productslp 
                               (orderNum, prodName, prodDrawing, prodImg, amount, whoRequested, status, cloth, weaveCloth, dateStock, progress) 
                        VALUES ( $orderNum, '@prodName', '@prodDrawing', '@prodImg', @amount, '@whoRequested', '@status', '@cloth', '@weaveCloth', '@dateStock', '@progress')
                       ";                                              
           
           $queryUp = "UPDATE $tbl_productslp SET orderNum=@orderNum, prodName='@prodName', prodDrawing='@prodDrawing', prodImg='@prodImg',
                        amount=@amount, whoRequested='@whoRequested', status='@status', cloth='@cloth', weaveCloth='@weaveCloth', dateStock='@dateStock', progress='@progress'
                      WHERE prodId = @prodId ";     
           
            $queryDel = "DELETE FROM $tbl_productslp WHERE prodId = @prodId ";
             
            //echo $queryIns;            
            
            $ds->SelectCommand = $query;                                    
            
            if($orderNum!=0){
                $ds->InsertCommand = $queryIns;
                $ds->UpdateCommand = $queryUp;
                $ds->DeleteCommand = $queryDel;
            }
           return $ds;                            
       }
       
       public function insertDetailsOrder($orderNum,$idProduct,$idDrawing,$amount,$whoRequested,$status,$cloth,$weaveCloth,$dateStock,$prodImg,$progress){
           //comprobar que el status dado en xls exista en db
           //si no existe crear en su tabla correspondiente
           
           
           $db = JFactory::getDbo();   
           $tbl_productslp = $db->getPrefix().'productslp';
           
           $queryIns = "
                        INSERT INTO $tbl_productslp 
                               (orderNum, prodName, prodDrawing, prodImg, amount, whoRequested, status, cloth, weaveCloth, dateStock, progress) 
                        VALUES ( $orderNum, $idProduct, $idDrawing, '$prodImg', $amount, '$whoRequested', $status, '$cloth', '$weaveCloth', '$dateStock', '$progress')
                       ";  
           
           $db->setQuery($queryIns);                     
           $db->query();
           $id = $db->insertid();                
           
           return $id;  
       }
       
       public function chekExistOrder($orderNum){
           $db = JFactory::getDbo();   
           $tbl_productslp = $db->getPrefix().'productslp';
           
           $query = "   
                     SELECT orderNum FROM $tbl_productslp                        
                     WHERE orderNum = $orderNum                     
                    ";
           $db->setQuery($query);
           $db->query();    
           $rows = $db->loadResult();
            
           $exist = ($rows!=null) ? '1': '0';
           return $exist;                               
       }
       
       public function delDetailsOrderAndOrder($orderNum){
           $db = JFactory::getDbo();                         
           $tbl_productslp = $db->getPrefix().'productslp';
           $tbl_orderslp = $db->getPrefix().'orderslp';
           
           $queryOrderDetails = "
                     DELETE FROM $tbl_productslp WHERE orderNum IN ($orderNum)                     
                    ";
           $db->setQuery($queryOrderDetails);                     
           $db->query();             
           
           $queryOrder = "
                     DELETE FROM $tbl_orderslp WHERE orderNum IN ($orderNum)                     
                    ";
           $db->setQuery($queryOrder);
           $db->query();            
       }
       
       //Inicio Metodos de checkExist de los catalogos
       //comprobar que existe el cliente en la tabla cat_customerlp
       public function chekExistClient($customerName){
           $db = JFactory::getDbo();   
           $tbl_cat_customerslp = $db->getPrefix().'cat_customerslp';
           
           $query = "   
                     SELECT * FROM $tbl_cat_customerslp WHERE customerName = '$customerName'                                                                 
                    ";
           $db->setQuery($query);
           $db->query();    
           //$rows = $db->loadResult();
           $rows = $db->loadObjectList();
           
           if(count($rows)>0){
               if(count($rows)>1){
                   $result = 0;
                   //return 'Tiene mas de uno retornar como null';
               }else{
                   foreach($rows as $item){
                       $result = ($item->userIdJoomla!=null) ? $item->userIdJoomla : -1;
                   }                   
                   //return 'retornar el id de usuario de joomla';
               }
           }else{
               $queryIns = "
                        INSERT INTO $tbl_cat_customerslp (customerName, active, dateCreation)                                
                                               VALUES ('$customerName', '1', CURDATE())
                       ";  
           
               $db->setQuery($queryIns);                     
               $db->query();
               $idCustomer = $db->insertid(); 
               
               $result = -1;
               //return 'inserta en db pero sin un idUsuario de joomla';
           }
           
           return $result;
                    
       }
       
       //metodo que comprueba si existe nombre de producto en db, si no existe lo crea
       //y al final devolvera el id correspondiente
       public function chekExistProduct($productName){
           $db = JFactory::getDbo();   
           $tbl_cat_productslp = $db->getPrefix().'cat_productslp';
           
           $query = "   
                     SELECT productId FROM $tbl_cat_productslp                        
                     WHERE productName = '$productName'                     
                    ";
           $db->setQuery($query);
           $db->query();    
           $rows = $db->loadResult();
            
           //en caso de que el nombre de producto ya exista en tabla
           if($rows!=null){
               $idProduct = $rows;
           }else{ //en caso de no existir crearlo                
               $queryIns = "
                        INSERT INTO $tbl_cat_productslp (productName, active, dateCreation)                                
                                               VALUES ('$productName', '1', CURDATE())
                       ";  
           
               $db->setQuery($queryIns);                     
               $db->query();
               $idProduct = $db->insertid();   
           }
                      
           return $idProduct;
       }
       
       //metodo que comprueba si existe status en db, si no existe lo crea
       //y al final devolvera el id correspondiente
       public function chekExistStatus($statusName){
           $db = JFactory::getDbo();   
           $tbl_cat_statuslp = $db->getPrefix().'cat_statuslp';
           
           $query = "   
                     SELECT statusId FROM $tbl_cat_statuslp                        
                     WHERE statusName = '$statusName'                     
                    ";
           $db->setQuery($query);
           $db->query();    
           $rows = $db->loadResult();
            
           //en caso de que status ya exista en tabla
           if($rows!=null){
               $idStatus = $rows;
           }else{ //en caso de no existir crearlo                
               $queryIns = "
                        INSERT INTO $tbl_cat_statuslp (statusName, active, dateCreation)                                
                                               VALUES ('$statusName', '1', CURDATE())
                       ";  
           
               $db->setQuery($queryIns);                     
               $db->query();
               $idStatus = $db->insertid();   
           }
                      
           return $idStatus;
       }
       
       //metodo que comprueba si existe nombre de dibujo en db, si no existe lo crea
       //y al final devolvera el id correspondiente
       public function chekExistDrawing($drawingName){
           $db = JFactory::getDbo();   
           $tbl_cat_drawingslp = $db->getPrefix().'cat_drawingslp';
           
           $query = "   
                     SELECT drawingId FROM $tbl_cat_drawingslp                        
                     WHERE drawingName = '$drawingName'                     
                    ";
           $db->setQuery($query);
           $db->query();    
           $rows = $db->loadResult();
            
           //en caso de que el dibujo ya exista en tabla
           if($rows!=null){
               $idDrawing = $rows;
           }else{ //en caso de no existir crearlo                
               $queryIns = "
                        INSERT INTO $tbl_cat_drawingslp (drawingName, active, dateCreation)                                
                                               VALUES ('$drawingName', '1', CURDATE())
                       ";  
           
               $db->setQuery($queryIns);                     
               $db->query();
               $idDrawing = $db->insertid();   
           }
                      
           return $idDrawing;
       }
       
       //Fin Metodos de checkExist de los catalogos       
       
       
       //Inicio Consulta de coleccion de todos sus elementos de todos los catalogos
       public function GetAllProducs(){
           $db = JFactory::getDbo();   
           $tbl_cat_productslp = $db->getPrefix().'cat_productslp';
           
           $query = "   
                     SELECT * FROM $tbl_cat_productslp WHERE active=1                                            
                    ";
           $db->setQuery($query);
           $db->query();    
           $result = $db->loadObjectList();
           
           return $result;
       }
       
       public function GetAllStatus(){
           $db = JFactory::getDbo();   
           $tbl_cat_statuslp = $db->getPrefix().'cat_statuslp';
           
           $query = "   
                     SELECT * FROM $tbl_cat_statuslp WHERE active=1                                             
                    ";
           $db->setQuery($query);
           $db->query();    
           $result = $db->loadObjectList();
           
           return $result;
       }
       
       public function GetAllDrawings(){
           $db = JFactory::getDbo();   
           $tbl_cat_drawingslp = $db->getPrefix().'cat_drawingslp';
           
           $query = "   
                     SELECT * FROM $tbl_cat_drawingslp WHERE active=1                                           
                    ";
           $db->setQuery($query);
           $db->query();    
           $result = $db->loadObjectList();
           
           return $result;
       }
       //Fin Consulta de coleccion de todos sus elementos de todos los catalogos
       
       
       //comprobar que exista al menos el numero de orden dado
       //si no existe y sigue debe de borrar la orden previamente registrada       
       public function checkOrderNumInDetails($orderNum){
           $db = JFactory::getDbo();   
           $tbl_productslp = $db->getPrefix().'productslp';
           $tbl_orderslp = $db->getPrefix().'orderslp';
           
//           $queryOrder = " SELECT * FROM $tbl_orderslp WHERE orderNum = $orderNum ";                                                                                                         
//           $db->setQuery($queryOrder);
//           $db->query();    
//           $rows1 = $db->loadResult();
//           
//           if($rows1!=null){
              $query = "   
                     SELECT * FROM $tbl_productslp WHERE orderNum IN ($orderNum)                                                                
                    ";
              $db->setQuery($query);
              $db->query();    
              $rows = $db->loadResult();
              
              $exist = ($rows!=null) ? '1' : '0';
//           }else{
//              $exist = '0'; 
//           }
                                                       
           return $exist;
       }
       
        public function deleteOrderByOrderIdDB($idO){             
            $db = JFactory::getDbo();                                                                
            
            $query = "DELETE FROM #__orderslp WHERE idOrder=$idO ";                              
            $db->setQuery($query);
            $result = $db->query();                    
            
             return $result;
        } 
        
        
       //obtener todos las imagenes de los detalles
       public function GetAllImagesByDetailsInGrid($ds)
       {	                                 
           $db = JFactory::getDbo();   
           $tbl_productslp = $db->getPrefix().'productslp';           
           
           $query = "                           
                      SELECT DISTINCT prodImg FROM $tbl_productslp WHERE prodImg!=''                                                   
                    ";                                                       
            
          $ds->SelectCommand = $query;                                    
                        
           return $ds;                            
       }
}

?>
