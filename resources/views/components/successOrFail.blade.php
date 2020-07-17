<div class="success_or_fail">
  @if (session("success"))
    <div class="alert alert-success" role="alert">
      <div class="container">
        <p>{{session("success")}}</p>
      </div>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-warning" role="alert">
      <div class="container">
    @foreach ($errors->all() as $error)
        <p>{{$error}}</p>
    @endforeach
      </div>
    </div>
  @endif
</div>
