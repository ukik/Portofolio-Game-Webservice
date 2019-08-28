<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use GameStatus;

class GetTournament extends Model
{   

    use GameStatus;

    protected $table = 'library_tournament';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
        'code_tournament',
        'title',
        'day_begin',
        'day_end',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'code_tournament',
        'title',
        'day_begin',
        'day_end',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function initialize()
    {
    return [
        'id'                => '',
        'code_tournament'   => '',
        'title'             => '',
        'day_begin'         => '',
        'day_end'           => '',
        'status'            => '',
        'created_at'        => '',
        'updated_at'        => '',
        'deleted_at'        => '',
    ];
    }        
}
