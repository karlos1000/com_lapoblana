<?php
// No direct access
defined('_JEXEC') or die;

/**
 * test component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_contact
 * @since		1.6
 */
class LapoblanahpHelper
{	          
                   
       public static function lapoblanaTest(){
           //$test = 'Prueba';
          //$test = $this->returnTest();
          $test = self::returnTest();
          return $test;
       }
       
       public static function returnTest(){
          $text = 'Prueba';
          return $text;
       } 

       /*Metodos para obtener todos los productos dependiendo del numero de orden*/
       public static function GetAllProductsByOrderGrid($orderNum){
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';                                                      
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'koolgrid.php';            

           $config = new JConfig();
           $host = $config->host;
           $user = $config->user;
           $pass = $config->password;
           $db = $config->db;
           $dbConn = mysqli_connect($host, $user, $pass, $db) or die("cannot connect");            
           mysqli_select_db($db, $dbConn) or die("cannot connect database");  ;           
           $model = JModelLegacy::getInstance('Globalmethods', 'LapoblanaModel'); 
            
           $ds = new MySQLiDataSource($dbConn);                              
           $ds = $model->GetAllProductsToGridByOrder($ds,$orderNum);                                              
        
            $grid = new KoolGrid("productsOrderGrid");               
            self::defineGrid($grid, $ds);            
            self::defineColumn($grid, "prodId", "Id", true, true, 1);
            self::defineColumn($grid, "orderNum", "No. Orden", true, true, 1);
            self::defineColumn($grid, "prodName", "Producto", true, false, 1);
            self::defineColumn($grid, "prodDrawing", "Dibujo", true, false, 1);
            self::defineColumnEditImg($grid);
            self::defineColumn($grid, "prodImg", "Img", false, false, 1);
            self::defineColumn($grid, "amount", "Cantidad", true, false, 1);
            self::defineColumn($grid, "progress", "Avance", true, false, 1);
            self::defineColumn($grid, "whoRequested", "Solicit&oacute;", true, false, 1);
            self::defineColumn($grid, "status", "Estatus", true, false, 1);
            self::defineColumn($grid, "cloth", "Tela", true, false, 1);
            self::defineColumn($grid, "weaveCloth", "Tela por tejer", true, false, 1);
            self::defineColumn($grid, "dateStock", "Fecha almac&eacute;n", true, false, 1);
                                                            
            self::defineColumnEdit($grid);
            
            
            //Show Function Panel
            $grid->MasterTable->ShowFunctionPanel = true;
            //Insert Settings
            $grid->MasterTable->InsertSettings->Mode = "Form";                
            $grid->MasterTable->EditSettings->Mode = "Form";
            $grid->MasterTable->InsertSettings->ColumnNumber = 1;            

        //pocess grid
        $grid->Process();
        
        return $grid;                     
       }       
       
       public static function defineGrid($grid, $ds){ 
            $base = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolGrid/localization/es.xml';                
            $grid->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolGrid';
            $grid->styleFolder="default";
            $grid->Width = "900px";

            //$grid->RowAlternative = true;
            $grid->AjaxEnabled = true;		
            $grid->DataSource = $ds;
            $grid->AjaxLoadingImage =  JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolAjax/loading/5.gif';
            $grid->Localization->Load($base);	

            $grid->AllowInserting = true;		
            $grid->AllowEditing = true;
            $grid->AllowDeleting = true;		
            $grid->AllowSorting = true;
            $grid->ColumnWrap = true;
            $grid->CharSet = "utf8";    
            
            //$grid->MasterTable->DataSource = $ds;		
            $grid->MasterTable->AutoGenerateColumns = false;			
            $grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
            $grid->MasterTable->Pager->ShowPageSize = true;
            $grid->MasterTable->Pager->PageSizeOptions = "10,25,50,100,150";
            $grid->ClientSettings->ClientEvents["OnGridCommit"] = "Handle_OnGridCommit";
       }
       
