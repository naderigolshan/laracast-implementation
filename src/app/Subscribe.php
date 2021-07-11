<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(Answer::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
