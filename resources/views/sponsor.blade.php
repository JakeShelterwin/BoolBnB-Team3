@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)
    <script src='https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js'></script>
      <div class='container card sponsors'>
            <div class="choice row">
              @foreach ($sponsors as $sponsor)
                <div class="sponsor card {{$sponsor -> name}}">
                  <p> <b>Tipo:</b>  {{$sponsor -> name}} </p>
                  <p> <b>Costo:</b>  {{$sponsor -> price}} &euro;</p>
                  <p> <b>Durata: </b> <span class="durationSponsor">{{$sponsor -> duration}}</span> ore</p>

                  <input type="radio" name="sponsor" value="{{$sponsor -> name}}">
                </div>
              @endforeach
            </div>
            <div id='dropin-container'></div>
            <button id='submit-button' disabled>Request payment method</button>
        <input type="text" name="apartmentId" value="{{$apartment -> id }}" disabled style="display: none">
      </div>

      <script>

      var sponsorType;
      var ApartmentId = $('input[name=apartmentId]').val();
       // = $('input:checked').val();
      // console.log(sponsorType);
      $('.choice').on('click', "input[type=radio]", function () {
        sponsorType = $(this).val();
        // console.log(sponsorType);
        var button = $('#submit-button');
        button.prop("disabled", false);
        braintree.dropin.create({
          authorization: '{{ Braintree\ClientToken::generate() }}',
          container: '#dropin-container'
        }, function (createErr, instance) {
          button.on('click', function () {
            instance.requestPaymentMethod(function (err, payload) {
              $.get('{{ route('payment.make') }}', {payload, sponsorType, ApartmentId}, function (response) {
                if (response.success) {
                  // debug
                  // console.log(response.transaction.amount);
                  // alert('Payment successfull');
                  $('.success_or_fail').append("<div class='alert alert-success' role='alert'><div class='container'><p>SUCCESSO</p></div></div>");
                } else {
                  // alert('Payment failed');
                  $('.success_or_fail').append('<div class="alert alert-warning" role="alert"><div class="container"><p>Si è verificato un errore, il pagamento non è andato a buon fine</p></div></div>');
                }
              }, 'json');
            });
          });
        });
      });
      </script>
  @endif
@endsection
