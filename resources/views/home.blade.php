@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card createApartment row">
              <div class="bulge col-sm-5 col-lg-5">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif
                  <a href="{{route('createApartment')}}">Crea Appartamento <i class="far fa-plus-square"></i></a>
              </div>
              <div class="legenda col-sm-5 col-lg-5">
                <span> LEGENDA &nbsp  <i class="fas fa-layer-group"></i></span>
                <div class="nascondino">
                  <ul>
                    <li>Sponsor &nbsp<i class="fas fa-award"></i> </li>
                    <li>Edit&nbsp <i class="far fa-edit"></i> </li>
                    <li>Delete &nbsp<i class="far fa-trash-alt"></i> </li>
                    <li>Stats&nbsp <i class="fas fa-chart-line"></i></li>
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
                      <a class="col-sm-3 clickable" href="{{route('editApartment', $apartment['id'])}}">
                        <i class="far fa-edit"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('deleteApartment', $apartment['id'])}}">
                        <i class="far fa-trash-alt"></i>
                      </a>
                      <a class="col-sm-3 clickable" href="{{route('showApartmentStatistics', $apartment['id'])}}">
                        <i class="fas fa-chart-line"></i>
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
                        <div class="apartmentImg unsponsored" style="background-image: url('{{$apartment->image}}')"></div>
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
                        <i class="fas fa-chart-line"></i>
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
            <div class="bulge col-sm-7">
              <span>Messaggi ricevuti</span>
            </div>
          </div>
          @if ($users_messages_grouped_by_sponsored_apartment)
            @foreach ($users_messages_grouped_by_sponsored_apartment as $singleApartmentMessages)
              @foreach ($singleApartmentMessages as $message)
                  <div class="card message row" data-time="{{$message -> created_at}}">
                    <b> {{$message -> apartment -> title}}</b>
                     <div class="card-body messageContent  col-sm-12">
                      <b>Messaggio da: </b>{{$message -> email}} <br>
                      <b>Testo:  </b>{{$message -> message}}
                    </div>
                  </div>
                @endforeach
            @endforeach
           @endif
         @if ($users_messages_grouped_by_normal_apartment)
           @foreach ($users_messages_grouped_by_normal_apartment as $singleApartmentMessages)
             @foreach ($singleApartmentMessages as $message)
                 <div class="card message row" data-time="{{$message -> created_at}}">
                   <b> {{$message -> apartment -> title}}</b>
                   <div class="card-body messageContent col-sm-12">
                     <b>Messaggio da: </b>{{$message -> email}} <br>
                     <b>Testo:  </b>{{$message -> message}}
                   </div>
                 </div>
               @endforeach
           @endforeach
          @endif
      </div>
    </div>
</div>
@endsection
