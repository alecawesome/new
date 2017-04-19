<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "questions";

    public function choices(){
      return  $this->hasMany('App\Choice','question_id');
    }
}
