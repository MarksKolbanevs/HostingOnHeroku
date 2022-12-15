<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Storage extends Model
{
    protected $fillable = [
        'user_id',
        'capacity_GB',
        'used_GB',
        'empty_GB'
    ];
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'id');
    }
    public function room(){
        return $this->belongsToMany(Room::class);
    }
    
}
