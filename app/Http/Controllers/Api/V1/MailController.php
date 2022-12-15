<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Mail;
use App\Models\User;
use App\Models\Room;
use App\Http\Requests\StoreMailRequest;
use App\Http\Requests\UpdateMailRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\StorageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MailCategory;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        return Mail::paginate();
    }

    public function search($id,Request $request){
        /*
        user => user id;
        article => the article of mail;
        */
        return DB::table('mails')
            ->join('users', 'users.id', '=','mails.user_id')
            ->join('rooms', 'rooms.id', '=', 'mails.room_id')
            ->select('mails.text','mails.article','users.avatar','users.email')
            ->where('room_id',$id)
            ->where('mails.article', 'like', "%{$request->article}%")
            ->get();  
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
     * @param  \App\Http\Requests\StoreMailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMailRequest $request)
    {

        if(!User::where('email',$request->participant)->exists()){
            return array('status' => '400','message' => 'User not found!');
        }
        if($request->participant){
            $participantID = User::where('email',$request->participant)->get('id')->first();
            $participantID = $participantID['id'];
        }
       $storeFile = "";
       if($request->file('file')){
            if(filesize($request->file('file')) > 5 * 1024 * 1024){
                return array('status' => 400,'message' => 'File is too large!');  
            }
            if(StorageController::checkForCapacity($request->user,filesize($request->file('file')))){
                $file = $request->file('file');
                $storeFile = Storage::disk('files')->put('',$file);
            }else{
                return array('status' => 400,'message' => 'Error');
            }
        }
        if (Room::where('participant_1_id',$request->user)->where('participant_2_id',$participantID)->exists() || Room::where('participant_2_id',$request->user)->where('participant_1_id',$participantID)->exists()){
            if($request->room){
                Mail::create(array(
                    'user_id'=>$request->user,
                    'room_id'=>$request->room,
                    'article' => $request->article,
                    'text' => $request->text,
                    'size_KiB' => strlen($request->text)/1000,
                    'file' => './embed/'.$storeFile
                ));
            }else{
                return "error";
            }
            $mailID = Mail::max('id');
            MailCategory::create(array('mail_id' =>$mailID,'participant_id'=>$participantID,'room_id'=>$request->room));
            return array('status' => 200,'message' => 'Mail sent!');
        }else{
            Room::create(array('participant_1_id' => $request->user,'participant_2_id' => $participantID));
            $roomID = Room::max('id');
            Mail::create(array(
                'user_id'=>$request->user,
                'room_id'=>$roomID,
                'article' => $request->article,
                'text' => $request->text,
                'size_KiB' => strlen($request->text)/1000,
                'file' => $storeFile
            ));
            $mailID = Mail::max('id');
            MailCategory::create(array('mail_id' =>$mailID,'participant_id'=>$participantID,'room_id'=>$roomID));
            return array('status' => 200,'message' => 'Mail sent!');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(Mail $mail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMailRequest  $request
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMailRequest $request, Mail $mail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mail $mail)
    {
        Mail::destroy($mail->id);
    }
}
