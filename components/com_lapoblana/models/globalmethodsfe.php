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
class LapoblanaModelGlobalmethodsfe extends JModelLegacy{

       public function convertDateToMysql($date){
           list($d,$m,$y) = explode('/', $date);
           $date = $y.'-'.$m.'-'.$d;

           return $date;
       }

       //obtener todos los productos relacionados a la orden
       public function GetAllOrdersByIdUser($ds,$idUser)
       {
           $db = JFactory::getDbo();
           $tbl_orderslp = $db->getPrefix().'orderslp';

           $query = "
                        SELECT a.idOrder, a.orderNum, a.idCustomer, a.dateOrder, a.dateReceipt, a.weeks, a.dateEstimated
                        FROM $tbl_orderslp as a
                        WHERE a.idCustomer = $idUser AND DATE_SUB(NOW(),INTERVAL 1 YEAR) <= a.dateOrder
                        ORDER BY a.idOrder DESC
                    ";
            //echo $queryIns;

            $ds->SelectCommand = $query;

           return $ds;
       }

       public function GetAllOrdersAfterByIdUser($ds,$idUser)
       {
           $db = JFactory::getDbo();
           $tbl_orderslp = $db->getPrefix().'orderslp';

           $query = "
                        SELECT a.idOrder, a.orderNum, a.idCustomer, a.dateOrder, a.dateReceipt, a.weeks, a.dateEstimated
                        FROM $tbl_orderslp as a
                        WHERE a.idCustomer = $idUser AND DATE_SUB(NOW(),INTERVAL 1 YEAR) >= a.dateOrder
                        ORDER BY a.idOrder DESC
                    ";
           $ds->SelectCommand = $query;

           return $ds;
       }

       public function GetAllProdsDetailsByIdUser($ds, $idUser){
           $db = JFactory::getDbo();
           $tbl_productslp = $db->getPrefix().'productslp';
           $tbl_orderslp = $db->getPrefix().'orderslp';
           $tbl_cat_statuslp = $db->getPrefix().'cat_statuslp';
           $tbl_cat_drawingslp = $db->getPrefix().'cat_drawingslp';
           $tbl_cat_productslp = $db->getPrefix().'cat_productslp';

           $query = "
                    SELECT a.prodId, a.orderNum, e.productName, d.drawingName, a.prodImg, a.amount, a.whoRequested, c.statusName, a.cloth, a.weaveCloth, a.dateStock, a.progress
                    FROM $tbl_productslp as a
                    LEFT JOIN $tbl_orderslp as b ON b.orderNum=a.orderNum
                    LEFT JOIN $tbl_cat_statuslp as c on c.statusId=a.status
                    LEFT JOIN $tbl_cat_drawingslp as d on d.drawingId=a.prodDrawing
                    LEFT JOIN $tbl_cat_productslp as e on e.productId=a.prodName
                    WHERE b.idCustomer=$idUser
                    ";
           $ds->SelectCommand = $query;

           return $ds;
       }
}

?>
