$(document).ready(function(){
  
  $(".button-collapse").sideNav();

  $(".hide_class").click(function(){

   var hide_url = $(this).attr('id');
   $.ajax({
    context: this,
    type:'POST',
    url:'delete.php',
    data:'url='+hide_url,
    success:function(data) {
      if(data) {
        $(this).closest('#jobCards').hide('slow');
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