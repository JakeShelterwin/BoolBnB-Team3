require('chart.js');
require('./bootstrap');

$(document).ready(function(){
    console.log("js collegato");
      // questo if gestisce il modo in cui ci ricaviamo le coordiante dato un indirizzo.
      //Nel caso in cui l'utente commetta errori e dunque la pagina si ricarichi (non perdendo i valori grazie a old()) l'ajax viene richiamato in automatico su quei valori.
      var withAddress = 0;
      if ($("input[name=address]").val()) {
        var input = $("input[name=address]").val();
        $.ajax({
            // url : "https://api.tomtom.com/search/2/geocode/"+input+".json?",
            url : "https://api.tomtom.com/search/2/search/"+input+".json?",
            data: {
              "key": "GqqMbjtoswnKOW5HbgKmS6sLaqEXL7pl",
              "countrySet" : "IT"
            },
            method : "GET",
            success : function (data) {
              var lat = data["results"][0]["position"]["lat"];
              var lon = data["results"][0]["position"]["lon"];
              $("input[name=lat]").val(lat);
              $("input[name=lon]").val(lon);
              withAddress = 1;
              $("#bottoneCreate").prop("disabled", false);
            },
            error : function (richiesta,stato,errori) {
              console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
            }
      });
      }

      // Nel caso in cui l'indirizzo non sia stato ancora inserito allora si attende che l'utente abbia finito di scriverlo e quando il focus esce dall'input viene richiamato l'ajax che ottiene le coordinate.
      $(".info").on("keyup", "input[name=address]", function(){
          var input = $("input[name=address]").val();
          $("input[name=lat]").val(null);
          $("input[name=lon]").val(null);
          $.ajax({
              // url : "https://api.tomtom.com/search/2/geocode/"+input+".json?",
              url : "https://api.tomtom.com/search/2/search/"+input+".json?",
              data: {
                "key": "GqqMbjtoswnKOW5HbgKmS6sLaqEXL7pl",
                "countrySet" : "IT"
              },
              method : "GET",
              success : function (data) {
                // console.log(data);
                //debug
                // console.log(data['results']);
                //rimuovo eventuali p che mostra l'errore
                $(".address p").remove();
                // controllo di riceve almeno un indirizzo valido, se non lo ricevo faccio append di un p che mostra un messaggio d'errore
                // e disattiva il bottone d'invio dati
                // altrimneti valorizzo i campi lat e lon come sopra
                // e attivo il bottone d'invio dati
                if (data["results"].length === 0){
                  $(".address").append("<p style='color: red'>Indirizzo non riconosciuto</p>");
                  $("input[name=lat]").val(null);
                  $("input[name=lon]").val(null);
                  withAddress = 0;
                } else {
                  var lat = data["results"][0]["position"]["lat"];
                  var lon = data["results"][0]["position"]["lon"];
                  $("input[name=lat]").val(lat);
                  $("input[name=lon]").val(lon);
                  // if ($("input[name=lat]").val() && $("input[name=lon]").val()) {
                  withAddress = 1;
                  // }
                }
              },
              error : function (richiesta,stato,errori) {
                console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
              }
        });
      })

      var checkedServices = 0;
      // ascolta che tutti i campi comprese le checkbox siano valorizzati prima di attivare il bottone
      $(".info").on("keyup", ".listen", function(){
        if($("input:checked").length){
          checkedServices = 1;
        }else{
          checkedServices = 0;
        }
        if($("input[name=title]").val() &&
           $("textarea[name=description]").val() &&
           $("input[name=rooms_n]").val() &&
           $("input[name=beds_n]").val() &&
           $("input[name=bathrooms_n]").val() &&
           $("input[name=square_meters]").val() &&
           checkedServices &&
           withAddress){
             console.log(withAddress);
           $("#bottoneCreate").prop("disabled", false);
        }else{
          $("#bottoneCreate").prop("disabled", true);
        }
      });
      // ascolta che almeno una checkbox sia cliccata prima di attivare il bottone
      $(".info").on("change", ".listen", function(){
        if($("input:checked").length){
          checkedServices = 1;
        }else{
          checkedServices = 0;
        }
        if($("input[name=title]").val() &&
           $("textarea[name=description]").val() &&
           $("input[name=rooms_n]").val() &&
           $("input[name=beds_n]").val() &&
           $("input[name=bathrooms_n]").val() &&
           $("input[name=square_meters]").val() &&
           checkedServices &&
           withAddress){
             console.log(withAddress);
           $("#bottoneCreate").prop("disabled", false);
        }else{
          $("#bottoneCreate").prop("disabled", true);
        }
      });

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

        var popup = new tt.Popup({offset: popupOffsets}).setHTML("<p>" + $(".apartment #title").text() + "</p>" + $(".apartment h4").text());
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

          if (data["results"].length === 0){
          } else {
            var lat = data["results"][0]["position"]["lat"];
            var lon = data["results"][0]["position"]["lon"];
          }

        },
        error : function (richiesta,stato,errori) {
          console.log("E' avvenuto un errore. " + errori, "stato " + stato, richiesta);
        }
      });
  });
  // se il div con la classe filtri esiste
  var range;
  $("input[name=radius]").val(20);
  $('.searchField span').text(range);
  if($('.filtri').length){
    // copiati il valore dell'input redius e mettilo nello span
    range = $("input[name=radius]").val();
    $('.searchField span').text(range);

    // ascolta il cambiamento del value e cambia il contenuto dello span
    $("input[name=radius]").change(function() {
      range = $("input[name=radius]").val();
      $('.searchField span').text(range);
    });
    // ogni volta che avviene qualcosa all'input, fai girare l'evento change
    $('input[name=radius]').on('input', function () {
      $(this).trigger('change');
    });

  }
  // al caricamento della pagina di ricerca, automaticamente si seleziona l'input l'indirizzo
  $(".info #ricerca").select();


  // Pulsante che mostra ulteriori filtri nella pagina di ricerca
  $('.searchField').on('click', '#btnFilter', function () {
    $(".filtriNascosti").slideToggle();
  });


  ///////////////////////////////////////////////////////////////////
  ////////  GESTIONE COUNTDOWN APPARTAMENTI SPONSORIZZATI ///////////
  ///////////////////////////////////////////////////////////////////
  function sec2time(timeInSeconds) {
    var pad = function(num, size) {
       return ('000' + num).slice(size * -1);
     },
    time = parseFloat(timeInSeconds).toFixed(3),
    hours = Math.floor(time / 60 / 60),
    minutes = Math.floor(time / 60) % 60,
    seconds = Math.floor(time - minutes * 60)
    if (hours >= 100){
      return pad(hours, 3) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
    } else {
      return pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
    }
  }
  setInterval(function(){
    var allSponsoredApartments = $('.expire'); //in secondi
    var allShowTime = $('.showTime'); // estesa
    for (var i = 0; i < allSponsoredApartments.length; i++) {
      var expire = allSponsoredApartments[i].innerHTML - 1;
      allShowTime[i].innerHTML = sec2time(expire);
      allSponsoredApartments[i].innerHTML = expire;
    }
  }, 1000);

  ///////////////////////////////////////////////////////////////////
  ////////  MOSTRARE IN ORE LA DURATA DEGLI SPONSOR ///////////
  ///////////////////////////////////////////////////////////////////
  function sec2Hours(timeInSeconds) {
    var pad = function(num, size) {
      return ('000' + num).slice(size * -1);
    },
    time = parseFloat(timeInSeconds).toFixed(3),
    hours = Math.floor(time / 60 / 60)
    if (hours >= 100){
      return pad(hours, 3);
    } else {
      return pad(hours, 2);
    }
  }
  var allSponsor = $('.durationSponsor');
  for (var i = 0; i < allSponsor.length; i++) {
    var sponsorTime = allSponsor[i].innerHTML;
    allSponsor[i].innerHTML = sec2Hours(sponsorTime);
  }

  ///////////////////////////////////////////////////////////////////
  /////////////////////////   SLIDER   //////////////////////////////
  ///////////////////////////////////////////////////////////////////
  var myIndex = 0;
  carousel();
    function carousel() {
      var i;
      var x = $(".mySlides");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      if (myIndex >= x.length) {
        myIndex = 0
      }
      x[myIndex].style.display = "block";
      myIndex++;
      setTimeout(carousel, 3000); // Change image every 3 seconds
  }


});
