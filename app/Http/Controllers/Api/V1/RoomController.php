<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Room;
use App\Models\MailCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Room::get();   
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
     * @param  \App\Http\Requests\StoreRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        if(User::where('email','=',$request->receiver)->exists()){
            $receiverID = User::where('email','=',$request->receiver)->get('id')->first()->id;
            return Mail::create([
                'user_id' => $request->sender,
                'room_id' => $request->lastname,
                'article' => $request->article,
                'text'=> $request->text
                ]);
        }else{
            return 'user not found';
            //return array('status'=>'400');
        }
    }

    //'institution_id' => Institution::max('id'),

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room,Request $request)
    {
        return $room;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }

    public function search(Request $request){
        $firstSQL = DB::table('rooms')
        ->join('users', 'users.id', '=','rooms.participant_2_id')
        ->select('rooms.id','users.email','users.avatar')
        ->where('participant_1_id',$request->user)
        ->where('users.email', 'like', "%{$request->email}%")
        ->get();
        $secondSQL = DB::table('rooms')
        ->join('users', 'users.id', '=','rooms.participant_1_id')
        ->select('rooms.id','users.email','users.avatar')
        ->where('participant_2_id',$request->user)
        ->where('users.email', 'like', "%{$request->email}%")
        ->get();
        return array_merge($firstSQL->toArray(), $secondSQL->toArray());
    }

    public function mails($id,Request $request){
        
        MailCategory::where('participant_id',$request->user)
                    ->where('room_id',$id)
                    ->update(['unread' => false]);
        //
        $query = DB::table('rooms')
        ->join('mails', 'mails.room_id', '=', 'rooms.id')
        ->join('users', 'users.id', '=', 'mails.user_id')
        ->select('mails.id as id','users.id as participantID','article','text','file','users.avatar','users.email')
        ->where(['mails.room_id' => $id])
        ->orderBy('id', 'DESC')
        ->get();
        return $query;
    }
}
