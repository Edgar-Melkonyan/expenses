<?php

namespace App\Repositories\Expense;

use App\Models\Expense;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseService implements ExpenseRepository
{
    /**
     * Defining Items per page
     *
     * @const PER_PAGE
     */
    const PER_PAGE = 10;

    /**
     * @var $expense
     */
    protected $expense;

    /**
     * ExpenseService constructor.
     *
     * @param Expense $expense
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Get paginated expenses.
     *
     * @return LengthAwarePaginator
     */
    public function getAllExpenses(): LengthAwarePaginator
    {
        return $this->expense->with(['user.role'])->paginate(self::PER_PAGE);
    }

    /**
     * Get Expense Object by id.
     *
     * @param int $id
     *
     * @return Expense
     */
    public function getExpense(int $id): Expense
    {
        return $this->expense->with(['user.role'])->findOrFail($id);
    }

    /**
     * Create a new Expense.
     *
     * @param array $data
     *
     * @return Expense
     */
    public function createExpense(array $data): Expense
    {
        $expense = $this->expense->create($data);
        return $expense->load(['user.role']);
    }

    /**
     * Update Expense by id.
     *
     * @param int $id
     * @param array $data
     *
     * @return Expense
     */
    public function updateExpense(int $id, array $data): Expense
    {
        $expense = $this->expense->findOrFail($id);
        $expense->update($data);
        return $expense->load(['user.role']);
    }

    /**
     * Delete Expense by id.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteExpense(int $id): void
    {
        $this->expense->findOrFail($id)->delete();
    }
}