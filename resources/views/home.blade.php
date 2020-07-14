@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">{{ __('Dashboard') }}</div>

              <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif
                  <a href="{{route('createApartment')}}">Crea nuovo appartamento</a>
              </div>
            </div>
            @if ($apartmentSponsored)
              @foreach ($apartmentSponsored as $apartment)
                <div class="card sponsored attivo{{$apartment['is_active']}}" data-annuncioAttivo="{{$apartment['is_active']}}">
                  <a href="{{route('showApartment',$apartment['id'])}}"><div class="card-header">{{$apartment -> title}}</div></a>

                  <div class="card-body">
                    {{$apartment -> description}}
                  </div>
                  <p style="margin-bottom: 0; color: white">Sponsor Attivo per questo appartamento</p>
                  <a href="{{route('editApartment', $apartment['id'])}}">
                    Modifica
                  </a>
                  <a href="{{route('deleteApartment', $apartment['id'])}}">
                    Cancella
                  </a>
                  <a href="{{route('showApartmentStatistics', $apartment['id'])}}">
                    MOSTRA STATISTICS
                  </a>
                </div>
              @endforeach
            @endif
            @if ($user_apartments)
              @foreach ($user_apartments as $apartment)
                <div class="card attivo{{$apartment['is_active']}}" data-annuncioAttivo="{{$apartment['is_active']}}">
                  <div class="card-header"><a href="{{route('showApartment',$apartment['id'])}}">{{$apartment -> title}}</a>
                  <a href="{{route("sponsorApartment", $apartment->id)}}">Sponsorizzami tutto</a>
                  <a href="{{route('editApartment', $apartment['id'])}}">
                    Modifica
                  </a>
                  <a href="{{route('deleteApartment', $apartment['id'])}}">
                    Cancella
                  </a>
                  <a href="{{route('showApartmentStatistics', $apartment['id'])}}">
                    MOSTRA STATISTICS
                  </a>
                </div>
                     {{-- @if ($apartment -> is_active)
                        <form action="{{route('updateApartment', $apartment['id'])}}" method="post">
                          @csrf
                          @method('POST')
                          <input style="display:none" type="text" name="is_active" value="0">
                          <button type="submit" name="submit">Disattiva</button>
                        </form>
                      @else
                        <form action="{{route('updateApartment', $apartment['id'])}}" method="post">
                          @csrf
                          @method('POST')
                          <input style="display:none" type="text" name="is_active" value="1">
                          <button type="submit" name="submit">Attiva</button>
                        </form>
                      @endif --}}
                  <div class="card-body">
                    {{$apartment -> description}}
                  </div>

                </div>
              @endforeach
            @endif
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
