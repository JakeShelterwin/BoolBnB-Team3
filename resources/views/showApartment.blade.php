@extends('layouts.mainLayout')

@section('content')

@if (session("success"))
  <p>{{session("success")}}</p>
@endif
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <p>{{$error}}</p>
  @endforeach
@endif
<div class="apartment container">
  <h1 id="title">{{$apartment['title']}} <i class="fas fa-award"></i> </h1>
  <div class="containApartment col-sm-12">

    <div class="row">

      <div class="photo col-sm-12 col-lg-6" style="background-image: url('{{$apartment->image}}')">
        {{-- <img id="apartmentImage" src="{{asset($apartment['image'])}}" alt="photo{{$apartment['id']}}"> --}}
      </div>

      <div class="apartmentlInfo col-sm-12 col-lg-6">
        <div class="row">
          <div class="description col-sm-12 col-md-6">
            <h2>Descrizione</h2>
            <p>{{$apartment['description']}}</p>
          </div>

          <div class="address col-sm-12 col-md-6">
            <h2>Indirizzo</h2>
            <p>{{$apartment['address']}}</p>
            <div class="coordinate">
              <input id="latitude" type="text" name="latitude" value="{{$apartment['lat']}}">
              <input id="longitude" type="text" name="longitude" value="{{$apartment['lon']}}">
            </div>
          </div>

          <div class="features col-sm-12 col-md-6">
            <h2>Caratteristiche</h2>
            <ul>
              <li><b>Numero stanze: </b>{{$apartment['rooms_n']}}</li>
              <li><b>Numero letti: </b>{{$apartment['beds_n']}}</li>
              <li><b>Numero bagni: </b>{{$apartment['bathrooms_n']}}</li>
              <li><b>Metri quadrati: </b>{{$apartment['square_meters']}} m<SUP>2</SUP></li>
            </ul>
          </div>
          <div class="services col-sm-12 col-md-6">
            <h2>Servizi</h2>
            <ul>
              @foreach ($apartment -> services as $service)
                <li>{{$service -> name}}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

    </div>
    <div class="user_interactions row ">
      <div class="contact col-sm-12 col-lg-6">
        {{$emailUtente = NULL}}
        @auth
          @php
          $emailUtente = auth()->user()-> email
        @endphp

      @endauth
      <h2>Contatta il Proprietario</h2>
      <form class="form" action="{{route('storeMessage', $apartment -> id)}}" method="post">
        @csrf
        @method('POST')
        <label for="email">Inserisci la Tua Mail per essere Ricontattato</label> <br>
        <input type="email" name="email" value="{{old('email', $emailUtente)}}"> <br>
        <label for="message">Scrivi qui un messaggio per un proprietario</label> <br>
        <input type="textarea" name="message" value="{{old('message')}}"> <br>
        <button type="submit" name="submit">Invia Messaggio</button> <br>
      </form>
    </div>
    <div id="map" class="col-sm-12 col-lg-6"></div>
  </div>
  </div>
</div>

@endsection
