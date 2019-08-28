<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostAchievement extends Model
{
    protected $table = 'mutation_record_achievement';

    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
      'code_achievement',
      'title',
      'description',
      'term',
      'label',
      'cash',
      'coin',
      'score',
      'target',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];
}
