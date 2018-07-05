<?php

namespace App\Model\DbLayer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Players extends Model
{
    use SoftDeletes;
    protected $fillable = array('first_name', 'last_name', 'image_uri', 'team_id');
}
