<?php

namespace App\Repositories\Dashboard;

use App\Models\Statistic;
use Illuminate\Support\Carbon;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getReportByRange($from, $to)
    {
        $newTo = new Carbon($to);
        return Statistic::where([
            ['created_at', '>=', $from],
            ['created_at', '<', $newTo->addDay()->format('Y/m/d')],
        ])->oldest()->get();
    }

    public function getReportByMonth($month)
    {
        $month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth($month);
        $from = $month->startOfMonth()->format('Y/m/d');
        $to = $month === 0 ? Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d') : $month->endOfMonth()->format('Y/m/d');
        return $this->getReportByRange($from, $to);
    }

    public function getReportByWeek()
    {
        $week = Carbon::now('Asia/Ho_Chi_Minh')->subWeek();
        $from = $week->startOfWeek()->format('Y/m/d');
        $to = $week->endOfWeek()->format('Y/m/d');
        return $this->getReportByRange($from, $to);
    }
}
