<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostWithdraw extends Model
{  
    protected $table = 'library_withdraw';

    protected $primaryKey = 'id';

    protected $fillable = [
      'code_withdraw',
      'title',
      'label',
      'cash',
      'coin',
      'fee',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
