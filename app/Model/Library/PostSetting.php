<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostSetting extends Model
{   
    protected $table = 'library_setting';

    protected $primaryKey = 'id';

    protected $fillable = [
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
}
