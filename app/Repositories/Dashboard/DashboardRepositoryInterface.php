<?php

namespace App\Repositories\Dashboard;

interface DashboardRepositoryInterface
{
    /**
     * Get report by week
     */
    function getReportByWeek();
    /**
     * Get report by month
     */
    function getReportByMonth($month);
    /**
     * Get report from d to d
     */
    function getReportByRange($from, $to);
}
