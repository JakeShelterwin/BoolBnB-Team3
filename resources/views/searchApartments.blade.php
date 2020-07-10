@extends('layouts.mainLayout')

@section('content')

<div id="searchPage">

  <div>
    <input class="searchbar absolute_searchbar" type="text" placeholder="Cerca un appartamento...">
    <input class="buttonsearch absolute_botton" type="button" value="Cerca">
  </div>


  {{-- <div class="appartamenti">
  @foreach ($apartments as $apartment)
    <ul>
      <li><img src="{{$apartment->image}}" alt=""></li>
      <li><b><a href="{{route('showApartment', $apartment -> id)}}">Titolo appartamento:</b> {{$apartment -> title}} </a></li>
      <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
      <li><b>proprietario</b> {{$apartment -> user -> name}}</li>
    </ul>
  @endforeach
  </div> --}}
</div>
@endsection
