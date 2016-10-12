$("document").ready(function(){
  /* $(".my-selector-entete").collection({
       drag_drop : true
   });*/
   
   $(".my-selector-entete").sortable({
       update: function(event, ui){
                var list = $(".my-selector-entete");
                var pos = 0;
                $(list.find("tr")).each(function(){
                    $(this).find(".position").val(pos);
                    pos++;
                });
            }
   });
   
   $("#head_save").click(function(){ 
          var collect = $(".my-selector-entete");
          var pos = 0;
          $(collect.find("tr")).each(function(){
            $(this).find("td .position").val(pos);
            console.log(pos);
            pos++;
            }); 
   });
   
   $(".is_used").click(function(){
       if($(this).is(':checked')){
           $(this).parent().parent().parent().parent().addClass(" unused ");
       }
       else{
           $(this).parent().parent().parent().parent().removeClass(" unused ");
       }
       
   });
});
