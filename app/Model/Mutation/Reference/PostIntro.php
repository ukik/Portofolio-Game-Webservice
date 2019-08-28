<?php

namespace App\Model\Mutation\Reference;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\User;
use App\Model\Library\Intro as iIntro;

class PostIntro extends Model
{
    protected $table = 'mutation_reference_intro';

    protected $primaryKey = 'id';

    protected $fillable = [
      'id', 
      'code_user', 
      'code_intro', 
      'status', 
      'created_at'
    ];

    protected $dates = ['deleted_at'];
}
