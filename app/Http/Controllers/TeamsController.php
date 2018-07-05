<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Team;
use Illuminate\Database\QueryException;

class TeamsController extends Controller
{
    private $team = null;

    public function __construct()
    {
        $this->team = new Team();
    }

    /**
     * list all the teams
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $allTeams = $this->team->getAllTeams();
        return view('team.list')
        ->with('teams', $allTeams)
        ->with('css_arr', [
            'team.css'
        ]);
    }

    /**
     * Show the form for creating a new team.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('team.form');
    }

    /**
     * Store a newly created team
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = $request->all();
        $insert = $this->team->add($team);

        if($insert) {
            \Session::flash('success', 'Team addedd Successfully');
            
        } else {
            \Session::flash('error', 'Error!! SomeThing went Wrong');
        }
        return redirect('admins/teams');
    }


    /**
     * Show the form for editing the specified team.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = $this->team->findById($id);

        if($team) {
            return view('team.form')
                ->with('team', $team);    
        }else {
            \Session::flash('error', 'Error!! Invalid Team');
            return redirect('admins/teams');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if($this->team->updateTeam($data, $id)) {
            \Session::flash('success', 'Team updated Successfully');
        } else {
            \Session::flash('error', 'Error!! SomeThing went Wrong');
        }
        return redirect('admins/teams');
    }

    /**
     * Delete Team by Id
     */
    public function delete($id)
    {

        if($id) {
            \Session::flash('success', 'Team deleted Successfully');
            echo $this->team->deleteTeam($id);
        } else {
            \Session::flash('error', 'Error!! SomeThing went Wrong');
        }
    }


    /**
     * list the team for users
     */

    public function listTeams()
    {
        $request = Request::create('/api/v1/teams', 'GET');
        $allTeams = json_decode(\Route::dispatch($request)->getContent());

        return view('team.usersteam')
            ->with('teams', $allTeams)
            ->with('css_arr', [
                'team.css'
            ]);
    }

    public function teamPlayers($teamId)
    {
        $request = Request::create("/api/v1/teams/$teamId/players", 'GET');
        $teamPlayers = json_decode(\Route::dispatch($request)->getContent());
        //dd($teamPlayers); die;
        return view('team.teamplayer')
            ->with('teamPlayers', $teamPlayers[0])
            ->with('css_arr', [
                'team.css'
            ]);
    }
}
