<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use GameStatus;

class GetLimit extends Model
{   

    use GameStatus;

    protected $table = 'library_limit';

    protected $primaryKey = 'id';

    protected $guarded = [
        'code_limit',
        'title', 
        'range',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id', 
        'title',
        'range',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function initialize()
    {
    return [
        'title'      => '',
        'range'      => '',
        'status'     => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
    ];
    }        
}
