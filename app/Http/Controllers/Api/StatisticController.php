<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Statistic\StatisticRepository;
use App\Http\Requests\StatisticYearlyRequest;
use App\Http\Requests\StatisticMonthlyRequest;

class StatisticController extends Controller
{
    /**
     * @var $statisticRepository
     */
    protected $statisticRepository;

    /**
     * StatisticController constructor.
     *
     * @param StatisticRepository $statisticRepository
     */
    public function __construct(StatisticRepository $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }

    /**
     * Display yearly statistics.
     *
     * @param StatisticYearlyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function yearly(StatisticYearlyRequest $request)
    {
        $statistics = $this->statisticRepository->getYearly($request->year);
        return response()->json(['success' => $statistics], self::HTTP_OK);
    }

    /**
     * Display monthly statistics.
     *
     * @param StatisticMonthlyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function monthly(StatisticMonthlyRequest $request)
    {
        $statistics = $this->statisticRepository->getMonthly($request->year, $request->month);
        return response()->json(['success' => $statistics], self::HTTP_OK);
    }
}
