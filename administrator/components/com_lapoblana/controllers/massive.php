<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('joomla.application.component.controllerform');

class LapoblanaControllerMassive extends JControllerForm {                  
           
    //metodo para leer archivos xls ó xlsx para el componente la poblana
    function uploadXlsXlsx(){        
        //echo 'He subido mi archivo';       
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');        
        set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');        
        include_once JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_lapoblana'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'IOFactory.php';
        
        $filename = str_replace(' ', '', $_FILES['nameFile']['name']);
        $fileTempPath = $_FILES['nameFile']['tmp_name'];       
        $ext = end(explode(".", $filename));        
        
        if($ext=='xls' || $ext=='xlsx'):            
            $uploadPath = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_lapoblana'.DIRECTORY_SEPARATOR.'upload_files_xls'.DIRECTORY_SEPARATOR.$filename;                           
                                                        
            if(JFile::upload($fileTempPath, $uploadPath)){                                                                    
           //ruta del archivo temporal
            $readFile = $uploadPath;                                    

            //Lectura de archivo con PHPExcel
            $inputFileName = $readFile;
            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);                
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $totalCells = count($sheetData);  
            $totalCol = count($sheetData[1]);                                 

            //Insertar datos de archivo xls o xlsx de Ordenes
            $model = JModelLegacy::getInstance('Order', 'LapoblanaModel');                                                                    
            $modelGM = JModelLegacy::getInstance('Globalmethods', 'LapoblanaModel');                   

            $CollA = ''; //Numero de orden
            $CollB = ''; //Cliente
            $CollC = ''; //Fecha de la orden
            $CollD = ''; //Fecha de recepcion 
            $CollE = ''; //Producto
            $CollF = ''; //Dibujo
            $CollG = ''; //Cantidad
            $CollH = ''; //Entrega programada semanas
            $CollI = ''; //Entrega programada Fecha
            $CollJ = ''; //Solicito
            $CollK = ''; //Status
            $CollL = ''; //Tela tejida
            $CollM = ''; //Tela por tejer
            $CollN = ''; //Fecha de entrega almacen                
            $CollO = ''; //Es el nombre de la imagen 
            $CollP = ''; //Es el avance
            
                                
                //verifica que la estructura del archivo sea correcta 
                if($sheetData[1]["A"] && $sheetData[1]["B"] && $sheetData[1]["C"] && $sheetData[1]["D"] && $sheetData[1]["E"] && $sheetData[1]["F"] && $sheetData[1]["G"] && $sheetData[1]["H"] && $sheetData[1]["I"] && $sheetData[1]["J"] && $sheetData[1]["K"] && $sheetData[1]["L"] && $sheetData[1]["M"] && $sheetData[1]["N"] && $sheetData[1]["O"] && $sheetData[1]["P"]  )
                {
                    $struct = 1;                    
                    set_time_limit(0); //evitar el error max_execution_time                       

                    //Obtiene array unico de la informacion que se insertara en tabla de orderslp
                    for ($i = 2; $i <= $totalCells; $i++) {                         
                        $CollA = ($sheetData[$i]["A"] != "") ? (int)$sheetData[$i]["A"] : null;
                        $CollB = ($sheetData[$i]["B"] != "") ? $sheetData[$i]["B"] : null;
                        $CollC = ($sheetData[$i]["C"] != "") ? $this->getConvertDateMassive($sheetData[$i]["C"]) : null; 
                        $CollD = ($sheetData[$i]["D"] != "") ? $this->getConvertDateMassive($sheetData[$i]["D"]) : null; 
                        $CollH = ($sheetData[$i]["H"] != "") ? $sheetData[$i]["H"] : null;
                        $CollI = ($sheetData[$i]["I"] != "") ? $this->getConvertDateMassive($sheetData[$i]["I"]) : null; 

                        if($CollA!=null && $CollC!=null && $CollD!=null && $CollH!=null && $CollI!=null ){
                            $arrReadOrder[$CollA] = array("orderNum"=>$CollA,
                                                          "client"=>$CollB,
                                                          "dateO"=>$CollC,
                                                          "dateR"=>$CollD,
                                                          "weeks"=>$CollH,
                                                          "dateDely"=>$CollI,
                                                            );                                                                                            
                            $arrClienEmpty[$CollA] = array("orderNum"=>$CollA,
                                                           "client"=>$CollB,                                                         
                                                            );                                                                                                                            
                        }
                        
                        //comprueba que si la orden existe 
                        $existOrder = $modelGM->chekExistOrder($CollA); 
                        if($existOrder==1){                            
                            $modelGM->delDetailsOrderAndOrder($CollA); //elimina la orden ya existente con sus detalles
                            $arrayReplace[] = $CollA;
                        }                        
                    } 
                                                            
                    //almacena en db los numeros de orden y si existen hace un borrado de la orden y los detalles de la orden antigua
                    foreach ($arrReadOrder as $itemOrd){
                        //comprueba que el nombre del dibujo ya se encuentre en el sistema
                        //Si no es asi entonces mandar abrir vista para subir las imagenes y que correspondan al nombre del dibujo
                        //echo $itemOrd['orderNum'] .' - '.  $itemOrd['client']  .' - '. $itemOrd['dateO'] .' - '. $itemOrd['dateR'] .' - '. $itemOrd['weeks'] .' - '. $itemOrd['dateDely']    .'<br/>';                        
                        if($itemOrd['client']!=''){
                            $idClient = $modelGM->chekExistClient($itemOrd['client']);
                            //el cliente se encuentra duplicado
                            if($idClient==0){
                                $idClient = null;
                                $arrClientsDupli[] = (object)array("orderNum"=>$itemOrd['orderNum'],"client"=>$itemOrd['client']);
                            }
                            //se ha insertado el cliente pero no tiene un usuario joomla aosiado
                            if($idClient == -1){
                                $idClient = null;
                                $arrClientsNoAsoc[] = (object)array("orderNum"=>$itemOrd['orderNum'],"client"=>$itemOrd['client']);
                            }
                            //devuelve el id de usuario joomla asociado a su cliente
                            if($idClient != -1 && $idClient != 0){
                                $idClient = $idClient;
                            }

                            $idInsertOrder = $model->insertOrder($itemOrd['orderNum'], $idClient, $itemOrd['dateO'], $itemOrd['dateR'], $itemOrd['weeks'], $itemOrd['dateDely']);           
                            //
                        }else{
                            $idClient = null;
                            $idInsertOrder = $model->insertOrder($itemOrd['orderNum'], $idClient, $itemOrd['dateO'], $itemOrd['dateR'], $itemOrd['weeks'], $itemOrd['dateDely']);           
                        }
                        
                        //echo 'Id de Orden: '.$idInsertOrder .'<br/>';                                                                         
                        if($idInsertOrder>0){                            
                            if(in_array($itemOrd['orderNum'], $arrayReplace)){ //Preguntar si se tiene el idPreemplzo                       
                                $saveOrderReplace[] = (object)array("orderNum"=>$itemOrd['orderNum'],"dateO"=>$itemOrd['dateO']);
                            }else{
                                $saveOrder[] = (object)array("orderNum"=>$itemOrd['orderNum'],"dateO"=>$itemOrd['dateO']);
                            }
                        }                                                                        
                    }

                    $uploadPathImg = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_lapoblana'.DIRECTORY_SEPARATOR.'upload_files_img'.DIRECTORY_SEPARATOR;                                           

                    //Recorre todas las filas para insertar en ta labla de detalles de la orden que son productos relacionados
                    for ($i = 2; $i <= $totalCells; $i++) {                                                                                                                        
                        $orderNum = (int)$sheetData[$i]["A"];
                        $prodName = ($sheetData[$i]["E"] != "") ? $sheetData[$i]["E"] : null;
                        $prodDrawing = ($sheetData[$i]["F"] != "") ? $sheetData[$i]["F"] : null;
                        $amount = ($sheetData[$i]["G"] != "") ? str_replace(",","",$sheetData[$i]["G"]) : null;                                               
                        $whoRequested = ($sheetData[$i]["J"] != "") ? $sheetData[$i]["J"] : null;
                        $status = ($sheetData[$i]["K"] != "") ? $sheetData[$i]["K"] : null;
                        $cloth = ($sheetData[$i]["L"] != "") ? str_replace(",","",$sheetData[$i]["L"]) : null;  
                        $weaveCloth = ($sheetData[$i]["M"] != "") ? str_replace(",","",$sheetData[$i]["M"]) : null;  
                        $dateStock = ($sheetData[$i]["N"] != "") ? $this->getConvertDateMassive($sheetData[$i]["N"]) : null; 
                        $prodImg = ($sheetData[$i]["O"] != "") ? $sheetData[$i]["O"] : null;
                        $progress = ($sheetData[$i]["P"] != "") ? $sheetData[$i]["P"] : null;

                        if(array_key_exists($orderNum, $arrReadOrder)){                            
                            if($amount!=null && $dateStock!=null){                                
                                //echo $orderNum .' - '. $prodName .' - '. $prodDrawing .' - '.$amount .' - '. $whoRequested .' - '. $status .' - '. $cloth .' - '.$weaveCloth .' - '.$dateStock .' - '. $prodImg  .'<br/>';                                                              
                                $idProduct = $modelGM->chekExistProduct($prodName);
                                $idStatus = $modelGM->chekExistStatus($status);
                                $idDrawing = $modelGM->chekExistDrawing($prodDrawing);
                                $idInsertProd=$modelGM->insertDetailsOrder($orderNum,$idProduct,$idDrawing,$amount,$whoRequested,$idStatus,$cloth,$weaveCloth,$dateStock,$prodImg, $progress);
                                echo 'id detalle: ' .$idInsertProd .'<br/>';    
                                 
                                //comprobar que el nombre de la imagen exista en la carpeta servidor
                                if($prodImg!=''){
                                    if(!file_exists($uploadPathImg.$prodImg)) {
                                        //echo "El fichero $prodImg no existe<br/>";
                                        //$arrImgNames[] = $prodImg; 
                                        $dataImgNames[] = (object)array("product"=>$prodName,"img"=>$prodImg);
                                    }                                                                                                                           
                                }    
                            }                           
                        }                        
                    } 
                    
                }else{
                        $struct = 0;                                
                }
                        
                                                                                  
                        if($struct==1){                            
//                                echo '<pre>';
//                                  echo 'Ordenes reemplazadas';  
//                                  print_r($saveOrderReplace);
//                                  echo 'Ordenes creadas';  
//                                  print_r($saveOrder);
//                                echo '</pre>';
                            
                            if(count($arrClientsDupli)>0){
                              $hrefDupli = '<a href="index.php?option=com_lapoblana&view=catcustomers" target="_blank">aquí</a>';                                                                                    
                                  $htmlCdupli = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                                  $htmlCdupli .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                              <tr>
                                                  <td colspan="2"><div style="font-weight:bold;padding:5px;margin-bottom:5px;">Los siguientes clientes se encuentran duplicados el sistema no supo que hacer, presioné '.$hrefDupli.' para ver.</div></td>
                                              </tr>
                                              <tr style="text-align:center;">
                                                  <td>ORDEN</td>
                                                  <td>NOMBRE CLIENTE</td>                                            
                                              </tr>';
                                   foreach($arrClientsDupli as $item){                                
                                       $htmlCdupli .= '<tr><td>'.$item->orderNum.'</td><td>'.$item->client.'</td></tr>';
                                   }                                             
                                   $htmlCdupli .= '</table></div><br/>';                                                                                                       
                            }else{
                                $htmlCdupli = '';
                            }
                                 
                            if(count($arrClientsNoAsoc)>0){
                              $hrefAsoc = '<a href="index.php?option=com_lapoblana&view=catcustomers" target="_blank">aquí</a>';                                                                                    
                                  $htmlCAsoc = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                                  $htmlCAsoc .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                              <tr>
                                                  <td colspan="2"><div style="font-weight:bold;padding:5px;height:20px;margin-bottom:5px;">Los siguientes clientes no tienen un usuario de joomla asociado, presioné '.$hrefAsoc.' para ver.</div></td>
                                              </tr>
                                              <tr style="text-align:center;">
                                                  <td>ORDEN</td>
                                                  <td>NOMBRE CLIENTE</td>                                            
                                              </tr>';
                                   foreach($arrClientsNoAsoc as $item){                                
                                       $htmlCAsoc .= '<tr><td>'.$item->orderNum.'</td><td>'.$item->client.'</td></tr>';
                                   }                                             
                                   $htmlCAsoc .= '</table></div><br/>';                                                                                                       
                            }else{
                                $htmlCAsoc = '';
                            }
                            
                            
                            //mostrar vista para subir las imagenes
                            if(count($dataImgNames)>0){
                              $hrefUpload = '<a href="index.php?option=com_lapoblana&view=upload" target="_blank">aquí</a>';  
                              //$arrImgNames = array_filter($arrImgNames);                                                      
                                  //poner enlace a vista upload para encargada de subir las imagenes                                                        
                                  $htmlImg = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                                  $htmlImg .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                              <tr>
                                                  <td colspan="2"><div style="font-weight:bold;padding:5px;height:20px;margin-bottom:5px;">Imagenes que no existen en el servidor, presioné '.$hrefUpload.' para subirlas.</div></td>
                                              </tr>
                                              <tr style="text-align:center;">
                                                  <td>PRODUCTO</td>
                                                  <td>NOMBRE IMAGEN</td>                                            
                                              </tr>';
                                   foreach($dataImgNames as $item){                                
                                       $htmlImg .= '<tr><td>'.$item->product.'</td><td>'.$item->img.'</td></tr>';
                                   }                                             
                                   $htmlImg .= '</table></div><br/>';                                                                                                       
                            }else{
                                $htmlImg = '';
                            }
                              
                            if(count($saveOrderReplace)>0){
                                $hrefOrder = '<a href="index.php?option=com_lapoblana&view=orders" target="_blank">aquí</a>';  
                                $htmlOrdenRe = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                                $htmlOrdenRe .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                            <tr>
                                                <td colspan="2"><div style="font-weight:bold;padding:5px;margin-bottom:5px;">Ordenes que fuerón reemplazadas, por favor debe asociar con un usuario de joomla todas aquellas ordenes que no lo tengan presionando '.$hrefOrder.'.</div></td>
                                            </tr>
                                            <tr style="text-align:center;">
                                                <td>ORDEN</td>
                                                <td>FECHA DE ORDEN</td>                                                
                                            </tr>';
                                 foreach($saveOrderReplace as $item){                                
                                     $htmlOrdenRe .= '<tr><td>'.$item->orderNum.'</td><td>'.$item->dateO.'</td></tr>';
                                 }                                             
                                 $htmlOrdenRe .= '</table></div><br/>'; 
                            }else{
                                $htmlOrdenRe = ''; 
                            }
                            
                            if(count($saveOrder)>0){
                                $hrefOrder = '<a href="index.php?option=com_lapoblana&view=orders" target="_blank">aquí</a>';  
                                $htmlOrden = '<div style="font-weight:normal;text-indent:0px;margin-left:40px;">';
                                $htmlOrden .= '<table width="300" style="border:1px solid #888;text-align:center;background:#fff;color:#000;border-radius:10px;">
                                            <tr>
                                                <td colspan="2"><div style="font-weight:bold;padding:5px;margin-bottom:5px;">Ordenes que fuerón creadas correctamente, por favor asociar con un usuario de joomla todas aquellas ordenes que no lo tengan presionando '.$hrefOrder.'.</div></td>
                                            </tr>
                                            <tr style="text-align:center;">
                                                <td>ORDEN</td>
                                                <td>FECHA DE ORDEN</td>                                                
                                            </tr>';
                                 foreach($saveOrder as $item){                                
                                     $htmlOrden .= '<tr><td>'.$item->orderNum.'</td><td>'.$item->dateO.'</td></tr>';
                                 }                                             
                                 $htmlOrden .= '</table></div><br/>'; 
                            }else{
                                $htmlOrden = ''; 
                            }

                            $htmlMsg = $htmlOrdenRe.$htmlOrden.$htmlImg.$htmlCAsoc.$htmlCdupli;
                        }
                        
                        if($struct==0){
                            $htmlMsg = "Por favor verifique la estructura del archivo no contiene las columnas correctas.";
                        }
                            
                        $this->setRedirect('index.php?option=com_lapoblana&view=massive', $htmlMsg);                                     
                        
             }else{
                 $msg = JText::sprintf('Fallo al subir archivo');            
                 $this->setRedirect('index.php?option=com_lapoblana&view=massive', $msg);                
                die();
             }
                                            
