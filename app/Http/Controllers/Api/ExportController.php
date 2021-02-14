<?php

namespace App\Http\Controllers\Api;

use App\Exports\ExpenseExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export expenses.
     *
     * @return void
     */
    public function export()
    {
        return Excel::download(new ExpenseExport, 'expenses.xlsx');
    }
}
