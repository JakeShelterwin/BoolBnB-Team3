@extends('layouts.mainLayout')
@section('content')

<div class="apartment">

  <div class="photo">
    <img src="{{$apartment['image']}}" alt="photo{{$apartment['id']}}">
  </div>

  <div class="info">
    @if ($errors->any())
      @foreach ($errors->all() as $error)
        <p>{{$error}}</p>
      @endforeach
    @endif
    <form class="" action="{{route('updateApartment', $apartment['id'])}}" method="post">
      @csrf
      @method('POST')
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
              <select class="" name="rooms_n">
                @for ($i=1; $i < 11; $i++)
                  <option value="{{$i}}" @if ($i == $apartment['rooms_n'])
                    selected
                  @endif>{{$i}}</option>
                @endfor
              </select>
            </li>

            <li><b>Numero letti: </b>
              <select class="" name="bedrooms_n">
                @for ($i=1; $i < 11; $i++)
                  <option value="{{$i}}" @if ($i == $apartment['bedrooms_n'])
                    selected
                  @endif>{{$i}}</option>
                @endfor
              </select>
            </li>

            <li><b>Numero bagni: </b>
              <select class="" name="bathrooms_n">
                @for ($i=1; $i < 11; $i++)
                  <option value="{{$i}}" @if ($i == $apartment['bathrooms_n'])
                    selected
                  @endif>{{$i}}</option>
                @endfor
              </select>
            </li>

            <li><b>Metri quadrati: </b>
              <select class="" name="square_meters">
                @for ($i=30; $i < 201; $i++)
                  <option value="{{$i}}" @if ($i == $apartment['square_meters'])
                    selected
                  @endif>{{$i}}</option>
                @endfor
              </select> metri2
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
        <button type="submit" name="submit">Submittami Tutto</button>
      </form>
    </div>

      <div class="user_interactions">
        <div class="map">

        </div>
        <div class="contact">

        </div>
      </div>
  </div>
</div>

@endsection
