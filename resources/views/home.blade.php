@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 containApartments">
            <div class="card createApartment row">
              <div class="bulge col-sm-6 col-lg-5">
                  <a href="{{route('createApartment')}}">Crea Annuncio &nbsp  <i class="far fa-plus-square"></i></a>
              </div>
              <div class="legenda col-sm-5 col-lg-5">
                <span> LEGENDA &nbsp  <i class="fas fa-layer-group"></i></span>
                <div class="nascondino">
                  <ul>
                    <li>Sponsor &nbsp<i class="fas fa-award"></i> </li>
                    <li>Edit &nbsp <i class="far fa-edit"></i> </li>
                    <li>Delete &nbsp<i class="far fa-trash-alt"></i> </li>
                    <li>Stats &nbsp <i class="far fa-chart-bar"></i></li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="apartmentsSponsored row">
              @if ($apartmentSponsored)
                @foreach ($apartmentSponsored as $apartment)
                  <div class="card  attivo{{$apartment['is_active']}}">
                  <div class="apartment row" data-annuncioAttivo="{{$apartment['is_active']}}">
                    <div class="immagine col-sm-12">

                      <a href="{{route('showApartment', $apartment -> id)}}">
                        <div class="apartmentImg" style="background-image: url('{{$apartment->image}}')" alt="Foto {{$apartment['title']}}"></div>
                      </a>
                      <div class="sponsoredRibbon">
                          <span class="expire d-none">{{$apartment['sponsor_expire_time'] - time()}}</span>
                          <span class="showTime">{{$apartment['sponsor_expire_time'] - time()}}</span>
                        <i class="fas fa-award"></i>
                      </div>

                    </div>

                    <div class="funzioni row col-sm-12">
                      <a class="col-sm-12" href="{{route('showApartment',$apartment['id'])}}">
                        {{$apartment -> title }}
                      </a>

                      <a class="col-sm-3 clickable" href="{{route('editApartment', $apartment['id'])}}">
                        <i class="far fa-edit"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('deleteApartment', $apartment['id'])}}">
                        <i class="far fa-trash-alt"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('showApartmentStatistics', $apartment['id'])}}">
                        <i class="far fa-chart-bar"></i>
                      </a>
                    </div>
                  </div>
                </div>
                @endforeach
              @endif
            </div>

            <div class="normalApartments row">
              @if ($user_apartments)
                @foreach ($user_apartments as $apartment)
                <div class="card attivo{{$apartment['is_active']}}">
                  <div class="apartment row" data-annuncioAttivo="{{$apartment['is_active']}}">
                    <div class="immagine col-sm-12">
                      <a href="{{route('showApartment', $apartment -> id)}}">
                        <div class="apartmentImg" style="background-image: url('{{$apartment->image}}')"></div>
                      </a>
                    </div>
                    <div class="funzioni row col-sm-12">
                      <a class="col-md-12" href="{{route('showApartment',$apartment['id'])}}">{{$apartment -> title}}
                      </a>
                      <a class="col-sm-3 clickable" href="{{route("sponsorApartment", $apartment->id)}}">
                        <i class="fas fa-award"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('editApartment', $apartment['id'])}}">
                        <i class="far fa-edit"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('deleteApartment', $apartment['id'])}}">
                        <i class="far fa-trash-alt"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('showApartmentStatistics', $apartment['id'])}}">
                        <i class="far fa-chart-bar"></i>
                      </a>
                    </div>
                  </div>
                </div>
                @endforeach
              @endif
            </div>
        </div>

        <div class="col-md-4 containMessages">
          <div class="messages card row">
            <div class="bulge col-sm-8">
              <span> Messaggi ricevuti </span>
            </div>
          </div>
         @if ($messages)
           @foreach ($messages as $message)
               <div class="card message row">
                 <b> {{$message -> apartment -> title}}
                   @if ($message -> apartment -> sponsor_expire_time >= time())
                    &nbsp<i class="fas fa-award"></i>
                   @endif
                 </b>
                 <div class="card-body messageContent col-sm-12">
                    <span> <b>Ricevuto da: </b>{{$message -> email}}</span>
                    <span><b>il: </b>{{$message -> created_at}} </span>
                    <span> <b>Testo: </b>{{$message -> message}}</span>
                 </div>
               </div>
             @endforeach
          @endif
      </div>
    </div>
</div>
@endsection
