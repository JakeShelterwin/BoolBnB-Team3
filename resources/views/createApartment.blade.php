@extends('layouts.mainLayout')
@section('content')

<div class="apartment">
  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  @endif
  <form class="" action="{{route('storeApartment')}}" method="post">
    @csrf
    @method('POST')

  <div class="photo">
    <label for="image">Foto Appartamento: </label>
    <input type="text" name="image" value="{{old('image')}}">
  </div>

  <div class="info">
      <label for="title">Nome Appartamento </label>
      <input type="text" name="title" value="{{old('title')}}">
      <div class="description">
          <h2>Descrizione</h2>
          <p><input type="textarea" name="description" value="{{old('description')}}"></p>
      </div>

      <label for="address">Indirizzo Appartamento</label>
      <input type="text" name="address" value="{{old('address')}}">
      <input style="display:none" type="text" name="lat" value="">
      <input style="display:none" type="text" name="lon" value="">
      
      
      

      <div class="other_info">
        <div class="features">
          <h2>Caratteristiche</h2>
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
          <ul>

            @foreach ($services as $service)
              <li><input type="checkbox" name="services[]" value="{{$service -> id}}">{{$service -> name}}</li>
            @endforeach
          </ul>
        </div>
        <label for="is_active">Vuoi rendere già subito attivo l'annuncio?</label>
        <select class="" name="is_active">
          <option value="1">Si</option>
          <option value="0">No</option>
        </select>
        <br>
        <button type="submit" name="submit">Crea Appartamento</button>
      </form>
    </div>
  </div>
</div>

@endsection
