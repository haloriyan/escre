<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'connect_id','title','date','duration','place','place_type','notes',
        'status','status_code'
    ];

    public function connection() {
        return $this->belongsTo('App\Models\Connect', 'connect_id');
    }
}
