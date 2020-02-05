@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="jumbotron">
                @guest
                    <h1 class="display-4">{{ __('Hello Guest!') }}</h1>
                    <p class="lead">{{ __('You must be logged in to view the feed') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">{{ __('Register') }}</a>
                @else
                    <h1 class="display-4">{{ __('Hello') }} {{ Auth::user()->name }}!</h1>
                    <p class="lead">{{ __('Thanks for registering') }}</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">{{ __('View Feed') }}</a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
