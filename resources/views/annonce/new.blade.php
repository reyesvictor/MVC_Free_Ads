@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div class="card-header">{{ __('Create new annonce') }}</div>
          @if ( Session::has('success'))
          <br>
          <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
          </div>
          @endif
          <br>
          <form method="post" action="{{route('annonce.create')}}">
            @csrf
            {{-- {{ method_field('patch') }} --}}
            <div class="form-group row">
              <label for="titre" class="col-md-4 col-form-label text-md-right">{{ __('Titre') }}</label>
              <div class="col-md-6">
                <input id="titre" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre"
                  value="{{ old('titre') }}" required autocomplete="titre" autofocus placeholder="Titre">

                @error('titre')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror </div>
            </div>
            <div class="form-group row">
              <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
              <div class="col-md-6">
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                  name="description" value="{{ old('description') }}" required autocomplete="description" autofocus
                  placeholder="Description">

                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror </div>
            </div>
            <div class="form-group row">
              <label for="prix" class="col-md-4 col-form-label text-md-right">{{ __('Prix') }}</label>
              <div class="col-md-6">
                <input id="prix" type="number" class="form-control @error('prix') is-invalid @enderror" name="prix"
                  value="{{ old('prix') }}" required autocomplete="prix" autofocus placeholder="Prix">

                @error('prix')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Publish') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</form>
</div>
@endsection