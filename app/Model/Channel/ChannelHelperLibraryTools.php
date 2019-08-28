<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

class ChannelHelperLibraryTools extends Model
{   

    protected $table = 'channel_helper_library_tools';

    public $incrementing = false;

    protected $primaryKey = 'code_tools';

    protected $guarded = [
      'code_tools',
      'title',
      'package',
      'price',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'cash_discount',
      'coin_discount',
      'discount',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'package',
      'level',
      'name',
      'description',
      'cash',
      'coin',
      'cash_discount',
      'coin_discount',
      'discount',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title'           => '',
        'package'         => '',
        'level'           => '',
        'name'            => '',
        'description'     => '',
        'cash'            => '',
        'coin'            => '',
        'cash_discount'   => '',
        'coin_discount'   => '',
        'discount'        => '',
        'status'          => '',
        'created_at'      => '',
        'updated_at'      => '',
        'deleted_at'      => '',
      ];
    }            
}
