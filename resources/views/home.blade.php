@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <div class="header">
                        <h1>Top 10</h1>
                    </div>

                    @foreach ($top as $key => $word)
                        <div class="item">
                            <h2>{{ $word }}</h2>
                            <p>{{ $key }}</p>
                        </div>
                    @endforeach

                    <div class="header">
                        <h1><a href="{{ $permalink }}">{{ $title }}</a></h1>
                    </div>

                    @foreach ($items as $item)
                        <div class="item">
                            <h2><a href="{{ $item->get_permalink() }}">{{ $item->get_title() }}</a></h2>
                            {!! $item->get_description() !!}
                            <p><small>Posted on {{ $item->get_date('j F Y | g:i a') }}</small></p>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
