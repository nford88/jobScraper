$(document).ready(function(){


    $(".apply_button").click(function(){
        var url = $(this).attr('id');
        console.log("clicked");
        $.ajax({
            context: this,
            type:'POST',
            url:'represent.php',
            data:'apply='+url,
            success:function(data) {
              if(data) {
                alert("you've applied for the job!")
            } 
            else { 
                alert("couldnt hide data from table")
            }
        }
    });
        console.log(url);
    }); 




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