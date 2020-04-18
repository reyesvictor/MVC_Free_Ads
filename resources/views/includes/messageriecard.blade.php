@if( Auth::check() )
<div class="card">
  <div class="card-header">Messagerie</div>
  <div class="card-body">
      <a class="btn btn-primary btn-lg btn-block" href="{{ route('message.new') }}" role="button">Create
          new message</a>
      <a class="btn btn-primary btn-lg btn-block" href="{{ route('message.inbox') }}" role="button">My inbox</a>
  </div>
</div>
@endif