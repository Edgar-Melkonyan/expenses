<?php

namespace App\Http\Controllers\Api;

use App\Exports\ExpenseExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Defining file name
     *
     * @const FILE_NAME
     */
    const FILE_NAME = 'expenses.xlsx';

    /**
     * Export expenses.
     *
     * @return void
     */
    public function export()
    {
        return Excel::download(new ExpenseExport, self::FILE_NAME);
    }
}
