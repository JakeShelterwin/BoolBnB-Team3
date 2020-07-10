@extends('layouts.mainLayout')

@section('content')

<div id="searchPage">
  <div class="info">
    {{-- <form action="{{route('searchApartments')}}" method="post">
      @csrf
      @method('POST')
      <input id="ricerca" name="address" class="searchbar absolute_searchbar" type="text" placeholder="Dove vorresti alloggiare?">
      <label for="radius">Raggio (in Km)</label> --}}
      {{-- <input type="range" id="volume" name="volume"
         min="0" max="11"> --}}
      {{-- <div class="coordinate">
        <input id="range" name="radius" type="text" value="10">
        <input id="latitude" type="text" name="lat" value="">
        <input id="longitude" type="text" name="lon" value="">
      </div>
      <button id="btnQuery" class="buttonsearch absolute_botton" type="submit" name="button" value="Cerca">Cerca!</button>
    </form> --}}
  {{-- </div> --}}
</div>

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
</div>
@endsection
