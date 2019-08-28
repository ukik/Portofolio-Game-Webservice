<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostPurchase extends Model
{    
    protected $table = 'library_purchase';

    protected $primaryKey = 'id';

    protected $fillable = [
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

}
