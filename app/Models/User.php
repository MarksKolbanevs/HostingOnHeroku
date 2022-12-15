<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'email',
        'avatar',
        'password',
        'subscription_id',
        'admin'
    ];

    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

    public function storage(){
        return $this->hasOne(Storage::class, 'user_id', 'id');
    }

    public function room(){
        return $this->hasMany(Room::class);
    }

    public function mailCategory(){
        return $this->hasMany(MailCategory::class);
    }

    public function roomCategory(){
        return $this->hasMany(RoomCategory::class);
    }

    public function draft(){
        return $this->hasMany(Draft::class);
    }
    
}
