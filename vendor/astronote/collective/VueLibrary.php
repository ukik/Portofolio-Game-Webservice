<?php

use Request;

trait VueLibrary
{

    public function LibraryAchievement($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('description', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('term', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('label', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('cash', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('coin', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('target', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryHelp($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('key', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('description', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryIntro($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('description', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('variant', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryLimit($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('range', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryMission($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('code_mission', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            // ->orWhere
            //     ('mode', 'LIKE', "%".$keyword."%")
            ->orWhere
                ('difficulty', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('premium', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('normal', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('package', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('cash', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('coin', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('score', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryPurchase($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('code_purchase', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('label', 'LIKE', "%" . $keyword . "%")
            // ->orWhere
            //     ('currency', 'LIKE', "%".$keyword."%")
            ->orWhere
                ('price', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('value', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('discount', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryTools($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('code_tools', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('package', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('level', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('name', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('description', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('price', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('discount', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryVehicle($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('code_vehicle', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('package', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('title', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('level', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('name', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('description', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('price', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('discount', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('health', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('fuel', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function LibraryWithdraw($query, $keyword)
    {
        # code...
        if($keyword == NULL) {
            return $query;
        }
        return $query
            ->where('id', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('code_withdraw', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('label', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('cash', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('coin', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('fee', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('status', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('created_at', 'LIKE', "%" . $keyword . "%")
            ->orWhere
                ('updated_at', 'LIKE', "%" . $keyword . "%");
    }

    public function scopeLibrary($query)
    {

        $keyword = [];

        for ($i = 0; $i < count(getter('request')); $i++) {
            $keyword += [decode_key(getter('request'), $i) => base_paginate_value(getter('request'), $i)];
        }

        if (!empty($keyword['search'])) {
            switch (Request::segment(3)) {
                case "achievement":
                    return $this->LibraryAchievement($query, $keyword['search']);
                    break;
                case "help":
                    return $this->LibraryHelp($query, $keyword['search']);
                    break;
                case "intro":
                    return $this->LibraryIntro($query, $keyword['search']);
                    break;
                case "limit":
                    return $this->LibraryLimit($query, $keyword['search']);
                    break;
                case "mission":
                    return $this->LibraryMission($query, $keyword['search'])->filter('mode');
                    break;
                case "purchase":
                    return $this->LibraryPurchase($query, $keyword['search'])->filter('currency');
                    break;
                case "tools":
                    return $this->LibraryTools($query, $keyword['search']);
                    break;
                case "vehicle":
                    return $this->LibraryVehicle($query, $keyword['search']);
                    break;
                case "withdraw":
                    return $this->LibraryWithdraw($query, $keyword['search']);
                    break;
            }
        } else {
            switch (Request::segment(3)) {
                case "mission":
                    return $this->LibraryMission($query, $keyword['search'])->filter('mode');
                    break;
                case "purchase":
                    return $this->LibraryPurchase($query, $keyword['search'])->filter('currency');
                    break;
            }
        }
    }
}
