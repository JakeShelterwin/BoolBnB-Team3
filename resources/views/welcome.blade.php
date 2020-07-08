@extends('layouts.mainLayout')

@section('content')
<div class="jumbotron"> 
  <input class="searchbar" type="text" placeholder="Cerca un appartamento..."><input class="buttonsearch" type="button" value="Cerca"><br>
  @foreach ($services as $service)
      <input type="checkbox" name="{{$service -> name}}" value="{{$service -> id}}">{{$service -> name}}
  @endforeach
</div>

<ul class="appartamenti">

  @foreach ($apartments as $apartment)
    <li><b><a href="{{route('showApartment', $apartment -> id)}}">Titolo appartamento:</b> {{$apartment -> title}} </a></li>
    <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
    <li><b>proprietario</b> {{$apartment -> user -> name}}</li>
    <li><b>messaggi</b>  <ul>
                    @foreach ($apartment -> messages as $message)
                      <li> {{$message -> message }}</li>
                    @endforeach
                  </ul>  </li>
    <li>sponsor</b>  <ul>
                    @foreach ($apartment -> sponsor as $sponsor)
                      <li> {{$sponsor -> name }}</li>
                    @endforeach
                  </ul>  </li>
    <li>servizi</b>  <ul>
                    @foreach ($apartment -> services as $service)
                      <li> {{$service -> name }}</li>
                    @endforeach
                  </ul>  </li>
    <li>visite</b>  <ul>
                    @foreach ($apartment -> views as $view)
                      <li> {{$view -> views }}</li>
                    @endforeach
                  </ul>  </li>
    -----------------------------
    <br>
  @endforeach
</ul>


@endsection
