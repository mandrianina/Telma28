/**
 * Created by mamy on 05/09/2016.
 */
$("document").ready(function () {
    console.log("Loading page ok");
   
    $(".nom").change(loadContenu);

});
function loadContenu() {
        console.log("Champ séléctionné");

      //  if($(".contenu").val().length === 0 || $(".alias").val().length === 0)
       // {

            $.ajax({
                type: 'POST',
                url:Routing.generate('telma_dashboard_getcontenu'),
                data : 'nom='+ $(this).val(),
                beforeSend: function () {
                    console.log("Avant l'envoi");
                },
                success: function(data){
                    $(".contenu").val(data.contenu);
                    $(".alias").val(data.alias);
                },
                errors: function() {
                    console.log("Error");
                }
            });
       // }
    }
function saveTextAsFile() {
                var textToWrite = document.getElementById('textearea').value;
                var textFileAsBlob = new Blob([textToWrite], {
                    type: 'text/plain'
                });
                var fileNameToSaveAs = "policy.txt";

                var downloadLink = document.createElement("a");
                downloadLink.download = fileNameToSaveAs;
                downloadLink.innerHTML = "Download File";
                if (window.webkitURL != null) {
                    // Chrome allows the link to be clicked
                    // without actually adding it to the DOM.
                    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
                } else {
                    // Firefox requires the link to be added to the DOM
                    // before it can be clicked.
                    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
                    downloadLink.onclick = destroyClickedElement;
                    downloadLink.style.display = "none";
                    document.body.appendChild(downloadLink);
                }

                downloadLink.click();
            }

function destroyClickedElement(event) {
                // remove the link from the DOM
        document.body.removeChild(event.target);
}
    
