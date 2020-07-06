
require('./bootstrap');

$(document).ready(function(){
    console.log("js collegato");
      // questo if gestisce il modo in cui ci ricaviamo le coordiante dato un indirizzo.
      //Nel caso in cui l'utente commetta errori e dunque la pagina si ricarichi (non perdendo i valori grazie a old()) l'ajax viene richiamato in automatico su quei valori.
      // Nel caso in cui l'indirizzo non sia stato ancora inserito allora si attende che l'utente abbia finito di scriverlo e quando il focus esce dall'input viene richiamato l'ajax che ottiene le coordinate.
      if ($("input[name=address]").val()) {
        var input = $("input[name=address]").val();
        $.ajax({
            url : "https://api.tomtom.com/search/2/geocode/"+input+".json?",
            data: {
              "key": "GqqMbjtoswnKOW5HbgKmS6sLaqEXL7pl",
            },
            method : "GET",
            success : function (data) {
              var lat = data["results"][0]["position"]["lat"];
              var lon = data["results"][0]["position"]["lon"];
              var position = data["results"][0]["position"];
              $("input[name=lat]").val(position["lat"]);
              $("input[name=lon]").val(position["lon"]);
              $("#bottoneCreate").prop("disabled", false);
            },
            error : function (richiesta,stato,errori) {
              console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
            }
      });
      } else {
        $(".info").on("blur", "input[name=address]", function(){
            var input = $("input[name=address]").val();

            $.ajax({
                url : "https://api.tomtom.com/search/2/geocode/"+input+".json?",
                data: {
                  "key": "GqqMbjtoswnKOW5HbgKmS6sLaqEXL7pl",
                },
                method : "GET",
                success : function (data) {
                  //rimuovo eventuali p che mostra l'errore
                  $(".address p").remove();
                  // controllo di riceve almeno un indirizzo valido, se non lo ricevo faccio append di un p che mostra un messaggio d'errore
                  // e disattiva il bottone d'invio dati
                  // altrimneti valorizzo i campi lat e lon come sopra
                  // e attivo il bottone d'invio dati
                  if (data["results"].length === 0){
                    $("#bottoneCreate").prop("disabled", true);
                    $(".address").append("<p style='color: red'>Indirizzo non riconosciuto</p>")
                  } else {
                    var lat = data["results"][0]["position"]["lat"];
                    var lon = data["results"][0]["position"]["lon"];
                    var position = data["results"][0]["position"];
                    $("input[name=lat]").val(position["lat"]);
                    $("input[name=lon]").val(position["lon"]);
                    $("#bottoneCreate").prop("disabled", false);
                  }

                },
                error : function (richiesta,stato,errori) {
                  console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
                }
          });
        })
      }

      // TEST PER ORDINARE CRONOLOGICAMENTE I MESSAGGI
      // $('.messages .card').sort(function(a,b) {
      //     console.log("ciclo");
      //    return $(a).data('time') > $(b).data('time');
      // }).appendTo('.messages');
});
