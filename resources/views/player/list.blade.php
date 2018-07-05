@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
            <a href="{{route('player.create')}}">Add Player</a>
        </div>
    </div>

    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
            @if (count($players) > 0)

                <ul class="event-list">
            @foreach ($players as $player)

                <li>

                    @if($player['image_uri'])
                        <img src="{{ url('profile_img/' . $player['image_uri']) }}" class="img-responsive"/>
                    @else
                        <img alt="No Image" src="{{ url('no_img/no_image.png') }}" class="img-responsive">
                    @endif

                    <div class="info">
                        <h2 class="title">{{ $player['first_name'] }} {{ $player['last_name'] }}</h2>
                    </div>

                    <div class="social">
                        <ul>
                            <li class="action"><a href="{{route('player.edit', $player['id'])}}"><span class="fa fa-pencil-square-o"></span></a></li>
                            <li class="action"><a href="{{route('player.delete', $player['id'])}}" class="delete"><span class="fa fa-trash-o"></span></a></li>
                        </ul>
                    </div>
                    
                </li>

            @endforeach
                </ul>
            @else
                No Data!!
            @endif

        </div>
    </div>
</div>
@endsection