       public static function defineColumn($grid,$name_field, $name_header, $visible=true, $read_only=false, $validator=0)
       {
        include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolCalendar' . DIRECTORY_SEPARATOR . 'koolcalendar.php';                   
        $calLangueaje = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolCalendar/localization/es.xml';     
        $scrpFolder = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolCalendar';     
        $pahtImg = JURI::root().'media/com_lapoblana/upload_files_img/';
        $model = JModelLegacy::getInstance('Globalmethods', 'LapoblanaModel');                     
                   
        $dateC = date("Y-m-d");
        if ($name_field == 'dateStock') {                       
            $column = new GridDateTimeColumn();                        
            $column->Picker = new KoolDatePicker();
            $column->Picker->scriptFolder = $scrpFolder;            
            $column->Picker->Localization->Load($calLangueaje);
            $column->Picker->styleFolder = "default";	
            $column->Picker->DateFormat = "Y-m-d";	
            $column->Picker->ShowToday = true;             
            $column->DefaultValue = $dateC;
        }
//        elseif($name_field == 'prodImg'){
//            $column = new gridcustomcolumn;
//            $column->Visible = $visible;
//            $column->ReadOnly = $read_only;
//            $column->ItemTemplate = '<img src="'.$pahtImg.'{prodImg}" height="42" width="42">';            
//            //$column->ItemTemplate = '{prodImg}';            
//        }
        elseif($name_field == 'status'){
            $column = new GridDropDownColumn();	                    
            $collStatus = $model->GetAllStatus();    
            
            foreach($collStatus as $item)
            {                
               $column->AddItem($item->statusName,$item->statusId);             
            }     
        }
        elseif($name_field == 'prodDrawing'){
            $column = new GridDropDownColumn();	                    
            $collDrawings = $model->GetAllDrawings();    
            
            foreach($collDrawings as $item)
            {                
               $column->AddItem($item->drawingName,$item->drawingId);             
            }     
        }        
        elseif($name_field == 'prodName'){
            $column = new GridDropDownColumn();	                    
            $collProducts = $model->GetAllProducs();    
            
            foreach($collProducts as $item)
            {                
               $column->AddItem($item->productName,$item->productId);             
            }     
        }
        else{                        
            $column = new gridboundcolumn();	
        }
        
        if($validator > 0)            
            $column->addvalidator(self::GetValidator($validator));
                
        $column->DataField = $name_field;
        $column->HeaderText = $name_header;
        $column->ReadOnly = $read_only;
        $column->Visible = $visible;
        $grid->MasterTable->AddColumn($column);
       }
       
       public static function GetValidator($type){
        
        switch ($type) {
            case 1: //required
                $validator = new RequiredFieldValidator();
                $validator->ErrorMessage = "Campo requerido";
                return $validator;
                break;
            }
        }
        
       public static function defineColumnEdit($grid)
       {
           
           $column = new GridCustomColumn(); 
           $column->HeaderText = "Acciones"; 
           $column->Align = "center";
           $column->Width = "100px"; 
           $column->ItemTemplate = "
                                    <a class='kgrLinkEdit'{record_editable} onclick='grid_edit(this)' href='javascript:void 0' type='button'>Editar</a> | 
                                    <a class='kgrLinkDelete'{record_editable} onclick='grid_delete(this)' href='javascript:void 0' type='button'>Eliminar</a>
                                   "; 
                                        
           $grid->MasterTable->AddColumn($column);
//            $column = new grideditdeletecolumn();
//            $column->Align = "center";
//            $column->HeaderText = "Acciones";
//            $column->Width = "20px";            
//            $column->ShowEditButton = true;
//            //$column->EditButtonText = "Editar | ";
//            $column->ItemTemplate = ' | ';  
//            $column->ShowDeleteButton = true;            
//            //$column->ButtonType = "Link";
//            $grid->MasterTable->AddColumn($column);	

       } 
       
       public static function defineColumnEditImg($grid)
       {
            $pahtImg = JURI::root().'media/com_lapoblana/upload_files_img/';
            $column = new gridcustomcolumn;            
            $column->Align = "center";
            $column->HeaderText = "Img";
            $column->ItemTemplate = '<img src="'.$pahtImg.'{prodImg}" height="42" width="42">';  
            $grid->MasterTable->AddColumn($column);	

       }              
     /*Fin de metodos para obtener todos los productos dependiendo del numero de orden*/
         
