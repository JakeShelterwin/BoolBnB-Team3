@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)
  <div id="statistics">
    <h1>Statistiche di "{{$apartment -> title}}"</h1>
    <div id="charts">

      <div class="chartBox visualizzazioni" style="width: 400px">
        <h2>Visualizzazioni</h2>
        <canvas id="viewsStatsBar" style="width: 400px; height: 400px"></canvas>
        <canvas id="viewsStatsLine" style="width: 400px; height: 400px"></canvas>
      </div>

      <div class="chartBox messaggi" style="width: 400px">
        <h2>Messaggi ricevuti</h2>
        <canvas id="messagesStatsBar" style="width: 400px; height: 400px"></canvas>
        <canvas id="messagesStatsLine" style="width: 400px; height: 400px"></canvas>
      </div>

    </div>
  </div>
  @endif
@endsection
