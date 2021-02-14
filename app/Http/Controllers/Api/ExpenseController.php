<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Expense\ExpenseRepository;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * @var $expenseRepository
     */
    protected $expenseRepository;

    /**
     * ExpenseController constructor.
     *
     * @param ExpenseRepository $expenseRepository
     */
    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Display a listing of the user expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = $this->expenseRepository->getAllExpenses();
        return response()->json(['success' => $expenses], self::HTTP_OK);
    }

    /**
     * Display the specified expense.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $expense = $this->expenseRepository->getExpense($id);
        return response()->json(['success' =>  $expense ], self::HTTP_OK);
    }

    /**
     * Store a newly created expense.
     *
     * @param ExpenseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $expense = $this->expenseRepository->createExpense($request->validated());
        return response()->json(['success' =>  $expense ] ,self::HTTP_CREATED );
    }

    /**
     * Update the specified expense.
     *
     * @param  int  $id
     * @param ExpenseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id , ExpenseRequest $request)
    {
        $expense = $this->expenseRepository->updateExpense($id, $request->validated());
        return response()->json(['success' =>  $expense], self::HTTP_OK);
    }

    /**
     * Remove the specified expense.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->expenseRepository->deleteExpense($id);
        return response()->json(null , self::HTTP_NO_CONTENT);
    }
}
