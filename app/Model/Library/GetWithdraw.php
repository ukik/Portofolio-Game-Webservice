<?php

namespace App\Model\Library;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

use WithdrawAttribute;

use ContractWithdraw;

use GameStatus;

class GetWithdraw extends Model implements ContractWithdraw
{  

    use GameStatus;

    use WithdrawAttribute;

    protected $table = 'library_withdraw';

    protected $primaryKey = 'id';

    protected $guarded = [
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

    protected $filter = [
      'id', 
      'title',
      'label',
      'cash',
      'coin',
      'fee',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title'      => '',
        'label'      => '',
        'cash'       => '',
        'coin'       => '',
        'fee'        => '',
        'status'     => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
      ];

    }   

}
