<?php

namespace App\Repositories\Statistic;

use Illuminate\Database\Eloquent\Collection;

interface StatisticRepository
{
    public function getYearly(int $year): Collection;
    public function getMonthly(int $year, int $month): Collection;
}
