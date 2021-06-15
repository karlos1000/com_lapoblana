//var JQ=jQuery.noConflict(); 
var JQ=jQuery.noConflict(true);
function registerInsertAction(){
   alert('registerInsertAction');
}

JQ(document).ready(function(){
  //alert('hola');  
  JQ("#adminForm").validate();         
  JQ('#date1_calendar').removeClass('defaultKCD').addClass('defaultKCD');   
});
