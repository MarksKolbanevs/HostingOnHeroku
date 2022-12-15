<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_id',
        'room_id',
        'participant_id',
        'unread',
        'important'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'user_id', 'id');
    }
    
}
