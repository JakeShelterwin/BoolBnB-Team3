@extends('layouts.mainLayout')

@section('content')

<div class="container contentSearch">
  <div class="info">
    <form action="{{route('searchApartments')}}" method="GET">
      <div class="searchField card">

        <input id="ricerca" name="address" class="searchbar" type="text" placeholder="Dove vorresti alloggiare?" value="{{$query}}">
        <button id="btnQuery" class="buttonsearch" type="submit" name="button" value="Cerca">Cerca!</button>
        <p id="btnFilter" class="buttonFilter" name="button">Più filtri</p>
        <div class="filtri filtriNascosti row">
            <div class="filtriNumerici col-sm-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">

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

              Raggio (Km)
              <input type="range" id="volume" name="radius" min="1" max="40" value="">
              <span></span>
            </div>
            <div class="filtroServizi col-sm-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
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
      </div>

      <div class="coordinate">
        <input id="latitude" type="text" name="lat" value="">
        <input id="longitude" type="text" name="lon" value="">
      </div>
    </form>
  </div>

  <div class="apartments row">
      @if ($sponsoredApartment)
        @foreach ($sponsoredApartment as $apartment)
        <div class="card col-sm-12 row">
          <div class="sponsoredApartment col-sm-12 row">

            <a  class=" col-sm-12 col-md-4 noPadding"  href="{{route('showApartment', $apartment -> id)}}"> <div class="sponsoredApartmentImg" style="background-image: url('{{$apartment->image}}')"></div> </a>

            <ul class="col-sm-12 col-md-8 apartmentInfo">
              <li><a href="{{route('showApartment', $apartment -> id)}}"> <b>{{$apartment -> title}} </b> </a></li>
              <li class="description"><b>Descrizione</b>  {{ Illuminate\Support\Str::limit($apartment -> description, 165) }}</li>
              <li><b>Proprietario</b> {{$apartment -> user -> name}}</li>
              <li>
                <ul class="apartmentServices">
                  <li> <b>Servizi:</b> </li>
                  @foreach ($apartment -> services as $service)
                    <li>
                      @if ($service -> name == "Wi-Fi")
                      &nbsp   <i class="fas fa-wifi"></i>
                      @elseif ($service -> name == "Posto Auto")
                      &nbsp   <i class="fas fa-car"></i>
                      @elseif ($service -> name == "Piscina")
                      &nbsp   <i class="fas fa-swimming-pool"></i>
                      @elseif ($service -> name == "Portineria")
                      &nbsp   <i class="fas fa-concierge-bell"></i>
                      @elseif ($service -> name == "Sauna")
                      &nbsp   <i class="fas fa-hot-tub"></i>
                      @elseif ($service -> name == "Vista Mare")
                      &nbsp    <i class="fas fa-binoculars"></i>
                      @endif
                        {{$service -> name}}
                    </li>

                  @endforeach
                </ul>
              </li>
            </ul>
            <div class="sponsoredRibbon">
              <i class="fas fa-award"></i>
              <span>Sponsored</span>
            </div>
          </div>
        </div>
        @endforeach
      @endif
      @foreach ($selectedApartmentsFilteredByUser as $key => $apartment)
        <div class="card col-sm-12 row">
        <div class="searchedApartment col-sm-12 row">
          <a class=" col-sm-12 col-md-4 noPadding" href="{{route('showApartment', $apartment -> id)}}"> <div class="searchedApartmentImg" style="background-image: url('{{$apartment->image}}')"></div> </a>
          <ul class="col-sm-12 col-md-8 apartmentInfo">
            <li><a href="{{route('showApartment', $apartment -> id)}}"> <b>{{$apartment -> title}} </b> </a></li>
            <li class="description"><b>Descrizione</b>  {{ Illuminate\Support\Str::limit($apartment -> description, 165) }}</li>
            <li><b>Proprietario</b> {{$apartment -> user -> name}}</li>
            <li>
              <ul class="apartmentServices">
                <li> <b>Servizi:</b> </li>
                @foreach ($apartment -> services as $service)
                  <li>
                    @if ($service -> name == "Wi-Fi")
                       &nbsp <i class="fas fa-wifi"></i>
                    @elseif ($service -> name == "Posto Auto")
                      &nbsp <i class="fas fa-car"></i>
                    @elseif ($service -> name == "Piscina")
                    &nbsp   <i class="fas fa-swimming-pool"></i>
                    @elseif ($service -> name == "Portineria")
                    &nbsp   <i class="fas fa-concierge-bell"></i>
                    @elseif ($service -> name == "Sauna")
                      &nbsp <i class="fas fa-hot-tub"></i>
                    @elseif ($service -> name == "Vista Mare")
                    &nbsp   <i class="fas fa-binoculars"></i>
                    @endif
                      {{$service -> name}}
                  </li>

                @endforeach
              </ul>
            </li>
            <li><b>Distanza:</b>
                @if ($key < 1000)
                  {{$key}}m
                @else
                  @php
                    $key = $key/1000;
                    $key = round($key, 2);
                  @endphp
                  {{$key}}km
                @endif
            </li>
          </ul>
        </div>
        </div>
      @endforeach
  </div>
</div>
@endsection
