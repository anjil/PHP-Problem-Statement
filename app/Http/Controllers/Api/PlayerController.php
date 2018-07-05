<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Player;

class PlayerController extends Controller
{
    private $player = null;

    public function __construct()
    {
        $this->player = new Player();
    }
}
