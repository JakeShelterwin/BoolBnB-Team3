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
    public function index(){
      $apartments = Apartment::all() -> where('is_active', 1);
      $services = Service::all();
      return view('welcome', compact("apartments", "services"));
    }
    public function showApartment($id){
      $apartment = Apartment::findOrFail($id);
      // prendo tutte le view
      $allView = View::all();
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
        $apartmentViews->user_id = (\Auth::check())?\Auth::id():null; //this check will either put the user id or null, no need to use \Auth()->user()->id as we have an inbuild function to get auth id
        $apartmentViews->ip = \Request::getClientIp();
        $apartmentViews->agent = \Request::header('User-Agent');
        $apartmentViews->save();//please note to save it at lease, very important
        // return redirect() -> route("showApartment", $id)
        // -> withSuccess("View aggiunta correttamente");
      } else {
          // return redirect() -> route("showApartment", $id)
          //     -> withSuccess("View non salvata per limite orario");
      }
      return view('showApartment', compact("apartment"));
    }
    public function storeMessage(Request $request, $id){
      $validateData = $request -> validate([
        'email' => 'required | email',
        'message' => 'required | string'
      ]);

      $message = new Message;
      $message -> email = $validateData['email'];
      $message -> message = $validateData['message'];
      $message -> apartment_id = $id;

      $message -> save();
      return redirect() -> route("showApartment", $id)
                        -> withSuccess("Messaggio inviato correttamente");
    }


    public function searchApartments(Request $request){
      // preparazione variabili
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

      ///////////////////////////////////////////////////////////////////////////
      // GESTIONE SELEZIONE APPARTAMENTI IN BASE AI SERVIZI SCELTI DALL'UTENTE //
      ///////////////////////////////////////////////////////////////////////////

      // funzione che controlla che tutti i valori fi arrayA siano dentro dentro arrayB: https://stackoverflow.com/questions/7542694/in-array-multiple-values
      function in_array_all($arrayA, $arrayB) {
         return empty(array_diff($arrayA, $arrayB));
      }

      // SE L'UTENTE HA DEI SERVIZI SELEZIONATI, SELEZIONIAMO SOLO GLI APPARTAMENTI CHE HANNO QUEI SERVIZI
      if ($selectedServices) {
        // prepariam un array dove salvarsi gli appartamenti selezionati
        $selectedApartments = [];
        // per ogni appartamenti nel DB
        foreach ($apartments as $apartment) {
          // SALVIAMO IN UN ARRAY I SERVIZI DELL'APPARTAMENTO
          $apartmentServices = $apartment -> services;
          $arrayApartmentServices = [];
          foreach ($apartmentServices as $service) {
            $arrayApartmentServices[] = $service->name;
          }
          // USANDO LA FUNZIONE DICHIARA PRIMA, CONTROLLIAMO CHE L'ARRAY CHE CONTIENE I SERVIZI SELEZIONATI DALL'UTENTE SIA COMPLETAMENTE CONTENUTO NELL'ARRAY DEI SERVIZI DELL'APPARTAMENTO, SE QUESTO E' VERO L'APPARTAMENTO VIENE SALVATO
          if (in_array_all( $selectedServices, $arrayApartmentServices )){
            $selectedApartments[] = $apartment;
          }
        }
      }

      /////////////////////////////////////////////////////////////////////////////
      // GESTIONE SELEZIONE APPARTAMENTI IN BASE RAGGIO DI KM SCELTO DALL'UTENTE //
      /////////////////////////////////////////////////////////////////////////////

      // se l'utente non sceglie nulla, allora il raggio è automaticamente 20km
      if($request['radius']){
          $radius = $request['radius'] * 1000;
        }else{
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
      // ordina l'array associativo in base alla KEY, siccome la key è la distanza gli appartamenti saranno inseriti dal più vicino (alle coordinate inserite) al più lontano
      ksort($selectedApartmentsBasedOnLocation);

      // se non esistono appartamenti per la selezione corrente, restituisci un array vuoto
      //se invece esistono, allora restituiscili
      $selectedApartmentsFilteredByUser=[];
      if ($selectedApartmentsBasedOnLocation) {
        $selectedApartmentsFilteredByUser = $selectedApartmentsBasedOnLocation;
      }
      return view("searchApartments", compact('selectedApartmentsFilteredByUser', "services","selectedServices", 'query', "numberOfBeds", "numberOfRooms" ));

    }

}
