JQ(document).ready(function(){                                             
        //Reemplazar evento onclick        
        JQ('#toolbar-delete a').attr('onclick','').unbind('click');
        JQ('#toolbar-delete a').click(function(){                                  
            if (document.adminForm.boxchecked.value==0){
                alert('Please first make a selection from the list');
            }else{ 
                var r=confirm('No es posible eliminar la orden(s), al hacerlo se borrara los productos vinculados, ¿Realmente estás seguro?');
                if (r==true){                                            
                    Joomla.submitbutton('orders.delete');
                }else{                                                          
                    return false;
                }                
            }                                          
         });

 });