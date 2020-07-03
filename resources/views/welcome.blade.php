@extends('layouts.mainLayout')

@section('content')

<ul class="appartamenti">

  @foreach ($apartments as $apartment)
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
  @endforeach
</ul>


@endsection
