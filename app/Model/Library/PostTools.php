<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostTools extends Model
{    
    protected $table = 'library_tools';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_tools',
      'title',
      'package',
      'price',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'discount',
      'status',
      'slot',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];
    
}
