@extends('layouts.mainLayout')

@section('content')

@if (session("success"))
  <p>{{session("success")}}</p>
@endif
<div class="apartment">
  <div class="photo">
    <img src="{{$apartment['image']}}" alt="photo{{$apartment['id']}}">
  </div>

  <div class="info">
    <h1>{{$apartment['title']}}</h1>
    <div class="description">
      <h2>Descrizione</h2>
      <p>{{$apartment['description']}}</p>
    </div>

    <div class="other_info">
      <div class="features">
        <h2>Caratteristiche</h2>
        <ul>
          <li><b>Numero stanze: </b>{{$apartment['rooms_n']}}</li>
          <li><b>Numero letti: </b>{{$apartment['beds_n']}}</li>
          <li><b>Numero bagni: </b>{{$apartment['bathrooms_n']}}</li>
          <li><b>Metri quadrati: </b>{{$apartment['square_meters']}} metri2</li>
        </ul>
      </div>
      <div class="services">
        <h2>Servizi</h2>
        <ul>
          @foreach ($apartment -> services as $service)
            <li>{{$service -> name}}</li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="user_interactions">
      <div class="map">

      </div>
      <div class="contact">

      </div>
    </div>

  </div>
  @auth
    @if (auth()->user()-> id == $apartment -> user_id)
      <a href="{{route('editApartment', $apartment['id'])}}">
        <button type="button" name="button">Modifica</button>
      </a>
      <a style="margin-left:50px" href="{{route('deleteApartment', $apartment['id'])}}">
        <button type="button" name="button">Cancella</button>
      </a>

    @endif
  @endauth
</div>




{{-- @foreach ($apartments as $apartment)
    <li>Titolo appartamento: {{$apartment -> title}}</li>
    <li>Descrizione appartamento: {{$apartment["description"]}}</li>
    <li>proprietario {{$apartment -> user -> name}}</li>
    <li>messaggi  <ul>
                    @foreach ($apartment -> messages as $message)
                      <li> {{$message -> message }}</li>
                    @endforeach
                  </ul>  </li>
    <li>sponsor  <ul>
                    @foreach ($apartment -> sponsor as $sponsor)
                      <li> {{$sponsor -> name }}</li>
                    @endforeach
                  </ul>  </li>
    <li>servizi  <ul>
                    @foreach ($apartment -> services as $service)
                      <li> {{$service -> name }}</li>
                    @endforeach
                  </ul>  </li>
    <li>visite  <ul>
                    @foreach ($apartment -> views as $view)
                      <li> {{$view -> views }}</li>
                    @endforeach
                  </ul>  </li>
    -----------------------------
    <br>
  @endforeach --}}



@endsection
