@extends('layouts.mainLayout')

@section('content')
  <div class="container content">
    <div class="jumboSearch row">
      <div class="jumboText col-sm-12	col-lg-8">
        <h1>Immagina dove vorresti essere</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore obcaecati, reprehenderit beatae eveniet numquam cum deserunt iste nemo fugiat nisi? Illum, accusantium vero sit laudantium ipsum amet facere sapiente quos!</p>
        <div class="info">
          <form action="{{route('searchApartments')}}" method="GET">
            <input id="ricerca" name="address" class="searchbarWelcome" type="text" placeholder="Dove vorresti alloggiare?" value="">
            <div class="coordinate">
              <input id="latitude" type="text" name="lat" value="">
              <input id="longitude" type="text" name="lon" value="">
            </div>
            <button id="btnQuery" class="buttonWelcome" type="submit" name="button" value="Cerca"><i class="fas fa-plane-departure" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
      {{-- <div class="jumboImages">
        <img class="mySlides" src="{{ asset('uploads/images/img.jpg') }}" alt="">
        <img class="mySlides" src="{{ asset('uploads/images/img1.jpg') }}" alt="">
        <img class="mySlides" src="{{ asset('uploads/images/img2.jpg') }}" alt="">
      </div> --}}
    </div>

    <div class="apartaments row">

        <h1 class="col-sm-12">In Evidenza</h1>
        @foreach ($apartments as $apartment)
          <div class="apartmentCard col-sm-12 col-md-6 col-lg-4">
              <div class="card  attivo{{$apartment['is_active']}}">
              <div class="apartment row" data-annuncioAttivo="{{$apartment['is_active']}}">
                <div class="immagine col-sm-12">

                  <a href="{{route('showApartment', $apartment -> id)}}">
                    <div class="apartmentImg" style="background-image: url('{{$apartment->image}}')"></div>
                  </a>
                  <div class="sponsoredRibbon">
                    <i class="fas fa-award"></i>
                  </div>

                </div>

                <div class="funzioni row col-sm-12">
                  <a class="col-md-12" href="{{route('showApartment',$apartment['id'])}}">
                    {{$apartment -> title }}
                  </a>
                  <span class="col-sm-12">
                    {{$apartment -> address }} <i class="fas fa-map-marked-alt"></i>
                  </span>
                  <span class="col-sm-12">
                    Proprietario - {{$apartment -> user -> name }} <i class="fas fa-key"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
    </div>




  </div>
@endsection
