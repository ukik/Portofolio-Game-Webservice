<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class GetSetting extends Model
{   
    protected $table = 'library_setting';

    protected $primaryKey = 'id';

    protected $guarded = [
        'code_setting',
        'title',
        'description',
        'alias',
        'value',
        'mode',
        'condition',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
        'id',
        'code_setting',
        'title',
        'description',
        'alias',
        'value',
        'mode',
        'condition',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function initialize()
    {
        return [
            'id'            => '',
            'code_setting'  => '',
            'title'         => '',
            'description'   => '',
            'alias'         => '',
            'value'         => '',
            'mode'          => '',
            'condition'     => '',
            'created_at'    => '',
            'updated_at'    => '',
            'deleted_at'    => ''
        ];
    }        
}
