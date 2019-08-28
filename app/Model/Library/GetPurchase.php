<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use GameStatus;

class GetPurchase extends Model
{    

    use GameStatus;

    protected $table = 'library_purchase';

    protected $primaryKey = 'id';

    protected $guarded = [
      'code_purchase',
      'title',
      'currency',
      'label',
      'price',
      'value',
      'discount',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'title',
      'currency',
      'label',
      'price',
      'value',
      'discount',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title'       => '',
        'currency'    => '',
        'label'       => '',
        'price'       => '',
        'value'       => '',
        'discount'    => '',
        'status'      => '',
        'created_at'  => '',
        'updated_at'  => '',
        'deleted_at'  => '',
      ];
    }        
}
