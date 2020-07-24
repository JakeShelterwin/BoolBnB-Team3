@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)

<div class="apartment card container edit-Create">
  <div class="row">
      <form class="col-md-12 col-lg-6" action="{{route('updateApartment', $apartment['id'])}}" method="post"  enctype="multipart/form-data">
          @csrf
          @method('POST')
        <div class="info">
          <ul>
            <li><b>Titolo:</b> <input  class="listen" type="text" name="title" value="{{old('title', $apartment['title'])}}"></li>
            <li class="photo"> <b>Foto Appartamento:</b> <input type="file" name="image"></li>
            <li class="address"> <b>Indirizzo:</b>
              <input class="listen" type="text" name="address" value="{{old('address', $apartment['address'])}}">
              <div class="coordinate">
                <input id="latitude" type="text" name="lat" value="">
                <input id="longitude" type="text" name="lon" value="">
              </div>
            </li>
            <li><b>Descrizione:</b> <textarea  class="listen"rows="4" cols="35" name="description" value="{{old('description', $apartment['description'])}}" placeholder="Inserisci la tua richiesta" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Inserisci la tua richiesta'">{{old('description', $apartment['description'])}}</textarea></li>
          </ul>

          <div class="other_info">
            <div class="features">
              <ul>
                <li><b>Numero stanze: </b>
                  <input  class="listen" type="number" name="rooms_n" value="{{old('rooms_n', $apartment['rooms_n'])}}">
                </li>
                <li><b>Numero letti: </b>
                  <input class="listen" type="number" name="beds_n" value="{{old('beds_n', $apartment['beds_n'])}}">
                </li>
                <li><b>Numero bagni: </b>
                  <input class="listen" type="number" name="bathrooms_n" value="{{old('bathrooms_n', $apartment['bathrooms_n'])}}">
                </li>
                <li><b>Metri quadrati: </b>
                  <input class="listen" type="number" name="square_meters" value="{{old('square_meters', $apartment['square_meters'])}}"> m<SUP>2</SUP>
                </li>
              </ul>
            </div>
            <div class="services">
              <b>Servizi</b>
              <ul style="margin-left: 10px">
                @foreach ($services as $service)
                  <li><input class="listen" type="checkbox" name="services[]" value="{{$service -> id}}"
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
            <button id="bottoneCreate" type="submit" name="submit" disabled>Apporta Modifiche</button>
        </div>
      </div>
    </form>
    <div class="title col-md-12 col-lg-6">
      <h1>boolbnb</h1>
    </div>
  </div>
</div>

  @else
    <div class="container permissionDenied">
      <h1>Ops... non hai il permesso per accedere a questa pagina</h1>
    </div>
  @endif
@endsection
