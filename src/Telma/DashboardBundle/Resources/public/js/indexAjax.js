$("document").ready(function () {
    console.log("Loading page ok");
   
    //$(".afterRef").toggle();
    $(".ref").change(loadReg);

});

function loadReg(){
    console.log("Champ séléctionné");
    
    //if($(".reg").val() === null)
      //  {
            $.ajax({
                type: 'get',
                url:Routing.generate('telma_dashboard_getRegion', {'reference' : $(this).val()}),
                beforeSend: function () {
                    console.log("Avant l'envoi");
                    $(".ref").parent().parent().append('<div class="col-sm-1 loading"></div>');
                },
                success: function(data){   
                    
                    if($(".afterRef").is(":hidden"))
                    {
                        $(".afterRef").toggle("slow");
                    }
                    else
                    {
                        $('.reg').find("option").each(function(){
                            $(this).remove();
                        });
                    }
                    jQuery.each(data.regions, function(index, value){
                        $('<option value="' + value + '">' + value + '</option>').prependTo($(".reg"));
                    });
                    $(".loading").remove();
                },
                errors: function() {
                    console.log("Error");
                }
            });
            
        //}
}