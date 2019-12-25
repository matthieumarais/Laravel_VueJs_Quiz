<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['id_quiz', 'id_question', 'id_prospect', 'value'];
}
