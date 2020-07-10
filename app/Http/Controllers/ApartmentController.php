<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Apartment;
use App\Service;
use App\Message;
use App\View;
use Carbon\Carbon;

class ApartmentController extends Controller
{
    public function index(){
      $apartments = Apartment::all();
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

    public function searchApartments($lat, $lon){
      $apartments = Apartment::all();


      return view('welcome', compact("apartments", ));
    }
}
