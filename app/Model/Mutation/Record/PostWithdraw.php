<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

class PostWithdraw extends Model
{

    protected $table = 'mutation_record_withdraw';

    protected $primaryKey = 'id';
    
    protected $fillable = [
      'id',
      'code_user',
      'code_withdraw',
      'code_this',
      'title',
      'label',
      'cash',
      'coin',
      'fee',
      'limit',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
