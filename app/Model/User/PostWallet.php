<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

use WalletAttribute;

use ContractWallet;

class PostWallet extends Model implements ContractWallet
{
    use WalletAttribute;

    protected $table = 'user_wallet';

    protected $primaryKey = 'id';

    protected $fillable = [
      'id',
      'code_wallet',
      'code_user',
      'activity',
      'premium',
      'normal',
      'cash_in',
      'cash_out',
      'coin_in',
      'coin_out',
      'score_in',
      'bonus_in',
      'status',
      'score_tournament',
      'tools_vehicle',
      'created_at',
      'updated_at',          
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
      'created_at',
      'updated_at',
      'deleted_at'    
    ];    

}
