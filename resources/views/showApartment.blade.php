@extends('layouts.mainLayout')

@section('content')

<div class="success_or_fail">
  @if (session("success"))
    <p>{{session("success")}}</p>
  @endif
  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  @endif
</div>

<div class="apartment container">
  <h1 id="title">{{$apartment['title']}} <i class="fas fa-award"></i> </h1>
  <div class="containApartment col-sm-12">

    <div class="row">

      <div class="photo col-sm-12 col-lg-6" style="background-image: url('{{$apartment->image}}')"> </div>

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

        @auth
        @if (auth()->user()->id == $apartment -> user_id)
          <h2 class="manage text-center">Gestisci il tuo appartamento</h2>
          <div class="funzioni">
            <a href="{{route('editApartment', $apartment['id'])}}">Modifica</a>
            <a href="{{route('deleteApartment', $apartment['id'])}}">Cancella</a>
            <a href="{{route('showApartmentStatistics', $apartment['id'])}}">Statistiche</a>
          </div>
        @else
          <h2>Contatta il Proprietario</h2>
          <form class="form" action="{{route('storeMessage', $apartment -> id)}}" method="post">
            @csrf
            @method('POST')
            <label for="email">Inserisci la Tua Mail per essere Ricontattato</label> <br>
            <input type="email" name="email" value="{{old('email', $emailUtente)}}" placeholder="La tua e_mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'La tua e_mail'"> <br>
            <label for="message">Scrivi qui un messaggio per un proprietario</label> <br>
            <input type="textarea" name="message" value="{{old('message')}}" placeholder="Inserisci la tua richiesta" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci la tua richiesta'"> <br>
            <button type="submit" name="submit">Invia Messaggio</button> <br>
          </form>
        @endauth
        @else
          <h2>Contatta il Proprietario</h2>
          <form class="form" action="{{route('storeMessage', $apartment -> id)}}" method="post">
            @csrf
            @method('POST')
            <label for="email">Inserisci la Tua Mail per essere Ricontattato</label> <br>
            <input type="email" name="email" value="{{old('email', $emailUtente)}}" placeholder="La tua e_mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'La tua e_mail'"> <br>
            <label for="message">Scrivi qui un messaggio per un proprietario</label> <br>
            <input type="textarea" name="message" value="{{old('message')}}" placeholder="Inserisci la tua richiesta" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci la tua richiesta'"> <br>
            <button type="submit" name="submit">Invia Messaggio</button> <br>
          </form>
        @endif
      </div>
    <div id="map" class="col-sm-12 col-lg-6"></div>
  </div>
  </div>
</div>

@endsection
