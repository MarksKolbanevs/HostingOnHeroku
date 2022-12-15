<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Storage as Store;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;
use App\Filters\V1\UsersFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {   
        if(strpos($request->email, '@indana.com') === false){
            return array('status' => 400, 'message' => 'Email have to end on @indana.com!');
        }
        if(User::where(['email' => $request->email])->exists()){
            return array('status' => 400, 'message' => 'User already exists!');
        }
        if(User::create($request->all())){
            $userID = User::max('id');
            Store::create(['user_id' => $userID]);
            return array('status' => 200, 'message' => $userID);
        }else{
            return array('status' => 400, 'message' => 'Something went wrong');
        };      
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request){
        return $user;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //Under construction
        return $request;
        if($request){
                if($request->email){
                    if(!str_contains($request->email,'@indana.com')){
                        return array('status' => '400', 'message' => "Email need to have prefix @indana.com!");
                    }
                    if(User::where('email',$request->email)->exists()){
                    return array('status' => '400', 'message' => "User already exists");
                    } 
                }
                if(User::where('phone',$request->phone)->exists()){
                     return array('status' => '400', 'message' => "Phone is using!");
                 } 
                if($user->password == $request->password){
                    return array('status' => '400', 'message' => "Password need to match!");
                }
                if($request->image){
                    $dbImgPath = User::where('id',$user->id)->get('avatar')->first();
                    $dbImgPath = $dbImgPath['avatar'];
                    $dbImg = str_replace('./images/avatars/','',$dbImgPath);
                    $requestImage = $request->image;
                    if(strcmp($dbImg, 'default-avatar.png') !== 0){
                        Storage::disk('avatars')->delete($dbImg);
                        $storeImg = Storage::disk('avatars')->put('',$requestImage);
                        User::where('id',$user->id)->update(['avatar' => './images/avatars/'.$storeImg]);
                        return array('status' => '200');
                    }else{
                        $storeImg = Storage::disk('avatars')->put('',$requestImage);
                        User::where('id',$user->id)->update(['avatar' => './images/avatars/'.$storeImg]);
                        return array('status' => '200');
                    } 
                } 
                if($user->update($request->all())){
                    return array('status' => '200');
                }else{
                    return 'Something went wrong';
                }  
            }else{
                return array('status' => '400', 'message' => "Nothing to update"); 
            }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return array('status' => '200', 'message' => 'User deleted!');
    }
    
    public function unreadCount($id,Request $request){
        return DB::table('rooms')
                ->join('mail_categories', 'mail_categories.room_id', '=', 'rooms.id')
                ->where('mail_categories.participant_id',$id)
                ->where('mail_categories.room_id',$request->room_id)
                ->where('unread',true)
                ->count();
    }

    public function checkForAdmin($id, Request $request){
        $user = User::findOrFail($id);
        if($user->admin == true){
                return array('status' => '200');
            }else{
                return array('status' => '400', 'message' => 'unauthorized access');
        }
    }
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;

        $data = User::get()->where('email','=',$email)->first();
        
        if(User::where('email','=',$email)->exists()){
            if ($data->password == $password){
                return array('status'=>'200','id'=> $data->id);
            }else{
                return array('status'=>'400');
            }
        }else{
            return array('status'=>'400');
        }
    }
}
