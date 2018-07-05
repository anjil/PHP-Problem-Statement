@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
            <a href="{{route('team.create')}}">Add Team</a>
        </div>
    </div>

    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">

            @if (count($teams) > 0)

                <ul class="event-list">
            @foreach ($teams as $team)

                <li>
                    @if($team['logo_uri'])
                        <img alt="User Pic" src="{{ url('logo/' . $team['logo_uri']) }}" class="img-responsive">
                    @else
                        <img alt="No Image" src="{{ url('no_img/no_image.png') }}" class="img-responsive">
                    @endif
                    
                    <div class="info">
                        <h2 class="title">{{ $team['name'] }}</h2>
                    </div>

                    <div class="social">
                        <ul>
                            <li class="action"><a href="{{route('team.edit', $team['id'])}}"><span class="fa fa-pencil-square-o"></span></a></li>
                            <li class="action"><a href="{{route('team.delete', $team['id'])}}" class="delete"><span class="fa fa-trash-o"></span></a></li>
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
