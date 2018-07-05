<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Player;
use App\Model\Team as Team;
use Illuminate\Database\QueryException;

class PlayersController extends Controller
{
    private $player = null;

    public function __construct()
    {
        $this->player = new Player();
    }

    /**
     * list all the player
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $allPlayer = $this->player->getAllPlayer();
        return view('player.list')
            ->with('players', $allPlayer)
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
        $teams = Team::teamList();
        return view('player.form')
            ->with('teams', $teams);
    }

    /**
     * Store a newly created player
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'team' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $player = $request->all();
        $insert = $this->player->add($player);

        if($insert) {
            \Session::flash('success', 'Player addedd Successfully');
            
        } else {
            \Session::flash('error', 'Error!! SomeThing went Wrong');
        }
        return redirect('admins/players');
    }


    /**
     * Show the form for editing the specified player.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $player = $this->player->findById($id);

        if($player) {
            $teams = Team::teamList();
            return view('player.form')
                ->with('player', $player)
                ->with('teams', $teams);    
        }else {
            \Session::flash('error', 'Error!! Invalid Team');
            return redirect('admins/players');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'team' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if($this->player->updatePlayer($data, $id)) {
            \Session::flash('success', 'Player updated Successfully');
        } else {
            \Session::flash('error', 'Error!! SomeThing went Wrong');
        }
        return redirect('admins/players');
    }

    /**
     * Delete Team by Id
     */
    public function delete($id)
    {

        if($id) {
            \Session::flash('success', 'Player deleted Successfully');
            echo $this->player->deletePlayer($id);
        } else {
            \Session::flash('error', 'Error!! SomeThing went Wrong');
        }
    }
}
