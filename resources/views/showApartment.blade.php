@extends('layouts.mainLayout')

@section('content')

<div class="apartment container">
  <h1 id="title">{{$apartment['title']}}
    @if ($sponsorAttivo)
      <i class="fas fa-award"></i>
    @endif
   </h1>
  <h4>{{$apartment['address']}} </h4>
  <div class="address col-sm-12 col-md-6">
    <div class="coordinate">
      <input id="latitude" type="text" name="latitude" value="{{$apartment['lat']}}">
      <input id="longitude" type="text" name="longitude" value="{{$apartment['lon']}}">
    </div>
  </div>
  <div class="containApartment row">

    <div class="row col-sm-12 col-lg-9">
      <div class="containPhoto col-sm-12">
        <div class="photo col-sm-12" style="background-image: url('{{$apartment->image}}')"> </div>
      </div>

      <div class="apartmentlInfo col-sm-12 col-lg-8">
        <div class="row">
          <div class="description col-sm-12">
            <h5>Descrizione</h5>
            <div class="textDescription">
              <p>{{$apartment['description']}}</p>
            </div>
          </div>

          <div class="features row col-sm-12">
            <ul class="rooms col-sm-12">
              <li><b>Stanze: &nbsp </b>{{$apartment['rooms_n']}}</li>
              <li><b>Letti: &nbsp </b>{{$apartment['beds_n']}}</li>
              <li><b>Toilettes: &nbsp </b>{{$apartment['bathrooms_n']}}</li>
              <li><b>Metratura: &nbsp </b>{{$apartment['square_meters']}}m&#178;</li>
            </ul>
            <ul class="services col-sm-12">
              @foreach ($apartment -> services as $service)
                <li>
                  @if ($service -> name == "Wi-Fi")
                    <i class="fas fa-wifi"></i>
                  @elseif ($service -> name == "Posto Auto")
                    <i class="fas fa-car"></i>
                  @elseif ($service -> name == "Piscina")
                    <i class="fas fa-swimming-pool"></i>
                  @elseif ($service -> name == "Portineria")
                    <i class="fas fa-concierge-bell"></i>
                  @elseif ($service -> name == "Sauna")
                    <i class="fas fa-hot-tub"></i>
                  @elseif ($service -> name == "Vista Mare")
                    <i class="fas fa-binoculars"></i>
                  @endif
                  <p>{{$service -> name}}</p>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>

      <div class="user_interactions contact col-sm-12 col-lg-4">
        {{$emailUtente = NULL}}
        @auth
          @php
          $emailUtente = auth()->user()-> email
          @endphp
        @endauth

        @auth
          @if (auth()->user()->id == $apartment -> user_id)
            <h5 class="text-center">Gestisci il tuo appartamento</h5>
            <div class="funzioni">
              <a href="{{route('editApartment', $apartment['id'])}}">Modifica</a>
              <a href="{{route('deleteApartment', $apartment['id'])}}">Cancella</a>
              <a href="{{route('showApartmentStatistics', $apartment['id'])}}">Statistiche</a>
              @if (!$sponsorAttivo)
                <a href="{{route('sponsorApartment', $apartment['id'])}}">Sponsor</a>
              @endif
            </div>
          @else
            <h5>Contatta {{$apartment -> user -> name}}</h5>
            <form class="form" action="{{route('storeMessage', $apartment -> id)}}" method="post">
              @csrf
              @method('POST')
              <input type="email" name="email" value="{{old('email', $emailUtente)}}" placeholder="La tua e-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'La tua e-mail'"> <br>
              <br>
              <textarea type="textarea" rows="4" cols="40" name="message" value="{{old('message')}}" placeholder="Inserisci la tua richiesta" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci la tua richiesta'">{{old('message')}}</textarea> <br>
              <button type="submit" name="submit">Invia Messaggio</button> <br>
            </form>
          @endif
        @endauth
        @guest
          <h5>Contatta {{$apartment -> user -> name}}</h5>
          <form class="form" action="{{route('storeMessage', $apartment -> id)}}" method="post">
            @csrf
            @method('POST')
            <input type="email" name="email" value="{{old('email', $emailUtente)}}" placeholder="La tua e-mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'La tua e-mail'"> <br>
            <br>
            <textarea type="textarea" rows="4" cols="40" name="message" value="{{old('message')}}" placeholder="Inserisci la tua richiesta" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci la tua richiesta'">{{old('message')}}</textarea> <br>
            <button type="submit" name="submit">Invia Messaggio</button> <br>
          </form>
        @endguest
      </div>
    </div>
    <div id="map" class="col-sm-12 col-lg-3"></div>
  </div>
</div>
@endsection
