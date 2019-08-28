<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostLimit extends Model
{   
    protected $table = 'library_limit';

    protected $primaryKey = 'id';

    protected $fillable = [
        'code_limit',
        'title', 
        'range',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

}
