@extends('layouts.mainLayout')

@section('content')
<div class="jumbotron">
  <h1 class="absolute_title">CIAO SONO UN TITOLO</h1>
  <p class="absolute_p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore obcaecati, reprehenderit beatae eveniet numquam cum deserunt iste nemo fugiat nisi? Illum, accusantium vero sit laudantium ipsum amet facere sapiente quos!</p>
  <div><input class="searchbar absolute_searchbar" type="text" placeholder="Cerca un appartamento..."><input class="buttonsearch absolute_botton" type="button" value="Cerca"></div>
  <img class="mySlides" src="{{ asset('uploads/images/img.jpg') }}" alt="">
  <img class="mySlides" src="{{ asset('uploads/images/img1.jpg') }}" alt="">
  <img class="mySlides" src="{{ asset('uploads/images/img2.jpg') }}" alt="">
  <!-- @foreach ($services as $service)
      <input type="checkbox" name="{{$service -> name}}" value="{{$service -> id}}">{{$service -> name}}
  @endforeach -->
</div>

{{-- <ul class="appartamenti">

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

  @endforeach
</ul> --}}

<div class="appartamenti">
  @foreach ($apartments as $apartment)
  <ul>
    <li><img src="{{$apartment->image}}" alt=""></li>
    <li><b><a href="{{route('showApartment', $apartment -> id)}}">Titolo appartamento:</b> {{$apartment -> title}} </a></li>
    <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
    <li><b>proprietario</b> {{$apartment -> user -> name}}</li>
  </ul>
  @endforeach
</div>
@endsection
