@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)
    ciao sono uno sponsor
    <script src='https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js'></script>
      <div class='container'>
        {{-- {{$apartment -> id }} --}}
        <div class='row'>
          <div class='col-md-8 col-md-offset-2'>
            <div class="choice">
              <input type="radio" name="sponsor" value="silver">
              <label for="silver">silver</label>
              <input type="radio" name="sponsor" value="gold">
              <label for="gold">gold</label>
              <input type="radio" name="sponsor" value="platinum">
              <label for="platinum">platinum</label>
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
      $('.choice').on('click', "input[name=sponsor]", function () {
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
                  alert('Payment successfull');
                  console.log(response.transaction.amount);
                } else {
                  alert('Payment failed');
                }
              }, 'json');
            });
          });
        });
      });

      // $('#submit-button').on('click', getPayment());
      //
      // function getPayment(){
      //   braintree.dropin.create({
      //     authorization: '{{ Braintree\ClientToken::generate() }}',
      //     container: '#dropin-container'
      //   }, function (createErr, instance) {
      //     $('#submit-button').on('click', function () {
      //       instance.requestPaymentMethod(function (err, payload) {
      //         $.get('{{ route('payment.make') }}', {payload}, function (response) {
      //           console.log("ciaio");
      //           if (response.success) {
      //             alert('Payment successfull');
      //             // console.log(response.transaction.amount);
      //           } else {
      //             alert('Payment failed');
      //           }
      //         }, 'json');
      //       });
      //     });
      //   });
      // }



      </script>
  @endif
@endsection
