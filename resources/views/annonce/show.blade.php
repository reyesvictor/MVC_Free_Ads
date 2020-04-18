@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card">
        <div class="card-header">
          <a class='float-left w-25 p-3' href="{{ route('annonce.show') }}">
            Annonces
          </a>
          @if(Auth::check())
          <a class="btn btn-info float-right mr-2" href="{{ route('annonce.mylist') }}" role="button">See All Mine</a>
          <a class="btn btn-info float-right mr-2" href="{{ route('annonce.new') }}" role="button">Create new</a>
          <a class="btn btn-info float-right mr-2" href="{{ route('annonce.latest') }}" role="button">3 Most Recent</a>
          @endif
        </div>
      </div>
      <br>


      <div class="card">
        <div class="card-header">
          {{ __('Search an annonce') }}
          <br><br>
          <form action="{{route('annonce.search')}}">
            {{-- @csrf --}}
            <div class="form-group row">
              <div class="col-md-6">
                <select name="prix" clas='browser-default custom-select'>
                  <option value='0' selected>--Price option--</option>
                  <option value="1">Under 100</option>
                  <option value="2">100 - 300</option>
                  <option value="3">300 - ...</option>
              </select>
              <br><br>
                <input id="search" type="text" class="form-control @error('search') is-invalid @enderror" name="s"
                  value="{{ old('search') }}" autocomplete="search" autofocus placeholder="search">
                @error('search')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror </div>
            </div>
            <button type="submit" class="btn btn-info mr-3">
              {{ __('Search') }}
            </button>
          </form>
        </div>
      </div>
      <br>


      @if(Session::has('update'))
      <div class="alert alert-info" role="alert">
        {{ Session::get('update') }}
      </div>
      @endif

      @if(Session::has('delete'))
      <div class="alert alert-danger mt-3" role="alert">
        {{ Session::get('delete') }}
      </div>
      @endif

      @if(isset($annonces))
      @foreach( $annonces as $annonce)
      <div class="card">
        <div class="card-header">{{ $annonce->titre }}</div>
        <div class="card-body">
          <p>{{ $annonce->description }}</p>
          <p>{{ $annonce->prix }} € </p>
          @if(isset($annonce->photos))
          @foreach ($annonce->photos as $photo)
          <img class="img-thumbnail w-25 p-3" src="{{ asset( 'storage/' . $photo->path) }}">
          @endforeach
          <br>
          <br>
          @endif

          <div class="d-flex flex-row bd-highlight mb-3">
            {{-- <a class="btn btn-primary  mr-3" href="{{ route('annonce.getAnnonce', $annonce->id) }}"
            role="button">See
            annonce</a> --}}

            @if( $annonce->user_id == Auth::id())
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
            @endif

          </div>
        </div>
      </div>
      <div class="card-footer text-muted">
        Created {{ $annonce->created_at->format('d-m-y H:i') }}
        and Updated {{ $annonce->updated_at->format('d-m-y H:i') }}
      </div>
      <br>



      @endforeach


      @elseif (isset($annonce))
      <div class="card">
        <div class="card-header">{{ $annonce->titre }}</div>
        <div class="card-body">
          <p>{{ $annonce->description }}</p>
          <p>{{ $annonce->prix }} € </p>
          @if( $annonce->user_id == Auth::id())
          <div class="d-flex flex-row bd-highlight mb-3">
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
      <div class="card-footer text-muted">
        Created {{ $annonce->created_at->format('d-m-y H:i') }}
        and Updated {{ $annonce->updated_at->format('d-m-y H:i') }}
      </div>

      @else
      <div class="card">
        <div class="card-header">This annonce doesnt exist</div>
      </div>
      @endif

      {{-- Pagination --}}
      <div class="d-flex justify-content-center">
        @if (isset($annonces) && $annonces instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $annonces->links() }}
        @elseif (isset($annonce) && $annonce instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $annonce->links() }}
        @endif
      </div>
    </div>
  </div>
</div>


@endsection