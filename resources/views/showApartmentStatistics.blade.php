@extends('layouts.mainLayout')

@section('content')

  <div id="charts">
    <div class="visualizzazioni" style="border: 1px solid black; width: 400px; height: 400px">
      <canvas id="viewsStats" width="400px" height="400px"></canvas>

    </div>

    <div class="messaggi" style="border: 1px solid black; width: 400px; height: 400px">

      <canvas id="messagesStats" width="400px" height="400px"></canvas>

    </div>


    {{-- @foreach ($messages as $message)
      <p>{{$message['message']}}</p>

    @endforeach
    @foreach ($views as $view)
      <p>{{$view['created_at']}}</p>

    @endforeach --}}
  </div>

@endsection
