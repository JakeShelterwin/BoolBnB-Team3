@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)
    <script src='https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js'></script>
      <div class='container'>
        {{-- {{$apartment -> id }} --}}
        <div class='row'>
          <div class='col-md-8 col-md-offset-2'>
            <div class="choice">
              @foreach ($sponsors as $sponsor)
                <div class="sponsor">
                  <input type="radio" name="sponsor" value="{{$sponsor -> name}}">
                  {{$sponsor -> name}} {{$sponsor -> price}}
                </div>
              @endforeach
            </div>
            <div id='dropin-container'></div>
            <button id='submit-button' disabled>Request payment method</button>
          </div>
        </div>
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
                // console.log("ciao");
                if (response.success) {
                  console.log(response.transaction.amount);
                  alert('Payment successfull');
                } else {
                  alert('Payment failed');
                }
              }, 'json');
            });
          });
        });
      });
      </script>
  @endif
@endsection
