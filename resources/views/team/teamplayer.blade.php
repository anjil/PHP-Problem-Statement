@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
            <div class="panel panel-info">
                <div class="panel-heading"><h3 class="panel-title">{{ $teamPlayers->name }}</h3></div>
            </div>

            <div class="panel-body">
                <div class="row">

                    <div class="col-md-3 col-lg-3 " align="center">
                        @if($teamPlayers->logo_uri)
                            <img alt="User Pic" src="{{ url('logo/' . $teamPlayers->logo_uri) }}" class="img-circle img-responsive">
                        @else
                            <img alt="No Image" src="{{ url('no_img/no_image.png') }}" class="img-circle img-responsive">
                        @endif
                    </div>

                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Total Team Players:</td>
                                    <td>{{ count($teamPlayers->player) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="row"><h1>Team Players.</h1></div></div>
                <div class="row">
                    @if ($teamPlayers->player)
                    @foreach($teamPlayers->player as $player)
                        <div class="column">
                            @if($player->image_uri)
                                <img src="{{ url('profile_image/' . $player->image_uri) }}" class="img-circle img-responsive"/>
                            @else
                                <img alt="No Image" src="{{ url('no_img/no_image.png') }}" class="img-circle img-responsive">
                            @endif
                            <p style="text-align: center;">Name<br>{{ $player->first_name}} {{ $player->last_name}}</p>
                        </div>
                    @endforeach
                    @else
                        No Players assigned in this team.
                    @endif
                </div>
        </div>
    </div>
</div>
@endsection
