@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Send New Message</div>
        
        @if ( Session::has('success'))
        <br>
        <div class="alert alert-success" role="alert">
          {{ Session::get('success') }}
        </div>
        @endif

        <div class="card-body">
          <form method="post" action="{{route('message.create')}}" enctype="multipart/form-data">
            @csrf
            {{-- {{ method_field('patch') }} --}}
            {{-- @method('PATCH') --}}

            @if(isset($users))
            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('User') }}</label>
            <select name="user_id_receiver" class='col-md-4 form-group browser-default custom-select' required>
              <option disabled selected value="">--User to talk to--</option>
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
            @endif

            <div class="form-group row">
              <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
              <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                  value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="title">

                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror </div>
            </div>

            <div class="form-group row">
              <label for="content" class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>
              <div class="col-md-6">
                <input id="content" type="text" class="form-control @error('content') is-invalid @enderror"
                  name="content" value="{{ old('content') }}" required autocomplete="content" autofocus
                  placeholder="content">

                @error('content')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror </div>
            </div>
            <div class="form-group row">
              <div class="col text-center">
                <button type="submit" class="btn btn-info mr-3">
                  {{ __('Send') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection