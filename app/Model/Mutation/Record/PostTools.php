<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostTools extends Model
{    
    protected $table = 'mutation_record_tools';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_user',
      'code_tools',
      'code_this',
      'package',
      'title',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'price',
      'discount',
      'status',
      'slot',
      'created_at',            
      'updated_at',           
    ];

    protected $dates = ['deleted_at'];

}
