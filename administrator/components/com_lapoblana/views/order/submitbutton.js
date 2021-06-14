
function jSelectCustomerlp(nameCustomer, user, idUserJoomla) {
     console.log(nameCustomer +' - ' + user + ' - ' +idUserJoomla);
     JQ("#jform_client").val(nameCustomer);
     //JQ("#userName").val(user);
     JQ("#idUser_hidden").val(idUserJoomla);     
     SqueezeBox.close();
}
                       
JQ(document).ready(function() {
    JQ('#dateO').attr('readonly', true);    
    JQ('#dateR').attr('readonly', true);    
    JQ('#dateD').attr('readonly', true);    
}); 

//Validar campos utilizando libreria jquery
//Joomla.submitbutton = function(task)
//{    
//        
//        var action = task.split('.');
//        if(action[1] != 'cancel' && action[1] != 'close')
//        {
//            //var idUserJoomla = JQ('#idUser_hidden').val();            
//            //var isValid = JQ("#adminForm").valid();
//            var isValid = true;
//            
//            //if(isValid && idUserJoomla!=''){                
//            if(isValid){                
//                //Joomla.submitform(task, document.getElementById('adminForm'));                     
//                Joomla.submitform(task);
//                return true;
//            }
//            else
//            {
//                return false;
//            }    
//        }else{
//            var idUrl = JQ('#no_order').val();
//             JQ.ajax({   
//                type: 'POST',
//                url: 'index.php?option=com_lapoblana&task=order.checkOrderNumInDetails',                                
//                data: {orderNum: idUrl},                    
//                beforeSend: function(){            
//                },
//                success: function(html){       
//                    var result = JQ(html).find('response').html();                                            
//                                        
//                    alert(result);  
//                    var r =confirm("Estas seguro de querer cancelar la operacion, si lo hace se perdera la orden");
//                        if(r==true){
//                            alert('Borrar orden');
//                        }else{
//                            alert('No borrar orden');
//                        }                    
//                }
//            });
//            
//            Joomla.submitform(task);
//            return true;            
//            
//        }                   
//}


//window.onbeforeunload = function(e) {
//    //consulta para saber si ya existe el numero de orden en db
//    
//    //return 'Dialog text here.';
//};


Joomla.submitbutton = function(task)
{    
        if (task == '')
        {
                return false;
        }
        else
        {
                var idOrder = JQ("#idOrder").val();                                                        
                
                var isValid=true;
                var action = task.split('.');
                if (action[1] != 'cancel' && action[1] != 'close')
                {
                        var forms = $$('form.form-validate');
                        for (var i=0;i<forms.length;i++)
                        {
                                if (!document.formvalidator.isValid(forms[i]))
                                {
                                        isValid = false;
                                        break;
                                }
                        }
                        
                        if (isValid)
                        {
                            if(idOrder!=''){                        
                                var check = retornExistRows();
                                //alert(check);
                               if(check==true){                                    
                                    Joomla.submitform(task);
                                    return true;  
                               }else{                                    
                                   var r =confirm("Antes de salir debe crear al menos un detalle de orden, si presiona aceptar se cancelara la orden");
                                   if(r==true){                                
                                       deleteOrderByOrderID(idOrder,task);                                         
                                   }                                   
                               }                                                                                    
                               return false;
                           }else{
                               Joomla.submitform(task);
                               return true;                        
                           }                            
                        }
                        else
                        {                               
                                return false;
                        }

                }else{                                        
                    if(idOrder!=''){                        
                         var check = retornExistRows();
                         //alert(check);
                        if(check==true){                                    
                             Joomla.submitform(task);
                             return true;  
                        }else{                                    
                            var r =confirm("Antes de salir debe crear al menos un detalle de orden, si presiona aceptar se cancelara la orden");
                            if(r==true){                                
                                deleteOrderByOrderID(idOrder,task);                                         
                            }                                   
                        }                                                                                    
                        return false;
                    }else{
                        Joomla.submitform(task);
                        return true;                        
                    }
                }
 
                
        }
}

function deleteOrderByOrderID(idUrl,task){
    JQ.ajax({   
        type: 'POST',
        url: 'index.php?option=com_lapoblana&task=order.deleteOrderByOrderID',                                
        data: {orderId: idUrl},                    
        beforeSend: function(){            
        },
        success: function(html){       
            var result = JQ(html).find('response').html();
            Joomla.submitform(task);
            return true;  
        }
    });  
}

function retornExistRows()
{
        var _mastertable = productsOrderGrid.getMasterTable();
        var _rows = _mastertable.getRows();
        var _first_row = _rows[0];
        
        if(_first_row != undefined) {
            check = true;
        }else{
            check = false;
        }
        
        return check;
}