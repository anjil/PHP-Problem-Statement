@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Player</div>
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" 
                        action="{{ !isset($player['id']) ? route('player.store') : route('player.update', $player['id']) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" 
                                    value="{{ isset($player['first_name']) ? $player['first_name'] : old('first_name') }}"  required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" 
                                    value="{{ isset($player['last_name']) ? $player['last_name'] : old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('team') ? ' has-error' : '' }}">
                            <label for="team" class="col-md-4 control-label">Team</label>

                            <div class="col-md-6">
                                <select id="team" name="team" class="form-control" required>
                                    <option value="">Select Team</option>
                                    @foreach($teams as $id => $name)
                                        <option value="{{ $id }}" {{ (isset($player['team_id']) && $id == $player['team_id']) ? 'selected="selected"' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('team'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('team') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
                            <label for="log"o class="col-md-4 control-label">Profile Image</label>

                            <div class="col-md-6">
                                <input type="file" name="profile_image" id="profile_image" accept="image/*">
                                @if ($errors->has('profile_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profile_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
