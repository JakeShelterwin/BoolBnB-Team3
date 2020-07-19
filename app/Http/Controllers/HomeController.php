<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Service;
use App\Sponsor;
use App\Apartment;
use App\User;
use App\Message;
use App\View;
use Carbon\Carbon;
use JavaScript;
use Braintree\Transaction;
// file UploadTrait creato da noi dentro la cartella creata da noi Traits per fare l'upload delle immagini
use App\Traits\UploadTrait;

class HomeController extends Controller
{
  use UploadTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

   // ----------------------------------------------------------------
   // ---------------- DASHBOARD UTENTE REGISTRATO -------------------
   // ----------------------------------------------------------------
    public function index()
    {
      $user_id = auth()->user()->id;
      $apartments = Apartment::all() -> where('user_id',$user_id) ;
      $allMessages = Message::all();
      $user_apartments = $apartments -> where('sponsor_expire_time', '<', time());
      $apartmentSponsored = $apartments -> where('sponsor_expire_time', '>=', time());

      // preparo array per conservare i messaggi per ogni appartamento dell'utente
      $users_messages_grouped_by_apartment = [];
      foreach ($apartments as $apartment) {
        $users_messages_grouped_by_apartment[] = $allMessages -> where('apartment_id', $apartment -> id);
      }

      // preparo array dove inserire tutti i messaggi
      $messages = [];
      foreach ($users_messages_grouped_by_apartment as $apartment) {
        foreach ($apartment as $message) {
          $messages[$message["id"]] = $message;
        }
      }
      // ordino al contrario i messaggi, così da mostrare in pagina in testa i più recenti
      krsort($messages);
      return view('home', compact('user_apartments', "apartmentSponsored", 'messages' ));
    }


    // ----------------------------------------------------------------
    // --------------------- CREA APPARTAMENTO  -----------------------
    // ----------------------------------------------------------------
    public function createApartment()
    {
      $services = Service::all();
      return view('createApartment', compact('services'));
    }

    // ----------------------------------------------------------------
    // --------------- SALVA APPARTAMENTO CREATO ----------------------
    // ----------------------------------------------------------------
    public function storeApartment(Request $request){
      $validateData = $request -> validate([
        'title' => 'required | string',
        'image' => 'required | image | mimes:jpeg,png,jpg,gif | max:2048',
        'description' => 'required | string',
        'rooms_n' => 'required | integer | min:1',
        'beds_n' => 'required | integer | min:1',
        'bathrooms_n' => 'required | integer | min:0',
        'square_meters' => 'required | integer | min:4',
        'services' => 'required',
        'address' => 'required | string',
        "lat" => 'required | string',
        "lon" => 'required | string',
        'is_active' => 'required | boolean'
      ]);
      $apartment = new Apartment;
      $apartment -> title = $validateData['title'];
      $apartment -> description = $validateData['description'];
      $apartment -> rooms_n = $validateData['rooms_n'];
      $apartment -> beds_n = $validateData['beds_n'];
      $apartment -> bathrooms_n = $validateData['bathrooms_n'];
      $apartment -> square_meters = $validateData['square_meters'];
      $apartment -> address = $validateData['address'];
      $apartment -> lat = $validateData['lat'];
      $apartment -> lon = $validateData['lon'];
      $apartment -> is_active = $validateData['is_active'];
      $apartment -> user_id = auth()->user()->id;

      // Controlla se un'immagine è stata caricata
      if ($request->has('image')) {
          // Ottieni il file dell'immagine
          $image = $request->file('image');
          // assegna al nome del file il titolo dell'appartamento + il timestamp
          $name = Str::slug($request->input('title'), '-').'_'.time();
          // Cartella salvataggio dell'immagine
          $folder = '/uploads/images/';
          // file Path dove verrà salvata l'immagine
          $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
          // funzione che carica l'immagine
          $this->uploadOne($image, $folder, 'public', $name);
          // assegna all'appartamento l'immagine caricata
          $apartment -> image = $filePath;
      }

      // Per evitare che l'utente salvi "inavvertitamente" più appartamenti identici cliccando più volte
      // nel pulsante submit, confrontiamo la data del suo ultimo appartamento creato con la data attuale
      $lastApartment = Apartment::all() -> where('user_id', auth()->user()->id) -> last();
      $now = date( "Y-m-d H:i:s", strtotime( Carbon::now()));
      $lastApartmentCreatedTime = date( "Y-m-d H:i:s", strtotime( $lastApartment["created_at"]) + 30);

      //se la data dell'ultimo appartamento creato (sommati 30 secondi) è superiore a "adesso"
      // salva l'appartamento, altrimenti no.
      if($now >= $lastApartmentCreatedTime){
        $apartment -> save();
        $apartment -> services() -> sync($validateData['services']);
        return redirect() -> route("showApartment",$apartment['id'])
                          -> withSuccess("Appartamento creato correttamente");
      }else{
        return redirect() -> route("showApartment",$lastApartment['id'])
                          -> withSuccess("Appartamento creato correttamente");
      }
    }

