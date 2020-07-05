<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Apartment;
use App\User;
use App\Message;
class HomeController extends Controller
{
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
    public function index()
    {
      $apartments = Apartment::all();
      $user_id = auth()->user()->id;
      $messages = Message::all();
      $user_apartments = $apartments -> where('user_id',$user_id);
      $user_messages = [];
      foreach ($user_apartments as $apartment) {
        $user_messages[] = $messages -> where('apartment_id', $apartment -> id);
      }
      return view('home', compact('user_apartments', 'user_messages'));
    }

    public function createApartment()
    {
      $services = Service::all();
      return view('createApartment', compact('services'));
    }

    public function storeApartment(Request $request){
      $validateData = $request -> validate([
        'title' => 'required | string',
        'image' => 'required | string',
        'description' => 'required | string',
        'rooms_n' => 'required | integer',
        'beds_n' => 'required | integer',
        'bathrooms_n' => 'required | integer',
        'square_meters' => 'required | integer',
        'services' => 'required',
        'address' => 'required | string',
        "lat" => 'required | string',
        "lon" => 'required | string',
        'is_active' => 'required | boolean'
      ]);
      $apartment = new Apartment;
      $apartment -> title = $validateData['title'];
      $apartment -> image = $validateData['image'];
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

      $apartment -> save();
      $apartment -> services() -> sync($validateData['services']);
      return redirect() -> route("showApartment",$apartment['id'])
                        -> withSuccess("Appartamento creato correttamente");
    }

    public function editApartment($id){
      $apartment = Apartment::findOrFail($id);
      $services = Service::all();
      return view('editApartment', compact("apartment", "services"));
    }

    public function updateApartment(Request $request, $id){

      $validateData = $request -> validate([
        'title' => 'required | string',
        'description' => 'required | string',
        'rooms_n' => 'required | integer',
        'beds_n' => 'required | integer',
        'bathrooms_n' => 'required | integer',
        'square_meters' => 'required | integer',
        'services' => 'required',
        'is_active' => 'required | boolean'
      ]);
      $apartment = Apartment::findOrFail($id);
      $apartment -> title = $validateData['title'];
      $apartment -> description = $validateData['description'];
      $apartment -> rooms_n = $validateData['rooms_n'];
      $apartment -> beds_n = $validateData['beds_n'];
      $apartment -> bathrooms_n = $validateData['bathrooms_n'];
      $apartment -> square_meters = $validateData['square_meters'];
      $apartment -> is_active = $validateData['is_active'];
      $apartment -> save();

      $apartment -> services() -> sync($validateData['services']);

      return redirect() -> route("showApartment", $id)
                        -> withSuccess("Appartamento ".$validateData["title"]
                            ." aggiornato correttamente");
    }

    public function deleteApartment($id){
      $apartment = Apartment::findOrFail($id);
      $apartment -> delete();
      return redirect() -> route("welcome")
                        -> withSuccess("Appartamento eliminato con successo!");
    }
}
