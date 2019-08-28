<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostHelp extends Model
{
    protected $table = 'library_help';

    protected $primaryKey = 'id';

    protected $fillable = [
      'id',
      'code_help',
      'title',
      'key',
      'description',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    protected $dates = ['deleted_at'];

}
