@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">

      @if(App\Http\Controllers\MessageController::notif() != null)
      <br>
      <div class="alert alert-success" role="alert">
        You have {{ App\Http\Controllers\MessageController::notif() }} new messages !
      </div>
      @endif

      @if(Session::has('read'))
      <br>
      <div class="alert alert-info" role="alert">
        {{ Session::get('read') }}
      </div>
      @endif

      @if(isset($messages))
      @foreach( $messages as $message)
      <div class="card">
        <div class="card-header">{{ $message->title }}</div>
        <div class="card-body">
          <p>{{ $message->content }}</p>

          @if($message->seen == 0)
          <div class="col-md-4">
            <form action="{{ route('message.read') }}" method="POST">
              @csrf
              <input type="text" name="message_id" value="{{ $message->message_id }}" hidden>
              <button type="submit" class="btn btn-info mr-3">
                {{ __('Mark as Read') }}
              </button>
            </form>
          </div>
          @endif

          <br>
          <footer class="blockquote-footer">Écrit à {{ $message->created_at }}<cite title="Source Title">par
              {{ $message->name }}</cite></footer>
        </div>
      </div>
      <br>
      @endforeach
      @endif

    </div>
  </div>
</div>
</div>
@endsection