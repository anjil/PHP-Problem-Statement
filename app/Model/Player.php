<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Model\DbLayer\Players;
//use App\Model\DbLayer\TeamPlayer;


class Player extends Model
{
    /**
     * Keeps database error
     */
    public $error = null;

    /**
     * Function fetches all the player
     * @param none
     * @return Allplayers <array>
     */
    public function getAllPlayer() {
        return Players::all()->toArray();
    }

    /**
     * Function add a player
     * @param $data
     * @return boolean
     */
    public function add($data) {
        
        try {

            $player = [];
            $player['first_name'] = $data['first_name'];
            $player['last_name'] = $data['last_name'];
            $player['team_id'] = $data['team'];

            return Players::create($player);
            

        }catch(QueryException $e) {

            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Function find team by Id
     * @param $id
     * @return team <array>
     */
    public function findById($id) {
        
        try {

           $player = Players::find($id);
           if($player) {
               return $player->toArray(); 
           }
           

        }catch(QueryException $e) {

            $this->error = $e->getMessage();
            return false;
        }   
    }

    /**
     * Update the player
     * @param $data <array>
     * @param $id <int>
     * 
     * @return updated player <array>
     */
    public function updatePlayer($data, $id) {

        try {

            $player = Players::find($id);

            if($player) {

                $oldImageName = ($player->image_uri) ? $player->image_uri : null;

                if( isset($data['profile_image']) ) {
                    $imageName = $this->uploadLogo( $data['profile_image'] );

                    if($imageName) {
                        $player->image_uri = $imageName;
                        $this->deleteLogo($oldImageName);
                    }
                }

                $player->first_name = $data['first_name'];
                $player->last_name = $data['last_name'];
                $player->team_id = $data['team'];

                return $player->save();

            } else {
                
                return false;   
            }

        }catch(QueryException $e) {

            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Delete player by ID
     * @param $id <int>
     */
    public function deletePlayer($id) {

        $player = Players::find( $id );
        return $player->delete();
    }

    private function uploadLogo($logoObj)
    {

        $logo = $logoObj;
        $imagename = time().'.'.$logo->getClientOriginalExtension();
        $destinationPath = public_path('/profile_img');

        if($logo->move($destinationPath, $imagename)) {
            return $imagename;
        }
        return null;

    }

    private function deleteLogo($logo_name)
    {

        $destinationPath = public_path('/profile_img/' . $logo_name);
        $status = false;
        if(\File::exists($destinationPath))
        {
            $status = \File::delete($destinationPath);
        }
        return $status;

    }
}
