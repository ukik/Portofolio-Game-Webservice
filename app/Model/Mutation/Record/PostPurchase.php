<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostPurchase extends Model
{
    
    protected $table = 'mutation_record_purchase';

    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
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
