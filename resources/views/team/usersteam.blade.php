@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">

            @if (count($teams) > 0)

                <ul class="event-list">
            @foreach ($teams as $team)

                <li>
                    @if ($team->logo_uri)
                        <img alt="{{ $team->name }}" src="{{ url('logo/' . $team->logo_uri) }}" />
                    @endif

                    <div class="info">
                        <h2 class="title">{{ $team->name }}</h2>
                    </div>

                    <div class="social">
                        <ul>
                            <li class="action"><a href="{{ route('teams.players', $team->id) }}"><span class="fa fa-pencil-square-o"></span></a></li>
                        </ul>
                    </div>

                </li>

            @endforeach
                </ul>
            @else
                No Data!! Login to admin panel and add Team/Player
                <br />
                Default UserName: admin@pro.com
                <br />
                Password: 123456
            @endif

        </div>
    </div>
</div>
@endsection
