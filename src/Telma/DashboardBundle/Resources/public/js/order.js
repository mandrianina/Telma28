$("document").ready(function() {
   //$(".offres").sortable({handle: ".handle"});
   $(".offres").sortable({
       update: function(event,ui){
           var list = $(".offres");
           var pos = 0;
           $(list.find("tr")).each(function(){
               pos++;
               console.log(pos);
               $(this).find("td").each(function(){
                   $(this).find('input.positionInput').val(pos);
               });
           });
           
       }
   });
});