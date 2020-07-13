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
      <h1 class="col-sm-12">Sponsorizzati</h1>
      @foreach ($apartments as $apartment)
        <ul class="col-sm-12 col-md-6 col-lg-4">
          <li> <a href="{{route('showApartment', $apartment -> id)}}"> <div class="apartmentImg" style="background-image: url('{{$apartment->image}}')"></div> </a></li>
          <li><b><a href="{{route('showApartment', $apartment -> id)}}">{{$apartment -> title}}</b>  </a></li>
          <li>{{$apartment["description"]}}</li>
          <li>Di: {{$apartment -> user -> name}}</li>
        </ul>
      @endforeach
    </div>
  </div>
@endsection
