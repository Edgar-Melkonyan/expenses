<?php

namespace App\Repositories\Statistic;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class StatisticService implements StatisticRepository
{
    /**
     * @var $expense
     */
    protected $expense;

    /**
     * StatisticService constructor.
     *
     * @param Expense $expense
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Get expenses yearly statistics.
     *
     * @param int $year
     * @return Collection
     */
    public function getYearly(int $year): Collection
    {
        $data = $this->expense->whereYear('created_at', $year)
            ->select(
                DB::raw('SUM(amount) as total'),
                DB::raw('MONTH(created_at) as month')
            )->groupBy(DB::raw('month'))->get();

        return $data;
    }

    /**
     * Get expenses monthly statistics.
     *
     * @param int $year, int $month
     * @return Collection
     */
    public function getMonthly(int $year, int $month): Collection
    {
        $data = $this->expense->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select(
                DB::raw('SUM(amount) as total'),
                DB::raw('DAY(created_at) as day')
            )->groupBy(DB::raw('day'))->get();

        return $data;
    }
}
