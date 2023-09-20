<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'time'
    ];

    protected $casts = [
        'time' => 'datetime:Y-m-d H:i:s'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeDateSearch($query, $date){
        if(!empty($date)){
            $query->where('time', 'like', $date.'%');
        }
    }

    public function scopeGetLastSection($query, $user_id){
        if(!empty($user_id)){
            $query->latest()->where('user_id', $user_id)->first();
        }
    }
}
