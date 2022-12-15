<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'participant_1_id',
        'participant_2_id'
    ];

    public function user(){
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function storage(){
        return $this->belongsToMany(Storage::class, 'user_id', 'id');
    }

    public function roomCategory(){
        return $this->hasMany(RoomCategory::class, 'user_id', 'id');
    }

    public function draft(){
        return $this->hasMany(Draft::class, 'user_id', 'id');
    }

    public function mail(){
        return $this->hasMany(Mail::class);
    }
}
