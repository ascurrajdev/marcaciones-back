<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentHour extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
