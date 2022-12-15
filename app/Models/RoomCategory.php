<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'room_id',
        'participant_id',
        'deferred',
        'important'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'user_id', 'id');
    }
}
