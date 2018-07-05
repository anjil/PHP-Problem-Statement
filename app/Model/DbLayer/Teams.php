<?php

namespace App\Model\DbLayer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Teams extends Model
{
    use SoftDeletes;
    protected $fillable = array('name', 'logo_uri');

    public function player()
    {
        return $this->hasMany('App\Model\DbLayer\Players', 'team_id', 'id');
    }
}
