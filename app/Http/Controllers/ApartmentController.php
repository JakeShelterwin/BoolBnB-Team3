<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Apartment;
use App\Service;
use App\Message;
use App\View;
use Carbon\Carbon;
use Treffynnon\Navigator as N;
class ApartmentController extends Controller
{
  // ----------------------------------------------------------------
  // -- PAGINA INIZIALE CHE MOSTRA SOLO APPARTAMENTI SPONSORIZZATI --
  // ----------------------------------------------------------------
    public function index(){
      $apartments = Apartment::all() -> where('is_active', 1) -> where('sponsor_expire_time', '>=', time());
      $services = Service::all();
      return view('welcome', compact("apartments", "services"));
    }

    // ----------------------------------------------------------------
    // -------- PAGINA CHE MOSTRA L'APPARTAMENTO SELEZIONATO ----------
    // ----------------------------------------------------------------

    // -> GESTISCE LE VISUALIZZAZIONI: SE LO STESSO IP HA VISTO LA PAGINA ENTRO 2 ORE,
    //    CONTEGGIA UNA SOLA VISUALIZZAZIONE
    public function showApartment($id){
      $apartment = Apartment::findOrFail($id);
      $allView = View::all();

      // ------------ GESTIONE VISUALIZZAZIONI ------------
      // mi seleziono l'ultima view salvata appartenente all'ip dell'utente che clicca per un dato appartamento
      $lastViewIP = $allView -> where('ip', \Request::getClientIp()) -> where('apartment_id', $id) -> last() ;

      // mi salvo la data completa di questa view e ci aggiungo il limite temporale di 2 ore
      // risorsa usata: https://stackoverflow.com/questions/1124752/add-13-hours-to-a-timestamp
      $expiredViewTime = date( "Y-M-d H:i:s", strtotime( $lastViewIP["created_at"] ) + 2 * 3600 );

      // mi salvo la data completa attuale
      $now = date( "Y-M-d H:i:s", strtotime( Carbon::now()));

      // se l'ultima view + 2 ore, è minore dell'orario attuale, salva nuovamente la view. Altrimenti mostra la pagina dell'appartamento e basta
      if ($expiredViewTime<$now) {
        // risorsa usata: https://stackoverflow.com/questions/45422497/counting-page-views-with-laravel
        $apartment = Apartment::findOrFail($id);
        $apartmentViews= new View();
        $apartmentViews->apartment_id = $apartment -> id;
        $apartmentViews->url = \Request::url();
        $apartmentViews->session_id = \Request::getSession()->getId();
        $apartmentViews->user_id = (\Auth::check())?\Auth::id():null;
        $apartmentViews->ip = \Request::getClientIp();
        $apartmentViews->agent = \Request::header('User-Agent');
        $apartmentViews->save();
      }

      // ------------ SPONSOR ------------
      // controlla se l'appartamento ha uno sponsor attivo
      $sponsorAttivo = 0;
       if ($apartment['sponsor_expire_time'] >= time()) {
         $sponsorAttivo = 1;
       }
      return view('showApartment', compact("apartment", "sponsorAttivo"));
    }

    // ----------------------------------------------------------------
    // ---------------- SALVATAGGIO IN DB DEI MESSAGGI ----------------
    // ----------------------------------------------------------------
    public function storeMessage(Request $request, $id){
      $validateData = $request -> validate([
        'email' => 'required | email',
        'message' => 'required | string'
      ]);

      $message = new Message;
      $message -> email = $validateData['email'];
      $message -> message = $validateData['message'];
      $message -> apartment_id = $id;

      // Per evitare che l'utente salvi "inavvertitamente" più messaggi identici cliccando più volte
      // nel pulsante submit, confrontiamo la data del suo ultimo messaggio con l'attuale
      $lastMessageEmail = Message::all() -> where('email', $validateData['email']) -> last();
      $now = date( "Y-m-d H:i:s", strtotime( Carbon::now()));
      $lastMessageEmailCreatedTime = date( "Y-m-d H:i:s", strtotime( $lastMessageEmail["created_at"]) + 10); // 10 secondi dall'ultimo messaggio

      if($now >= $lastMessageEmailCreatedTime){ // se sono passati 10 secondi dall'ultimo messaggio
        $message -> save();
        return redirect() -> route("showApartment", $id)
                          -> withSuccess("Messaggio inviato correttamente");
      }else{
        return redirect() -> route("showApartment", $id)
                          -> withErrors("Messaggio precedente inviato correttamente. Per inviare altri messaggi attendere qualche secondo.");
      }
    }


