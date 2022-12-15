<?php

namespace App\Http\Controllers\Api\V1;;

use App\Models\Storage;
use App\Http\Requests\StoreStorageRequest;
use App\Http\Requests\UpdateStorageRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mail;
use App\Models\User;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Storage::get();
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
     * @param  \App\Http\Requests\StoreStorageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStorageRequest $request)
    {
        $userID = User::max('id')->get();
        Storage::create('user_id', $userID);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show(Storage $storage)//storage id = user id
    {
        StorageController::refresh($storage);
        return $storage;
    }

    private function refresh(Storage $storage){
        $sumSizeKiB = Mail::where('user_id',$storage->id)->sum('size_KiB');
        $capacityGB = Storage::where('user_id',$storage->id)->get('capacity_GB')->first();
        $capacityGB = $capacityGB['capacity_GB'];
        $sumSizeGB = $sumSizeKiB/1000000;
        $emptyGB =  $capacityGB - $sumSizeGB;

        Storage::where('user_id',$storage->id)->update(['used_GB' => $sumSizeGB]);
        Storage::where('user_id',$storage->id)->update(['empty_GB' => $emptyGB]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage)
    {
        return $storage;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStorageRequest  $request
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStorageRequest $request, Storage $storage)
    {
        return $storage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storage $storage)
    {
        //
    }
    public function checkForCapacity($userID,$size){
        //size in bytes
        $storage = Storage::where('user_id',$userID)->get()->first();
        $maxCapacity = $storage->capacity_GB;
        $usedCapacity = $storage->used_GB;
        $GB = $size / (1024*1024*1024);
        if($usedCapacity + $GB >= $maxCapacity){
            return false;
        }else{
            return true;
        }
    }
}
