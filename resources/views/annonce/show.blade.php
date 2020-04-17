@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Annonces') }}</div>
      </div>

      @if(Session::has('update'))
      <div class="alert alert-info" role="alert">
        {{ Session::get('update') }}
      </div>
      @endif

      @if(isset($annonces))
      @foreach( $annonces as $annonce)
      <div class="card">
        <div class="card-header">{{ $annonce->titre }}</div>
        <div class="card-body">
          <p>{{ $annonce->description }}</p>
          <p>{{ $annonce->prix }} € </p>

          <div class="d-flex flex-row bd-highlight mb-3">
            <a class="btn btn-primary  mr-3" href="{{ route('annonce.getAnnonce', $annonce->id) }}" role="button">See
              annonce</a>
            @if( $annonce->user_id == Auth::id())
            {{-- <a class="btn btn-info" href="{{ route('annonce.edit', $annonce->id) }}"
            role="button">Edit</a> --}}

            <form method="post" action="{{route('annonce.edit')}}">
              @csrf
              {{ method_field('patch') }}
              <input id="prodId" name="annonce_id" type="hidden" value="{{ $annonce->id }}">
              <button type="submit" class="btn btn-info mr-3">
                {{ __('Edit') }}
              </button>
            </form>

            <form method="post" action="{{route('annonce.delete')}}">
              @csrf
              {{-- {{ method_field('patch') }} --}}
              <input id="prodId" name="annonce_id" type="hidden" value="{{ $annonce->id }}">
              <button type="submit" class="btn btn-danger">
                {{ __('Delete') }}
              </button>
            </form>

          </div>
          @endif
        </div>
      </div>
      @endforeach

      @elseif (isset($annonce))
      <div class="card">
        <div class="card-header">{{ $annonce->titre }}</div>
        <div class="card-body">
          <p>{{ $annonce->description }}</p>
          <p>{{ $annonce->prix }} € </p>
          <div class="d-flex flex-row bd-highlight mb-3">
            @if( $annonce->user_id == Auth::id())
            {{-- <a class="btn btn-info" href="{{ route('annonce.edit', $annonce->id) }}"
            role="button">Edit</a> --}}

            <form method="post" action="{{route('annonce.edit')}}">
              @csrf
              {{ method_field('patch') }}
              <input id="prodId" name="annonce_id" type="hidden" value="{{ $annonce->id }}">
              <button type="submit" class="btn btn-info mr-3">
                {{ __('Edit') }}
              </button>
            </form>

            <form method="post" action="{{route('annonce.delete')}}">
              @csrf
              {{-- {{ method_field('patch') }} --}}
              <input id="prodId" name="annonce_id" type="hidden" value="{{ $annonce->id }}">
              <button type="submit" class="btn btn-danger">
                {{ __('Delete') }}
              </button>
            </form>

          </div>
          @endif
        </div>
      </div>
    </div>

    @else
    <div class="card">
      <div class="card-header">This annonce doesnt exist</div>
    </div>
    @endif

  </div>
  </form>
</div>
</div>
@endsection