     /*Grid que muestra las imagenes que estan ocupadas por los detalles de los productos*/  
       public static function GetAllImagesByDetailsInGrid(){
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';                                                      
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'koolgrid.php';            

           $config = new JConfig();
           $host = $config->host;
           $user = $config->user;
           $pass = $config->password;
           $db = $config->db;
           $dbConn = mysqli_connect($host, $user, $pass, $db) or die("cannot connect");
           mysqli_select_db($dbConn,$db) or die("cannot connect database");  ;           
           $model = JModelLegacy::getInstance('Globalmethods', 'LapoblanaModel'); 
            
           $ds = new MySQLiDataSource($dbConn);
           $ds = $model->GetAllImagesByDetailsInGrid($ds);                                              
        
            $grid = new KoolGrid("imagesLapoblanaGrid");               
            self::defineGridImages($grid, $ds);                        
            self::defineColumnImages($grid, "prodImg", "Nombre de la imagen", true, false, 1);            
            self::defineColumnImagesShowImg($grid);            
            //            
            //Show Function Panel
            $grid->MasterTable->ShowFunctionPanel = false;
            //Insert Settings
            $grid->MasterTable->InsertSettings->Mode = "Form";                
            $grid->MasterTable->EditSettings->Mode = "Form";
            $grid->MasterTable->InsertSettings->ColumnNumber = 1;            

        //pocess grid
        $grid->Process();
        
        return $grid;                     
       }    
       
      public static function defineGridImages($grid, $ds){ 
            $base = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolGrid/localization/es.xml';                
            $grid->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolGrid';
            $grid->styleFolder="default";
            $grid->Width = "500px";

            //$grid->RowAlternative = true;
            $grid->AjaxEnabled = true;		
            $grid->DataSource = $ds;
            $grid->AjaxLoadingImage =  JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolAjax/loading/5.gif';
            $grid->Localization->Load($base);	

            $grid->AllowInserting = true;		
            $grid->AllowEditing = true;
            $grid->AllowDeleting = true;		
            $grid->AllowSorting = true;
            $grid->ColumnWrap = true;
            $grid->CharSet = "utf8";    
            
            //$grid->MasterTable->DataSource = $ds;		
            $grid->MasterTable->AutoGenerateColumns = false;			
            $grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
            $grid->MasterTable->Pager->ShowPageSize = true;
            $grid->MasterTable->Pager->PageSizeOptions = "10,25,50,100,150";            
      }
       
      public static function defineColumnImages($grid,$name_field, $name_header, $visible=true, $read_only=false){                                       
        $column = new gridboundcolumn();	        
        $column->DataField = $name_field;
        $column->HeaderText = $name_header;
        $column->ReadOnly = $read_only;
        $column->Visible = $visible;
        $column->Align = "center";
        $column->Width = "40%";
        $grid->MasterTable->AddColumn($column);
      }
       
      public static function defineColumnImagesShowImg($grid)
       {
            $pahtImg = JURI::root().'media/com_lapoblana/upload_files_img/';
            //$pathAbs = 'C:\Program Files\EasyPHP-12.0\www\toraguimarrprueba\media\com_lapoblana\upload_files_img\p31.jpg';            
//            $line = trim("\ ");            
//            $nameImg = '{prodImg}';
//            $pathAbs = trim(JPATH_SITE."\media\com_lapoblana\upload_files_img".$line.$nameImg);            
//            
//            if(file_exists($pathAbs)) {
//                $exist = 'Existe';
//            } else {
//                $exist = 'No existe';
//            }
            //alt="'.$exist.'"            
            $column = new gridcustomcolumn;            
            $column->Align = "center";
            $column->HeaderText = "Imagen";
            $column->Width = "60%";
            $column->ItemTemplate = '<img src="'.$pahtImg.'{prodImg}" height="0%" width="30%">';  
            $grid->MasterTable->AddColumn($column);	

       }
     /*Fin Grid que muestra las imagenes que estan ocupadas por los detalles de los productos*/  
}
