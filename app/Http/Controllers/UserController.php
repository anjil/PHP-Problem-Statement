<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\Resource;
Use App\User;


class UserController extends Controller
{

    /**
     * @SWG\Get(
     *   path="/api/users",
     *   summary="Check user list",
     *   tags={"Users"},
     *   operationId="User List",
     *   @SWG\Response(
     *     response=200,
     *     description="successful operation",
     *     @SWG\Schema(type="string"),
     *     @SWG\Header(
     *       header="X-Rate-Limit",
     *       type="integer",
     *       format="int32",
     *       description="calls per hour allowed by the user"
     *     ),
     *     @SWG\Header(
     *       header="X-Expires-After",
     *       type="string",
     *       format="date-time",
     *       description="date in UTC when token expires"
     *     )
     *   ),
     *   @SWG\Response(response=400, description="Invalid username/password supplied")
     * )
     */
    
    public function UserList(Request $request)
    {
       return User::orderBy('id', 'desc')
                      ->pluck('name', 'email'); 
    }


    /**
     * @SWG\POST(
     *     path="/api/user/create",
     *     tags={"Users"},
     *     operationId="createUser",
     *     summary="Create new user entry",
     *      @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/User"),
     *      ),
     *   @SWG\Response(
     *     response=200,
     *     description="successful operation",
     *     @SWG\Schema(type="string"),
     *     @SWG\Header(
     *       header="X-Rate-Limit",
     *       type="integer",
     *       format="int32",
     *       description="calls per hour allowed by the user"
     *     ),
     *     @SWG\Header(
     *       header="X-Expires-After",
     *       type="string",
     *       format="date-time",
     *       description="date in UTC when token expires"
     *     )
     *   ),
     *   @SWG\Response(response=400, description="User not created")
     * )
     */
    
    public function store(Request $request){

        $request->merge(['password' => \Hash::make($request->password)]);
        return User::create($request->all());
    }

    public function updateUserDetails(Request $request){
        $User = User::findOrFail($id);
        $User->update($request->all());        
    }
}
