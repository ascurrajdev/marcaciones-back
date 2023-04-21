<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcacion extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        "position" => "array",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeHasUser($query, $userId){
        $query->where(["user_id" => $userId]);
    }
}
