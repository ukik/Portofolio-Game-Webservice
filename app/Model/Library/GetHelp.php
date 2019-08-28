<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetHelp extends Model
{  
    protected $table = 'library_help';

    protected $primaryKey = 'id';

    protected $guarded = [
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

    protected $filter = [
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

    public static function initialize()
    {
      return [
        'id'          => '',
        'code_help'   => '',
        'title'       => '',
        'key'         => '',
        'description' => '',
        'status'      => '',
        'created_at'  => '',
        'updated_at'  => '',
        'deleted_at'  => '',
      ];
    }        
}
