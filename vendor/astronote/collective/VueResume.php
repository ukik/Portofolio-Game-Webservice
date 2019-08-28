<?php

use DB;
use Request;

trait VueResume
{

    public function ResumeGameMission($query, $start, $end)
    {

        setter("start", $start);
        setter("end", $end);

        return $query
            ->join(
                'mutation_record_mission', function ($join) {
                    $start = getter('start');
                    $end = getter('end');
                    $join->on('mutation_record_game.code_user', '=', 'mutation_record_mission.code_user')
                        ->on('mutation_record_game.code_mission', '=', 'mutation_record_mission.code_mission')
                        ->where('mutation_record_game.status', '=', 'enable')
                        ->where('mutation_record_game.created_at', '>=', $start)
                        ->where('mutation_record_game.created_at', '<', $end);
                }
            )
            ->select(
                DB::raw("
                    mutation_record_game.code_user AS code_user,
                    SUM(mutation_record_mission.cash + mutation_record_game.cash)+SUM(mutation_record_mission.cash) AS total_cash,
                    SUM(mutation_record_mission.coin + mutation_record_game.coin)+SUM(mutation_record_mission.coin) AS total_coin,
                    SUM(mutation_record_mission.score + mutation_record_game.score)+SUM(mutation_record_mission.score) AS total_score,
                    COUNT(mutation_record_mission.code_mission + mutation_record_game.code_game) AS total_transaction,
                    GROUP_CONCAT(DISTINCT mutation_record_game.status) as status

                ")
            )
            ->groupBy('mutation_record_game.code_user')
            ->orderBy('mutation_record_game.code_user', 'desc');

    }

    public function ResumePurchase($query, $start, $end)
    {

        return $query
            ->select(
                DB::raw("
                    mutation_record_purchase.code_user,
                    SUM(mutation_record_purchase.price - ((mutation_record_purchase.price * mutation_record_purchase.discount) / 100)) AS total_cash,
                    0 AS total_coin,
                    0 AS total_score,
                    COUNT(mutation_record_purchase.code_purchase) AS total_transaction,
                    GROUP_CONCAT(DISTINCT mutation_record_purchase.status) as status
                ")
            )
            ->where('status', '=', 'enable')
            ->where('mutation_record_purchase.created_at', '>=', $start)
            ->where('mutation_record_purchase.created_at', '<', $end)
            ->groupBy('code_user')
            ->orderBy('code_user', 'desc');
    }

    public function ResumeWithdraw($query, $start, $end)
    {

        return $query
            ->select(
                DB::raw("
                    mutation_record_withdraw.code_user,
                    SUM(mutation_record_withdraw.cash + mutation_record_withdraw.cash * mutation_record_withdraw.fee / 100) AS total_cash,
                    SUM(mutation_record_withdraw.coin + mutation_record_withdraw.coin * mutation_record_withdraw.fee / 100) AS total_coin,
                    0 AS total_score,
                    COUNT(mutation_record_withdraw.code_withdraw) AS total_transaction,
                    GROUP_CONCAT(DISTINCT mutation_record_withdraw.status) AS status
                ")
            )
            ->where('status', '=', 'enable')
            ->where('mutation_record_withdraw.created_at', '>=', $start)
            ->where('mutation_record_withdraw.created_at', '<', $end)
            ->groupBy('code_user')
            ->orderBy('code_user', 'desc');
    }

    public function scopeQueryTools($query, $start, $end)
    {

        return $query
            ->select(
                DB::raw("
                    mutation_record_tools.code_user,
                    COUNT(mutation_record_tools.code_tools) AS total_transaction,
                    SUM(mutation_record_tools.cash - ((mutation_record_tools.cash * mutation_record_tools.discount)/100)) as total_cash,
                    GROUP_CONCAT(DISTINCT mutation_record_tools.status) AS status
                ")
            )
            ->where('status', '=', 'enable')
            ->where('mutation_record_tools.created_at', '>=', $start)
            ->where('mutation_record_tools.created_at', '<', $end)
            ->groupBy('code_user')
            ->orderBy('code_user', 'desc');
    }

    public function scopeQueryVehicle($query, $start, $end)
    {

        return $query
            ->select(
                DB::raw("
                    mutation_record_vehicle.code_user,
                    COUNT(mutation_record_vehicle.code_vehicle) AS total_transaction,
                    SUM(mutation_record_vehicle.cash - ((mutation_record_vehicle.cash * mutation_record_vehicle.discount)/100)) as total_cash,
                    GROUP_CONCAT(DISTINCT mutation_record_vehicle.status) AS status
                ")
            )
            ->where('status', '=', 'enable')
            ->where('mutation_record_vehicle.created_at', '>=', $start)
            ->where('mutation_record_vehicle.created_at', '<', $end)
            ->groupBy('code_user')
            ->orderBy('code_user', 'desc');

    }

    public function scopeQuery($query, $start = "", $end = "")
    {

        switch (Request::segment(4)) {
            case "game":
            case "mission":
                return $this->ResumeGameMission($query, $start, $end);
                break;

            case "purchase":
                return $this->ResumePurchase($query, $start, $end);
                break;

            case "withdraw":
                return $this->ResumeWithdraw($query, $start, $end);
                break;

            default:
                return;

        }
    }
}
