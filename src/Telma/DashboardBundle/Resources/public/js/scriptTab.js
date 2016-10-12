 /*
 $( function() {
   
    $('.my-selector').collection({
        allow_add: false,
        allow_remove: false
    });
    $( ".my-selector" ).sortable({
            update: function(event, ui){
                var list = $(".my-selector");
                var pos = 0;
                $(list.find("tr")).each(function(){
                    pos++;
                   $(this).find(".positionInput").val(pos);
                });
            }
    });
    $(".resizable").resizable();
    
    
  } );
  */
  $("document").ready(function(){
     var tableList = $(".my-selector");
     var totalMaxHost = 0;
     var totalConfig = 0;
     var nombreOffre = 0;
     $(tableList.find("tr")).each(function(){
         totalMaxHost += toValidInt($(this).find("td .maxHost").val());
         totalConfig += toValidFloat($(this).find("td .configCalulee").val());
         nombreOffre++;
         
     });
     
     $(".total").find("p").each(function(){
         $(this).find(".host").val(totalMaxHost);
         $(this).find(".config").val(totalConfig);
         $(this).find(".offers").val(nombreOffre);
     });
  });
  
  $("document").ready(function(){
      console.log("event change ok");
     $(".calcul").keyup(calculerParHost);
     $(".configCalulee").keyup(calculerParConfig);
  });

function calculerParConfig(){
    var maxHost = $(this).parent().parent().find("td .maxHost");
    var maxbd = $(this).parent().parent().find("td .debitMax");
    var minbd = $(this).parent().parent().find("td .debitMin");
    var maxoff = $(this).parent().parent().find("td .debitMG");
    var minobt = $(this).parent().parent().find("td .debitMinObtenu");
    var taux = $(this).parent().parent().find("td .taux");
    var configCalculee = $(this);
    if(isNaN($(configCalculee).val()))
    {
        $(taux).val(0);
        $(minobt).val(0);   
    }
    else
    {
        $(taux).val((($(configCalculee).val() * 1024)/$(maxHost).val())/parseFloat($(minbd).val()));
        $(minobt).val(($(configCalculee).val() / $(maxHost).val())*1024);
    }
}
function calculerParHost(){
    console.log("calcul par host");
    var maxHost = $(this).text();
    var maxbd = $(this).parent().parent().find("td .debitMax");
    var minbd = $(this).parent().parent().find("td .debitMin");
    var maxoff = $(this).parent().parent().find("td .debitMG");
    var minobt = $(this).parent().parent().find("td .debitMinObtenu");
    
    var configCalculee = (parseFloat($(minbd).val()) * parseFloat(maxHost))/1024;
    if(isNaN(configCalculee))
    {
        //$(this).parent().parent().find("td .configCalulee").val(0);
        $(this).parent().find("td .configCalulee").val(0);
        //$(this).parent().parent().find("td .taux").val(0);
    }
    else
    {
        //$(this).parent().parent().find("td .configCalulee").val(configCalculee);
        $(this).parent().find("td .configCalulee").val(configCalculee);
        //$(this).parent().parent().find("td .taux").val(((configCalculee * 1024)/$(maxHost).val())/parseFloat($(minbd).val()));
        //$(minobt).val((configCalculee / $(maxHost).val())*1024);
    }
}
function toValidInt(number){
    var b = parseInt(number);
    if(isNaN(b))
    {
        return 0;
    }
    else{
        return b;
    }
}
function toValidFloat(num){
    var c = parseFloat(num);
    if(isNaN(c))
    {
        return 0;
    }
    else{
        return c;
    }
}