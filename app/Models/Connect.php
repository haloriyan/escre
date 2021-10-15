<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    use HasFactory;

    protected $fillable = [
        'secretary_id','headship_id'
    ];

    public function headships() {
        return $this->belongsTo('App\Models\User', 'secretary_id');
    }
    public function secretaries() {
        return $this->belongsTo('App\Models\User', 'headship_id');
    }
}
