<?php

namespace App\Model\DbLayer;

use Illuminate\Database\Eloquent\Model;


class TeamPlayer extends Model
{
    
    protected $fillable = array('player_id', 'team_id');
    protected $table = 'team_player';
    public $timestamps = false;
}
