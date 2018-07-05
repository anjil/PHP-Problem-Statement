<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Model\DbLayer\Teams;


class Team extends Model
{
    /**
     * Keeps database error
     */
    public $error = null;

    /**
     * Function fetches all the team
     * @param none
     * @return AllTeams <array>
    **/
    public function getAllTeams() {

        return $teams = Teams::all()->toArray();
    }

    /**
     * Function add a team
     * @param $data
     * @return boolean
     */
    public function add($data) {
        
        try {

            $logoName = null;
            if( isset($data['logo']) ) {
                $logoName = $this->uploadLogo( $data['logo'] );
            }
            
            $team = [];
            $team['name'] = $data['name'];
            $team['logo_uri'] = $logoName;

            return Teams::create($team);    

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
    public function findById(int $id): array {
        
        try {

           $team = Teams::find($id);
           if($team){
               return $team->toArray();
           }
           return [];
           

        }catch(QueryException $e) {

            $this->error = $e->getMessage();
            return false;
        }   
    }

    /**
     * Update the team
     * @param $data <array>
     * @param $id <int>
     * 
     * @return updated team <array>
     */
    public function updateTeam($data, $id) {

        try {

            $team = Teams::find($id);

            if($team) {
                $oldLogo = $team->logo_uri;
                if( isset($data['logo']) ) {
                    $logoName = $this->uploadLogo( $data['logo'] );

                    if($logoName) {
                        $team->logo_uri = $logoName;
                        if($oldLogo) {
                            $this->deleteLogo($oldLogo);
                        }
                    }
                    
                }

                $team->name = $data['name'];
                return $team->save();

            } else {
                
                return false;   
            }

        }catch(QueryException $e) {

            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Delete team by ID
     * @param $id <int>
     */
    public function deleteTeam($id)
    {

        $team = Teams::find( $id );
        return $team->delete();
    }

    public static function teamList()
    {
        return Teams::pluck('name', 'id')->toArray();
    }

    private function uploadLogo($logoObj)
    {

        $logo = $logoObj;
        $imagename = time().'.'.$logo->getClientOriginalExtension();
        $destinationPath = public_path('/logo');

        if($logo->move($destinationPath, $imagename)) {
            return $imagename;
        }
        return null;

    }

    private function deleteLogo($logo_name)
    {

        $destinationPath = public_path('/logo/' . $logo_name);
        $status = false;
        if(\File::exists($destinationPath))
        {
            $status = \File::delete($destinationPath);
        }
        return $status;

    }

    public function getTeamsPlayers($teamId) {

        return Teams::where('id', $teamId)->with('player')->get();
    }
}
