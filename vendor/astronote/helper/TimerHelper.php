<?php

use Carbon\Carbon;

trait TimerHelper
{

    protected function startToday()
    {
        return Carbon::now()->today()->format('Y-m-d 00:00:00');
    }

    protected function endToday()
    {
        return Carbon::now()->today()->format('Y-m-d 23:59:00');
    }

    protected function startYesterday()
    {
        return Carbon::now()->yesterday()->format('Y-m-d 00:00:00');
    }

    protected function endYesterday()
    {
        return Carbon::now()->yesterday()->format('Y-m-d 23:59:00');
    }

    protected function startWeek($key = 0)
    {
        # start day is monday
        # ++ next, -- prev
        return Carbon::now()->startOfWeek()->subWeeks($key)->format('Y-m-d 00:00:00');
    }

    protected function endWeek($key = 0)
    {
        # end day is sunday
        # ++ next, -- prev
        return Carbon::now()->endOfWeek()->subWeeks($key)->format('Y-m-d 23:59:00');
    }

    protected function startMonth($key = 0)
    {
        return Carbon::now()->startOfMonth()->subMonths($key)->format('Y-m-d 00:00:00');
    }

    protected function endMonth($key = 0)
    {
        return Carbon::now()->endOfMonth()->subMonths($key)->format('Y-m-d 23:59:00');
    }
}
