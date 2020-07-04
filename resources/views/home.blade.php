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
                @if ($user_apartments)
                  @foreach ($user_apartments as $apartment)

                    <a href="{{route('showApartment',$apartment['id'])}}"><div class="card-header">{{$apartment -> title}}</div></a> 
                    <div class="card-body">
                      {{$apartment -> description}}

                    </div>
                  @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
