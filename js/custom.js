var busy = false;
var limit = 12
var offset = 0;

function displayRecords(lim, off) {
    $.ajax({
      type: "GET",
      async: false,
      url: "represent.php",
      data: "limit=" + lim + "&offset=" + off,
      cache: false,
      beforeSend: function() {
        $('#loader_image').show();
    },
    success: function(html) {
        $("#results > .row").append(html);
        $('#loader_image').hide();
      window.busy = false;
  }
});
} 

$(document).ready(function(){

if (busy == false) {
  busy = true;
  // start to load the first set of data
  displayRecords(limit, offset);
}

$(window).scroll(function() {
          // make sure u give the container id of the data to be loaded in.
          var rowCount = $(".row").children().length;
          var scrollRemain = $("#results").height() - $(window).scrollTop() ;
          console.log ('Remaining Pixels = '+ scrollRemain);
          if ( scrollRemain < 1000 && !busy) {
            busy = true;
            offset = limit + offset;
            displayRecords(limit, offset);
            var rowCount = $(".row").children().length;
            console.log("Row Count "+ rowCount);
        }
    });


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
        $(this).closest('.jobCards').hide('slow');
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
