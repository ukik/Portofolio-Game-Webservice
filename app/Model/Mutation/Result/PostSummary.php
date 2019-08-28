<?php

namespace App\Model\Mutation\Result;

use Illuminate\Database\Eloquent\Model;

use SummaryAttribute;

use ContractSummary;

class PostSummary extends Model implements ContractSummary
{

    use SummaryAttribute;

    protected $table = 'user_summary';

    public $incrementing = false;

    protected $primaryKey = 'code_user';

    protected $fillable = [

        'id',
        'code_summary',
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
        'score_tournament',
        'tools_vehicle',
        'created_at',
        'updated_at',

    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function get_user_profile()
    {
        return $this
            ->hasOne(GetUser::class, 'code_user')
            ->select(['code_user', 'name']);
    }

    public function get_leaderboard()
    {
        return $this
            ->hasMany(PostSummary::class, 'self', 'self')
            ->with('get_user_profile')
            ->orderBy('score_in', 'desc')
            ->take(3);
    }

}
