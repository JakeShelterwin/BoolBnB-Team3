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
            @if ($user_apartments)
              @foreach ($user_apartments as $apartment)
                <div class="card">
                  <a href="{{route('showApartment',$apartment['id'])}}"><div class="card-header">{{$apartment -> title}}</div></a>
                  <div class="card-body">
                    {{$apartment -> description}}
                  </div>
                </div>
              @endforeach
            @endif
        </div>

        <div class="col-md-4 flex-column-reverse d-flex">
          @if ($user_messages)
            @foreach ($user_messages[0] as $message)
              <div class="card">
                <div class="card-header">Appartamento: {{$message -> apartment -> title}}</div>
                <div class="card-body">
                  <b>Messaggio da: </b>{{$message -> email}} <br>
                  <b>Testo:  </b>{{$message -> message}}
                </div>
              </div>
            @endforeach
          @endif
        </div>
    </div>
</div>
@endsection
