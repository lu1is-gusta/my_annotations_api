<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'annotation',
        'password',
    ];

    public function user() : belongsTo {
        return $this->belongsTo(User::class);
    }
}
