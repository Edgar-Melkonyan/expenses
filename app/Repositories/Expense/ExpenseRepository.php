<?php

namespace App\Repositories\Expense;

use App\Models\Expense;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExpenseRepository
{
    public function getAllExpenses(): LengthAwarePaginator;
    public function getExpense(int $id): Expense;
    public function createExpense(array $data): Expense;
    public function updateExpense(int $id, array $data): Expense;
    public function deleteExpense(int $id): void;
}