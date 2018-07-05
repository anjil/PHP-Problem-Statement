<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Team;

class TeamsController extends Controller
{
    private $team = null;

    public function __construct()
    {
        $this->team = new Team();
    }

    /**
     * list all the teams
     * @return array
     */
    public function list()
    {
        return $allTeams = $this->team->getAllTeams();
    }

    public function getPlayerByTeamId($teamId)
    {
        return $this->team->getTeamsPlayers($teamId);
    }
}
