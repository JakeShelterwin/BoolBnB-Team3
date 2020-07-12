@extends('layouts.mainLayout')

@section('content')

<div id="searchPage">
  <div class="info">
    <form action="{{route('searchApartments')}}" method="GET">
      <input id="ricerca" name="address" class="searchbar" type="text" placeholder="Dove vorresti alloggiare?" value="{{$query}}">
      <button id="btnQuery" class="buttonsearch" type="submit" name="button" value="Cerca">Cerca!</button>
      numero minimo stanze <input type="number" name="rooms_n" value=
      @if ($numberOfRooms)
        "{{$numberOfRooms}}"
      @else
        "1"
      @endif>
      minimo posti letto <input type="number" name="beds_n"  value=
      @if ($numberOfBeds)
        "{{$numberOfBeds}}"
      @else
        "1"
      @endif>

      <div class="filtri">
        <label for="radius">Raggio (in Km)</label>
        <input type="range" id="volume" name="radius" min="0" max="40" value="">
        <span></span>
        <br>
        <div class="filtriNascosti">
          @foreach ($services as $service)
            <input type="checkbox" name="services[]" value="{{$service -> name}}"
            @if ($selectedServices)
              @foreach ($selectedServices as $serviceApartment)
                @if ($service['name'] == $serviceApartment)
                  checked
                @endif
              @endforeach
            @endif
            > {{$service -> name}}
          @endforeach
        </div>
      </div>
      <div class="coordinate">
        <input id="latitude" type="text" name="lat" value="">
        <input id="longitude" type="text" name="lon" value="">
      </div>
    </form>
  </div>
</div>

  <div class="appartamenti">
    @if ($sponsoredApartment)
      @foreach ($sponsoredApartment as $apartment)
        <ul id="sponsored">
          <li><img src="{{$apartment->image}}" alt=""></li>
          <li><b><a href="{{route('showApartment', $apartment -> id)}}">Titolo appartamento:</b> {{$apartment -> title}} </a></li>
          <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
          <li><b>proprietario</b> {{$apartment -> user -> name}}</li>
          <li>
            <ul>
              @foreach ($apartment -> services as $service)
               <li> {{$service -> name}} </li>
              @endforeach
            </ul>
          </li>
        </ul>
      @endforeach
    @endif
  @foreach ($selectedApartmentsFilteredByUser as $apartment)
    <ul>
      <li><img src="{{$apartment->image}}" alt=""></li>
      <li><b><a href="{{route('showApartment', $apartment -> id)}}">Titolo appartamento:</b> {{$apartment -> title}} </a></li>
      <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
      <li><b>proprietario</b> {{$apartment -> user -> name}}</li>
      <li>
        <ul>
          @foreach ($apartment -> services as $service)
           <li> {{$service -> name}} </li>
          @endforeach
        </ul>
      </li>
    </ul>
  @endforeach
  </div>
</div>
@endsection
