<?php

use Request;

trait SimpleHelper
{

    public function scopeStatus($query)
    {

        $request = [];

        for ($i = 0; $i < count(getter('request')); $i++) {
            $request += [decode_key(getter('request'), $i) => base_paginate_value(getter('request'), $i)];
        }

        if (isset($request['status'])) {
            if ($request['status'] == "recovery") {
                return $query->onlyTrashed();
            } else {
                return $query->where('status', '=', $request['status']);
            }
        } else {
            return;
        }
    }

    public function scopeMisc($query)
    {

        $request = [];
        for ($i = 0; $i < count(getter('request')); $i++) {
            $request += [decode_key(getter('request'), $i) => base_paginate_value(getter('request'), $i)];
        }

        switch (Request::segment(4)) {
            case "mission":
                if (!empty($request['misc'])) {
                    return $query->where('mode', $request['misc']);
                } else {
                    return;
                }

                break;

            case "purchase":
                if (!empty($request['misc'])) {
                    return $query->where('currency', '=', $request['misc']);
                } else {
                    return;
                }

                break;
        }
    }

    public function scopeIsEnable($query)
    {
        return $query->whereStatus('enable');
    }

    public function scopeIsDisable($query)
    {
        return $query->whereStatus('disable');
    }    

    public function scopeFilter($query, $key) # for mission library
    {
        $request = [];

        for ($i = 0; $i < count(getter('request')); $i++) {
            $request += [decode_key(getter('request'), $i) => decode_value(getter('request'), $i)];
        }
        return $query->where($key, '=', $request['filter']);
    }

    # Mission Only
    public function scopePremium($query, $premium)
    {
        if ($premium) {
            return $query
                    ->where('normal', '=', null) // only premium
                    ->where('premium', '!=', null); // only premium
        }
        return $query
                ->where('normal', '!=', null) // only normal
                ->where('premium', '=', null); // only normal
    }

    # Achievement only
    public function scopeLabel($query, $label){
        return $query
                ->whereLabel($label)
                ->whereCodeUser(getter('user')->code_user)
                ->count();
    }

}
