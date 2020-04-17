@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ( Session::has('delete'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('delete') }}
                    </div>
                    @endif
                    @if (Auth::check())
                    <div class="alert alert-success" role="alert">
                        {{-- {{ session('status') }} --}}
                        You are logged in!
                    </div>
                    {{-- <h5>You are logged in!</h5> --}}
                    @else
                    <h5>You need to login!</h5>
                    @endif
                    <a class="btn btn-primary btn-lg btn-block" href="{{ route('annonce.index') }}" role="button">Go to
                        Annonces Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection