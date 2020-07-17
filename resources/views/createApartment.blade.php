@extends('layouts.mainLayout')
@section('content')

<div class="apartment card container edit-Create">

  <form class="" action="{{route('storeApartment')}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('POST')

  <div class="info">
    <ul>
      <li><b>Titolo:</b> <input type="text" name="title" value="{{old('title')}}" placeholder="Inserisci un titolo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci un titolo'"></li>
      <li><b>Foto Appartamento:</b><input type="file" name="image"></li>
      <li class="address"> <b>Indirizzo:</b><input type="text" name="address" value="{{old('address')}}" placeholder="Via e n° / CAP / Città" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Via e n° / CAP / Città'">
      <div class="coordinate">
        <input id="latitude" type="text" name="lat" value="">
        <input id="longitude" type="text" name="lon" value="">
      </div>
      </li>
      <li><b>Descrizione:</b> <textarea rows="4" cols="40" name="description" placeholder="Inserisci la tua richiesta" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci la tua richiesta'">{{old('description') }}</textarea></li>
    </ul>

      <div class="other_info">
        <div class="features">
          <ul>

            <li><b>Numero stanze: </b>
              <input type="number" name="rooms_n" value="{{old('rooms_n')}}">
            </li>

            <li><b>Numero letti: </b>
              <input type="number" name="beds_n" value="{{old('beds_n')}}">
            </li>

            <li><b>Numero bagni: </b>
              <input type="number" name="bathrooms_n" value="{{old('bathrooms_n')}}">
            </li>

            <li><b>Metri quadrati: </b>
              <input type="number" name="square_meters" value="{{old('square_meters')}}"> m<SUP>2</SUP>
            </li>
          </ul>
        </div>
        <div class="services">
          <h2>Servizi</h2>
          <ul style="margin-left: 10px">

            @foreach ($services as $service)
              <li><input type="checkbox" name="services[]" value="{{$service -> id}}"> {{$service -> name}}</li>
            @endforeach
          </ul>
        </div>
        <label for="is_active">Vuoi rendere da subito attivo l'annuncio?</label>
        <select class="" name="is_active">
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        <br>
        <button id="bottoneCreate" type="submit" name="submit" disabled >Crea Appartamento</button>
      </form>
    </div>
  </div>
</div>

@endsection
