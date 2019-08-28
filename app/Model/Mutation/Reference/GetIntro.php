<?php

namespace App\Model\Mutation\Reference;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\User;
use App\Model\Library\Intro as iIntro;

use GameStatus;

class GetIntro extends Model
{
  
    use GameStatus;

    protected $table = 'mutation_reference_intro';

    protected $primaryKey = 'id';

    protected $guarded = [
      'id',
      'code_user',
      'code_intro',
      'status',
      'created_at'
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id', 
      'code_user', 
      'code_intro', 
      'status', 
      'created_at'
    ];

    public static function initialize()
    {
      return [
        'code_user'   => '', 
        'code_intro'  => '', 
        'status'      => '', 
      ];
    }    

    public function get_reference_user()
    {
      return $this->belongsTo(User::class, 'code_user','code_user');
    }

    public function get_reference_intro()
    {
      return $this->belongsTo(iIntro::class,'code_intro','code_intro');
    }
}