    // ----------------------------------------------------------------
    // -------------- MODIFICA APPARTAMENTO CREATO --------------------
    // ----------------------------------------------------------------
    public function editApartment($id){
      $apartment = Apartment::findOrFail($id);
      $services = Service::all();
      return view('editApartment', compact("apartment", "services"));
    }

    // ----------------------------------------------------------------
    // --------------- SALVA APPARTAMENTO MODIFICATO ------------------
    // ----------------------------------------------------------------
    public function updateApartment(Request $request, $id){
      $validateData = $request -> validate([
        'title' => 'required | string',
        'image' => 'nullable | image | mimes:jpeg,png,jpg,gif | max:2048',
        'description' => 'required | string',
        'rooms_n' => 'required | integer | min:1',
        'beds_n' => 'required | integer | min:1',
        'bathrooms_n' => 'required | integer | min:0',
        'square_meters' => 'required | integer | min:4',
        'services' => 'required',
        'address' => 'required | string',
        "lat" => 'required | string',
        "lon" => 'required | string',
        'is_active' => 'required | boolean'
      ]);
      $apartment = Apartment::findOrFail($id);
      $apartment -> title = $validateData['title'];
      $apartment -> description = $validateData['description'];
      $apartment -> rooms_n = $validateData['rooms_n'];
      $apartment -> beds_n = $validateData['beds_n'];
      $apartment -> bathrooms_n = $validateData['bathrooms_n'];
      $apartment -> square_meters = $validateData['square_meters'];
      $apartment -> address = $validateData['address'];
      $apartment -> lat = $validateData['lat'];
      $apartment -> lon = $validateData['lon'];
      $apartment -> is_active = $validateData['is_active'];

      $oldImage = public_path($apartment -> image);

      // Check if a profile image has been uploaded
      if ($request->has('image')) {
        // Ottieni il file dell'immagine
        $image = $request->file('image');
        // assegna al nome del file il titolo dell'appartamento + il timestamp
        $name = 'apartment'.Str::slug($apartment -> id, '-').'_'.time();
        // Cartella salvataggio dell'immagine
        $folder = '/uploads/images/';
        // file Path dove verrà salvata l'immagine
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        // prima di salvare l'appartamento cancello in locale la vecchia immagine
        File::delete($oldImage);
        // funzione che carica l'immagine
        $this->uploadOne($image, $folder, 'public', $name);
        // assegna all'appartamento l'immagine caricata
        $apartment -> image = $filePath;
      }
      $apartment -> save();
      $apartment -> services() -> sync($validateData['services']);

      return redirect() -> route("showApartment", $id)
                        -> withSuccess("Appartamento ".$validateData["title"]
                            ." aggiornato correttamente");
    }

    // ----------------------------------------------------------------
    // ------------------ CANCELLA APPARTAMENTO -----------------------
    // ----------------------------------------------------------------
    public function deleteApartment($id){
      $apartment = Apartment::findOrFail($id);
      $deleteImage = File::delete(public_path($apartment -> image));
      $apartment -> delete();
      return redirect() -> route("home")
                        -> withSuccess("Appartamento eliminato con successo!");
    }