        else:            
            $msg = JText::sprintf('La extensión del archivo no es correcta');            
            $this->setRedirect('index.php?option=com_lapoblana&view=massive', $msg);
        endif;
        
    }
            
  
    
    public function getConvertDateMassive($date=null){
          list($d,$m,$y) = explode('-',$date);
          $m = strtolower($m);
//          $months = array('01'=>'jan','02'=>'feb','03'=>'mar','04'=>'apr','05'=>'may','06'=>'jun',
//                          '07'=>'jul','08'=>'aug','09'=>'sep','10'=>'oct','11'=>'nov','12'=>'dec');
//          for($i=1; $i<=12; $i++){
//             $monthInNum = array_search($m, $months);
//          }
          
          switch ($m) {
              case 'jan': $m='01'; break;                                 
              case 'feb': $m='02'; break;              
              case 'mar': $m='03'; break;              
              case 'apr': $m='04'; break;              
              case 'may': $m='05'; break;              
              case 'jun': $m='06'; break;             
              case 'jul': $m='07'; break;              
              case 'aug': $m='08'; break;              
              case 'sep': $m='09'; break;              
              case 'oct': $m='10'; break;             
              case 'nov': $m='11'; break;               
              case 'dec': $m='12'; break;                          
          }
                              
          $date = date('Y-m-d', strtotime($y.'-'.$m.'-'.$d));
                                
          return $date;
                       
       }      
    
}

?>
