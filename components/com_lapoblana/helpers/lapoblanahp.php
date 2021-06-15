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

        /*Metodos de ayuda del componente la poblana*/
       public static function GetAllOrdersByIdUser($idUser){
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'koolgrid.php';
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'ext'. DIRECTORY_SEPARATOR .'datasources'. DIRECTORY_SEPARATOR .'MySQLiDataSource.php';

           $config = new JConfig();
           $host = $config->host;
           $user = $config->user;
           $pass = $config->password;
           $db = $config->db;
           $dbConn = mysqli_connect($host, $user, $pass, $db) or die("cannot connect");
           mysqli_select_db($dbConn, $db) or die("cannot connect database");
           $model = JModelLegacy::getInstance('globalmethodsfe', 'LapoblanaModel');

           $ds = new MySQLiDataSource($dbConn);
           $ds = $model->GetAllOrdersByIdUser($ds,$idUser);
           $dsDetails = new MySQLiDataSource($dbConn);
           $dsDetails = $model->GetAllProdsDetailsByIdUser($dsDetails,$idUser);  //Obtener los productos detalles de las ordenes

            $grid = new KoolGrid("productsOrderGridClient");
            self::defineGridClient($grid, $ds, $dsDetails);
            self::defineColumn($grid, "idOrder", "Id", false, true, 1);
            self::defineColumn($grid, "orderNum", "No. Orden", true, true, 1);
            self::defineColumn($grid, "idCustomer", "Cliente", false, false, 1);
            self::defineColumn($grid, "dateOrder", "Fecha Orden", true, false, 1);
            self::defineColumn($grid, "dateReceipt", "Fecha recepción", true, false, 1);
            self::defineColumn($grid, "weeks", "Semanas", true, false, 1);
            self::defineColumn($grid, "dateEstimated", "Fecha Estimada", true, false, 1);

            //self::defineColumnEdit($grid);

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

       public static function defineGridClient($grid, $ds, $dsDetails){
            $base = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolGrid/localization/es.xml';
            $grid->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolGrid';
            $grid->styleFolder="default";
            $grid->Width = "740px";

            $grid->RowAlternative = false;
            $grid->AjaxEnabled = true;
            //$grid->DataSource = $ds;
            $grid->AjaxLoadingImage =  JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolAjax/loading/5.gif';
            $grid->Localization->Load($base);

            $grid->AllowInserting = false;
            $grid->AllowEditing = false;
            $grid->AllowDeleting = false;
            $grid->AllowSorting = true;
            $grid->ColumnWrap = true;
            $grid->CharSet = "utf8";
            $grid->AllowHtmlRender = true;

            $table_detail = new GridTableView();
            $table_detail->ColumnAlign  = "center";
            $table_detail->ColumnValign  = "top";
            //$table_detail->ShowFooter = true;
            $table_detail->Width = "100%";
            $table_detail->DataSource = $dsDetails; //Fuente de datos Hijos
            $table_detail->AddRelationField("orderNum","orderNum");
            $table_detail->AutoGenerateColumns = false;//Auto Generate all column from tables
            $table_detail->DisableAutoGenerateDataFields = "prodId,orderNum";

            //self::defineColumnTableView($table_detail, "productName", "Prod");
            self::defineColumnTableView($table_detail, "drawingName", "Dibujo");
            self::defineColumnTableView($table_detail, "prodImg", "Img");
            self::defineColumnTableView($table_detail, "amount", "Cantidad");
            //self::defineColumnTableView($table_detail, "whoRequested", "Solicitó");
            self::defineColumnTableView($table_detail, "progress", "Avance");
            self::defineColumnTableView($table_detail, "statusName", "Estatus");
            self::defineColumnTableView($table_detail, "cloth", "Tejida");
            self::defineColumnTableView($table_detail, "weaveCloth", "Tela por tejer");
            self::defineColumnTableView($table_detail, "dateStock", "Fecha Estimada");

            $grid->MasterTable->DataSource = $ds; //Fuente de datos padres
            $grid->MasterTable->AutoGenerateExpandColumn = true;
            $grid->MasterTable->AutoGenerateColumns = false;
            $grid->MasterTable->AddDetailTable($table_detail);

            $grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
            $grid->MasterTable->Pager->ShowPageSize = true;
            $grid->MasterTable->Pager->PageSizeOptions = "10,25,50,100,150";

       }

       public static function defineColumn($grid,$name_field, $name_header, $visible=true, $read_only=false, $validator=0)
       {
        if($name_field=='orderNum') {
            $column = new gridboundcolumn();
            $column->Width="100px";
            $column->Align="center";
        }
        elseif($name_field=='dateOrder'){
            $column = new gridboundcolumn();
            $column->Width="120px";
            $column->Align="center";
        }
        elseif($name_field=='dateReceipt'){
            $column = new gridboundcolumn();
            $column->Width="130px";
            $column->Align="center";
        }
        elseif($name_field=='weeks'){
            $column = new gridboundcolumn();
            $column->Width="90px";
            $column->Align="center";
        }
        elseif($name_field=='dateEstimated'){
            $column = new gridboundcolumn();
            $column->Width="130px";
            $column->Align="center";
        }

        else{
            $column = new gridboundcolumn();
        }

        $column->DataField = $name_field;
        $column->HeaderText = $name_header;
        $column->ReadOnly = $read_only;
        $column->Visible = $visible;
        $grid->MasterTable->AddColumn($column);
       }

       public static function defineColumnEdit($grid)
       {
           $column = new GridCustomColumn();
           $column->DataField = 'actions';
           $column->HeaderText = 'Detalles';
           $column->ReadOnly = true;
           $column->Align = "center";
           $column->AllowHtmlRender = true;
           $column->ItemTemplate = '<a href="javascript:seeDetails({orderNum});"  class="see_details_order"><img src="" title="Ver"/></a>';
           //$column->ItemTemplate = '<img src="'.$this->imgExportReport.'" title="Exportar a excel" onclick="updateGrid({idOwner},{idCondominium});" style="cursor:pointer" />';
           $grid->MasterTable->AddColumn($column);//
       }
/*Fin de configuracion del grid*/


       /*Obtener todas las ordenes despues de un año*/
        public static function GetAllOrdersAfterByIdUser($idUser){
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolAjax' . DIRECTORY_SEPARATOR . 'koolajax.php';
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'koolgrid.php';
           include_once JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_lapoblana' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'KoolControls' . DIRECTORY_SEPARATOR . 'KoolGrid' . DIRECTORY_SEPARATOR . 'ext'. DIRECTORY_SEPARATOR .'datasources'. DIRECTORY_SEPARATOR .'MySQLiDataSource.php';

           $config = new JConfig();
           $host = $config->host;
           $user = $config->user;
           $pass = $config->password;
           $db = $config->db;
           $dbConn = mysqli_connect($host, $user, $pass,$db) or die("cannot connect");
           mysqli_select_db($dbConn,$db) or die("cannot connect database");  ;
           $model = JModelLegacy::getInstance('globalmethodsfe', 'LapoblanaModel');

           $ds = new MySQLiDataSource($dbConn);
           $ds = $model->GetAllOrdersAfterByIdUser($ds,$idUser);
           $dsDetails = new MySQLiDataSource($dbConn);
           $dsDetails = $model->GetAllProdsDetailsByIdUser($dsDetails,$idUser);  //Obtener los productos detalles de las ordenes

            $grid = new KoolGrid("ordersAfterYear");
            self::defineGridAfterYear($grid, $ds,$dsDetails);
            self::defineColumnAY($grid, "idOrder", "Id", false, true, 1);
            self::defineColumnAY($grid, "orderNum", "No. Orden", true, true, 1);
            self::defineColumnAY($grid, "idCustomer", "Cliente", false, false, 1);
            self::defineColumnAY($grid, "dateOrder", "Fecha Orden", true, false, 1);
            self::defineColumnAY($grid, "dateReceipt", "Fecha recepción", true, false, 1);
            self::defineColumnAY($grid, "weeks", "Semanas", true, false, 1);
            self::defineColumnAY($grid, "dateEstimated", "Fecha Estimada", true, false, 1);

            //self::defineColumnEdit($grid);

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

       public static function defineGridAfterYear($grid, $ds,$dsDetails){
            $base = JPATH_SITE.'/administrator/components/com_lapoblana/common/KoolControls/KoolGrid/localization/es.xml';
            $grid->scriptFolder = JURI::root().'administrator/components/com_lapoblana/common/KoolControls/KoolGrid';
            $grid->styleFolder="default";
            $grid->Width = "740px";

            $grid->RowAlternative = false;
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

            $table_detail = new GridTableView();
            $table_detail->ColumnAlign  = "center";
            $table_detail->ColumnValign  = "top";
            //$table_detail->ShowFooter = true;
            $table_detail->Width = "100%";
            $table_detail->DataSource = $dsDetails; //Fuente de datos Hijos
            $table_detail->AddRelationField("orderNum","orderNum");
            $table_detail->AutoGenerateColumns = false;//Auto Generate all column from tables
            $table_detail->DisableAutoGenerateDataFields = "prodId,orderNum";

            //self::defineColumnTableView($table_detail, "productName", "Prod");
            self::defineColumnTableView($table_detail, "drawingName", "Dibujo");
            self::defineColumnTableView($table_detail, "prodImg", "Img");
            self::defineColumnTableView($table_detail, "amount", "Cantidad");
            //self::defineColumnTableView($table_detail, "whoRequested", "Solicitó");
            self::defineColumnTableView($table_detail, "progress", "Avance");
            self::defineColumnTableView($table_detail, "statusName", "Estatus");
            self::defineColumnTableView($table_detail, "cloth", "Tejida");
            self::defineColumnTableView($table_detail, "weaveCloth", "Tela por tejer");
            self::defineColumnTableView($table_detail, "dateStock", "Fecha Estimada");

            $grid->MasterTable->DataSource = $ds; //Fuente de datos padres
            $grid->MasterTable->AutoGenerateExpandColumn = true;
            $grid->MasterTable->AutoGenerateColumns = false;
            $grid->MasterTable->AddDetailTable($table_detail);

            $grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
            $grid->MasterTable->Pager->ShowPageSize = true;
            $grid->MasterTable->Pager->PageSizeOptions = "10,25,50,100,150";
       }

       public static function defineColumnAY($grid,$name_field, $name_header, $visible=true, $read_only=false, $validator=0){
        if($name_field=='orderNum') {
            $column = new gridboundcolumn();
            $column->Width="100px";
            $column->Align="center";
        }
        elseif($name_field=='dateOrder'){
            $column = new gridboundcolumn();
            $column->Width="120px";
            $column->Align="center";
        }
        elseif($name_field=='dateReceipt'){
            $column = new gridboundcolumn();
            $column->Width="130px";
            $column->Align="center";
        }
        elseif($name_field=='weeks'){
            $column = new gridboundcolumn();
            $column->Width="90px";
            $column->Align="center";
        }
        elseif($name_field=='dateEstimated'){
            $column = new gridboundcolumn();
            $column->Width="130px";
            $column->Align="center";
        }
        else{
            $column = new gridboundcolumn();
        }

        $column->DataField = $name_field;
        $column->HeaderText = $name_header;
        $column->ReadOnly = $read_only;
        $column->Visible = $visible;
        $grid->MasterTable->AddColumn($column);
       }
       /*Fin de ordenes en el historial*/

        //Define la vista de las columnas de la tabla view
       public static function defineColumnTableView($table_detail, $name_field, $name_header)
       {
         //$uploadPathImg = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_lapoblana'.DIRECTORY_SEPARATOR.'upload_files_img'.DIRECTORY_SEPARATOR;
         $pahtImg = JURI::root().'media/com_lapoblana/upload_files_img/';

         if($name_field=='prodImg') {
             $imgDefault = '{prodImg}';
//             $ext = end(explode('.', $imgDefault));
//
//             if($ext=='jpg' || $ext=='png' || $ext=='gif'){
//                 $img = $ext;
////                  if(file_exists($uploadPathImg.$imgDefault)) {
////                        $img = $imgDefault;
////                    }else{
////                        $img = 'default.jpg';
////                    }
//             }else{
//                 $img = $ext;
//             }


             $column = new gridcustomcolumn;
             $column->ItemTemplate = '<img src="'.$pahtImg.$imgDefault.'" height="42" width="42">';
        }else{
            $column = new GridBoundColumn();
        }
         $column->DataField = $name_field;
         $column->HeaderText = $name_header;
         $table_detail->AddColumn($column);
       }
}
