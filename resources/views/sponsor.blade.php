@extends('layouts.mainLayout')
@section('content')
  @if (auth()->user()-> id == $apartment -> user_id)
    @if ($apartment -> sponsor_expire_time <= time())
      <script src='https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js'></script>
        <div class="container card titleSponsor">
            <h2>Sponsorizza il tuo appartamento</h2>
        </div>
        <div class='container card sponsors'>
              <div class="choice row">
                @foreach ($sponsors as $sponsor)
                  <div class="sponsor card {{$sponsor -> name}}">
                    <span> <b>Tipo:</b>  {{$sponsor -> name}} </span>
                    <span> <b>Costo:</b>  {{$sponsor -> price}} &euro;</span>
                    <span> <b>Durata: </b> <span class="durationSponsor">{{$sponsor -> duration}}</span> ore</span>

                    <input type="radio" name="sponsor" value="{{$sponsor -> name}}">
                  </div>
                @endforeach
              </div>
              <div id='dropin-container'></div>
              <button id='submit-button' disabled>Esegui Pagamento</button>
          <input type="text" name="apartmentId" value="{{$apartment -> id }}" disabled style="display: none">
        </div>

        <script>

        var sponsorType;
        var ApartmentId = $('input[name=apartmentId]').val();
         // = $('input:checked').val();
        // console.log(sponsorType);
        $('.choice').on('click', ".sponsor.card", function () {
          sponsorType = $(this).find("input[type=radio]").val();
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
                    $('.success_or_fail').append("<div class='alert alert-success' role='alert'><div class='container'><p>Appartamento Sponsorizzato con Successo</p></div></div>");
                  } else {
                    //debug
                    // alert('Payment failed');
                    $('.alert-warning').remove();
                    $('.success_or_fail').append('<div class="alert alert-warning" role="alert"><div class="container"><p>Si è verificato un errore, il pagamento non è andato a buon fine</p></div></div>');
                  }
                }, 'json');
              });
            });
          });
        });

        $('.choice').on('click', ".sponsor.card", function () {
          $(".sponsor.card").css({"box-shadow": "0px 1px 11px -2px rgba(0, 0, 0, 0.3), inset 0 -3px 4px -1px rgba(0,0,0,0.2), 0 -10px 15px -1px rgba(255,255,255,0.6),  inset 0 20px 30px 0 rgba(255,255,255,0.2)", "color" : "#1b3c59"});
          $(this).css({"box-shadow": "inset 0px 1px 7px -2px rgba(0, 0, 0, 0.3)", "color" : "#E31C5F"});
          $(this).find("input[type=radio]").prop("checked", true);
        });

        </script>
    @else
      <div class="container permissionDenied">
        <h1>Sponsor già attivo per questo appartamento</h1>
      </div>
    @endif
  @else
    <div class="container permissionDenied">
      <h1>Ops... non hai il permesso per accedere a questa pagina</h1>
    </div>
  @endif
@endsection
