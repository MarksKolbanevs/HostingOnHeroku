<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\MailCategory;
use App\Models\RoomCategory;
use App\Models\User;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function every($id){
        $firstSQL = DB::table('rooms')
                        ->join('users', 'users.id', '=','rooms.participant_2_id')
                        ->select(['rooms.id','users.email','users.avatar'])
                        ->where(['participant_1_id' => $id])
                        ->get();
        $secondSQL = DB::table('rooms')
                        ->join('users', 'users.id', '=','rooms.participant_1_id')
                        ->select(['rooms.id','users.email','users.avatar'],[])
                        ->where(['participant_2_id' => $id])
                        ->get();
        $sql = array_merge($firstSQL->toArray(), $secondSQL->toArray());
        return $sql;
    }
    public function unread($id){
        $sql = DB::table('rooms')
        ->join('mail_categories', 'mail_categories.room_id', '=', 'rooms.id')
        ->join('mails', 'mails.id', '=', 'mail_categories.mail_id')
        ->join('users', 'users.id', '=', 'mails.user_id')
        ->select('rooms.id','users.email','users.avatar')
        ->where(["mail_categories.unread" => true, 'mail_categories.participant_id' => $id])
        ->groupBy(['users.email','rooms.id','users.avatar'])
        ->get();
        if($sql == null){
            return [];
        }else{
           return $sql;  
        } 
    }
    public function important($id){
        $firstSQL = DB::table('rooms')
        ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
        ->join('users', 'users.id', '=', 'rooms.participant_1_id')
        ->select('rooms.id','users.email','users.avatar')
        ->where(["room_categories.important" => 1, 'rooms.participant_2_id' => $id])
        ->get();
        
        $secondSQL = DB::table('rooms')
        ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
        ->join('users', 'users.id', '=', 'rooms.participant_2_id')
        ->select('rooms.id','users.email','users.avatar')
        ->where(["room_categories.important" => 1, 'rooms.participant_1_id' => $id])
        ->get();
        
         return array_merge($firstSQL->toArray(), $secondSQL->toArray());
    }
    public function deferred($id){
        $firstSQL = DB::table('rooms')
            ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'rooms.participant_1_id')
            ->select('rooms.id','users.email','users.avatar')
            ->where(["room_categories.deferred" => 1, 'rooms.participant_2_id' => $id])
            ->get();

            $secondSQL = DB::table('rooms')
            ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'rooms.participant_2_id')
            ->select('rooms.id','users.email','users.avatar')
            ->where(["room_categories.deferred" => 1, 'rooms.participant_1_id' => $id])
            ->get();

        return array_merge($firstSQL->toArray(), $secondSQL->toArray());
    }
    
    public function importantStore($id,Request $request){
        $participantID = User::where(['email' => $request->email])->get('id')->first();
        $participantID = $participantID['id'];
        
        if(RoomCategory::where('room_id',$request->room)
                    ->where('participant_id',$id)
                    ->where('important',1)
                    ->exists()){

                RoomCategory::where('room_id', $request->room)
                     ->where('participant_id',$id)
                     ->update(['important' => 0]);
                return array('status' => '200');
            
            }else if (RoomCategory::where('room_id',$request->room)
                        ->where('participant_id',$id)
                        ->where('important',0)
                        ->exists()){
                                        
                RoomCategory::where('room_id', $request->room)
                     ->where('participant_id',$id)
                     ->update(['important' => 1]);
                return array('status' => '200');
            
            }else{
                RoomCategory::create([
                'room_id' => $request->room,
                'participant_id' => $id,
                'important'=> 1
                ]);
                return array('status' => '200');
            }
    }
    public function deferredStore($id,Request $request){
        if(RoomCategory::where('room_id',$request->room_id)
                            ->where('participant_id',$id)
                            ->where('deferred',1)
                            ->exists()){
                RoomCategory::where('room_id', $request->room_id)
                     ->where('participant_id',$id)
                     ->update(['deferred' => 0]);
                return array('status' => 'undeferred');
            }else if(RoomCategory::where('room_id',$request->room_id)
                        ->where('participant_id',$id)
                        ->where('deferred',0)
                        ->exists()){
                RoomCategory::where('room_id', $request->room_id)
                     ->where('participant_id',$id)
                     ->update(['deferred' => 1]);
                return array('status' => 'deferred');
            }else{
                RoomCategory::create([
                    'room_id' => $request->room_id,
                    'participant_id' => $id,
                    'deferred' => 1
                    ]);
                return array('status' => '200');
            }
    }
    public function deferredCheck($id,Request $request){
        if(RoomCategory::where('participant_id', $id)->where('room_id',$request->room)->where('deferred',true)->exists()){
            return array('status' => '200', 'message' => 'deferred');
        }else{
            return array('status' => '200', 'message' => 'undeferred');
        }
    }
    public function importantCheck($id,Request $request){
        if(RoomCategory::where('participant_id', $id)->where('room_id',$request->room)->where('important',true)->exists()){
            return array('status' => '200', 'message' => 'important');
        }else{
            return array('status' => '200', 'message' => 'unimportant');
        }
    }
    public function searchEvery($id,Request $request){
        $firstSQL = DB::table('rooms')
                        ->join('users', 'users.id', '=','rooms.participant_2_id')
                        ->select(['rooms.id','users.email','users.avatar'])
                        ->where('participant_1_id', $id)
                        ->where('users.email','LIKE', '%'.$request->email.'%')
                        ->get();
        $secondSQL = DB::table('rooms')
                        ->join('users', 'users.id', '=','rooms.participant_1_id')
                        ->select(['rooms.id','users.email','users.avatar'])
                        ->where('participant_2_id', $id)
                        ->where('users.email','LIKE', '%'.$request->email.'%')
                        ->get();
        $sql = array_merge($firstSQL->toArray(), $secondSQL->toArray());
        return $sql;
    }
    public function searchUnread($id,Request $request){
        $sql = DB::table('rooms')
        ->join('mail_categories', 'mail_categories.room_id', '=', 'rooms.id')
        ->join('mails', 'mails.id', '=', 'mail_categories.mail_id')
        ->join('users', 'users.id', '=', 'mails.user_id')
        ->select('rooms.id','users.email','users.avatar')
        ->where(["mail_categories.unread" => true, 'mail_categories.participant_id' => $id])
        ->where('users.email', 'LIKE', '%'.$request->email.'%')
        ->groupBy(['users.email','rooms.id','users.avatar'])
        ->get();
        if($sql == null){
            return [];
        }else{
           return $sql;  
        }
    }
    public function searchImportant($id,Request $request){
        $firstSQL = DB::table('rooms')
            ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'rooms.participant_1_id')
            ->select('rooms.id','users.email','users.avatar')
            ->where(["room_categories.deferred" => 1, 'rooms.participant_2_id' => $id])
            ->where('users.email', 'LIKE', $request->email)
            ->get();

            $secondSQL = DB::table('rooms')
            ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'rooms.participant_2_id')
            ->select('rooms.id','users.email','users.avatar')
            ->where(["room_categories.deferred" => 1, 'rooms.participant_1_id' => $id])
            ->where('users.email', 'LIKE', $request->email)
            ->get();

        return array_merge($firstSQL->toArray(), $secondSQL->toArray());
    }
    public function searchDeferred($id,Request $request){
        $firstSQL = DB::table('rooms')
            ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'rooms.participant_1_id')
            ->select('rooms.id','users.email','users.avatar')
            ->where(["room_categories.deferred" => 1, 'rooms.participant_2_id' => $id])
            ->where('users.email', 'LIKE', '%'.$request->email.'%')
            ->get();

            $secondSQL = DB::table('rooms')
            ->join('room_categories', 'room_categories.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'rooms.participant_2_id')
            ->select('rooms.id','users.email','users.avatar')
            ->where(["room_categories.deferred" => 1, 'rooms.participant_1_id' => $id])
            ->where('users.email', 'LIKE', '%'.$request->email.'%')
            ->get();

        return array_merge($firstSQL->toArray(), $secondSQL->toArray());
    }
}