    // ----------------------------------------------------------------
    // ---------------- RICERCA APPARTAMENTO  -------------------------
    // ----------------------------------------------------------------
    public function searchApartments(Request $request){
      $apartments = Apartment::all() -> where('is_active', 1)  -> where('beds_n', ">=", $request['beds_n'])-> where('rooms_n', ">=", $request['rooms_n']);
      $services = Service::all();
      $query = $request['address'];
      $lat = $request['lat'];
      $lon = $request['lon'];
      $radius = $request['radius'];
      $selectedServices = $request['services'];
      $numberOfBeds = $request['beds_n'];
      $numberOfRooms = $request['rooms_n'];
      $selectedApartments = $apartments;

      // GESTIONE SELEZIONE APPARTAMENTI IN BASE AI SERVIZI SCELTI DALL'UTENTE
      // funzione che controlla che tutti i valori di arrayA siano dentro dentro arrayB: https://stackoverflow.com/questions/7542694/in-array-multiple-values
      function in_array_all($arrayA, $arrayB) {
         return empty(array_diff($arrayA, $arrayB));
      }

      // Se l'utente ha dei servizi selezionati, selezioniamo solo gli appartamenti che hanno quei servizi
      if ($selectedServices) {
        // prepariamo un array dove salvarsi gli appartamenti selezionati
        $selectedApartments = [];
        // per ogni appartamenti nel DB
        foreach ($apartments as $apartment) {
          // salviamo in un array i servizi dell'appartamento
          $apartmentServices = $apartment -> services;
          // prepariamo array per salvare i servizi scelti dall'utente
          $arrayApartmentServices = [];
          foreach ($apartmentServices as $service) {
            $arrayApartmentServices[] = $service->name;
          }
          // usando la funzione dichiara prima, controlliamo che l'array che contiene i servizi selezionati dall'utente sia completamente contenuto nell'array dei servizi dell'appartamento, se questo e' vero l'appartamento viene salvato
          if (in_array_all( $selectedServices, $arrayApartmentServices )){
            $selectedApartments[] = $apartment;
          }
        }
      }

      // gestione selezione appartamenti in base raggio di km scelto dall'utente
      // se l'utente non sceglie nulla, allora il raggio è automaticamente 20km da frontend. Se sceglie 0 il raggio è 1km
      if($request['radius']){
          $radius = $request['radius'] * 1000;
      } else {
          $radius = 20000;
      }

      $selectedApartmentsBasedOnLocation = [];
      // FONTE LIBRERIA per il calcolo della distanza fra 2 punti sul globo https://github.com/treffynnon/Navigator
      // selectedApartments è uguale ad Apartments:all() se non sono stati selezionati servizi, altrimenti corrisponde agli appartamenti già selezionati in base ai servizi
      foreach ($selectedApartments as $apartment) {
        $distance = N::getDistance($lat, $lon, $apartment['lat'], $apartment['lon']);
        if($distance <= $radius){
          // salvo come chiave dell'array associativo la distanza calcolata, e come valore l'appartamento
          $selectedApartmentsBasedOnLocation[$distance] = $apartment;
        }
      }

      $sponsoredApartment = [];
      foreach ($selectedApartmentsBasedOnLocation as $apartment) {
        if($apartment['sponsor_expire_time'] >= time()){
          $sponsoredApartment[] = $apartment;
        }
      }

      // ordina l'array associativo in base alla KEY, siccome la key è la distanza gli appartamenti saranno inseriti dal più vicino (alle coordinate inserite) al più lontano
      ksort($selectedApartmentsBasedOnLocation);

      // se non esistono appartamenti per la selezione corrente, restituisci un array vuoto
      //se invece esistono, allora restituiscili
      $selectedApartmentsFilteredByUser=[];
      if ($selectedApartmentsBasedOnLocation) {
        $selectedApartmentsFilteredByUser = $selectedApartmentsBasedOnLocation;
      }
      return view("searchApartments", compact("sponsoredApartment", 'selectedApartmentsFilteredByUser', "services","selectedServices", 'query', "numberOfBeds", "numberOfRooms" ));
    }
}
