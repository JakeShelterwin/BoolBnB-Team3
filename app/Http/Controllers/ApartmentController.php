<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Apartment;
use App\Service;

class ApartmentController extends Controller
{
    public function index(){
      $apartments = Apartment::all();
      return view('welcome', compact("apartments"));
    }
    public function showApartment($id){
      $apartment = Apartment::findOrFail($id);
      return view('showApartment', compact("apartment"));
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
        'bedrooms_n' => 'required | integer',
        'bathrooms_n' => 'required | integer',
        'square_meters' => 'required | integer',
        'services' => 'required'
      ]);
      $apartment = Apartment::findOrFail($id);
      $apartment -> title = $validateData['title'];
      $apartment -> description = $validateData['description'];
      $apartment -> rooms_n = $validateData['rooms_n'];
      $apartment -> bedrooms_n = $validateData['bedrooms_n'];
      $apartment -> bathrooms_n = $validateData['bathrooms_n'];
      $apartment -> square_meters = $validateData['square_meters'];
      $apartment -> save();

      $apartment -> services() -> sync($validateData['services']);


      return redirect() -> route("showApartment", $id)
                        -> withSuccess("Appartamento ".$validateData["title"]
                            ." aggiornato correttamente");
    }

}
