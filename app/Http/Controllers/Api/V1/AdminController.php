<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mail;
class AdminController extends Controller
{
    public function deleteUser($email){
        if(User::where(['email' => $email])->delete()){
            return array('status' => '200', 'message' => 'User deleted!');
        }else{
            return array('status' => '400', 'message' => 'User not found!');
        };
    }
    public function getMessage(Request $request){
        $userID = User::where(['email' => $request->email])->get('id')->first();
        
        $userID = $userID['id'];
        
        return Mail::where(['user_id' => $userID, 'article' => $request->article])->get();
    }
    public function patchUser(Request $request){
        if(User::where(['email' => $request->email])->exists()){
            if(!User::where(['email' => $request->newEmail])->exists()){
                User::where(['email' => $request->email])->update(['email' => $request->newEmail]);
                return array('status' => '200', 'message' => 'User email updated');
            }else{
                return array('status' => '400', 'message' => 'User already exists'); 
            }
        }else{
            return array('status' => '400', 'message' => 'User not found');
        }
        
    }
    public function deleteMail(Request $request){
        return $request;
    }
}