    // ----------------------------------------------------------------
    // --------------- MOSTRA STATISTICHE APPARTAMENTO ----------------
    // ----------------------------------------------------------------
    public function showApartmentStatistics($apartment_id)
    {
      //soluzione spiegata https://stackoverflow.com/questions/5667888/counting-the-occurrences-frequency-of-array-elements
      // soluzione https://jsfiddle.net/simevidas/bnACW/
      $apartment = Apartment::findOrFail($apartment_id);
      //restituisce array[] con all'interno ogni singola view dell'appartamento
      $views = View::all() -> where('apartment_id', $apartment_id);
      //restituisce array[] con all'interno ogni singolo messaggio per l'appartamento
      $messages = Message::all() -> where('apartment_id', $apartment_id);
      // fra tutti i messaggi prendiamo solo quelli dell'ultimo anno partendo dalla data odierna
      $lessThan1yearOldMessages = [];
      foreach ($messages as $message) {
        if (strtotime($message -> created_at) >= time() - 31536000 ) {
          $lessThan1yearOldMessages[] = $message;
        }
      }
      $messages = $lessThan1yearOldMessages;

      // Gestione delle informazioni per le visualizzazioni
      // fra tutti le visualizzaioni prendiamo solo quelle dell'ultimo anno partendo dalla data odierna
      $viewsFiltered = [];
      foreach ($views as $view) {
        if (strtotime($view -> created_at) >= time() - 31536000 ) {
          $viewsFiltered[] = date( "m",  strtotime( $view -> created_at) );
        }
      }
      $viewsMonths = []; // restituirà l'array con i mesi in ordine
      $viewsCount = []; // restituirà l'array le occorrenze di ciascun mese
      $prev = 0;

      sort($viewsFiltered);
      // Questo ciclo popolerà 2 array: uno conterrà i mesi (da 1 a 12),
      // l'altro, rispettando la posizione degli indici, le viste.
      for ($i = 0; $i < count($viewsFiltered); $i++ ) {
          if ( $viewsFiltered[$i] !== $prev ) {
              $viewsMonths[] = $viewsFiltered[$i];
              $viewsCount[] = 1;
          } else {
              $viewsCount[count($viewsCount) - 1]++;
          }
          $prev = $viewsFiltered[$i];
      }

      // array di appoggio per rispettare le corrispondenze con i mesi dell'anno
      $viewsMonthsFinal = [0,0,0,0,0,0,0,0,0,0,0,0];
      $viewsCountFinal = [0,0,0,0,0,0,0,0,0,0,0,0];

      // iteratore di appoggio
      $index = 0;
      for ($i = 1; $i < count($viewsMonthsFinal)+1; $i++) {
        if (in_array($i, $viewsMonths)) {
          $x = $i-1; // riduciamo di una posizione l'indice per la corrispondenza con i mesi
          $viewsMonthsFinal[$x] = $i;  // ripopolo l'array dei mesi
          $viewsCountFinal[$x] = $viewsCount[$index]; // ripopolo l'array delle visualizzazioni
          $index++;
        }
      }

      // Gestione delle informazioni per i Messaggi
      $messagesFiltered = [];
      foreach ($messages as $message) {
        $messagesFiltered[] = date( "m",  strtotime( $message -> created_at) );
      }
      $messagesMonths = []; // restituirà l'array con i mesi in ordine
      $messagesCount = []; // restituirà l'array le occorrenze di ciascun mese
      $prev = 0;


      sort($messagesFiltered);
      for ($i = 0; $i < count($messagesFiltered); $i++ ) {
          if ( $messagesFiltered[$i] !== $prev ) {
              $messagesMonths[] = $messagesFiltered[$i];
              $messagesCount[] = 1;
          } else {
              $messagesCount[count($messagesCount) - 1]++;
          }
          $prev = $messagesFiltered[$i];
      }

      // array di appoggio per rispettare le corrispondenze con i mesi dell'anno
      $messagesMonthsFinal = [0,0,0,0,0,0,0,0,0,0,0,0];
      $messagesCountFinal = [0,0,0,0,0,0,0,0,0,0,0,0];

      // iteratore di appoggio
      $index = 0;
      for ($i = 1; $i < count($messagesMonthsFinal)+1; $i++) {
        if (in_array($i, $messagesMonths)) {
          $x = $i-1; // riduciamo di una posizione l'indice per la corrispondenza con i mesi
          $messagesMonthsFinal[$x] = $i;  // ripopolo l'array dei mesi
          $messagesCountFinal[$x] = $messagesCount[$index]; // ripopolo l'array dei messaggi
          $index++;
        }
      }

      JavaScript::put([ // questa classe trasferisce i dati al javascript
      'viewsCount' => $viewsCountFinal,
      'messagesCount' => $messagesCountFinal,
      ]);

      return view('showApartmentStatistics', compact('apartment'));
    }

    // ----------------------------------------------------------------
    // --------------------- SPONSOR APPARTAMENTO ---------------------
    // ----------------------------------------------------------------
    public function sponsorApartment($apartment_id){
      $apartment = Apartment::findOrFail($apartment_id);
      $sponsors = Sponsor::all();
      return view('sponsor', compact('apartment', "sponsors"));
    }

    // ----------------------------------------------------------------
    // ---------------------- PAGAMENTO SPONSOR -----------------------
    // ----------------------------------------------------------------
    public function make(Request $request) {
          $apartment_id = $request->input('ApartmentId');
          $apartment = Apartment::findOrFail($apartment_id);
          $sponsors = Sponsor::all();

          $payload = $request->input('payload', false);
          $nonce = $payload['nonce'];

          $sponsorType = $request->input("sponsorType");
          $allWasWell = false;
          $sponsorId = 0;
          foreach ($sponsors as $sponsor) {
            if ($sponsor["name"]==$sponsorType) {
              $duration = $sponsor["duration"];
              $sponsorId = $sponsor["id"];
              $amount = $sponsor["price"];
            }
          }
          $status = Transaction::sale([
            'amount' => 0,
            'paymentMethodNonce' => $nonce,
            'options' => [
              'submitForSettlement' => False
               ]
          ]);

          if ($apartment -> sponsor_expire_time) {
            if ($apartment -> sponsor_expire_time <= time()){
              $apartment -> sponsor_expire_time = time() + $duration;
              $apartment -> save();
              $apartment -> sponsor() -> attach($sponsorId);
              $allWasWell = true;
              $status = Transaction::sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                  'submitForSettlement' => True
                 ]
              ]);
            }
          } else {
            $apartment -> sponsor_expire_time = time() + $duration;
            $apartment -> save();
            $apartment -> sponsor() -> attach($sponsorId);
            $allWasWell = true;
            $status = Transaction::sale([
              'amount' => $amount,
              'paymentMethodNonce' => $nonce,
              'options' => [
                 'submitForSettlement' => True
               ]
            ]);
          }
          return response()->json($status);
      }
}
