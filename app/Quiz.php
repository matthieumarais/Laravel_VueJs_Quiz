<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['title', 'token'];
    protected $appends = ['human_created_at'];

    /**
     * @return mixed
     */
    public function getHumanCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
