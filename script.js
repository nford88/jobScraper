$(document).ready(function(){
 $(".hide_class").click(function(){

   var hide_url = $(this).attr('id');
   console.log(hide_url);
   $.ajax({
    context: this,
    type:'POST',
    url:'delete.php',
    data:'url='+hide_url,
    success:function(data) {
      if(data) {
        if ($(this).closest('tr').nextAll(':has(.itemDesc):first').find('.itemDesc').is(":visible")) {
          $(this).closest('tr').nextAll(':has(.itemDesc):first').find('.itemDesc').toggle(); 
        }
        $(this).closest('tr').remove();
      } 
      else { 
        alert("couldnt hide data from table")
      }
    }
  });
 });

$(".descTogg").click(function(){
        $(this).closest('tr').nextAll(':has(.itemDesc):first').find('.itemDesc').toggle();
  
 })
   
 


});