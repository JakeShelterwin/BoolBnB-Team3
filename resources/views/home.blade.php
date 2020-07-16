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
                  <a href="{{route('createApartment')}}">Crea &nbsp  Appartamento &nbsp  <i class="far fa-plus-square"></i></a>
              </div>
              <div class="legenda col-sm-5 col-lg-5">
                <span> LEGENDA &nbsp  <i class="fas fa-layer-group"></i></span>
                <div class="nascondino">
                  <ul>
                    <li>Sponsor <i class="fas fa-award"></i> </li>
                    <li>Edit <i class="far fa-edit"></i> </li>
                    <li>Delete <i class="far fa-trash-alt"></i> </li>
                    <li>Stats <i class="fas fa-chart-line"></i></li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="apartmentsSponsored row">
              @if ($apartmentSponsored)
                @foreach ($apartmentSponsored as $apartment)
                  <div class="card">
                  <div class="apartment sponsored row attivo{{$apartment['is_active']}}" data-annuncioAttivo="{{$apartment['is_active']}}">
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
                <div class="card">
                  <div class="apartment row attivo{{$apartment['is_active']}}" data-annuncioAttivo="{{$apartment['is_active']}}">
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

        <div class="messages col-md-4 flex-column-reverse d-flex justify-content-end">
          @if ($users_messages_grouped_by_sponsored_apartment)
            @foreach ($users_messages_grouped_by_sponsored_apartment as $singleApartmentMessages)
              @foreach ($singleApartmentMessages as $message)
                  <div class="card" data-time="{{$message -> created_at}}">
                    <div class="card-header">Appartamento: {{$message -> apartment -> title}}</div>
                    <div class="card-body">
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
                 <div class="card" data-time="{{$message -> created_at}}">
                   <div class="card-header">Appartamento: {{$message -> apartment -> title}}</div>
                   <div class="card-body">
                     <b>Messaggio da: </b>{{$message -> email}} <br>
                     <b>Testo:  </b>{{$message -> message}}
                   </div>
                 </div>
               @endforeach
           @endforeach
          @endif
          {{-- aggiunta grafica sopra ai messaggi ricevuti --}}
          <div class="card">
            <div class="card-header">{{ __('Messaggi Ricevuti') }}</div>
            <div class="card-body"> </div>
          </div>
        </div>
    </div>
</div>
@endsection
