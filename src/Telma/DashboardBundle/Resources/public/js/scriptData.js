
$("document").ready(function () {
    console.log("Loading scriptData ok");
    
    $('.my-selector').collection({
        drag_drop : false,
    });
   
   //La liste dans le tableau
    var selector = $(".my-selector");
    
    //Fonction qui alimente les lignes du tableau
    $(selector.find("tr")).each(function(){
        // Find classe ( input , affichage , valeur)       
        $(this).find("td").each(function(){
           var td = $(this);
           var input = $(this).next();
           if($(input).attr("class") !== "positionInput input_edit input-sm")
           {
               $(td).append($(input).val());
           }
           
        });
    });

    $(".td-maxHost").keyup(calculerParHost);
    $(".td-configCalculee").keyup(calculerParConfig);
    
    $("#edit_save").click(function(){ 
          var collect = $(".my-selector");
          var pos = 0;
          $(collect.find("tr")).each(function(){
            $(this).find(".positionInput").val(pos);
            console.log(pos);
            pos++;
            }); 
   });

});

$("document").ready(function(){
    $(".input-total").focus(function(){
        if ($(".info-total").is(":hidden")){
            $(".info-total").toggle("slow");
        }
    });
});


function saveContent(edited){
    var recu = $(edited).text();
    $(edited).next().val(recu);
}

function calculerParHost(){  
    var maxHost = $(this).text();
    var maxbd = $(this).parent().find(".debitMax");
    var minbd = $(this).parent().find(".debitMin");
    var maxoff = $(this).parent().find(".debitMG");
    var minobt = $(this).parent().find(".debitMinObtenu");
    var taux = $(this).parent().find(".taux");
    var cc = $(this).parent().find(".configCalulee");

    var configCalculee = (parseFloat($(minbd).val()) * parseFloat(maxHost))/1024;

    var taux_calcule = ((configCalculee * 1024)/maxHost)/$(minbd).val();
    
    var minobt_calcule = Math.round(((configCalculee / maxHost)*1024)* 10)/10;
    
    var maxoff_calcule = (maxHost * $(maxbd).val())/1024;
    
    if(isNaN(configCalculee) || isNaN(maxHost))
    {
        $(cc).val(0);
        $(cc).prev().val(0);        
        
        $(taux).val(0);
        $(taux).prev().text(0);
        
        $(minobt).val(0);
        $(minobt).prev().text(0);
        
        $(maxoff).val(0);
        $(maxoff).prev().text(0);
    }
    else
    {
        $(cc).val(configCalculee);
        $(cc).prev().text(configCalculee);
        
        $(taux).val(taux_calcule);
        $(taux).prev().text(taux_calcule);
        
        $(minobt).val(minobt_calcule);
        $(minobt).prev().text(minobt_calcule);
        
        $(maxoff).val(maxoff_calcule);
        $(maxoff).prev().text(maxoff_calcule);
    }
}

function calculerParConfig(){
    var maxHost = $(this).parent().find(".maxHost");;
    var maxbd = $(this).parent().find(".debitMax");
    var minbd = $(this).parent().find(".debitMin");
    var maxoff = $(this).parent().find(".debitMG");
    var minobt = $(this).parent().find(".debitMinObtenu");
    var taux = $(this).parent().find(".taux");
    var cc = $(this).text();

    var taux_calcule = Math.round(((cc * 1024)/$(maxHost).val())/$(minbd).val()*10)/10;
    
    var minobt_calcule = Math.round((((cc / $(maxHost).val()))*1024)* 10)/10;
    
    var maxoff_calcule = (($(maxHost).val()) * $(maxbd).val())/1024;
    
    if(isNaN(cc))
    {
        $(taux).val(0);
        $(taux).prev().text(0);
        
        $(minobt).val(0);
        $(minobt).prev().text(0);
        
        $(maxoff).val(0);
        $(maxoff).prev().text(0);
    }
    else
    {
        $(taux).val(taux_calcule);
        $(taux).prev().text(taux_calcule);
        
        $(minobt).val(minobt_calcule);
        $(minobt).prev().text(minobt_calcule);
        
        $(maxoff).val(maxoff_calcule);
        $(maxoff).prev().text(maxoff_calcule);
    }
}



function loadData() {
        console.log("Champ séléctionné");
            $.ajax({
                type: 'GET',
                url:Routing.generate('telma_dashboard_getdata'),
                beforeSend: function () {
                    console.log("Avant l'envoi");
                },
                success: function(data){
                    var offres = data.offres;
                    $(offres).each(function(){
                       console.log(this);
                    });
                },
                errors: function() {
                    console.log("Error");
                }
            });

    }
    