require('chart.js');
require('./bootstrap');

$(document).ready(function(){
    console.log("js collegato");
      // questo if gestisce il modo in cui ci ricaviamo le coordiante dato un indirizzo.
      //Nel caso in cui l'utente commetta errori e dunque la pagina si ricarichi (non perdendo i valori grazie a old()) l'ajax viene richiamato in automatico su quei valori.
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
              $("input[name=lat]").val(lat);
              $("input[name=lon]").val(lon);
              $("#bottoneCreate").prop("disabled", false);
            },
            error : function (richiesta,stato,errori) {
              console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
            }
      });
      }

      // Nel caso in cui l'indirizzo non sia stato ancora inserito allora si attende che l'utente abbia finito di scriverlo e quando il focus esce dall'input viene richiamato l'ajax che ottiene le coordinate.
      $(".info").on("blur", "input[name=address]", function(){
          var input = $("input[name=address]").val();
          console.log("funziona o no");
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
                  $("input[name=lat]").val(lat);
                  $("input[name=lon]").val(lon);
                  $("#bottoneCreate").prop("disabled", false);
                }

              },
              error : function (richiesta,stato,errori) {
                console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
              }
        });
      })

      // TEST PER DISABILITARE IL BOTTONE APPENA VIENE LICCATO PER EVITARE IL SALVATAGGIO DI DUPLICATI DI APPARTAMENTI
      // Se il bottone è attivo, appena ci clicco sopra si disattiva (evito doppio click)
      // if ($("#bottoneCreate").prop("disabled", false)) {
      //   $(".info").on("dblclick", "#bottoneCreate", function(){
      //     $("#bottoneCreate").prop("disabled", true);
      //   });
      // }

      // TEST PER ORDINARE CRONOLOGICAMENTE I MESSAGGI
      // $('.messages .card').sort(function(a,b) {
      //     console.log("ciclo");
      //    return $(a).data('time') > $(b).data('time');
      // }).appendTo('.messages');



      // GUIDA TOM TOM https://developer.tomtom.com/maps-sdk-web-js/tutorials-use-cases/map-marker-tutorial
      if($('#map').length){ // se esiste nella pagina il div con id "map"
        var currentApartment = [$("#longitude").val(), $("#latitude").val()];
        var map = tt.map({
                  container: 'map',
                  key: 'GqqMbjtoswnKOW5HbgKmS6sLaqEXL7pl',
                  style: 'tomtom://vector/1/basic-main',
                  center: currentApartment,
                  zoom: 18
              });
        var marker = new tt.Marker().setLngLat(currentApartment).addTo(map);
        var popupOffsets = {
          top: [0, 0],
          bottom: [0, -70],
          'bottom-right': [0, -70],
          'bottom-left': [0, -70],
          left: [25, -35],
          right: [-25, -35]
        }

        var popup = new tt.Popup({offset: popupOffsets}).setHTML("<p>" + $(".info #title").text() + "</p>" + $(".address p").text());
        marker.setPopup(popup).togglePopup();
      }



      if ($('#charts').length) {
        //ricevo dati dall' HomeController@showApartmentStatistics
        var viewsMonths = statistics.viewsMonths;
        var views = statistics.viewsCount;
        var messagesMonths = statistics.messagesMonths;
        var messages = statistics.messagesCount;

        // sommo le visualizzazioni e i messaggi
        var viewsTotalsCounter = views.reduce((a, b) => a + b, 0);
        var messagesTotalsCounter = messages.reduce((a, b) => a + b, 0);
        $('#charts .visualizzazioni h2').append("<br>" + viewsTotalsCounter + " totali");
        $('#charts .messaggi h2').append("<br>" + messagesTotalsCounter + " totali");

        //creo i grafici
        var months = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre']
        createCharts('#viewsStatsBar', 'bar', 'Visualizzazioni Appartamento', months, views);
        createCharts('#viewsStatsLine', 'line', 'Visualizzazioni Appartamento', months, views);
        createCharts('#messagesStatsBar', 'bar', 'Messaggi Ricevuti', months, messages);
        createCharts('#messagesStatsLine', 'line', 'Messaggi Ricevuti', months, messages);

    }

    // FUNZIONE CHE CREA GRAFICI
    function createCharts(idHtml, type, titleOfGraph, months,data){
      var ctx = $(idHtml);
      var graph = new Chart(ctx, {
          type:  type,
          data: {
              labels: months,
              datasets: [{
                  label: titleOfGraph,
                  data: data,
                  backgroundColor: [
                    'rgba(150, 33, 146, 0.2)',
                    'rgba(82, 40, 204, 0.2)',
                    'rgba(4, 51, 255, 0.2)',
                    'rgba(0, 146, 146, 0.2)',
                    'rgba(0, 249, 0, 0.2)',
                    'rgba(202, 250, 0, 0.2)',
                    'rgba(255, 251, 0, 0.2)',
                    'rgba(255, 199, 0, 0.2)',
                    'rgba(255, 147, 0, 0.2)',
                    'rgba(255, 80, 0, 0.2)',
                    'rgba(255, 38, 0, 0.2)',
                    'rgba(216, 34, 83, 0.2)'
                  ],
                  borderColor: [
                      'rgba(150, 33, 146, 1)',
                      'rgba(82, 40, 204, 1)',
                      'rgba(4, 51, 255, 1)',
                      'rgba(0, 146, 146, 1)',
                      'rgba(0, 249, 0, 1)',
                      'rgba(202, 250, 0, 1)',
                      'rgba(255, 251, 0, 1)',
                      'rgba(255, 199, 0, 1)',
                      'rgba(255, 147, 0, 1)',
                      'rgba(255, 80, 0, 1)',
                      'rgba(255, 38, 0, 1)',
                      'rgba(216, 34, 83, 1)'
                  ],
                  lineTension: 0,
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
      });
    }

  $("#btnQuery").bind("click", function () {
    var input = $("#ricerca").val();
    $.ajax({
        url : "https://api.tomtom.com/search/2/geocode/"+input+".json?",
        data: {
          "key": "GqqMbjtoswnKOW5HbgKmS6sLaqEXL7pl",
        },
        method : "GET",
        success : function (data) {

          // $(".address p").remove();

          if (data["results"].length === 0){
            // $("#bottoneCreate").prop("disabled", true);
            // $(".address").append("<p style='color: red'>Indirizzo non riconosciuto</p>")
          } else {
            var lat = data["results"][0]["position"]["lat"];
            var lon = data["results"][0]["position"]["lon"];

            // var querystring = "?search=" + input + "&lat=" + lat + "&lon=" + lon;
            //
            // var url = "searchApartments/" + querystring;
            // window.location.href = url;
          }

        },
        error : function (richiesta,stato,errori) {
          console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
        }
      });
  });
  // $('#searchbar').val()
  
});
