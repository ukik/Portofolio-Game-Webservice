<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostIntro extends Model
{
    protected $table = 'library_intro';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_intro',
      'title',
      'description',
      'variant',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
