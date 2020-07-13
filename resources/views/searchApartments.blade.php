@extends('layouts.mainLayout')

@section('content')

<div class="container contentSearch">
  <div class="info">
    <form action="{{route('searchApartments')}}" method="GET">
      <div class="searchField">

        <input id="ricerca" name="address" class="searchbar" type="text" placeholder="Dove vorresti alloggiare?" value="{{$query}}">
        <button id="btnQuery" class="buttonsearch" type="submit" name="button" value="Cerca">Cerca!</button>
        Numero Stanze <input type="number" name="rooms_n" value=
        @if ($numberOfRooms)
          "{{$numberOfRooms}}"
        @else
          "1"
        @endif>
        Posti letto <input type="number" name="beds_n"  value=
        @if ($numberOfBeds)
          "{{$numberOfBeds}}"
        @else
          "1"
        @endif>
        Raggio (in Km)
        <input type="range" id="volume" name="radius" min="0" max="40" value="">
        <span></span>
      </div>

      <div class="filtri">
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

  <div class="apartments">
      @if ($sponsoredApartment)
        @foreach ($sponsoredApartment as $apartment)
          <div class="sponsoredApartment row">
            <a  class=" col-sm-12 col-md-4"  href="{{route('showApartment', $apartment -> id)}}"> <div class="sponsoredApartmentImg" style="background-image: url('{{$apartment->image}}')"></div> </a>
            <ul class="col-sm-12 col-md-8">
              <li><a href="{{route('showApartment', $apartment -> id)}}"> <b>{{$apartment -> title}} </b> </a></li>
              <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
              <li><b>Proprietario</b> {{$apartment -> user -> name}}</li>
              <li>
                <ul class="apartmentServices">
                  <li> <b>Servizi:</b> </li>
                  @foreach ($apartment -> services as $service)
                    <li> {{$service -> name}} </li>
                  @endforeach
                </ul>
              </li>
            </ul>
            <div class="sponsoredRibbon">
              <i class="fas fa-award"></i>
              <p>Sponsored</p>
            </div>
          </div>
        @endforeach
      @endif
      @foreach ($selectedApartmentsFilteredByUser as $apartment)
        <div class="searchedApartment row">
          <a class=" col-sm-12 col-md-4" href="{{route('showApartment', $apartment -> id)}}"> <div class="searchedApartmentImg" style="background-image: url('{{$apartment->image}}')"></div> </a>
          <ul class="col-sm-12 col-md-8">
            <li><a href="{{route('showApartment', $apartment -> id)}}"> <b>{{$apartment -> title}} </b> </a></li>
            <li><b>Descrizione appartamento:</b> {{$apartment["description"]}}</li>
            <li><b>Proprietario</b> {{$apartment -> user -> name}}</li>
            <li>
              <ul class="apartmentServices">
                <li> <b>Servizi:</b> </li>
                @foreach ($apartment -> services as $service)
                 <li> {{$service -> name}} </li>
                @endforeach
              </ul>
            </li>
          </ul>
        </div>
      @endforeach
  </div>
</div>
@endsection
