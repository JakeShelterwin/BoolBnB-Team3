@extends('layouts.mainLayout')

@section('content')
<div class="jumbotron">
  <h1 class="absolute_title">CIAO SONO UN TITOLO</h1>
  <p class="absolute_p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore obcaecati, reprehenderit beatae eveniet numquam cum deserunt iste nemo fugiat nisi? Illum, accusantium vero sit laudantium ipsum amet facere sapiente quos!</p>
  <div class="info">
    <form action="{{route('searchApartments')}}" method="GET">
      <input id="ricerca" name="address" class="searchbar absolute_searchbar" type="text" placeholder="Dove vorresti alloggiare?" value="">
      <div class="coordinate">
        <input id="latitude" type="text" name="lat" value="">
        <input id="longitude" type="text" name="lon" value="">
      </div>
      <button id="btnQuery" class="buttonsearch absolute_botton" type="submit" name="button" value="Cerca">Cerca!</button>
    </form>
    {{-- <a href="{{route('searchApartments')}}">Vai</a> --}}
  </div>
  <img class="mySlides" src="{{ asset('uploads/images/img.jpg') }}" alt="">
  <img class="mySlides" src="{{ asset('uploads/images/img1.jpg') }}" alt="">
  <img class="mySlides" src="{{ asset('uploads/images/img2.jpg') }}" alt="">
  {{-- <!-- @foreach ($services as $service)
      <input type="checkbox" name="{{$service -> name}}" value="{{$service -> id}}">{{$service -> name}}
  @endforeach --> --}}
</div>

<div class="appartamenti">
  @foreach ($apartments as $apartment)
  <ul id="sponsored">
    <li><img src="{{$apartment->image}}" alt=""></li>
    <li><b><a href="{{route('showApartment', $apartment -> id)}}">Titolo appartamento:</b> {{$apartment -> title}} </a></li>
    <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
    <li><b>proprietario</b> {{$apartment -> user -> name}}</li>
  </ul>
  @endforeach
</div>
@endsection
