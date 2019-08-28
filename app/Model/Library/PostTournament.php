<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

class PostTournament extends Model
{   
    protected $table = 'library_tournament';

    protected $primaryKey = 'id';

    protected $fillable = [
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

}
