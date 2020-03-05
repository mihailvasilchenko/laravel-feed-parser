@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Top 10 Words') }}</div>

                <div class="card-body">
                    <ol class="lead">
                        @foreach ($feed['top'] as $word => $count)
                            <li>
                                {{ $word }} <span class="badge badge-primary">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h2 class="display-6 mb-4"><a href="{{ $feed['permalink'] }}">{{ $feed['title'] }}</a></h2>
            @foreach ($feed['items'] as $item)
                <div class="card mb-4">
                    <div class="card-body">
                        <h3><a href="{{ $item->get_link() }}">{{ $item->get_title() }}</a></h3>
                        {!! $item->get_description() !!}
                        <p class="mb-0"><small>Posted on {{ $item->get_date('j F Y | g:i a') }}</small></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
