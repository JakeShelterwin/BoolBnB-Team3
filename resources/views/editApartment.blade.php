@extends('layouts.mainLayout')
@section('content')

<div class="apartment">

    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <p>{{$error}}</p>
      @endforeach
    @endif
  <form class="" action="{{route('updateApartment', $apartment['id'])}}" method="post"  enctype="multipart/form-data">
      @csrf
      @method('POST')
    <div class="photo">
      <label for="image">Foto Appartamento: </label>
      <input type="file" name="image">
    </div>
    <div class="info">

      <h1><input type="text" name="title" value="{{old('title', $apartment['title'])}}"></h1>
      <div class="description">
          <h2>Descrizione</h2>
          <p><input type="textarea" name="description" value="{{old('description', $apartment['description'])}}"></p>
      </div>

      <div class="other_info">
        <div class="features">
          <h2>Caratteristiche</h2>
          <ul>

            <li><b>Numero stanze: </b>
              <input type="number" name="rooms_n" value="{{old('rooms_n', $apartment['rooms_n'])}}">
            </li>

            <li><b>Numero letti: </b>
              <input type="number" name="beds_n" value="{{old('beds_n', $apartment['beds_n'])}}">
            </li>

            <li><b>Numero bagni: </b>
              <input type="number" name="bathrooms_n" value="{{old('bathrooms_n', $apartment['bathrooms_n'])}}">
            </li>

            <li><b>Metri quadrati: </b>
              <input type="number" name="square_meters" value="{{old('square_meters', $apartment['square_meters'])}}"> m<SUP>2</SUP>
            </li>
          </ul>
        </div>
        <div class="services">
          <h2>Servizi</h2>
          <ul>

            @foreach ($services as $service)
              <li><input type="checkbox" name="services[]" value="{{$service -> id}}"
                @foreach ($apartment -> services as $serviceApartment)
                  @if ($service['name'] == $serviceApartment['name'])
                    checked
                  @endif
              @endforeach> {{$service -> name}}</li>
            @endforeach
          </ul>
        </div>
        <label for="is_active">Visibilità annuncio</label>
        <select class="" name="is_active">
          @if ($apartment -> is_active)
            <option value="1">Si</option>
            <option value="0">No</option>
          @else
            <option value="0">No</option>
            <option value="1">Si</option>
          @endif
        </select>
        <br>
        <button type="submit" name="submit">Apporta Modifiche</button>
    </div>
  </form>

      <div class="user_interactions">
        <div class="map">

        </div>
        <div class="contact">

        </div>
      </div>
  </div>
</div>

@endsection
