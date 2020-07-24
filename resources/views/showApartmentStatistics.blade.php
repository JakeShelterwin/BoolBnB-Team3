@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)
    <div class="container card allStats">
      <div id="statistics">
        <h1> <i class="far fa-chart-bar"></i> Statistiche per {{$apartment -> title}}</h1>
        <div id="charts" class="col-sm-12 row" style="padding: 0; margin: 0;">

          <div class="chartBox visualizzazioni col-sm-12 col-md-6">
            <h2>Visualizzazioni</h2>
            <small>negli ultimi 365 giorni</small>
            <canvas id="viewsStatsBar" style="width: 400px; height: 400px"></canvas>
            <canvas id="viewsStatsLine" style="width: 400px; height: 400px"></canvas>
          </div>

          <div class="chartBox messaggi col-sm-12 col-md-6">
            <h2>Messaggi ricevuti</h2>
            <small>negli ultimi 365 giorni</small>
            <canvas id="messagesStatsBar" style="width: 400px; height: 400px"></canvas>
            <canvas id="messagesStatsLine" style="width: 400px; height: 400px"></canvas>
          </div>

        </div>
      </div>
    </div>
  @else
    <div class="container permissionDenied">
      <h1>Ops... non hai il permesso per accedere a questa pagina</h1>
    </div>
  @endif
@endsection
