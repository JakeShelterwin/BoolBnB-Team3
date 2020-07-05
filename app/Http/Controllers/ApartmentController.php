<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Apartment;
use App\Service;
use App\Message;

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

}
