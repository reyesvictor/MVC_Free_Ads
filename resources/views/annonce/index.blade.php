@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Annonces') }}</div>
                <div class="card-body">
                    @if( Auth::check() )
                    <a class="btn btn-primary btn-lg btn-block" href="{{ route('annonce.new') }}"
                    role="button">Create new annonce</a>
                    <a class="btn btn-primary btn-lg btn-block" href="{{ route('annonce.mylist') }}"
                        role="button">My annonces</a>
                    @endif
                    <a class="btn btn-primary btn-lg btn-block" href="{{ route('annonce.show') }}" role="button">See all annonces</a>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
@endsection