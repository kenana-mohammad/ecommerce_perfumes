<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable=[
         'user_id','comment','rating'
    ];


    public function product()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->beLongsTo(User::class);
    }
}
