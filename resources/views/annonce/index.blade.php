@extends('layouts.app')

@section('content')

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.annoncecard')
            <br>
            @if(App\Http\Controllers\MessageController::notif() != null)
            <div class="alert alert-success" role="alert">
                You have {{ App\Http\Controllers\MessageController::notif() }} new messages !
            </div>
            @endif
            @include('includes.messageriecard')
        </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection