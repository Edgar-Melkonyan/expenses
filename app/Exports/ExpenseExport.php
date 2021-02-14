<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpenseExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        $query = DB::table('expenses')
            ->join('users', 'users.id', '=', 'expenses.user_id')
            ->orderBy('expenses.id')
            ->select(
                'expenses.id',
                'expenses.amount',
                'users.name',
                DB::raw('MONTH(expenses.created_at)'),
                DB::raw('YEAR(expenses.created_at)')
            );

            return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Amount',
            'Belongs to',
            'Month',
            'Year'
        ];
    }
}
