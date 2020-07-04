@extends('layouts.mainLayout')

@section('content')

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
